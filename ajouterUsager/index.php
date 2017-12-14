<?php

require('../ressources/Usager.php');
require('../ressources/dao/UsagerDAO.php');

session_start();

if(isset($_POST['addUsa'])) {
    if(!empty($_POST['civilite'])
        && !empty($_POST['name'])
        && !empty($_POST['surname'])
        && !empty($_POST['address'])
        && !empty($_POST['dateborn'])
        && !empty($_POST['placeborn'])
        && !empty($_POST['numsecu'])
        && !empty($_POST['medref'])) {
        $usa = new Usager(null, $_POST['civilite'], $_POST['name'], $_POST['surname'], $_POST['address'], $_POST['dateborn'], $_POST['placeborn'], $_POST['numsecu'], $_POST['medref']);
        $rusa = new UsagerDAO($usa);
        if($rusa->exists()) {
            $_SESSION['infoUsa'] = 3;
        } else {
            $_SESSION['infoUsa'] = $rusa->insert();
        }
        unset($_POST);
    } else {
        $_SESSION['infoUsa'] = 2;
    }
} else {
    // TODO régler soucis require (conflits)
    require_once('../ressources/Medecin.php');
    require_once('../ressources/dao/MedecinDAO.php');

    $listmed = new MedecinDAO(new Medecin(null, null, null, null));

    $_SESSION['infoUsa'] = 4;
}

?>

    <!doctype html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>GCM | Ajouter un usager</title>
    </head>
    <body>

    <h1>Ajouter un usager</h1>

    <?php
    switch($_SESSION['infoUsa']) {
        case 0:
            echo "Erreur: Insertion impossible.";
            break;
        case 1:
            echo "Succès: Usager ajouté.";
            break;
        case 2:
            echo "Attention: Veuillez renseigner tous les champs.";
            break;
        case 3:
            echo "Erreur: Usager déjà existant.";
            break;
    }
    echo "<br>";
    ?>

    <form method="post">
        <label for="civilite">Civilité</label>
        <select name="civilite">
            <option value="Homme">Homme</option>
            <option value="Femme">Femme</option>
            <option value="Autre">Autre</option>
        </select>

        <br>

        <label for="name">Nom</label>
        <input name="name" type="text">

        <br>

        <label for="surname">Prénom</label>
        <input name="surname" type="text">

        <br>

        <label for="address">Adresse</label>
        <input name="address" type="text">

        <br>

        <label for="dateborn">Date de naissance</label>
        <input name="dateborn" type="date">

        <br>

        <label for="placeborn">Lieu de naissance</label>
        <input name="placeborn" type="text">

        <br>

        <label for="numsecu">Numéro de sécurité sociale</label>
        <input name="numsecu" type="text">

        <br>

        <label for="medref">Médecin référent</label>
        <select name="medref">
            <?php while($data = $listmed->getElementsByKeyword("")->fetch()) { ?>
                <option value="<?php echo $data['id_medecin']?>"><?php echo "Docteur ".$data['nom'] ?></option>
            <?php } ?>
        </select>
        <br>

        <button name="addUsa" type="submit">Ajouter</button>

    </form>

    </body>
    </html>

<?php
unset($_SESSION['infoUsa']);
?>