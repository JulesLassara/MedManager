<?php

require('../ressources/login/logincheck.php');
if(!isConnected()) {
    header('Location: ../..');
}

require('../ressources/Medecin.php');
require('../ressources/dao/MedecinDAO.php');

require('../ressources/Usager.php');
require('../ressources/dao/UsagerDAO.php');

require('../ressources/RDV.php');
require('../ressources/dao/RDVDAO.php');

// S'il n'y a pas les clés primaires de la consultation en paramètre de l'URL
if(!isset($_GET['date']) && !isset($_GET['act_id_medecin'])) {
    header('Location: .');
}

// Vérification que l'id du médecin passé en paramètres existe
$verifmed = new MedecinDAO(new Medecin($_GET['act_id_medecin'], null, null, null));
if(!$verifmed->existsFromId()) {
    header('Location: .');
}

// Consultation
$rdv = new RDVDAO(new RDV(null, null, null, null));
$infosrdv = $rdv->getElementByIds($_GET['date'], $_GET['act_id_medecin']);

// Si la consultation n'existe pas
if($infosrdv == 0) {
    header('Location: .');
}

//Liste des usagers
$listusa = new UsagerDAO(new Usager(null, null, null, null, null, null, null, null, null));
$rlistusa = $listusa->getElementsByKeyword("");

//Traitement après avoir rempli le formulaire
if(isset($_POST['step1'])) {
    if(!isset($_POST['id_usager'])) $usagermissing = 1;
    else {
        header('Location: modifConsult2.php?date='.$_GET['date'].'&act_id_medecin='.$_GET['act_id_medecin'].'&id_usager='.$_POST['id_usager']);
    }
}

?>

<!doctype html>
<html lang="fr">

<?php include('../ressources/inc/head.html'); ?>

<body>

<?php include('../ressources/inc/nav.html'); ?>

<!-- Page Header -->
<header class="masthead" style="background-image: url('../img/consultations.jpg')">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="site-heading">
                    <h1>Consultations</h1>
                    <span class="subheading">Modification d'une consultation - Choix de l'usager</span>
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
                    <button type="submit" class="btn btn-danger" name="back"><i class="fa fa-chevron-left"></i> Retour</button>
                </div>
            </form>

            <form method="POST">
                <div class="control-group">
                    <div class="form-group controls">
                        <?php if(isset($usagermissing)): ?><p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Veuillez renseigner ce champs.</p> <?php endif; ?>
                        <select name="id_usager" class="form-control">
                            <option value="" disabled selected>Usager concerné</option>
                            <?php foreach($rlistusa as $data) { ?>
                                <option <?php if($infosrdv['id_usager'] == $data['id_usager']) echo "selected "; ?>value="<?php echo $data['id_usager']; ?>"><?php echo $data['nom']." ".$data['prenom']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <br>
                <div class="form-group submit-center">
                    <button type="submit" class="btn btn-success" name="step1">Modification du médecin</button>
                </div>
            </form>


        </div>
    </div>
</div>

<hr>

<?php include('../ressources/inc/footer.html'); ?>

<?php include('../ressources/inc/scripts.html'); ?>

</body>
</html>