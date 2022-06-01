<?php
require_once('Base.php');

class Panier extends Base{
    // Connexion
    private $con;
    private $table = "panier";

    // object properties
    public $idEvent;
    public $nomEvent;
    public $tarif;
    public $idOrganisateur;

    /**
     * Constructeur pour la connexion à la base de données
     */
    public function __construct(){
        $this->con = $this->connect();
    }

    public function getAll($idOrganisateur) {
        $query = "SELECT evenement.nomEvent, panier.tarif, evenement.img,panier.qte, panier.idOrganisateur, panier.idEvent, panier.idPanier FROM $this->table INNER JOIN evenement ON panier.idEvent=evenement.idEvent WHERE panier.idOrganisateur= :idOrganisateur";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(':idOrganisateur',$idOrganisateur);
        $stmt->execute();
        return $stmt;
    }

    public function ticketsById($idOrganisateur) {
        $query = "SELECT evenement.nomEvent, evenement.tarif, evenement.img, $this->table.idOrganisateur, $this->table.idEvent FROM $this->table INNER JOIN evenement ON panier.idEvent=evenement.idEvent WHERE evenement.idOrganisateur=:idOrganisateur" ;
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(':idOrganisateur',$idOrganisateur);
        $stmt->execute();
        return $stmt;
    }

    public function addToPanier($idEvent, $idOrganisateur ,$qte, $tarif) {
        $query = "INSERT INTO $this->table SET idEvent='$idEvent', idOrganisateur='$idOrganisateur' , qte = '$qte', tarif='$tarif'";
        $stmt = $this->con->prepare($query);
        return $stmt->execute();
    }

    public function remove($idPanier) {
        $query = "DELETE FROM $this->table WHERE idPanier = ?";
        $stmt = $this->con->prepare($query);
        $idPanier = htmlspecialchars(strip_tags($idPanier));
        $stmt->bindParam(1, $idPanier);
        return $stmt->execute();
    }

    public function plusOne($idPanier, $qte, $tarif) {
        $idPanier = htmlspecialchars(strip_tags($idPanier));
        $qte = htmlspecialchars(strip_tags($qte));
        $tarif = htmlspecialchars(strip_tags($tarif));
        $query = "UPDATE $this->table SET `qte`='$qte', `tarif`='$tarif' WHERE idPanier = $idPanier";
        $stmt = $this->con->prepare($query);
        return $stmt->execute();
    }

    public function minusOne($idPanier, $qte, $tarif) {
        $idPanier = htmlspecialchars(strip_tags($idPanier));
        $qte = htmlspecialchars(strip_tags($qte));
        $tarif = htmlspecialchars(strip_tags($tarif));
        $query = "UPDATE $this->table SET `qte`='$qte', `tarif`='$tarif' WHERE idPanier = $idPanier";
        $stmt = $this->con->prepare($query);
        return $stmt->execute();
    }

    public function updateTarif ($idPanier, $tarif, $qte) {
        $idPanier = htmlspecialchars(strip_tags($idPanier));
        $qte = htmlspecialchars(strip_tags($qte));
        $tarif = htmlspecialchars(strip_tags($tarif));
        $query = "UPDATE $this->table SET `tarif`= '$tarif' WHERE idPanier = $idPanier";
        $stmt = $this->con->prepare($query);
        return $stmt->execute();
    }
}