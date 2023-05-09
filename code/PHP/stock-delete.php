<?php
session_start();
$id = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="icon" href="./assets/img/le-terminus.ico" />
    <title>Suppression du produit n°<?= $id ?> - Le Terminus</title>
</head>

<body>
    <?php
    require_once('./include/header.inc.php');

    $stock = $stockManager->getInfoById($id);

    if (isset($_POST['submit'])) {

        try {
            $deleteStock = new Stock(['IdStock' => $id]);
            $stockManager->deleteStock($deleteStock);
            alertBox("success", "Suppresion réussite", 'index.php', 1000);
            Logs("🗑️ L'utilisateur '" . $_SESSION['username'] . "' (" . $_SERVER['REMOTE_ADDR'] . ") a supprimé le produit n°$id");
        } catch (PDOException $e) {
            alertBox("danger", "La requête n'a pas pu aboutir", '', '');
            Logs("⚠️ L'utilisateur '" . $_SESSION['username'] . "' (" . $_SERVER['REMOTE_ADDR'] . ") n'a pas réussi à supprimer le produit n°$id");
        }
    }

    ?>
    <div class="container">
        <br>
        <?php
        if ($_SESSION['job'] == "admin" || $_SESSION['job'] == "patron") {
        ?>
            <div class="text-center">
                <h3>Vous êtes sur le point de supprimer : </h3>
            </div>
            <form method="POST" name="deleteForm" novalidate>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="libelle">Libelle</label>
                        <input type="text" pattern="^[\p{L}0-9\s]$" class="form-control" name="libelle" value="<?= $stock->getLibelleStock() ?>" readonly>
                        <div class="invalid-feedback">
                            Seulement les lettres et les nombres sont acceptés.
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="marque">Marque</label>
                        <input type="text" pattern="^[\p{L}0-9\s]$" class="form-control" name="marque" value="<?= $stock->getMarqueStock() ?>" readonly>
                        <div class="invalid-feedback">
                            Seulement les lettres et les nombres sont acceptés.
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="qte">Quantité</label>
                        <input type="number" pattern="^[0-9]+$" class="form-control" name="qte" value="<?= $stock->getQteStock() ?>" readonly>
                        <div class="invalid-feedback">
                            Seulement les nombres sont acceptés.
                        </div>
                    </div>
                </div>
                <br>
                <div class="text-center">
                    <p style="color:#c0392b;">Cette action sera <b>irréversible</b> ?</p>
                </div>
                <br>
                <div class="text-center">
                    <input type="submit" class="btn btn-danger btn-lg" name="submit" value="Supprimer">
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