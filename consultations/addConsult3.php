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

require('../ressources/Util.php');

//Vérification qu'un id est passé en paramètre
if(!isset($_GET['id_usager']) || !isset($_GET['id_medecin']) || !isset($_GET['duree_rdv'])) {
    $_SESSION['consult_erreur'] = "Adresse invalide.";
    header('Location: .');
}

// Retour à l'étape 2
if(isset($_POST['backstep2'])) {
    header('Location: addConsult2.php?id_usager='.$_GET['id_usager']);
}

// Si le formulaire pour plus de consultations a été rempli
if(isset($_POST['more_rdv'])) {
    if(is_numeric($_POST['nb_more_rdv'])) {
        $more_rdv = $_POST['nb_more_rdv'];
    } else {
        $more_rdv = 0;
    }
} else {
    $more_rdv = 0;
}

// Vérification que l'id de l'usager passé en paramètre existe
$usa = new UsagerDAO(new Usager($_GET['id_usager'], null, null, null, null, null, null, null, null));
if(!$usa->existsFromId()) {
    $_SESSION['consult_erreur'] = "Usager de la consultation inexistant.";
    header('Location: .');
}

// Vérification que l'id du médecin passé en paramètre existe
$med = new MedecinDAO(new Medecin($_GET['id_medecin'], null, null, null));
if(!$med->existsFromId()) {
    $_SESSION['consult_erreur'] = "Médecin de la consultation inexistant.";
    header('Location: .');
}

// Vérification de la durée de la consulation passée en paramètre
if($_GET['duree_rdv'] != 30
&& $_GET['duree_rdv'] != 60
&& $_GET['duree_rdv'] != 90
&& $_GET['duree_rdv'] != 120
&& $_GET['duree_rdv'] != 150) {
    $_SESSION['consult_erreur'] = "Durée de rendez-vous invalide.";
    header('Location: .');
}

//Ajout de la consultation
if(isset($_POST['step3'])) {
    $datetmp = DateTime::createFromFormat('d/m/Y H:i:s', $_POST['horaire']);
    $rdv = new RDVDAO(new RDV($datetmp, $_GET['id_usager'], $_GET['id_medecin'], $_GET['duree_rdv']));
    $_SESSION['consult_added'] = $rdv->insert();
    header('Location: .');
}

// Jour courant
$today = new DateTime(date('Y-m-d H:i:s', time()));

// Création du premier créneau
if($today->format("i") < 30) {
    $today->setTime($today->format("H"), 30, 0);
} else {
    $today->setTime($today->format("H"), 0, 0);
    $today->modify('+1 hour');
}

// Création du rdv courant
$currentrdv = new RDV($today, null, null, 30);

// Liste des créneaux déjà occupés
$listrdv = new RDVDAO($currentrdv);
$allrdv = $listrdv->getElementsByIdMedecin($_GET['id_medecin'], false)->fetchAll(PDO::FETCH_ASSOC);

// Créneaux dispos (20 premiers)
$rdvs = array();

// Tant qu'il n'y a pas 20 créneaux disponibles
while (sizeof($rdvs) < 20 + $more_rdv) {

    // Si l'heure de fin du rdv ne dépasse pas 17h30 et que ce n'est pas dimanche
    if($currentrdv->getDateheureFin()->format("H") <= 17
        && $currentrdv->getDateheure()->format("w") != 0) {
        $overlap = false;

        // Parcours de tous les rendez-vous
        foreach($allrdv as $data) {
            $overlap = checkOverlap($currentrdv, $data);

            // S'il y a chevauchement : sortie de la boucle
            if($overlap) break;

        }

        // Si le rendez-vous courant n'en chevauche pas un autre
        if(!$overlap) {
            $rdvs[sizeof($rdvs)] = $currentrdv->getDateheure()->format("d/m/Y H:i:s");
        }
        // Horaire suivant
        $currentrdv->nextSlot();
    } else {
        // Jour suivant
        $currentrdv->nextDay();
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
                    <button type="submit" class="btn btn-danger" name="back"><i class="fa fa-chevron-left"></i> Retour</button>
                </div>
            </form>

            <form method="POST">
                <div class="control-group">
                    <div class="form-group controls">
                        <?php if(isset($horairemissing)): ?><p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Veuillez renseigner ce champs.</p> <?php endif; ?>
                        <select name="horaire" class="form-control">
                            <option value="" disabled selected><?php echo 20 + $more_rdv; ?> premiers créneaux disponibles</option>
                            <?php foreach($rdvs as $rdv) { ?>
                                <option value="<?php echo $rdv; ?>"><?php echo $rdv; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-inline">
                    <input type="number" class="form-control" placeholder="Exemple : 30" name="nb_more_rdv">
                    <button type="submit" class="btn btn-info" name="more_rdv">Plus de créneaux</button>
                </div>
                <br>
                <div class="submit-center form-group">
                    <button type="submit" class="btn btn-primary" name="backstep2">Choix de la date</button>
                    <button type="submit" class="btn btn-success" name="step3">Enregistrer la consultation</button>
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