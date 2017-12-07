<?php

require('../ressources/Medecin.php');
require('../ressources/dao/MedecinDAO.php');

session_start();
if(isset($_POST['addDoc'])) {
    if(!empty($_POST['civilite'])
    && !empty($_POST['name'])
    && !empty($_POST['surname'])) {
        $med = new Medecin(null, $_POST['civilite'], $_POST['name'], $_POST['surname']);
        $rmed = new MedecinDAO($med);
        if($rmed->exists()) {
            $_SESSION['info'] = 3;
        } else {
            $_SESSION['info'] = $rmed->insert();
        }
        unset($_POST);
    } else {
        $_SESSION['info'] = 2;
    }
} else {
    $_SESSION['info'] = 4;
}

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GCM | Ajouter un médecin</title>
</head>
<body>

<h1>Ajouter un médecin</h1>

<?php
switch($_SESSION['info']) {
    case 0:
        echo "Erreur: Insertion impossible.";
        break;
    case 1:
        echo "Succès: Médecin ajouté.";
        break;
    case 2:
        echo "Attention: Veuillez renseigner tous les champs.";
        break;
    case 3:
        echo "Erreur: Médecin déjà existant.";
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

    <button name="addDoc" type="submit">Ajouter</button>

</form>

</body>
</html>

<?php
unset($_SESSION['info']);
?>