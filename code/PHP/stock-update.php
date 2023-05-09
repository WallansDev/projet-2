<?php
session_start();
$id = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="icon" href="./assets/img/le-terminus.ico" />
    <title>Modification du produit n°<?= $id ?> - Le Terminus</title>
</head>

<body>
    <?php
    require_once('./include/header.inc.php');

    $stock = $stockManager->getInfoById($id);

    if (isset($_POST['submit'])) {
        $libelle = $_POST['libelle'];
        $marque = $_POST['marque'];
        $qte = $_POST['qte'];

        try {
            $updateStock = new Stock(['LibelleStock' => $libelle, 'MarqueStock' => $marque, 'QteStock' => $qte, 'IdStock' => $id]);
            $stockManager->updateStock($updateStock);
            alertBox("success", "Modification réussite", 'index.php', 1000);
            Logs("📝 L'utilisateur '" . $_SESSION['username'] . "' (" . $_SERVER['REMOTE_ADDR'] . ") a modifié le produit n°$id");
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                alertBox("danger", "Ce libelle existe déjà.", '', '');
                Logs("⚠️ L'utilisateur '" . $_SESSION['username'] . "' (" . $_SERVER['REMOTE_ADDR'] . ") à essayé de modifier le produit n°$id mais le libellé rentré existe déjà ($libelle)");
            } else {
                alertBox("danger", "La requête n'a pas pu aboutir.", '', '');
                Logs("⚠️ L'utilisateur '" . $_SESSION['username'] . "' (" . $_SERVER['REMOTE_ADDR'] . ") n'a pas réussi à modifier le produit n°$id");
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
                        <label for="libelle">Libelle</label>
                        <input type="text" pattern="^[\p{L}0-9\s]${2,50}" class="form-control" name="libelle" value="<?= $stock->getLibelleStock() ?>" required>
                        <div class="invalid-feedback">
                            Seulement les lettres et les nombres sont acceptés.
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="marque">Marque</label>
                        <input type="text" pattern="^[\p{L}0-9\s']${2,50}" class="form-control" name="marque" value="<?= $stock->getMarqueStock() ?>" required>
                        <div class="invalid-feedback">
                            Seulement les lettres et les nombres sont acceptés.
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="qte">Quantité</label>
                        <input type="number" pattern="^[0-9]+$" class="form-control" name="qte" value="<?= $stock->getQteStock() ?>" required>
                        <div class="invalid-feedback">
                            Seulement les nombres sont acceptés.
                        </div>
                    </div>
                </div>
                <br>
                <div class="text-center">
                    <input type="submit" class="btn btn-success btn-lg" name="submit" value="Modifier">
                </div>
            </form>
        <?php
        } else if ($_SESSION['job'] == "serveur") {
        ?>
            <form method="POST" action="" id="updateForm" novalidate>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="libelle">Libelle</label>
                        <input type="text" class="form-control" pattern="^[\p{L}0-9\s]$" name="libelle" value="<?= $stock->getLibelleStock() ?>" readonly>
                        <div class="invalid-feedback">
                            Seulement les lettres et les nombres sont acceptés.
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="marque">Marque</label>
                        <input type="text" class="form-control" pattern="^[\p{L}0-9\s]$" name="marque" value="<?= $stock->getMarqueStock() ?>" readonly>
                        <div class="invalid-feedback">
                            Seulement les lettres et les nombres sont acceptés.
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="qte">Quantité</label>
                        <input type="number" pattern="^[0-9]+$" class="form-control" name="qte" value="<?= $stock->getQteStock() ?>" required>
                        <div class="invalid-feedback">
                            Seulement les nombres sont acceptés.
                        </div>
                    </div>
                </div>
                <br>
                <div class="text-center">
                    <input type="submit" class="btn btn-success btn-lg" name="submit" value="Modifier">
                </div>
            </form>
        <?php
        } else {
            alertBox("danger", "⚠️ Accès réfusé !", "index.php", 1500);
            Logs("⚠️ Un utilisateur non connecté (" . $_SERVER['REMOTE_ADDR'] . ") à essayer d'accès à la page stock-update.php");
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