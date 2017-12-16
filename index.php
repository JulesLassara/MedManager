<?php
session_start();
if(isset($_POST['connect'])) {
  if(empty($_POST['login'])) {
    $loginmissing = 1;
  }
  if(empty($_POST['password'])) {
    $passwordmissing = 1;
  }
  $_SESSION['login'] = $_POST['login'];
  $_SESSION['password'] = $_POST['password'];
}
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Gestionnaire de cabinet médical">
    <meta name="author" content="Jules Lassara">

    <title>MedManager</title>

    <!-- Bootstrap CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts -->
    <link rel="stylesheet" href="https://opensource.keycdn.com/fontawesome/4.7.0/font-awesome.min.css" integrity="sha384-dNpIIXE8U05kAbPhy3G1cz+yZmTzA6CY8Vg/u2L9xRnHjJiAK76m2BIEaSEV+/aU" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <!-- CSS -->
    <link href="css/style.css" rel="stylesheet">
  </head>

  <body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand" href=".">MedManager</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fa fa-bars"></i>
        </button>
      <?php
      if(isset($_SESSION['login']) && isset($_SESSION['password'])):
        if($_SESSION['login'] == "admin" && $_SESSION['password'] == "admin"): ?>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="usagers">Usagers</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="medecins">Médecins</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="consultations">Consultations</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="stats">Statistiques</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="ressources/login/disconnect.php"><i class="fa fa-power-off"></i> Se déconnecter</a>
            </li>
          </ul>
        </div>
      </div>
    <?php
      endif;
    endif;
    ?>
    </nav>

    <!-- Page Header -->
    <header class="masthead" style="background-image: url('img/home-bg.jpg')">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <div class="site-heading">
              <h1>MedManager</h1>
              <span class="subheading">Gestionnaire de Cabinet Médical</span>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
        <?php
        if(isset($_SESSION['login']) && isset($_SESSION['password'])){
          if($_SESSION['login'] == "admin" && $_SESSION['password'] == "admin") { ?>
            <p>Bienvenue. Cet outil de travail vous permet de gérer les médecins, les usagers ainsi que les consultations prévues au sein du centre. Pour tout problème technique ou d'utilisation, veuillez contacter Jules Lassara.</p>
          <?php } else { ?>
            <p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Identifiant et/ou mot de passe incorrect.</p>
          <?php
                  unset($_SESSION['login']);
                  unset($_SESSION['password']);
                }
        }
        if(!isset($_SESSION['login']) && !isset($_SESSION['password'])) {?>
          <p>Cet outil de travail est reservé au personnel du centre médical. Veuillez vous identifier pour continuer votre navigation.</p>
          <form method="POST">
            <div class="control-group">
              <div class="form-group floating-label-form-group controls">
                <label>Identifiant</label>
                <?php if(isset($loginmissing)): ?><p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Veuillez renseigner ce champs.</p> <?php endif; ?>
                <input type="text" class="form-control" placeholder="Identifiant" name="login" value="<?php if(isset($_POST['login'])) echo $_POST['login'] ?>">
              </div>
            </div>
            <div class="control-group">
              <div class="form-group floating-label-form-group controls">
                <label>Mot de passe</label>
                <?php if(isset($passwordmissing)): ?><p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Veuillez renseigner ce champs.</p> <?php endif; ?>
                <input type="password" class="form-control" placeholder="Mot de passe" name="password">
              </div>
            </div>
            <br>
            <div class="form-group">
              <button type="submit" class="btn btn-primary" name="connect">Se connecter</button>
            </div>
          </form>
        <?php } ?>
        </div>
      </div>
    </div>

    <hr>

    <!-- Footer -->
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <p class="copyright text-muted">Copyright &copy; Jules Lassara 2017</p>
          </div>
        </div>
      </div>
    </footer>

    <!-- Bootstrap JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript -->
    <script src="js/script.js"></script>

  </body>

</html>
