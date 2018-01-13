<?php

require('../ressources/login/logincheck.php');
if(!isConnected()) {
    header('Location: ../..');
}

require('../ressources/Usager.php');
require('../ressources/dao/UsagerDAO.php');

//Liste des usagers
$listusa = new UsagerDAO(new Usager(null, null, null, null, null, null, null, null, null));
$rlistusa = $listusa->getElementsByKeyword("");

//Traitement après avoir rempli le formulaire
if(isset($_POST['step1'])) {
    if(!isset($_POST['id_usager'])) $usagermissing = 1;
    else {
        header('Location: addConsult2.php?id_usager='.$_POST['id_usager']);
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
                    <span class="subheading">Ajout d'une consultation - Choix de l'usager</span>
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
                        <?php if(isset($usagermissing)): ?><p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Veuillez renseigner ce champs.</p> <?php endif; ?>
                        <select name="id_usager" class="form-control">
                            <option value="" disabled selected>Usager concerné</option>
                            <?php foreach($rlistusa as $data) { ?>
                                <option value="<?php echo $data['id_usager']; ?>"><?php echo $data['nom']." ".$data['prenom']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <br>
                <div class="form-group submit-right">
                    <button type="submit" class="btn btn-primary" name="step1">Choix du médecin</button>
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