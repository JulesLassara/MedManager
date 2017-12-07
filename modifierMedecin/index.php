<?php

require('../ressources/Medecin.php');
require('../ressources/dao/MedecinDAO.php');

if(isset($_POST['search'])) {
    $med = new MedecinDAO(new Medecin(null, null, null, null));
    $res = $med->getElementsByKeyword($_POST['keyword']);
    echo var_dump($res->fetch());
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

<?php if(isset($res)): ?>
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
