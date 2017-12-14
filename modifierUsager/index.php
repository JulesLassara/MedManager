<?php

session_start();

require('../ressources/Usager.php');
require('../ressources/dao/UsagerDAO.php');

$usa = new UsagerDAO(new Usager(null, null, null, null, null, null, null, null, null));
$updated = -1;

if(isset($_POST['modifUsager']) && isset($_SESSION['id'])) {
    $usa->setElement(new Usager($_SESSION['id'], $_POST['civilite'], $_POST['nom'], $_POST['prenom'], $_POST['adresse'], $_POST['datenaissance'], $_POST['lieunaissance'], $_POST['numsecu'], $_POST['medecinref']));
    if($usa->update()) {
        $updated = 1;
        $res = $usa->getElementsByKeyword("");
    } else {
        $updated = 0;
        $res = $usa->getElementsByKeyword("");
    }
    unset($_SESSION['id']);
} else if(isset($_GET['id'])) {
    $_SESSION['id'] = $_GET['id'];
    $valuesusa = $usa->getElementById($_GET['id']);
    if($valuesusa == null) {
        header('Location: .');
    } else {
        $usa->setElement(new Usager($_GET['id'], $valuesusa['civilite'], $valuesusa['nom'], $valuesusa['prenom'], $valuesusa['adresse'], $valuesusa['datenaissance'], $valuesusa['lieunaissance'], $valuesusa['numsecu'], $valuesusa['medecinref']));
    }
} else if(isset($_POST['search'])) {
    $res = $usa->getElementsByKeyword($_POST['keyword']);
} else {
    $res = $usa->getElementsByKeyword("");
}


?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GCM | Modifier un médecin</title>
</head>
<body>

<?php if(isset($_GET['id']) && $updated == -1): ?>

    <form method="post">

        <label for="civilite">Civilité</label>
        <select name="civilite">
            <option <?php if($usa->getElement()->toArray()['civilite'] == "Homme") echo "selected=\"selected\""; ?> value="Homme">Homme</option>
            <option <?php if($usa->getElement()->toArray()['civilite'] == "Femme") echo "selected=\"selected\""; ?> value="Femme">Femme</option>
            <option <?php if($usa->getElement()->toArray()['civilite'] == "Autre") echo "selected=\"selected\""; ?> value="Autre">Autre</option>
        </select>

        <br>

        <label for="nom">Nom</label>
        <input name="nom" type="text" value="<?php echo $usa->getElement()->toArray()['nom']?>">

        <br>

        <label for="prenom">Prénom</label>
        <input name="prenom" type="text" value="<?php echo $usa->getElement()->toArray()['prenom']?>">

        <br>

        <button name="modifUsager" type="submit">Modifier</button>

    </form>

<?php else:

    if($updated == 0) {
        echo "Mise à jour failed";
    } elseif ($updated == 1) {
        echo "Mise à jour réussie";
    }

    if(isset($_SESSION['deleted'])) {
        switch($_SESSION['deleted']) {
            case 1:
                echo "Suppression effectuée";
                break;
            case 2:
                echo "Echec de suppression, veuillez contacter l'admin";
                break;
            case 3:
                echo "Médecin inexistant.";
                break;
        }
        unset($_SESSION['deleted']);
    }
    ?>

    <form method="POST">
        <input type="text" name="keyword" placeholder="Ex: John">
        <button type="submit" name="search">Rechercher</button>
    </form>

    <table>
        <thead>
        <tr>
            <th>Civilité</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Modifier</th>
            <th>Supprimer</th>
        </tr>
        </thead>
        <tbody>
        <?php while($data = $res->fetch()) { ?>
            <tr>
                <td><?php echo $data['civilite'] ?></td>
                <td><?php echo $data['nom'] ?></td>
                <td><?php echo $data['prenom'] ?></td>
                <td>
                    <a href="index.php?id=<?php echo $data['id_medecin']?>">Modifier</a>
                </td>
                <td>
                    <a href="../suppression/medecin.php?id=<?php echo $data['id_medecin']?>">Supprimer</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

<?php endif; ?>

</body>
</html>