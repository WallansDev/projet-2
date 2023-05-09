<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="icon" href="./assets/img/le-terminus.ico" />
    <title>Ajout d'un utilisateur - Le Terminus</title>
</head>

<body>
    <?php
    require_once('./include/header.inc.php');

    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $poste = $_POST['job'];

        try {
            $addUser = new User(['Username' => $username, 'JobUser' => $poste, 'PasswordHash' => "00fcdde26dd77af7858a52e3913e6f3330a32b3121a61bce915cc6145fc44453"]);
            $id = $userManager->addUser($addUser);
            alertBox("success", "L'ajout a été fait.", "account.php", 1500);
            Logs("➕ L'utilisateur '" . $_SESSION['username'] . "' (" . $_SERVER['REMOTE_ADDR'] . ") a créer un nouvel utilisateur (n°$id)");
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                alertBox("danger", "Ce nom d'utilisateur existe déjà.", '', '');
                Logs("⚠️ L'utilisateur '" . $_SESSION['username'] . "' (" . $_SERVER['REMOTE_ADDR'] . ") à essayé de créer un nouvel utilisateur, mais le nom d'utilisateur rentré existe déjà ($username)");
            } else {
                alertBox("danger", "La requête n'a pas pu aboutir.", '', '');
                Logs("⚠️ L'utilisateur '" . $_SESSION['username'] . "' (" . $_SERVER['REMOTE_ADDR'] . ") n'a pas réussi à créer un nouvel utilisateur");
            }
        }
    }
    ?>
    <div class="container">
        <br>
        <?php
        if ($_SESSION['job'] == "patron" || $_SESSION['job'] == "admin") {
        ?>
            <form method="POST" action="" id="addForm" novalidate>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="username">Nom d'utilisateur</label>
                        <input type="text" pattern="[a-zA-Z0-9_-]{4,16}" class="form-control" name="username" placeholder="Ex: Nom d'utilisateur" required>
                        <div class="invalid-feedback">
                            Seulement les lettres et les nombres sont acceptés.
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="job">Poste</label>
                        <select class="form-control" id="job" name="job">
                            <option selected hidden>-- Poste --</option>
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
                    <input type="submit" class="btn btn-success btn-lg" name="submit" value="Ajouter">
                </div>
            </form>
        <?php
        } else {
            alertBox("danger", "⚠️ Accès réfusé !", "index.php", 1500);
            Logs("⚠️ Un utilisateur non connecté (" . $_SERVER['REMOTE_ADDR'] . ") à essayer d'accès à la page user-add.php");
        }
        ?>
    </div>
    <script>
        (function() {
            "use strict"
            window.addEventListener("load", function() {
                var form = document.getElementById("addForm")
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