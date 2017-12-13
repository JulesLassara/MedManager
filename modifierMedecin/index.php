<?php

session_start();

require('../ressources/Medecin.php');
require('../ressources/dao/MedecinDAO.php');

$med = new MedecinDAO(new Medecin(null, null, null, null));
$updated = -1;

if(isset($_POST['modifDoc'])) {
    $med->setElement(new Medecin($_SESSION['id'], $_POST['civilite'], $_POST['nom'], $_POST['prenom']));
    if($med->update()) {
        $updated = 1;
    } else {
        $updated = 0;
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

<form method="POST">
    <input type="text" name="keyword" placeholder="Ex: John">
    <button type="submit" name="search">Rechercher</button>
</form>

<?php if(isset($_GET['id']) && $updated == -1): ?>

<form method="post">

    <label for="civilite">Civilité</label>
    <select name="civilite">
        <option <?php if($med->getElement()->toArray()['civilite'] == "Homme") echo "selected=\"selected\""; ?> value="Homme">Homme</option>
        <option <?php if($med->getElement()->toArray()['civilite'] == "Femme") echo "selected=\"selected\""; ?> value="Femme">Femme</option>
        <option <?php if($med->getElement()->toArray()['civilite'] == "Autre") echo "selected=\"selected\""; ?> value="Autre">Autre</option>
    </select>

    <br>

    <label for="nom">Nom</label>
    <input name="nom" type="text" value="<?php echo $med->getElement()->toArray()['nom']?>">

    <br>

    <label for="prenom">Prénom</label>
    <input name="prenom" type="text" value="<?php echo $med->getElement()->toArray()['prenom']?>">

    <br>

    <button name="modifDoc" type="submit">Modifier</button>

</form>

<?php elseif($updated == 0): ?>
    <p>Mise à jour failed</p>
<?php elseif($updated == 1): ?>
    <p>Mise à jour réussie</p>
<?php else: ?>

<table>
    <thead>
    <tr>
        <th>Civilité</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Modifier</th>
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
        </tr>
    <?php } ?>
    </tbody>
</table>

<?php endif; ?>

</body>
</html>