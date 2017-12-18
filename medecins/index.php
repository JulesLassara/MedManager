<?php
require('../ressources/login/logincheck.php');
if(!isConnected()) {
  header('Location: ..');
}

require('../ressources/Medecin.php');
require('../ressources/dao/MedecinDAO.php');

$med = new MedecinDAO(new Medecin(null, null, null, null));
$updated = -1;

if(isset($_POST['modifDoc']) && isset($_SESSION['id'])) {
    $med->setElement(new Medecin($_SESSION['id'], $_POST['civilite'], $_POST['nom'], $_POST['prenom']));
    if($med->update()) {
        $updated = 1;
        $res = $med->getElementsByKeyword("");
    } else {
        $updated = 0;
        $res = $med->getElementsByKeyword("");
    }
    unset($_SESSION['id']);
} else if(isset($_GET['id'])) {
    $_SESSION['id'] = $_GET['id'];
    $valuesmed = $med->getElementById($_GET['id']);
    if($valuesmed == null) {
        header('Location: .');
    } else {
        $med->setElement(new Medecin($_GET['id'], $valuesmed['civilite'], $valuesmed['nom'], $valuesmed['prenom']));
    }
} else if(isset($_POST['search'])) {
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


            <?php if(isset($_GET['id']) && $updated == -1): ?>

            <form method="POST">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" name="back"><i class="fa fa-chevron-left"></i> Retour</button>
                </div>
            </form>

            <form method="POST">
                <div class="control-group">
                    <div class="form-group floating-label-form-group controls">
                        <label>Civilité</label>
                        <select name="civilite" class="form-control">
                            <option <?php if($med->getElement()->toArray()['civilite'] == "Homme") echo "selected=\"selected\""; ?> value="Homme">Homme</option>
                            <option <?php if($med->getElement()->toArray()['civilite'] == "Femme") echo "selected=\"selected\""; ?> value="Femme">Femme</option>
                            <option <?php if($med->getElement()->toArray()['civilite'] == "Autre") echo "selected=\"selected\""; ?> value="Autre">Autre</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <div class="form-group floating-label-form-group controls">
                        <label for="nom">Nom</label>
                        <input name="nom" type="text" class="form-control" value="<?php echo $med->getElement()->toArray()['nom']?>">
                    </div>
                </div>
                <div class="control-group">
                    <div class="form-group floating-label-form-group controls">
                        <label for="prenom">Prénom</label>
                        <input name="prenom" type="text" class="form-control" value="<?php echo $med->getElement()->toArray()['prenom']?>">
                    </div>
                </div>
                <br>
                <div class="form-group submit-right">
                    <button type="submit" class="btn btn-primary" name="modifDoc">Modifier</button>
                </div>
            </form>


            <?php else:
            if($updated == 0) { ?>
                <div class="alert alert-danger" role="alert">
                    <i class="fa fa-exclamation-circle"></i> Erreur : Échec de la mise à jour.
                </div>
            <?php } elseif ($updated == 1) { ?>
                <div class="alert alert-success" role="alert">
                    <i class="fa fa-check-circle"></i> Succès : Mise à jour effectuée.
                </div>
            <?php }

            if(isset($_SESSION['deleted'])) {
                switch($_SESSION['deleted']) {
                    case 1: ?>
                        <div class="alert alert-success" role="alert">
                            <i class="fa fa-check-circle"></i> Succès : Suppression effectuée.
                        </div>
                        <?php break;
                    case 2: ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fa fa-exclamation-circle"></i> Erreur : Échec de la suppression.
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
            ?>

            <form method="POST" class="form-inline">
                    <div class="form-group floating-label-form-group control searchMed">
                        <input type="text" class="form-control" placeholder="Exemple : John" name="keyword">
                    </div>
                    <button type="submit" class="btn btn-primary" name="search">Rechercher</button>
                    <div class="addMed">
                        <a href="addMedecin.php" class="btn btn-info" role="button" aria-pressed="true">Ajouter un médecin</a>
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
                            <a href="index.php?id=<?php echo $data['id_medecin']; ?>" class="card-link"><i class="fa fa-pencil"></i> Modifier</a>
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
            }
            endif; ?>
        </div>
      </div>
    </div>

    <hr>

    <?php include('../ressources/inc/footer.html'); ?>

    <?php include('../ressources/inc/scripts.html'); ?>

  </body>
</html>
