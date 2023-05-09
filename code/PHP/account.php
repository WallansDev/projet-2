<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="icon" href="./assets/img/le-terminus.ico" />
    <title>Mon compte - Le Terminus</title>
</head>

<body>
    <?php
    require_once('include/header.inc.php');
    $users = $userManager->getListInfo();

    if ($_SESSION['job'] == "patron" || $_SESSION['job'] == "admin" || $_SESSION['job'] == "serveur") {
    ?>
        <div class="container">
            <br>
            <div class="text-center">
                <h5>Vous êtes connecté en tant que <?= $_SESSION['username'] ?></h5>
            </div>
            <br>
            <a class="btn btn-warning" href="change-password.php">Modifier mon mot de passe</a><br><br>
            <?php if ($_SESSION['job'] == "patron" || $_SESSION['job'] == "admin") { ?>
                <a class="btn btn-success" href="user-add.php"><i class="bi bi-plus-square"></i></a>
                <div class="table-responsive">
                    <table class="table table-striped table-sm table-dark">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nom d'utilisateur</th>
                                <th scope="col">Poste</th>
                                <th scope="col">Mot de passe</th>
                                <th scope="col"></th>
                            </tr>
                            <?php foreach ($users as $user) { ?>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row"><?= $user->getIdUser(); ?></th>
                                <td><?= $user->getUsername(); ?></td>
                                <td><?= ucwords($user->getJobUser()); ?></td>
                                <?php if ($_SESSION['job'] == "patron" || $_SESSION['job'] == "admin") { ?>
                                    <td>
                                        <a class="btn btn-info" href="reset-password.php?id=<?= $user->getIdUser(); ?>"><i class="bi bi-arrow-clockwise"></i></a>
                                    </td>
                                <?php } ?>
                                <td>
                                    <a class="btn btn-success" href="user-update.php?id=<?= $user->getIdUser(); ?>"><i class="bi bi-pencil-square"></i></a>
                                    <?php if ($_SESSION['job'] == "patron" || $_SESSION['job'] == "admin") { ?>
                                        <a class="btn btn-danger" href="user-delete.php?id=<?= $user->getIdUser(); ?>"><i class="bi bi-trash-fill"></i></a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </div>
    <?php } else {
        alertBox("danger", "⚠️ Accès réfusé !", "index.php", 1500);
        Logs("⚠️ Un utilisateur non connecté (" . $_SERVER['REMOTE_ADDR'] . ") à essayer d'accès à la page account.php");
    } ?>
</body>

</html>