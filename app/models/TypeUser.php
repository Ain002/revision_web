<?php

namespace app\models;

class TypeUser {

    private $id;

    private $description; // changé

    public function __construct($id, $description)
    {
        $this->id = $id;
        $this->description = $description; // changé
    }

    public function addModel($db) {
        $stmt = $db->prepare("INSERT INTO type_user (description) VALUES (:description)");
        $stmt->bindParam(':description', $this->description);
        return $stmt->execute();
    }

    public function getAll($db) {
        $stmt = $db->prepare("SELECT * FROM type_user");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getDescription() { // changé
        return $this->description;
    }
}
