<?php

namespace app\controllers;

use Flight;
use app\models\User;

class UserController {

    public function add() {
        $body = Flight::request()->getBody();
        $data = json_decode($body, true);

        if (!$data || !isset($data['nom'], $data['mail'], $data['pwd'], $data['idtype'])) {
            Flight::json(['message' => 'Tous les champs sont requis'], 400);
            return;
        }

        // Vérifier si l'utilisateur existe déjà
        $userCheck = new User(null, null, $data['mail'], null, null);
        if ($userCheck->verifier(Flight::db())) {
            Flight::json(['message' => 'Cet email est déjà utilisé'], 409);
            return;
        }

        // Vérifier que le type est 1 (admin) ou 2 (visiteur)
        if (!in_array($data['idtype'], [1, 2])) {
            Flight::json(['message' => 'Type utilisateur invalide (1=admin, 2=visiteur)'], 400);
            return;
        }

        $pwd_hashed = password_hash($data['pwd'], PASSWORD_DEFAULT);
        $user = new User(null, $data['nom'], $data['mail'], $pwd_hashed, $data['idtype']);
        if ($user->addModel(Flight::db())) {
            Flight::json(['success' => true, 'message' => 'Inscription réussie']);
        } else {
            Flight::json(['message' => 'Erreur lors de l\'inscription'], 500);
        }
    }

    public function verifier() {
        $body = Flight::request()->getBody();
        $data = json_decode($body, true);

        if (!$data || !isset($data['mail'], $data['pwd'])) {
            Flight::json(['message' => 'Missing email or password'], 400);
            return;
        }

        $user = new User(null, null, $data['mail'], null, null);
        $result = $user->verifier(Flight::db());
        
        if (!$result) {
            Flight::json(['message' => 'Utilisateur introuvable'], 401);
            return;
        }

        if (!password_verify($data['pwd'], $result['pwd'])) {
            Flight::json(['message' => 'Mot de passe incorrect'], 401);
            return;
        }

        // Démarrer la session
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Créer les variables de session selon le type d'utilisateur
        $_SESSION['user_id'] = $result['id'];
        $_SESSION['user_nom'] = $result['nom'];
        $_SESSION['user_mail'] = $result['mail'];
        $_SESSION['user_type'] = $result['idtype'];
        
        // Créer une session spécifique selon le type
        if ($result['idtype'] == 1) {
            $_SESSION['is_admin'] = true;
            $_SESSION['is_visiteur'] = false;
        } else if ($result['idtype'] == 2) {
            $_SESSION['is_admin'] = false;
            $_SESSION['is_visiteur'] = true;
        }

        Flight::json([
            'success' => true,
            'message' => 'Connexion réussie',
            'user' => [
                'id' => $result['id'],
                'nom' => $result['nom'],
                'mail' => $result['mail'],
                'idtype' => $result['idtype']
            ]
        ]);
    }

    public function delete($id) {
        $user = new User($id, null, null, null, null);
        if ($user->deleteModel(Flight::db())) {
            Flight::json(['message' => 'User deleted successfully']);
        } else {
            Flight::json(['message' => 'Failed to delete user'], 500);
        }
    }

    public function update($id) {
        $data = Flight::request()->data;
        $pwd_hashed = isset($data['pwd']) ? password_hash($data['pwd'], PASSWORD_DEFAULT) : null;
        $user = new User($id, $data['nom'] ?? null, $data['mail'] ?? null, $pwd_hashed, $data['idtype'] ?? null);
        if ($user->updateModel(Flight::db())) {
            Flight::json(['message' => 'User updated successfully']);
        } else {
            Flight::json(['message' => 'Failed to update user'], 500);
        }
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Détruire toutes les variables de session
        $_SESSION = array();
        
        // Détruire la session
        session_destroy();
        
        Flight::json(['success' => true, 'message' => 'Déconnexion réussie']);
    }
}