<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="icon" href="./assets/img/le-terminus.ico" />
    <title>Changement mot de passe - Le Terminus</title>
</head>

<body>
    <?php
    require_once('include/header.inc.php');

    if (isset($_POST['submit'])) {
        $password = hash("sha256", $_POST['password']);
        $username = $_SESSION['username'];

        try {
            $updatePassword = new User(['PasswordHash' => $password, 'Username' => $username]);
            $userManager->changePassword($updatePassword);
            alertBox("success", "Modification réussie", 'account.php', 1500);
            Logs("📝 L'utilisateur '" . $_SESSION['username'] . "' (" . $_SERVER['REMOTE_ADDR'] . ") a modifié son mot de passe");
        } catch (PDOException $e) {
            alertBox("danger", "La requête n'a pas pu aboutir.", '', '');
            Logs("⚠️ L'utilisateur '" . $_SESSION['username'] . "' (" . $_SERVER['REMOTE_ADDR'] . ") n'a pas réussi à modifier son mot de passe");
        }
    }

    if (isset($_SESSION['job'])) {
    ?>
        <div class="container">
            <br>
            <form method="POST" id="updatePassword" novalidate>
                <div class="form-row">
                    <div class="form-group col-md-4"></div>
                    <div class="form-group col-md-4">
                        <label for="password">Mot de passe</label>
                        <input type="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$" class="form-control" name="password" required>
                        <div class="invalid-feedback">
                            Le format du mot de passe n'est pas respecté, il est requis :
                            <br>- 1 majuscule
                            <br>- 1 minuscule
                            <br>- 1 caractère spécial
                            <br>- 8 caractères
                        </div>
                    </div>
                </div>
                <br>
                <div class="text-center">
                    <input type="submit" class="btn btn-success btn-lg" name="submit" value="Modifier">
                </div>
            </form>
        </div>
    <?php
    } else {
        alertBox("danger", "⚠️ Accès réfusé !", "index.php", 1500);
        Logs("⚠️ Un utilisateur non connecté (" . $_SERVER['REMOTE_ADDR'] . ") à essayer d'accès à la page change-password.php");
    }
    ?>
    <script>
        (function() {
            "use strict"
            window.addEventListener("load", function() {
                var form = document.getElementById("updatePassword")
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