<?php

require('../ressources/Usager.php');
require('../ressources/dao/UsagerDAO.php');

session_start();

require_once('../ressources/Medecin.php');
require_once('../ressources/dao/MedecinDAO.php');

$listmed = new MedecinDAO(new Medecin(null, null, null, null));
$rlistmed = $listmed->getElementsByKeyword("");

if(isset($_POST['addUsa'])) {
    if(!empty($_POST['civilite'])
        && !empty($_POST['name'])
        && !empty($_POST['surname'])
        && !empty($_POST['address'])
        && !empty($_POST['dateborn'])
        && !empty($_POST['placeborn'])
        && !empty($_POST['numsecu'])
        && !empty($_POST['medref'])) {
        $usa = new Usager(null, $_POST['medref'], $_POST['civilite'], $_POST['name'], $_POST['surname'], $_POST['address'], $_POST['dateborn'], $_POST['placeborn'], $_POST['numsecu']);
        $rusa = new UsagerDAO($usa);
        if($rusa->exists()) {
            $exists = 1;
        } else {
            $_SESSION['added'] = $rusa->insert();
            header('Location: .');
        }
        unset($_POST);
    } else {
        if (empty($_POST['civilite'])) {
            $civilitemissing = 1;
        }

        if (empty($_POST['name'])) {
            $namemissing = 1;
        }

        if (empty($_POST['surname'])) {
            $surnamemissing = 1;
        }

        if (empty($_POST['address'])) {
            $addressmissing = 1;
        }

        if (empty($_POST['dateborn'])) {
            $datebornmissing = 1;
        }

        if (empty($_POST['placeborn'])) {
            $placebornmissing = 1;
        }

        if (empty($_POST['numsecu'])) {
            $numsecumissing = 1;
        }
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
                        <h1>Usagers</h1>
                        <span class="subheading">Ajout d'un usager</span>
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
                        <i class="fa fa-exclamation-circle"></i> Erreur : Usager déjà existant.
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

                    <!-- Civilite -->
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls">
                            <label>Civilité</label>
                            <?php if(isset($civilitemissing)): ?><p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Veuillez renseigner ce champs.</p> <?php endif; ?>
                            <select name="civilite" class="form-control">
                                <option value="Homme">Homme</option>
                                <option value="Femme">Femme</option>
                                <option value="Autre">Autre</option>
                            </select>
                        </div>
                    </div>

                    <!-- Nom -->
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls">
                            <label>Nom</label>
                            <?php if(isset($namemissing)): ?><p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Veuillez renseigner ce champs.</p> <?php endif; ?>
                            <input name="name" type="text" class="form-control" placeholder="Nom">
                        </div>
                    </div>

                    <!-- Prenom -->
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls">
                            <label>Prénom</label>
                            <?php if(isset($surnamemissing)): ?><p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Veuillez renseigner ce champs.</p> <?php endif; ?>
                            <input name="surname" type="text" class="form-control" placeholder="Prénom">
                        </div>
                    </div>

                    <!-- Adresse -->
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls">
                            <label>Adresse</label>
                            <?php if(isset($addressmissing)): ?><p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Veuillez renseigner ce champs.</p> <?php endif; ?>
                            <input name="address" type="text" class="form-control" placeholder="Adresse">
                        </div>
                    </div>

                    <!-- Date de naissance -->
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls">
                            <label>Adresse</label>
                            <?php if(isset($datebornmissing)): ?><p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Veuillez renseigner ce champs.</p> <?php endif; ?>
                            <input name="dateborn" type="date" class="form-control" placeholder="Date de naissance">
                        </div>
                    </div>

                    <!-- Lieu de naissance -->
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls">
                            <label>Lieu de naissance</label>
                            <?php if(isset($placebornmissing)): ?><p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Veuillez renseigner ce champs.</p> <?php endif; ?>
                            <input name="placeborn" type="text" class="form-control" placeholder="Lieu de naissance">
                        </div>
                    </div>

                    <!-- Numero de securite sociale -->
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls">
                            <label>Numéro de sécurité sociale</label>
                            <?php if(isset($numsecumissing)): ?><p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Veuillez renseigner ce champs.</p> <?php endif; ?>
                            <input name="numsecu" type="text" class="form-control" placeholder="Numéro de sécurité sociale">
                        </div>
                    </div>

                    <!-- Médecin référent -->
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls">
                            <label>Médecin référent</label>
                            <select name="medref" class="form-control">
                                <option selected="selected" value="Aucun">Aucun</option>
                                <?php while($data = $rlistmed->fetch()) { ?>
                                    <option value="<?php echo $data['id_medecin']; ?>"><?php echo "Docteur ".$data['nom']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <br>

                    <div class="form-group submit-right">
                        <button type="submit" class="btn btn-primary" name="addUsa">Ajouter</button>
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