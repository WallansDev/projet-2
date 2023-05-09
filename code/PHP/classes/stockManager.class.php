<?php
class StockManager
{
    private $_db;

    public function __construct($db)
    {
        $this->setDB($db);
    }

    // ADD
    public function addStock(Stock $stock)
    {
        $q = $this->_db->prepare("INSERT INTO stock (LibelleStock, MarqueStock, QteStock) VALUES (:LibelleStock, :MarqueStock, :QteStock)");
        $q->bindValue(':LibelleStock', $stock->getLibelleStock());
        $q->bindValue(':MarqueStock', $stock->getMarqueStock());
        $q->bindValue(':QteStock', $stock->getQteStock());
        $q->execute();
        $id = $this->_db->lastInsertId();
        return $id;
    }

    // UPDATE
    public function updateStock(Stock $stock)
    {
        $q = $this->_db->prepare("UPDATE stock SET `LibelleStock` = :LibelleStock, `MarqueStock` = :MarqueStock, `QteStock` = :QteStock WHERE `IdStock` = :IdStock;");
        $q->bindValue(':IdStock', $stock->getIdStock());
        $q->bindValue(':LibelleStock', $stock->getLibelleStock());
        $q->bindValue(':MarqueStock', $stock->getMarqueStock());
        $q->bindValue(':QteStock', $stock->getQteStock());
        $q->execute();
    }

    // DELETE
    public function deleteStock(Stock $stock)
    {
        $q = $this->_db->prepare("DELETE FROM stock WHERE `IdStock` = :IdStock;");
        $q->bindValue(':IdStock', $stock->getIdStock());
        $q->execute();
    }

    public function getInfoById($id)
    {
        $id = (int) $id;
        $req = $this->_db->query("SELECT IdStock, LibelleStock, MarqueStock, QteStock FROM stock WHERE IdStock = $id");
        $donnees = $req->fetch(PDO::FETCH_ASSOC);

        return new Stock($donnees);
    }

    public function getListInfo()
    {
        $resultats = [];
        $q = $this->_db->query("SELECT IdStock, LibelleStock, MarqueStock, QteStock FROM stock ORDER BY IdStock");
        while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) {
            $resultats[] = new Stock($donnees);
        }
        return $resultats;
    }

    public function SearchStock($colonne, $valeur)
    {
        $resultats = [];
        $q = $this->_db->query("SELECT IdStock, LibelleStock, MarqueStock, QteStock FROM stock WHERE $colonne LIKE '%$valeur%'");
        while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) {
            $resultats[] = new Stock($donnees);
        }
        return $resultats;
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}

require_once('./include/bdd.inc.php');
$stockManager = new StockManager($db);
