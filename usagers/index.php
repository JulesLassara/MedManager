<?php
require('../ressources/login/logincheck.php');
if(!isConnected()) {
    header('Location: ..');
}

require('../ressources/Usager.php');
require('../ressources/Medecin.php');
require('../ressources/dao/UsagerDAO.php');
require('../ressources/dao/MedecinDAO.php');

$usa = new UsagerDAO(new Usager(null, null, null, null, null, null, null, null, null));
$med = new MedecinDAO(new Medecin(null, null, null, null));

if(isset($_POST['search'])) {
    $res = $usa->getElementsByKeyword($_POST['keyword']);
} else {
    $res = $usa->getElementsByKeyword("");
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
                    <h1>Usagers</h1>
                    <span class="subheading">Gestion des usagers du centre</span>
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
                            <i class="fa fa-exclamation-circle"></i> Erreur : Échec de la suppression.
                        </div>
                        <?php break;
                    case 3: ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fa fa-exclamation-circle"></i> Erreur : Usager inexistant.
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
                            <i class="fa fa-check-circle"></i> Succès : Usager ajouté.
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
                    <a href="addUsager.php" class="btn btn-info" role="button" aria-pressed="true"><i class="fa fa-plus"></i> Nouvel usager</a>
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
                        <h4 class="card-title"><?php echo $data['nom']." ".$data['prenom']; ?></h4>
                        <table>
                            <tbody>
                            <tr>
                                <td class="icon-row-card bull_over">
                                    <i class="fa fa-venus"></i>
                                    <span class="popup-text">Civilité</span>
                                </td>
                                <td><?php echo $data['civilite']; ?></td>
                            </tr>
                            <tr>
                                <td class="icon-row-card bull_over">
                                    <i class="fa fa-map-marker"></i>
                                    <span>Adresse</span>
                                </td>
                                <td><?php echo $data['adresse']; ?></td>
                            </tr>
                            <tr>
                                <td class="icon-row-card bull_over">
                                    <i class="fa fa-calendar-plus-o"></i>
                                    <span>Date et lieu de naissance</span>
                                </td>
                                <td><?php echo date("d/m/Y", strtotime($data['date_naissance']))." - ".$data['lieu_naissance']; ?></td>
                            </tr>
                            <tr>
                                <td class="icon-row-card bull_over">
                                    <i class="fa fa-id-card-o"></i>
                                    <span>Numéro de sécurité sociale</span>
                                </td>
                                <td><?php echo $data['num_secu']; ?></td>
                            </tr>
                            <tr>
                                <td class="icon-row-card bull_over">
                                    <i class="fa fa-user-circle-o"></i>
                                    <span>Médecin référent</span>
                                </td>
                                <td><?php echo "Docteur ".$med->getElementById($data['id_medecin'])['nom']." ".$med->getElementById($data['id_medecin'])['prenom']; ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">
                            <a href="modifUsager.php?id=<?php echo $data['id_usager']; ?>" class="card-link"><i class="fa fa-pencil"></i> Modifier</a>
                            <a href="supprUsager.php?id=<?php echo $data['id_usager']; ?>" class="card-link"><i class="fa fa-times-circle-o"></i> Supprimer</a>
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
