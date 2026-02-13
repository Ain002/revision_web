<?php
namespace app\models;

use PDO;

class CategorieModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function insertCategorie($nom){
        $sql = "INSERT INTO categorie (nom) VALUES (?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$nom]);
    }

    public function updateCategorie($nom,$id){
        $sql="update categorie set nom = ? where id_categorie = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$nom,$id]);
    }

    public function removeCategorie($id){
        $sql = "delete from categorie where id_categorie = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
    }

    public function getAllCategories(){
        $sql = "SELECT * FROM categorie";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategorie($id){
        $sql = "SELECT * FROM categorie WHERE id_categorie = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}