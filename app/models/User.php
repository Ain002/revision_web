<?php

namespace app\models;

class User {

    private $id;

    private $nom;

    private $mail;  

    private $pwd;

    private $idtype;


    public function __construct($id, $nom, $mail, $pwd, $idtype)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->mail = $mail;
        $this->pwd = $pwd;
        $this->idtype = $idtype;
    }

    public function addModel($db) {
        $stmt = $db->prepare("INSERT INTO user (nom, mail, pwd, idtype) VALUES (:nom, :mail, :pwd, :idtype)");
        $stmt->bindValue(':nom', $this->nom);
        $stmt->bindValue(':mail', $this->mail);
        $stmt->bindValue(':pwd', $this->pwd);
        $stmt->bindValue(':idtype', $this->idtype, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function verifier($db) {
        $stmt = $db->prepare("SELECT * FROM user WHERE mail = :mail");
        $stmt->bindParam(':mail', $this->mail);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function deleteModel($db) {
        $stmt = $db->prepare("DELETE FROM user WHERE id = :id");
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    public function updateModel($db) {
        $stmt = $db->prepare("UPDATE user SET nom = :nom, mail = :mail, pwd = :pwd, idtype = :idtype WHERE id = :id");
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':mail', $this->mail);
        $stmt->bindParam(':pwd', $this->pwd);
        $stmt->bindParam(':idtype', $this->idtype);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getMail() {
        return $this->mail;
    }

    public function getPwd() {
        return $this->pwd;
    }

    public function getIdtype() {
        return $this->idtype;
    }
}


