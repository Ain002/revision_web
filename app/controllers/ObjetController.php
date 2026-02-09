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
        $objetModel = new ObjetModel();
        $mesObjets = $objetModel->getObjectByOwner($this->app->get('user_id'));

        // Render the view with the list of objects
        $this->app->render('MyObjet', [
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
        $this->app->render('ObjetDetails', [
            'objet' => $objet,
            'images' => $images
        ]);
    }

}