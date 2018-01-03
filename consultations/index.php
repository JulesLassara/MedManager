<?php

require('../ressources/login/logincheck.php');
if(!isConnected()) {
    header('Location: ..');
}

require('../ressources/Usager.php');
require('../ressources/dao/UsagerDAO.php');

require('../ressources/Medecin.php');
require('../ressources/dao/MedecinDAO.php');

// Calendar
require('../ressources/Calendar.php');

if(!isset($_SESSION['usagers'])) {
    $listusa = new UsagerDAO(new Usager(null, null, null, null, null, null, null, null, null));
    $_SESSION['usagers'] = $listusa->getElementsByKeyword("");
}

//Récupération de l'usager du RDV
if(isset($_POST['step1'])) {
    if(!isset($_POST['usager'])) $usagermissing = 1;
    else {
        //TODO MODIFIER LA CREATION DE L'USAGER C'EST ULTRA MOCHE
        $tmpusa = new UsagerDAO(new Usager(null, null, null, null, null, null, null, null, null));
        $list = $tmpusa->getElementById($_POST['usager']);
        $_SESSION['usagerRDV'] = new Usager($_POST['usager'], $list['id_medecin'], $list['civilite'], $list['nom'], $list['prenom'], $list['adresse'], $list['date_naissance'], $list['lieu_naissance'], $list['num_secu']);
        $listmed = new MedecinDAO(new Medecin(null, null, null, null));
        $_SESSION['medecins'] = $listmed->getElementsByKeyword("");
    }
}

//Récupération du médecin du RDV
if(isset($_POST['step2'])) {
    if(!isset($_POST['medecin'])) $medecinmissing = 1;
    else if(!isset($_POST['dureerdv'])) $dureemissing = 1;
    else {
        //TODO MODIFIER LA CREATION DE L'USAGER C'EST ULTRA MOCHE
        $tmpmed = new MedecinDAO(new Medecin(null, null, null, null));
        $list = $tmpmed->getElementById($_POST['medecin']);
        $_SESSION['medecinRDV'] = new Medecin($_POST['medecin'], $list['civilite'], $list['nom'], $list['prenom']);
        //TODO search consults
    }
}

?>

<!DOCTYPE HTML>
<html>

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
              <span class="subheading">Gestion des consultations</span>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">

            <!-- Ajouter une consultation -->

            <form method="POST" class="form-inline">
                <div class="form-group floating-label-form-group control searchEntity">
                    <input type="text" class="form-control" placeholder="Exemple : John" name="keyword">
                </div>
                <button type="submit" class="btn btn-primary" name="search">Filtrer</button>
                <div class="addEntity">
                    <a href="#newConsultation" class="btn btn-info" role="button" aria-pressed="true"><i class="fa fa-plus"></i> Nouvelle consultation</a>
                </div>
            </form>

            <br>
            <h3 class="calendartitle"><a href="?ma=<?php echo $prev; ?>"><i class="fa fa-chevron-left"></i></a> <?php echo $html_title; ?> <a href="?ma=<?php echo $next; ?>"><i class="fa fa-chevron-right"></i></a></h3>

            <br>
            <table class="table table-bordered">
                <tr>
                    <th class="headday">Dim</th>
                    <th class="headday">Lun</th>
                    <th class="headday">Mar</th>
                    <th class="headday">Mer</th>
                    <th class="headday">Jeu</th>
                    <th class="headday">Ven</th>
                    <th class="headday">Sam</th>
                </tr>
                <?php
                foreach ($weeks as $week) {
                    echo $week;
                }
                ?>
            </table>

            <!-- NOUVELLE CONSULTATION -->
            <div id="newConsultation">
                <div class="popup_win">
                    <a class="close" href=""><i class="fa fa-times-circle close-btn"></i></a>

                    <?php if(isset($_POST['step1']) && !isset($usagermissing)): ?>

                    <!-- STEP 2 -->
                    <h2>Nouvelle consultation - 2/3</h2>

                    <form method="POST">
                        <div class="control-group">
                            <div class="form-group controls">
                                <?php if(isset($medecinmissing)): ?><p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Veuillez renseigner ce champs.</p> <?php endif; ?>
                                <select name="medecin" class="form-control">
                                    <option value="" disabled selected>Médecin</option>
                                    <?php while($data = $_SESSION['medecins']->fetch()) { ?>
                                        <option value="<?php echo $data['id_medecin']; ?>" <?php if($_SESSION['usagerRDV']->toArray()['id_medecin'] == $data['id_medecin']) echo "selected"; ?>><?php echo "Docteur ".$data['nom']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="form-group controls">
                                <?php if(isset($dureemissing)): ?><p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Veuillez renseigner ce champs.</p> <?php endif; ?>
                                <select name="duree_rdv" class="form-control">
                                    <option value="" disabled>Durée de la consultation</option>
                                    <option value="30" selected>00:30:00</option>
                                    <option value="60">01:00:00</option>
                                    <option value="90">01:30:00</option>
                                    <option value="120">02:00:00</option>
                                    <option value="150">02:30:00</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" name="backstep1">Choix de l'usager</button>
                            <button type="submit" class="btn btn-primary" name="step2">Choix de la date</button>
                        </div>
                    </form>

                    <?php elseif(isset($_POST['step2']) && !isset($medecinmissing)): ?>

                    <!-- STEP 3 -->
                    <h2>Nouvelle consultation - 3/3</h2>

                    <form method="POST">
                        <div class="control-group">
                            <div class="form-group controls">
                                <?php if(isset($medecinmissing)): ?><p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Veuillez renseigner ce champs.</p> <?php endif; ?>
                                <select name="civilite" class="form-control">
                                    <option value="" disabled selected>Médecin</option>
                                    <?php while($data = $_SESSION['medecins']->fetch()) { ?>
                                        <option value="<?php echo $data['id_medecin']; ?>" <?php if($_SESSION['usagerRDV']->getElement()->toArray()['id_medecin'] == $data['id_medecin']) echo "selected"; ?>><?php echo "Docteur ".$data['nom']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="form-group submit-right">
                            <button type="submit" class="btn btn-primary" name="step3">Enregistrer la consultation</button>
                        </div>
                    </form>

                    <?php else: ?>

                        <!-- STEP 1 -->
                        <h2>Nouvelle consultation - 1/3</h2>

                        <form method="POST">
                            <div class="control-group">
                                <div class="form-group controls">
                                    <?php if(isset($usagermissing)): ?><p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Veuillez renseigner ce champs.</p> <?php endif; ?>
                                    <select name="usager" class="form-control">
                                        <option value="" disabled selected>Usager concerné</option>
                                        <?php while($data = $_SESSION['usagers']->fetch()) { ?>
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

                    <?php endif; ?>

                </div>
            </div>
            <!-- END NOUVELLE CONSULTATION -->

        </div>
      </div>
    </div>

    <hr>

    <?php include('../ressources/inc/footer.html'); ?>

    <?php include('../ressources/inc/scripts.html'); ?>

  </body>
</html>
