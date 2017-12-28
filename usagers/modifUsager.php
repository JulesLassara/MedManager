<?php

session_start();

require('../ressources/Usager.php');
require('../ressources/dao/UsagerDAO.php');
require('../ressources/Medecin.php');
require('../ressources/dao/MedecinDAO.php');

$usa = new UsagerDAO(new Usager(null, null, null, null, null, null, null, null, null));

if(isset($_POST['modifUsa'])) {

    if(!empty($_POST['civilite'])
        && !empty($_POST['name'])
        && !empty($_POST['surname'])
        && !empty($_POST['address'])
        && !empty($_POST['dateborn'])
        && !empty($_POST['placeborn'])
        && !empty($_POST['numsecu'])
        && !empty($_POST['medref'])) {

        $usa->setElement(new Usager($_SESSION['id'], $_POST['medref'], $_POST['civilite'], $_POST['name'], $_POST['surname'], $_POST['address'], $_POST['dateborn'], $_POST['placeborn'], $_POST['numsecu']));
        if($usa->update()) {
            $_SESSION['updated'] = 1;
        } else {
            $_SESSION['updated'] = 0;
        }
        unset($_SESSION['id']);
        header('Location: .');

    } else {
        if (empty($_POST['civilite'])) $civilitemissing = 1;

        if (empty($_POST['name'])) $namemissing = 1;

        if (empty($_POST['surname'])) $surnamemissing = 1;

        if (empty($_POST['address'])) $addressmissing = 1;

        if (empty($_POST['dateborn'])) $datebornmissing = 1;

        if (empty($_POST['placeborn'])) $placebornmissing = 1;

        if (empty($_POST['numsecu'])) $numsecumissing = 1;
    }

}

if(isset($_GET['id'])) {
    $listmed = new MedecinDAO(new Medecin(null, null, null, null));
    $rlistmed = $listmed->getElementsByKeyword("");
    $_SESSION['id'] = $_GET['id'];
    $valuesusa = $usa->getElementById($_GET['id']);
    if($valuesusa == null) {
        header('Location: .');
    } else {
        $usa->setElement(new Usager($_GET['id'], $valuesusa['id_medecin'], $valuesusa['civilite'], $valuesusa['nom'], $valuesusa['prenom'], $valuesusa['adresse'], $valuesusa['date_naissance'], $valuesusa['lieu_naissance'], $valuesusa['num_secu']));
    }
} else {
    header('Location: .');
}




?>

<!doctype html>
<html lang="fr">

<?php include('../ressources/inc/head.html'); ?>

<body>

<?php include('../ressources/inc/nav.html'); ?>

<!-- Page Header -->
<header class="masthead" style="background-image: url('img/home-bg.jpg')">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="site-heading">
                    <h1>Médecins</h1>
                    <span class="subheading">Ajout d'un médecin</span>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">

            <form method="POST" action=".">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" name="back"><i class="fa fa-chevron-left"></i> Retour</button>
                </div>
            </form>

            <form method="POST">

                <!-- Civilite -->
                <div class="control-group">
                    <div class="form-group floating-label-form-group controls">
                        <label>Civilité</label>
                        <?php if(isset($civilitemissing)): ?><p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Veuillez renseigner ce champs.</p> <?php endif; ?>
                        <select name="civilite" class="form-control">
                            <option <?php if($usa->getElement()->toArray()['civilite'] == "Homme") echo "selected=\"selected\""; ?> value="Homme">Homme</option>
                            <option <?php if($usa->getElement()->toArray()['civilite'] == "Femme") echo "selected=\"selected\""; ?> value="Femme">Femme</option>
                            <option <?php if($usa->getElement()->toArray()['civilite'] == "Autre") echo "selected=\"selected\""; ?> value="Autre">Autre</option>
                        </select>
                    </div>
                </div>

                <!-- Nom -->
                <div class="control-group">
                    <div class="form-group floating-label-form-group controls">
                        <label>Nom</label>
                        <?php if(isset($namemissing)): ?><p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Veuillez renseigner ce champs.</p> <?php endif; ?>
                        <input name="name" type="text" class="form-control" placeholder="Nom" value="<?php echo $usa->getElement()->toArray()['nom']; ?>">
                    </div>
                </div>

                <!-- Prenom -->
                <div class="control-group">
                    <div class="form-group floating-label-form-group controls">
                        <label>Prénom</label>
                        <?php if(isset($surnamemissing)): ?><p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Veuillez renseigner ce champs.</p> <?php endif; ?>
                        <input name="surname" type="text" class="form-control" placeholder="Prénom" value="<?php echo $usa->getElement()->toArray()['prenom']; ?>">
                    </div>
                </div>

                <!-- Adresse -->
                <div class="control-group">
                    <div class="form-group floating-label-form-group controls">
                        <label>Adresse</label>
                        <?php if(isset($addressmissing)): ?><p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Veuillez renseigner ce champs.</p> <?php endif; ?>
                        <input name="address" type="text" class="form-control" placeholder="Adresse" value="<?php echo $usa->getElement()->toArray()['adresse']; ?>">
                    </div>
                </div>

                <!-- Date de naissance -->
                <div class="control-group">
                    <div class="form-group floating-label-form-group controls">
                        <label>Date de naissance</label>
                        <?php if(isset($datebornmissing)): ?><p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Veuillez renseigner ce champs.</p> <?php endif; ?>
                        <input name="dateborn" type="date" class="form-control" placeholder="Date de naissance" value="<?php echo $usa->getElement()->toArray()['date_naissance']; ?>">
                    </div>
                </div>

                <!-- Lieu de naissance -->
                <div class="control-group">
                    <div class="form-group floating-label-form-group controls">
                        <label>Lieu de naissance</label>
                        <?php if(isset($placebornmissing)): ?><p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Veuillez renseigner ce champs.</p> <?php endif; ?>
                        <input name="placeborn" type="text" class="form-control" placeholder="Lieu de naissance" value="<?php echo $usa->getElement()->toArray()['lieu_naissance']; ?>">
                    </div>
                </div>

                <!-- Numero de securite sociale -->
                <div class="control-group">
                    <div class="form-group floating-label-form-group controls">
                        <label>Numéro de sécurité sociale</label>
                        <?php if(isset($numsecumissing)): ?><p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Veuillez renseigner ce champs.</p> <?php endif; ?>
                        <input name="numsecu" type="text" class="form-control" placeholder="Numéro de sécurité sociale" value="<?php echo $usa->getElement()->toArray()['num_secu']; ?>">
                    </div>
                </div>

                <!-- Médecin référent -->
                <div class="control-group">
                    <div class="form-group floating-label-form-group controls">
                        <label>Médecin référent</label>
                        <select name="medref" class="form-control">
                            <option selected="selected" value="null">Aucun</option>
                            <?php while($data = $rlistmed->fetch()) { ?>
                                <option value="<?php echo $data['id_medecin']; ?>" <?php if($usa->getElement()->toArray()['id_medecin'] == $data['id_medecin']) echo "selected=\"selected\""; ?>><?php echo "Docteur ".$data['nom']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <br>

                <div class="form-group submit-right">
                    <button type="submit" class="btn btn-primary" name="modifUsa">Modifier</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('../ressources/inc/footer.html'); ?>

<?php include('../ressources/inc/scripts.html'); ?>

</body>
</html>
