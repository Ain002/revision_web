<?php

namespace app\models;

use flight;

class ObjetModel {

    public function getAllObjects() {
        /** @var PDO $db */
        $db = Flight::db(); 

        $stmt = $db->prepare("SELECT * FROM objets ORDER BY id");
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getObjectById($id) {
        /** @var PDO $db */
        $db = Flight::db(); 

        $stmt = $db->prepare("SELECT * FROM objets WHERE id = :id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getObjectImages($id) {
        /** @var PDO $db */
        $db = Flight::db(); 

        $stmt = $db->prepare("SELECT * FROM image WHERE objet_id = :id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getObjectByCategory($categoryId) {
        /** @var PDO $db */
        $db = Flight::db(); 

        $stmt = $db->prepare("SELECT * FROM objets WHERE categorie_id = :categoryId");
        $stmt->bindParam(':categoryId', $categoryId, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getObjectByOwner($ownerId) {
        /** @var PDO $db */
        $db = Flight::db(); 

        $stmt = $db->prepare("SELECT * FROM objets WHERE proprietaire_id = :ownerId");
        $stmt->bindParam(':ownerId', $ownerId, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addObject($data) {
        /** @var PDO $db */
        $db = Flight::db(); 

        $stmt = $db->prepare("INSERT INTO objets (proprietaire_id, categorie_id, nom, description, date_ajout, prix) VALUES (:proprietaire_id, :categorie_id, :nom, :description, NOW(), :prix)");
        $stmt->bindParam(':proprietaire_id', $data['proprietaire_id'], \PDO::PARAM_INT);
        $stmt->bindParam(':categorie_id', $data['categorie_id'], \PDO::PARAM_INT);
        $stmt->bindParam(':nom', $data['nom'], \PDO::PARAM_STR);
        $stmt->bindParam(':description', $data['description'], \PDO::PARAM_STR);
        $stmt->bindParam(':prix', $data['prix'], \PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function updateObject($id, $data) {
        /** @var PDO $db */
        $db = Flight::db(); 

        $stmt = $db->prepare("UPDATE objets SET proprietaire_id = :proprietaire_id, categorie_id = :categorie_id, nom = :nom, description = :description, prix = :prix WHERE id = :id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->bindParam(':proprietaire_id', $data['proprietaire_id'], \PDO::PARAM_INT);
        $stmt->bindParam(':categorie_id', $data['categorie_id'], \PDO::PARAM_INT);
        $stmt->bindParam(':nom', $data['nom'], \PDO::PARAM_STR);
        $stmt->bindParam(':description', $data['description'], \PDO::PARAM_STR);
        $stmt->bindParam(':prix', $data['prix'], \PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function deleteObject($id) {
        /** @var PDO $db */
        $db = Flight::db(); 

        $stmt = $db->prepare("DELETE FROM objets WHERE id = :id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function addImageToObject($objectId, $imageName) {
        /** @var PDO $db */
        $db = Flight::db(); 

        $stmt = $db->prepare("INSERT INTO image (objet_id, nom) VALUES (:objet_id, :nom)");
        $stmt->bindParam(':objet_id', $objectId, \PDO::PARAM_INT);
        $stmt->bindParam(':nom', $imageName, \PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function deleteImageFromObject($imageId) {
        /** @var PDO $db */
        $db = Flight::db(); 

        $stmt = $db->prepare("DELETE FROM image WHERE id = :id");
        $stmt->bindParam(':id', $imageId, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getObjectHorsProprietaire($proprietaireId) {
        /** @var PDO $db */
        $db = Flight::db(); 

        $stmt = $db->prepare("SELECT * FROM objets WHERE proprietaire_id != :proprietaire_id");
        $stmt->bindParam(':proprietaire_id', $proprietaireId, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}


