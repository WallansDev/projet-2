<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="icon" href="./assets/img/le-terminus.ico" />
    <title>Inventaire - Le Terminus</title>
</head>

<body>
    <?php
    require_once('./include/header.inc.php');

    $stocks = $stockManager->getListInfo();
    ?>
    <div class="container">
        <br>
        <?php
        if (isset($_POST['reset'])) {
            alertBox("warning", "Réinitialisation de la recherche.", "index.php", 300);
        }
        if (!isset($_SESSION['job'])) {
            alertBox("danger", "⚠️ Accès réfusé !", "", "");
            Logs("⚠️ Un utilisateur non connecté (" . $_SERVER['REMOTE_ADDR'] . ") à essayer d'accès à la page index.php");
        } else {
        ?>
            <form method="POST" novalidate class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" name="searchInput" placeholder="Rechercher" aria-label="Search">
                <div class="col-auto my-1">
                    <select class="custom-select mr-sm-2" name="categorie">
                        <option selected hidden disabled>-- Catégories --</option>
                        <option value="IdStock">Id</option>
                        <option value="LibelleStock">Libelle</option>
                        <option value="MarqueStock">Marque</option>
                    </select>
                </div>
                <input type="submit" class="btn btn-outline-success my-2 my-sm-0" name="search" value="Rechercher">
                &ensp;
                <input type="submit" class="btn btn-outline-warning my-2 my-sm-0" name="reset" value="Réinitialiser">
            </form>
            <form id="reset" method="POST" novalidate>

            </form>
            <br>
            <?php if ($_SESSION['job'] == "patron") { ?>
                <a class="btn btn-success" href="stock-add.php"><i class="bi bi-plus-square"></i></a>
            <?php } ?>

            <?php if (isset($_POST['search'])) {
                $searchInput = $_POST['searchInput'];
                $searchCategorie = $_POST['categorie'];

                $resultats = $stockManager->SearchStock($searchCategorie, $searchInput); ?>
                <div class="table-responsive">
                    <table class="table table-striped table-sm table-dark">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Libelle</th>
                                <th scope="col">Marque</th>
                                <th scope="col">Quantité</th>
                                <th scope="col"></th>
                            </tr>
                            <?php foreach ($resultats as $resultat) { ?>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row"><?= $resultat->getIdStock(); ?></th>
                                <td><?= $resultat->getLibelleStock(); ?></td>
                                <td><?= ucwords($resultat->getMarqueStock()); ?></td>
                                <td><?= $resultat->getQteStock(); ?></td>
                                <td>
                                    <a class="btn btn-success" href="stock-update.php?id=<?= $resultat->getIdStock(); ?>"><i class="bi bi-pencil-square"></i></a>
                                    <?php if ($_SESSION['job'] == "patron") { ?>
                                        <a class="btn btn-danger" href="stock-delete.php?id=<?= $resultat->getIdStock(); ?>"><i class="bi bi-trash-fill"></i></a>
                                    <?php } ?>
                                </td>
                            </tr>
                        </tbody>
                    <?php } ?>
                    </table>
                </div>
            <?php } else { ?>

                <div class="table-responsive">
                    <table class="table table-striped table-sm table-dark">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Libelle</th>
                                <th scope="col">Marque</th>
                                <th scope="col">Quantité</th>
                                <th scope="col"></th>
                            </tr>
                            <?php foreach ($stocks as $stock) { ?>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row"><?= $stock->getIdStock(); ?></th>
                                <td><?= $stock->getLibelleStock(); ?></td>
                                <td><?= ucwords($stock->getMarqueStock()); ?></td>
                                <td><?= $stock->getQteStock(); ?></td>
                                <td>
                                    <a class="btn btn-success" href="stock-update.php?id=<?= $stock->getIdStock(); ?>"><i class="bi bi-pencil-square"></i></a>
                                    <?php if ($_SESSION['job'] == "patron") { ?>
                                        <a class="btn btn-danger" href="stock-delete.php?id=<?= $stock->getIdStock(); ?>"><i class="bi bi-trash-fill"></i></a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
        <?php
            }
        }
        ?>
    </div>
</body>

</html>