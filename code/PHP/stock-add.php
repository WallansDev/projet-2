<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="icon" href="./assets/img/le-terminus.ico" />
    <title>Ajout d'un produit - Le Terminus</title>
</head>

<body>
    <?php
    require_once('./include/header.inc.php');

    if (isset($_POST['submit'])) {
        $libelle = $_POST['libelle'];
        $marque = $_POST['marque'];
        $qte = $_POST['qte'];

        try {
            $addStock = new Stock(['LibelleStock' => $libelle, 'MarqueStock' => $marque, 'QteStock' => $qte]);
            $id = $stockManager->addStock($addStock);
            alertBox("success", "L'ajout a été fait.", "index.php", 1500);
            Logs("➕ L'utilisateur '" . $_SESSION['username'] . "' (" . $_SERVER['REMOTE_ADDR'] . ") a ajouté le produit n°$id");
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                alertBox("danger", "Ce libelle existe déjà.", '', '');
                Logs("⚠️ L'utilisateur '" . $_SESSION['username'] . "' (" . $_SERVER['REMOTE_ADDR'] . ") à essayé d'ajouter un nouveau produit, mais le libellé rentré existe déjà ($libelle)");
            } else {
                alertBox("danger", "La requête n'a pas pu aboutir.", '', '');
                Logs("⚠️ L'utilisateur '" . $_SESSION['username'] . "' (" . $_SERVER['REMOTE_ADDR'] . ") n'a pas réussi à ajouter un nouveau le produit");
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
                        <label for="libelle">Libelle</label>
                        <input type="text" pattern="^[\p{L}0-9\s]{2,50}$" class="form-control" name="libelle" placeholder="Ex: Chips barbecue 500g" required>
                        <div class="invalid-feedback">
                            Seulement les lettres et les nombres sont acceptés.
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="marque">Marque</label>
                        <input type="text" pattern="^[\p{L}0-9\s']{2,50}$" class="form-control" name="marque" placeholder="Ex: Lays" required>
                        <div class="invalid-feedback">
                            Seulement les lettres et les nombres sont acceptés.
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="qte">Quantité</label>
                        <input type="number" pattern="^[0-9]+$" class="form-control" name="qte" placeholder="Ex: 5" required>
                        <div class="invalid-feedback">
                            Seulement les nombres sont acceptés.
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
            Logs("⚠️ Un utilisateur non connecté (" . $_SERVER['REMOTE_ADDR'] . ") à essayer d'accès à la page stock-add.php");
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