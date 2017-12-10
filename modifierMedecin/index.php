<?php

require('../ressources/Medecin.php');
require('../ressources/dao/MedecinDAO.php');

$med = new MedecinDAO(new Medecin(null, null, null, null));

if(isset($_POST['search'])) {
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

<?php if(isset($_GET['id'])):
    //                ^ à changer car si l'utilisateur change l'id et qu'il existe pas en faisant la requête ça fou la merde
    $valuesmed = $med->getElementById($_GET['id']);
    $med->setElement(new Medecin($_GET['id'], $valuesmed['civilite'], $valuesmed['nom'], $valuesmed['prenom']));
    echo var_dump($med->getElement()->toArray());
    //TODO debug
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
    <input name="name" type="text" value="<?php echo $med->getElement()->toArray()['nom']?>">

    <br>

    <label for="surname">Prénom</label>
    <input name="surname" type="text" value="<?php echo $med->getElement()->toArray()['prenom']?>">

    <br>

    <button name="modifDoc" type="submit">Modifier</button>

</form>

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
