<?php

namespace app\models;

class TypeUser {

    private $id;

    private $desc;

    public function __construct($id, $desc)
    {
        $this->id = $id;
        $this->desc = $desc;
    }

    public function addModel($db) {
        $stmt = $db->prepare("INSERT INTO type_user (desc) VALUES (:desc)");
        $stmt->bindParam(':desc', $this->desc);
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

    public function getDesc() {
        return $this->desc;
    }
}