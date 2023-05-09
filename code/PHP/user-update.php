<?php
session_start();
$id = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="icon" href="./assets/img/le-terminus.ico" />
    <title>Modification de l'utilisateur n°<?= $id ?> - Le Terminus</title>
</head>

<body>
    <?php
    require_once('./include/header.inc.php');

    $user = $userManager->getInfoById($id);

    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $poste = $_POST['job'];

        try {
            $updateUser = new User(['Username' => $username, 'JobUser' => $poste, 'IdUser' => $id]);
            $userManager->updateUser($updateUser);
            alertBox("success", "Modification réussite", 'account.php', 1000);
            Logs("📝 L'utilisateur '" . $_SESSION['username'] . "' (" . $_SERVER['REMOTE_ADDR'] . ") a modifié l'utilisateur n°$id");
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                alertBox("danger", "Ce nom d'utilisateur existe déjà.", '', '');
                Logs("⚠️ L'utilisateur '" . $_SESSION['username'] . "' (" . $_SERVER['REMOTE_ADDR'] . ") à essayé de modifier l'utilisateur n°$id mais le nom d'utilisateur rentré existe déjà ($libelle)");
            } else {
                alertBox("danger", "La requête n'a pas pu aboutir.", '', '');
                Logs("⚠️ L'utilisateur '" . $_SESSION['username'] . "' (" . $_SERVER['REMOTE_ADDR'] . ") n'a pas réussi à modifier l'utilisateur n°$id");
            }
        }
    }

    ?>
    <div class="container">
        <br>
        <?php
        if ($_SESSION['job'] == "admin" || $_SESSION['job'] == "patron") {
        ?>
            <form method="POST" action="" id="updateForm" novalidate>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="username">Nom d'utilisateur</label>
                        <input type="text" pattern="[a-zA-Z0-9_-]{4,16}" class="form-control" name="username" value="<?= $user->getUsername() ?>">
                        <div class="invalid-feedback">
                            Seulement les lettres et les nombres sont acceptés.
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="job">Poste</label>
                        <select class="form-control" id="job" name="job">
                            <option selected hidden><?= $user->getJobUser() ?></option>
                            <option value="serveur">Serveur</option>
                            <option value="patron">Patron</option>
                        </select>
                        <div class="invalid-feedback">
                            Seulement les lettres et les nombres sont acceptés.
                        </div>
                    </div>
                </div>
                <br>
                <div class="text-center">
                    <input type="submit" class="btn btn-success btn-lg" name="submit" value="Modifier">
                </div>
            </form>
        <?php } else {
            alertBox("danger", "⚠️ Accès réfusé !", "index.php", 1500);
            Logs("⚠️ Un utilisateur non connecté (" . $_SERVER['REMOTE_ADDR'] . ") à essayer d'accès à la page user-update.php");
        }
        ?>
    </div>
    <script>
        (function() {
            "use strict"
            window.addEventListener("load", function() {
                var form = document.getElementById("updateForm")
                form.addEventListener("submit", function(event) {
                    if (form.checkValidity() == false) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add("was-validated")
                }, false)
            }, false)
        }());
    </script>
</body>

</html>