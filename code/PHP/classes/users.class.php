<?php
class User
{
    // Attributs
    private $_IdUser;
    private $_Username;
    private $_JobUser;
    private $_PasswordHash;

    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }

    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value) {
            $method = 'set' . ucfirst($key);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    // Getters
    public function getIdUser()
    {
        return $this->_IdUser;
    }

    public function getUsername()
    {
        return $this->_Username;
    }

    public function getJobUser()
    {
        return $this->_JobUser;
    }

    public function getPasswordHash()
    {
        return $this->_PasswordHash;
    }

    // Setters
    public function setIdUser($idUser)
    {
        $this->_IdUser = $idUser;
    }

    public function setUsername($username)
    {
        if (is_string($username)) {
            $this->_Username = $username;
        }
    }

    public function setJobUser($jobUser)
    {
        if (is_string($jobUser)) {
            $this->_JobUser = $jobUser;
        }
    }

    public function setPasswordHash($passwordHash)
    {
        if (is_string($passwordHash)) {
            $this->_PasswordHash = $passwordHash;
        }
    }
}
