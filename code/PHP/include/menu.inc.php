<?php
// if (isset($_POST['patron'])) {
//     $_SESSION['job'] = "patron";
// }
// if (isset($_POST['serveur'])) {
//     $_SESSION['job'] = "serveur";
// }

if (isset($_POST['logs'])) {
    header('Location: logs.php');
}
if (isset($_POST['account'])) {
    header('Location: account.php');
}
if (isset($_POST['deco'])) {
    session_destroy();
    header('Location: login.php');
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand mb-0 h1" href="./index.php"><img src="./assets/img/le-terminus.png" width="30" height="30" class="d-inline-block align-top" alt=""> Le Terminus - Inventaire</a>
    <ul class="navbar-nav mr-auto">
        <!-- <form method="POST">
            <input type="submit" class="btn btn-success" name="patron" value="Patron">
            <input type="submit" class="btn btn-success" name="serveur" value="Serveur">
        </form> -->
    </ul>

    &ensp;
    <?php if (!empty($_SESSION['job'])) { ?>
        <form method="POST">
            <?php if ($_SESSION['job'] == "patron" || $_SESSION['job'] == "admin") { ?>
                <input type="submit" class="btn btn-info" name="logs" value="Logs">
            <?php } ?>
            <input type="submit" class="btn btn-info" name="account" value="Mon compte">
            <input type="submit" class="btn btn-danger" name="deco" value="Déconnexion">
        </form>
    <?php } else { ?>
        <form method="POST">
            <a href="login.php"><input type="button" class="btn btn-success" name="login" value="Se connecter"></a>
        </form>
    <?php } ?>
</nav>