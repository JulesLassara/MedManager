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

//Vérification qu'un id est passé en paramètre
if(!isset($_GET['id_usager']) || !isset($_GET['id_medecin']) || !isset($_GET['duree_rdv'])) {
    header('Location: addConsult1.php');
}

//Retour à l'étape 2
if(isset($_POST['backstep2'])) {
    header('Location: addConsult2.php?id_usager='.$_GET['id_usager']);
}

//Vérification que l'id de l'usager passé en paramètre existe
$usa = new UsagerDAO(new Usager($_GET['id_usager'], null, null, null, null, null, null, null, null));
if(!$usa->existsFromId()) {
    header('Location: addConsult1.php'); //TODO: message expliquant pq la redirection
}

//Vérification que l'id du médecin passé en paramètre existe
$med = new MedecinDAO(new Medecin($_GET['id_medecin'], null, null, null));
if(!$med->existsFromId()) {
    header('Location: addConsult1.php'); //TODO: message expliquant pq la redirection
}

//Vérification de la durée de la consulation passée en paramètre
if($_GET['duree_rdv'] != 30
&& $_GET['duree_rdv'] != 60
&& $_GET['duree_rdv'] != 90
&& $_GET['duree_rdv'] != 120
&& $_GET['duree_rdv'] != 150) {
    header('Location: addConsult1.php'); //TODO: message expliquant pq la redirection
}

//Ajout de la consultation
if(isset($_POST['step3'])) {
    $rdv = new RDVDAO(new RDV("2018-01-20 10:00:00", $_GET['id_usager'], $_GET['id_medecin'], $_GET['duree_rdv'])); //TODO modif datetime lol
    echo $rdv->insert();
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
                    <h1>Consultations</h1>
                    <span class="subheading">Ajout d'une consultation - Choix de la date</span>
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
                    <div class="form-group controls">
                        <?php if(isset($horairemissing)): ?><p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Veuillez renseigner ce champs.</p> <?php endif; ?>
                        <select name="horaire" class="form-control">
                            <option value="" disabled selected>Créneaux disponibles</option>

                        </select>
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" name="backstep2">Choix de la date</button>
                    <button type="submit" class="btn btn-primary" name="step3">Enregistrer la consultation</button>
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