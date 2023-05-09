<?php
try {
    $dbname = "gestionnaire_inventaire";
    $user = "admin";
    $pass = "supermdp";

    $db = new PDO('mysql:host=localhost;dbname=' . $dbname, $user, $pass);
} catch (PDOException $e) {
    echo "ERROR : " . $e->getMessage();
}
