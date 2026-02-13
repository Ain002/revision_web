<?php

namespace app\controllers;

use flight\Engine;
use app\models\ObjetModel;

class ObjetController {

	protected Engine $app;

	public function __construct($app) {
		$this->app = $app;
	}

    public function myObjects() {
        if(session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            return null;
        }

        $userId = $_SESSION['user_id'];
        
        $objetModel = new ObjetModel();
        $mesObjets = $objetModel->getObjectByOwner($userId);

        // Build images array for the view: flat list of images with objet_id => url/path
        $images = [];
        foreach ($mesObjets as $o) {
            $oid = $o['id'] ?? $o['objet_id'] ?? $o['id_objet'] ?? null;
            if ($oid) {
                $imgs = $objetModel->getObjectImages($oid);
                foreach ($imgs as $img) {
                    $images[] = [
                        'objet_id' => $oid,
                        'url' => $img['nom'] ?? $img['path'] ?? $img['filename'] ?? null,
                    ];
                }
            }
        }

        // Render the view with the list of objects and images
        $this->app->render('myObjet', [
            'mesObjets' => $mesObjets,
            'images' => $images,
        ]);
    }

    public function getObjectById($id) {
        $objetModel = new ObjetModel();
        $objet = $objetModel->getObjectById($id);
        if (!$objet) {
            $this->app->notFound();
            return;
        }

        // Fetch images associated with the object
        $images = $objetModel->getObjectImages($id);

        // Render the view with the object details and images
        $this->app->render('ficheObjet', [
            'objet' => $objet,
            'images' => $images
        ]);
    }

    public function getObjectHorsProprietaire() {
        if(session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            return null;
        }

        $userId = $_SESSION['user_id'];
        $objetModel = new ObjetModel();
        $objet = $objetModel->getObjectHorsProprietaire($userId);
        if (!$objet) {
            $this->app->notFound();
            return;
        }

        // Build images list for these objets
        $images = [];
        foreach ($objet as $o) {
            $oid = $o['id'] ?? $o['objet_id'] ?? $o['id_objet'] ?? null;
            if ($oid) {
                $imgs = $objetModel->getObjectImages($oid);
                foreach ($imgs as $img) {
                    $images[] = [ 'objet_id' => $oid, 'nom' => $img['nom'] ?? null ];
                }
            }
        }

        // Render the view with the object details and images
        $this->app->render('accueil', [
            'objet' => $objet,
            'images' => $images,
        ]);
    }

    public function createObjet() {
        $this->app->render('createObjet', []);
    }

    public function storeObjet() {
        if(session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) {
            $this->app->halt(403, 'Unauthorized');
        }

        $data = [
            'proprietaire_id' => $_SESSION['user_id'],
            'categorie_id' => $_POST['categorie_id'] ?? 1,
            'nom' => $_POST['nom'] ?? '',
            'description' => $_POST['description'] ?? '',
            'prix' => $_POST['prix'] ?? 0,
        ];

        $objetModel = new ObjetModel();
        $newId = $objetModel->addObject($data);
        if ($newId === false) {
            $this->app->halt(500, 'Erreur lors de la création');
        }

        // Handle image upload(s)
        if (!empty($_FILES['images'])) {
            $uploadDir = __DIR__ . '/../../public/uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            foreach ($_FILES['images']['error'] as $idx => $err) {
                if ($err === UPLOAD_ERR_OK) {
                    $tmp = $_FILES['images']['tmp_name'][$idx];
                    $orig = basename($_FILES['images']['name'][$idx]);
                    $safe = preg_replace('/[^A-Za-z0-9._-]/', '_', $orig);
                    $target = $uploadDir . $safe;
                    if (move_uploaded_file($tmp, $target)) {
                        $objetModel->addImageToObject($newId, $safe);
                    }
                }
            }
        }

        $this->app->redirect('/mesObjets');
    }

    public function editObjet($id) {
        $objetModel = new ObjetModel();
        $objet = $objetModel->getObjectById($id);
        if (!$objet) { $this->app->notFound(); return; }
        $images = $objetModel->getObjectImages($id);
        $this->app->render('editObjet', [ 'objet' => $objet, 'images' => $images ]);
    }

    public function updateObjet($id) {
        if(session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) {
            $this->app->halt(403, 'Unauthorized');
        }

        $data = [
            'proprietaire_id' => $_SESSION['user_id'],
            'categorie_id' => $_POST['categorie_id'] ?? 1,
            'nom' => $_POST['nom'] ?? '',
            'description' => $_POST['description'] ?? '',
            'prix' => $_POST['prix'] ?? 0,
        ];

        $objetModel = new ObjetModel();
        $ok = $objetModel->updateObject($id, $data);
        if (!$ok) $this->app->halt(500, 'Erreur mise à jour');

        // Handle new uploaded images
        if (!empty($_FILES['images'])) {
            $uploadDir = __DIR__ . '/../../public/uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            foreach ($_FILES['images']['error'] as $idx => $err) {
                if ($err === UPLOAD_ERR_OK) {
                    $tmp = $_FILES['images']['tmp_name'][$idx];
                    $orig = basename($_FILES['images']['name'][$idx]);
                    $safe = preg_replace('/[^A-Za-z0-9._-]/', '_', $orig);
                    $target = $uploadDir . $safe;
                    if (move_uploaded_file($tmp, $target)) {
                        $objetModel->addImageToObject($id, $safe);
                    }
                }
            }
        }

        $this->app->redirect('/mesObjets');
    }

}