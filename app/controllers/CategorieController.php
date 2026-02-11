<?php

namespace app\controllers;

use app\models\CategorieModel;
use flight\Engine;
use Flight;

class CategorieController{
    protected Engine $app;

	public function __construct($app) {
		$this->app = $app;
	}

    public function getAllCategories(){
        $db = Flight::db();
        $model = new CategorieModel($db);
        $categories = $model->getAllCategories();
        $this->app->render('index', ['categories' => $categories]);
    }

    public function insertCategorie(){
        $db = Flight::db();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Flight::redirect('/');
            return;
        }
        $nom   = $_POST['nom'];

        $model = new CategorieModel($db);
        $model->insertCategorie($nom);

        Flight::redirect('/inserCat');
    }

    public function removeCategorie($id) {
        $db = Flight::db();
        $model = new CategorieModel($db);
        $model->removeCategorie($id);
        Flight::redirect('/');
    }

    public function updateCategorie(){
        $db = Flight::db();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Flight::redirect('/');
            return;
        }
        $nom   = $_POST['nom'];
        $id = $_POST['id_categorie'];
        $model = new CategorieModel($db);
        $model->updateCategorie($nom,$id);

        Flight::redirect('/');
    }

}
;