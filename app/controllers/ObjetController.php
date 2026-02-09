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

        // Render the view with the list of objects
        $this->app->render('myObjet', [
            'objet' => $mesObjets
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

        // Render the view with the object details and images
        $this->app->render('accueil', [
            'objet' => $objet
        ]);
    }

}