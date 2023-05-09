<?php session_start(); ?>

<head>
    <link rel="icon" href="./assets/img/le-terminus.ico" />
    <title>Se Connecter - Le Terminus</title>
    <style>
        body {
            background-image: url("./assets/img/background-image.png");
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            height: 100vh;
            width: 100vw;
        }

        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 70vh;
            text-align: center;
        }

        .form-control {
            line-height: 2em;
        }
    </style>
</head>

<body>
    <?php
    require_once('include/header.inc.php');

    if (isset($_POST['connexion'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $passwordHash = hash("sha256", $password);

        try {
            $addUser = new User(['Username' => $username, 'PasswordHash' => $passwordHash]);
            $user = $userManager->verifConnexion($addUser);
            if ($user) {
                $_SESSION['username'] = $user->getUsername();
                $_SESSION['job'] = $user->getJobUser();
                alertBox("success", "Connexion réussi.", "index.php", 1500);
                Logs("🔑 L'utilisateur '" . $_SESSION['username'] . "' (" . $_SERVER['REMOTE_ADDR'] . ") s'est connecté");
            } else {
                alertBox("danger", "Mauvais nom d'utilisateur ou mot de passe.", "", "");
                Logs("⚠️ Un utilisateur (" . $_SERVER['REMOTE_ADDR'] . ") n'a pas réussi à se connecter");
            }
        } catch (PDOException $e) {
            alertBox("danger", "La requête n'a pas pu aboutir.", "", "");
            Logs("⚠️ Un utilisateur (" . $_SERVER['REMOTE_ADDR'] . ") n'a pas réussi à se connecter");
        }
    }
    ?>
    <div class="container">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-5 col-lg-5">
                    <div class="card">
                        <div class="card-header text-center">
                            <h3>Connexion</h3>
                        </div>
                        <div class="card-body">
                            <form id="loginForm" method="POST" novalidate>
                                <div class="form-group">
                                    <label for="username">Nom d'utilisateur</label>
                                    <input type="username" pattern="[a-zA-Z0-9_-]{4,16}" class="form-control" name="username" required>
                                    <div class="invalid-feedback">
                                        Le format du nom d'utilisateur n'est pas respecté.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password">Mot de passe</label>
                                    <input type="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$" class="form-control" name="password" required>
                                    <div class="invalid-feedback">
                                        Le format du mot de passe n'est pas respecté.
                                    </div>
                                </div><br>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-success btn-lg" name="connexion" value="Se connecter" required>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        (function() {
            "use strict"
            window.addEventListener("load", function() {
                var form = document.getElementById("loginForm")
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