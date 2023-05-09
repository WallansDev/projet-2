<?php
class UserManager
{
    private $_db;

    public function __construct($db)
    {
        $this->setDB($db);
    }

    // ADD
    public function addUser(User $user)
    {
        $q = $this->_db->prepare('INSERT INTO users (`Username`, `JobUser`, `PasswordHash`) VALUES (:Username, :JobUser, :PasswordHash)');
        $q->bindValue(':Username', $user->getUsername());
        $q->bindValue(':JobUser', $user->getJobUser());
        $q->bindValue(':PasswordHash', $user->getPasswordHash());
        $q->execute();
        $id = $this->_db->lastInsertId();
        return $id;
    }

    public function changePassword(User $user)
    {
        $q = $this->_db->prepare("UPDATE users SET `PasswordHash` = :PasswordHash WHERE `Username` = :Username;");
        $q->bindValue(':PasswordHash', $user->getPasswordHash());
        $q->bindValue(':Username', $user->getUsername());
        $q->execute();
    }

    public function resetPassword(User $user)
    {
        // Mot de passe initial (P@ssword1): 00fcdde26dd77af7858a52e3913e6f3330a32b3121a61bce915cc6145fc44453
        $q = $this->_db->prepare("UPDATE users SET `PasswordHash` = '00fcdde26dd77af7858a52e3913e6f3330a32b3121a61bce915cc6145fc44453' WHERE `IdUser` = :IdUser;");
        $q->bindValue(':IdUser', $user->getIdUser());
        $q->execute();
    }

    // UPDATE
    public function updateUser(User $user)
    {
        $q = $this->_db->prepare("UPDATE users SET `Username` = :Username, `JobUser` = :JobUser WHERE `IdUser` = :IdUser;");
        $q->bindValue(':IdUser', $user->getIdUser());
        $q->bindValue(':Username', $user->getUsername());
        $q->bindValue(':JobUser', $user->getJobUser());
        $q->execute();
    }

    // DELETE
    public function deleteUser(User $user)
    {
        $q = $this->_db->prepare("DELETE FROM stock WHERE `IdUser` = :IdUser;");
        $q->bindValue(':IdUser', $user->getIdUser());
        $q->execute();
    }

    public function verifConnexion(User $user)
    {
        $q = $this->_db->prepare("SELECT Username, JobUser, PasswordHash FROM users WHERE Username = :Username AND PasswordHash = :PasswordHash");
        $q->bindValue(':Username', $user->getUsername());
        $q->bindValue(':PasswordHash', $user->getPasswordHash());
        $q->execute();

        $userInfo = $q->fetch(PDO::FETCH_ASSOC);
        if ($userInfo) {
            return new User($userInfo);
        } else {
            return 0;
        }
    }

    public function getInfoById($id)
    {
        $id = (int) $id;
        $req = $this->_db->query("SELECT IdUser, Username, JobUser, PasswordHash FROM users WHERE IdUser = $id");
        $donnees = $req->fetch(PDO::FETCH_ASSOC);

        return new User($donnees);
    }

    public function getListInfo()
    {
        $resultats = [];
        $q = $this->_db->query("SELECT IdUser, Username, JobUser, PasswordHash FROM users ORDER BY IdUser");
        while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) {
            $resultats[] = new User($donnees);
        }
        return $resultats;
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}

require_once('./include/bdd.inc.php');
$userManager = new UserManager($db);
