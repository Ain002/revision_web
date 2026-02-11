<?php

namespace app\controllers;

use Flight;
use app\models\User;

class UserController {

    public function add() {
        $body = Flight::request()->getBody();
        $data = json_decode($body, true);

        if (!$data || !isset($data['nom'], $data['mail'], $data['pwd'], $data['idtype'])) {
            Flight::json(['message' => 'Missing required fields'], 400);
            return;
        }

        $pwd_hashed = password_hash($data['pwd'], PASSWORD_DEFAULT);
        $user = new User(null, $data['nom'], $data['mail'], $pwd_hashed, $data['idtype']);
        if ($user->addModel(Flight::db())) {
            Flight::json(['message' => 'User added successfully']);
        } else {
            Flight::json(['message' => 'Failed to add user'], 500);
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
        if ($result && password_verify($data['pwd'], $result['pwd'])) {
            Flight::json(['message' => 'User verified successfully', 'user' => ['id' => $result['id'], 'nom' => $result['nom'], 'mail' => $result['mail'], 'idtype' => $result['idtype']]]);
        } else {
            Flight::json(['message' => 'Invalid email or password'], 401);
        }
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
}