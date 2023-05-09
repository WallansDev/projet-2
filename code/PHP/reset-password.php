<?php
session_start();
$id = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="icon" href="./assets/img/le-terminus.ico" />
    <title>Réinitialisation de l'utilisateur n°<?= $id ?> - Le Terminus</title>
</head>

<body>
    <?php
    require_once('./include/header.inc.php');

    $user = $userManager->getInfoById($id);

    if (isset($_POST['submit'])) {
        try {
            $resetPassword = new User(['IdUser' => $id]);
            $userManager->resetPassword($resetPassword);
            alertBox("success", "Réinitialisation réussite", 'account.php', 1000);
            Logs("🗑️ L'utilisateur '" . $_SESSION['username'] . "' (" . $_SERVER['REMOTE_ADDR'] . ") a réinitialiser le mot de passe du compte '" . $user->getUsername() . "'");
        } catch (PDOException $e) {
            alertBox("danger", "La requête n'a pas pu aboutir", '', '');
            Logs("⚠️ L'utilisateur '" . $_SESSION['username'] . "' (" . $_SERVER['REMOTE_ADDR'] . ") n'a pas réussi à réinitialiser le mot de passe du compte '" . $user->getUsername() . "'");
        }
    }

    ?>
    <div class="container">
        <br>
        <?php
        if ($_SESSION['job'] == "admin" || $_SESSION['job'] == "patron") {
        ?>
            <div class="text-center">
                <h3>Vous êtes sur le point de réinitialiser : </h3>
            </div>
            <form method="POST" id="updateForm" novalidate>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="text" pattern="[a-zA-Z0-9_-]{4,16}" class="form-control" name="username" value="<?= $user->getUsername() ?>" readonly>
                        <div class="invalid-feedback">
                            Seulement les lettres et les nombres sont acceptés.
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" pattern="[a-zA-Z0-9_-]{4,16}" class="form-control" name="username" value="<?= $user->getJobUser() ?>" readonly>
                        <div class="invalid-feedback">
                            Seulement les lettres et les nombres sont acceptés.
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <p style="color:#c0392b;">Cette action sera <b>irréversible</b> ?</p>
                </div>
                <div class="text-center">
                    <input type="submit" class="btn btn-info btn-lg" name="submit" value="Réinitialiser">
                </div>
            </form>
        <?php
        } else {
            alertBox("danger", "⚠️ Accès réfusé !", "index.php", 1500);
            Logs("⚠️ Un utilisateur non connecté (" . $_SERVER['REMOTE_ADDR'] . ") à essayer d'accès à la page stock-delete.php");
        }
        ?>
    </div>
</body>

</html>