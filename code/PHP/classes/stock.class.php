<?php
class Stock
{
    // Attributs
    private $_IdStock;
    private $_LibelleStock;
    private $_MarqueStock;
    private $_QteStock;

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
    public function getIdStock()
    {
        return $this->_IdStock;
    }

    public function getLibelleStock()
    {
        return $this->_LibelleStock;
    }

    public function getMarqueStock()
    {
        return $this->_MarqueStock;
    }

    public function getQteStock()
    {
        return $this->_QteStock;
    }

    // Setters
    public function setIdStock($idStock)
    {
        $this->_IdStock = $idStock;
    }

    public function setLibelleStock($libelleStock)
    {
        if (is_string($libelleStock)) {
            $this->_LibelleStock = $libelleStock;
        }
    }

    public function setMarqueStock($marqueStock)
    {
        if (is_string($marqueStock)) {
            $this->_MarqueStock = $marqueStock;
        }
    }

    public function setQteStock($qteStock)
    {
        $this->_QteStock = $qteStock;
    }
}
