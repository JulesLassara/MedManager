<?php

session_start();

require('../ressources/Medecin.php');
require('../ressources/dao/MedecinDAO.php');

$med = new MedecinDAO(new Medecin(null, null, null, null));

if(isset($_POST['modifDoc'])) {

    if(!empty($_POST['civilite'])
        && !empty($_POST['name'])
        && !empty($_POST['surname'])) {

        $med->setElement(new Medecin($_SESSION['id'], $_POST['civilite'], $_POST['name'], $_POST['surname']));
        if($med->update()) {
            $_SESSION['updated'] = 1;
        } else {
            $_SESSION['updated'] = 0;
        }
        unset($_SESSION['id']);
        header('Location: .');

    } else {
        if(empty($_POST['civilite'])) $civilitemissing = 1;

        if(empty($_POST['name'])) $namemissing = 1;

        if(empty($_POST['surname'])) $surnamemissing = 1;
    }

}

if(isset($_GET['id'])) {
    $_SESSION['id'] = $_GET['id'];
    $valuesmed = $med->getElementById($_GET['id']);
    if($valuesmed == null) {
        header('Location: .');
    } else {
        $med->setElement(new Medecin($_GET['id'], $valuesmed['civilite'], $valuesmed['nom'], $valuesmed['prenom']));
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
                        <div class="control-group">
                            <div class="form-group floating-label-form-group controls">
                                <label>Civilité</label>
                                <?php if(isset($civilitemissing)): ?><p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Veuillez renseigner ce champs.</p> <?php endif; ?>
                                <select name="civilite" class="form-control">
                                    <option <?php if($med->getElement()->toArray()['civilite'] == "Homme") echo "selected=\"selected\""; ?> value="Homme">Homme</option>
                                    <option <?php if($med->getElement()->toArray()['civilite'] == "Femme") echo "selected=\"selected\""; ?> value="Femme">Femme</option>
                                    <option <?php if($med->getElement()->toArray()['civilite'] == "Autre") echo "selected=\"selected\""; ?> value="Autre">Autre</option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="form-group floating-label-form-group controls">
                                <label>Nom</label>
                                <?php if(isset($namemissing)): ?><p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Veuillez renseigner ce champs.</p> <?php endif; ?>
                                <input name="name" type="text" class="form-control" value="<?php echo $med->getElement()->toArray()['nom']?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="form-group floating-label-form-group controls">
                                <label>Prénom</label>
                                <?php if(isset($surnamemissing)): ?><p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Veuillez renseigner ce champs.</p> <?php endif; ?>
                                <input name="surname" type="text" class="form-control" value="<?php echo $med->getElement()->toArray()['prenom']?>">
                            </div>
                        </div>
                        <br>
                        <div class="form-group submit-right">
                            <button type="submit" class="btn btn-primary" name="modifDoc">Modifier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php include('../ressources/inc/footer.html'); ?>

        <?php include('../ressources/inc/scripts.html'); ?>

    </body>
</html>
