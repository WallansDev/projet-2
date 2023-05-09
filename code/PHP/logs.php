<?php session_start(); ?>

<head>
    <link rel="icon" href="./assets/img/le-terminus.ico" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&amp;display=swap" class="wtd-font">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Unbounded" class="wtd-font">
    <style>
        #logs-style {
            font-family: monospace;
            font-size: 14px;
            line-height: 1.2;
            padding: 1rem;
            background-color: black;
        }

        .log-line {
            color: white;
        }
    </style>
</head>

<body>
    <?php require_once('include/header.inc.php'); ?>
    <div id="logs-style">
        <?php
        if ($_SESSION['job'] == "admin" || $_SESSION['job'] == "patron") {
            $file = 'logs.log';
            $contenu = file_get_contents($file);
            $contenu = htmlentities($contenu);
            $contenu = nl2br($contenu);
            echo "<div class='log-line'>" . $contenu . "</div>";
        } else {
            alertBox("danger", "⚠️ Accès réfusé !", "index.php", 1500);
            Logs("⚠️ Un utilisateur non connecté (" . $_SERVER['REMOTE_ADDR'] . ") à essayer d'accès à la page logs.php");
        }
        ?>
    </div>
</body>