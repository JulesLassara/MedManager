<?php
require('../ressources/login/logincheck.php');
if(!isConnected()) {
    header('Location: ..');
}

require('../ressources/Medecin.php');
require('../ressources/dao/MedecinDAO.php');

// Si le formulaire a validé
if(isset($_POST['addDoc'])) {
    // Si tous les champs ont été remplis
    if(!empty($_POST['civilite'])
    && !empty($_POST['name'])
    && !empty($_POST['surname'])) {

        // Création du médecin
        $med = new Medecin(null, $_POST['civilite'], $_POST['name'], $_POST['surname']);
        $rmed = new MedecinDAO($med);

        // Insertion s'il n'existe pas déjà
        if($rmed->exists()) {
            $exists = 1;
        } else {
            $_SESSION['added'] = $rmed->insert();
            header('Location: .');
        }
        unset($_POST);
    } else {
        // Champs manquants
        if (!isset($_POST['civilite'])) $civilitemissing = 1;
        else if($_POST['civilite'] != "Homme" && $_POST['civilite'] != "Femme" && $_POST['civilite'] != "Autre") $civilitemissing = 1;

        if(empty($_POST['name'])) $namemissing = 1;

        if(empty($_POST['surname'])) $surnamemissing = 1;
    }
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
                    <?php if(isset($exists)) { ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fa fa-exclamation-circle"></i> Erreur : Médecin déjà existant.
                        </div>
                    <?php unset($exists);
                    }
                    ?>

                    <form method="POST" action=".">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" name="back"><i class="fa fa-chevron-left"></i> Retour</button>
                        </div>
                    </form>

                    <form method="POST">
                        <div class="control-group">
                            <div class="form-group controls">
                                <?php if(isset($civilitemissing)): ?><p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Veuillez renseigner ce champs.</p> <?php endif; ?>
                                <select name="civilite" class="form-control">
                                    <option value="" disabled selected>Civilité</option>
                                    <option value="Homme">Homme</option>
                                    <option value="Femme">Femme</option>
                                    <option value="Autre">Autre</option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="form-group floating-label-form-group controls">
                                <label>Nom</label>
                                <?php if(isset($namemissing)): ?><p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Veuillez renseigner ce champs.</p> <?php endif; ?>
                                <input name="name" type="text" class="form-control" placeholder="Nom">
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="form-group floating-label-form-group controls">
                                <label>Prénom</label>
                                <?php if(isset($surnamemissing)): ?><p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Veuillez renseigner ce champs.</p> <?php endif; ?>
                                <input name="surname" type="text" class="form-control" placeholder="Prénom">
                            </div>
                        </div>
                        <br>
                        <div class="form-group submit-right">
                            <button type="submit" class="btn btn-primary" name="addDoc">Ajouter</button>
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