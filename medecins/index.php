<?php
require('../ressources/login/logincheck.php');
if(!isConnected()) {
  header('Location: ..');
}

require('../ressources/Medecin.php');
require('../ressources/dao/MedecinDAO.php');

$med = new MedecinDAO(new Medecin(null, null, null, null));

if(isset($_POST['search'])) {
    $res = $med->getElementsByKeyword($_POST['keyword']);
} else {
    $res = $med->getElementsByKeyword("");
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
              <h1>Médecins</h1>
              <span class="subheading">Gestion des médecins du centre</span>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">

            <?php if(isset($_SESSION['updated'])) {
                switch($_SESSION['updated']) {
                    case 0: ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fa fa-exclamation-circle"></i> Erreur : Échec de la modification.
                        </div>
                        <?php break;
                    case 1: ?>
                        <div class="alert alert-success" role="alert">
                            <i class="fa fa-check-circle"></i> Succès : Modification effectuée.
                        </div>
                        <?php break;
                }
                unset($_SESSION['updated']);
            }

            if(isset($_SESSION['deleted'])) {
                switch($_SESSION['deleted']) {
                    case 1: ?>
                        <div class="alert alert-success" role="alert">
                            <i class="fa fa-check-circle"></i> Succès : Suppression effectuée.
                        </div>
                        <?php break;
                    case 2: ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fa fa-exclamation-circle"></i> Erreur : Un ou plusieurs usager(s) est/sont référencé(s) à ce médecin.
                        </div>
                        <?php break;
                    case 3: ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fa fa-exclamation-circle"></i> Erreur : Médecin inexistant.
                        </div>
                        <?php break;
                }
                unset($_SESSION['deleted']);
            }

            if(isset($_SESSION['added'])) {
                switch ($_SESSION['added']) {
                    case 0: ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fa fa-exclamation-circle"></i> Erreur : Ajout impossible.
                        </div>
                        <?php break;
                    case 1: ?>
                        <div class="alert alert-success" role="alert">
                            <i class="fa fa-check-circle"></i> Succès : Médecin ajouté.
                        </div>
                        <?php break;
                }
                unset($_SESSION['added']);
            }
            ?>

            <form method="POST" class="form-inline">
                    <div class="form-group floating-label-form-group control searchEntity">
                        <input type="text" class="form-control" placeholder="Exemple : John" name="keyword">
                    </div>
                    <button type="submit" class="btn btn-primary" name="search">Filtrer</button>
                    <div class="addEntity">
                        <a href="addMedecin.php" class="btn btn-info" role="button" aria-pressed="true"><i class="fa fa-plus"></i> Nouveau médecin</a>
                    </div>
            </form>
            <hr>

            <?php
            $nb = 1;
            while($data = $res->fetch()) {
                if($nb == 1) {
                    $nb++; ?>
                    <div class="card-deck">
                <?php } ?>
                <div class="card">
                    <div class="card-block">
                        <h4 class="card-title">Docteur <?php echo $data['nom']." ".$data['prenom']; ?></h4>
                        <table>
                            <tbody>
                            <tr>
                                <td class="icon-row-card bull_over">
                                    <i class="fa fa-venus"></i>
                                    <span class="popup-text">Civilité</span>
                                </td>
                                <td><?php echo $data['civilite']; ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">
                            <a href="modifMedecin.php?id=<?php echo $data['id_medecin']; ?>" class="card-link"><i class="fa fa-pencil"></i> Modifier</a>
                            <a href="supprMedecin.php?id=<?php echo $data['id_medecin']; ?>" class="card-link"><i class="fa fa-times-circle-o"></i> Supprimer</a>
                        </small>
                    </div>
                </div>
            <?php
                if($nb == 3) { ?>
                    </div>
                    <br>
                <?php $nb = 1;
                } else { $nb ++; }
            } ?>
        </div>
      </div>
    </div>

    <hr>

    <?php include('../ressources/inc/footer.html'); ?>

    <?php include('../ressources/inc/scripts.html'); ?>

  </body>
</html>
