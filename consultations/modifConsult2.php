<?php

require('../ressources/login/logincheck.php');
if(!isConnected()) {
    header('Location: ..');
}

require('../ressources/Usager.php');
require('../ressources/dao/UsagerDAO.php');

require('../ressources/Medecin.php');
require('../ressources/dao/MedecinDAO.php');

require('../ressources/RDV.php');
require('../ressources/dao/RDVDAO.php');

// Vérification qu'un id d'usagerest passé en paramètre
if(!isset($_GET['id_usager'])) {
    header('Location: .');
}

// Retour à l'étape 1
if(isset($_POST['backstep1'])) {
    header('Location: modifConsult1.php?date='.$_GET['date'].'&act_id_medecin='.$_GET['act_id_medecin']);
}

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

// Vérification que l'id de l'usager passé en paramètre existe
$usa = new UsagerDAO(new Usager($_GET['id_usager'], null, null, null, null, null, null, null, null));
if(!$usa->existsFromId()) {
    header('Location: .');
}

// Informations de l'usager
$list = $usa->getElementById($_GET['id_usager']);
$usa->setElement(new Usager($_GET['id_usager'], $list['id_medecin'], $list['civilite'], $list['nom'], $list['prenom'], $list['adresse'], $list['date_naissance'], $list['lieu_naissance'], $list['num_secu']));

// Liste des médecins
$listmed = new MedecinDAO(new Medecin(null, null, null, null));
$rlistmed = $listmed->getElementsByKeyword("");

// Traitement après avoir rempli le formulaire
if(isset($_POST['step2'])) {
    if(!isset($_POST['id_med'])) $medecinmissing = 1;
    else if(!isset($_POST['duree_rdv'])) $dureemissing = 1;
    else {
        header('Location: modifConsult3.php?date='.$_GET['date'].'&act_id_medecin='.$_GET['act_id_medecin'].'&id_usager='.$_GET['id_usager']."&id_medecin=".$_POST['id_med']."&duree_rdv=".$_POST['duree_rdv']);
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
                    <span class="subheading">Modification d'une consultation - Choix du médecin et de la durée de la consultation</span>
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
                        <?php if(isset($medecinmissing)): ?><p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Veuillez renseigner ce champs.</p> <?php endif; ?>
                        <select name="id_med" class="form-control">
                            <option value="" disabled selected>Médecins</option>
                            <?php foreach($rlistmed as $data) { ?>
                                <option <?php if($_GET['act_id_medecin'] == $data['id_medecin']) echo "selected "; ?> value="<?php echo $data['id_medecin']; ?>" <?php if($usa->getElement()->toArray()['id_medecin'] == $data['id_medecin']) echo "selected"; ?>><?php echo "Docteur ".$data['nom']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <div class="form-group controls">
                        <?php if(isset($dureemissing)): ?><p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Veuillez renseigner ce champs.</p> <?php endif; ?>
                        <select name="duree_rdv" class="form-control">
                            <option value="" disabled>Durée de la consultation</option>
                            <option value="30" <?php if($infosrdv['duree_rdv'] == 30) echo "selected"; ?>>00:30:00</option>
                            <option value="60" <?php if($infosrdv['duree_rdv'] == 60) echo "selected"; ?>>01:00:00</option>
                            <option value="90" <?php if($infosrdv['duree_rdv'] == 90) echo "selected"; ?>>01:30:00</option>
                            <option value="120" <?php if($infosrdv['duree_rdv'] == 120) echo "selected"; ?>>02:00:00</option>
                            <option value="150" <?php if($infosrdv['duree_rdv'] == 150) echo "selected"; ?>>02:30:00</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="form-group submit-center">
                    <button type="submit" class="btn btn-primary" name="backstep1">Modification de l'usager</button>
                    <button type="submit" class="btn btn-success" name="step2">Modification de la date</button>
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