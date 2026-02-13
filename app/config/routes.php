<?php

use app\controllers\ApiExampleController;
use app\controllers\CategorieController;
use app\controllers\ObjetController;
use app\controllers\UserController;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

/** 
 * @var Router $router 
 * @var Engine $app
 */

if (empty($app) === true) {
	$app = \Flight::app();
}

// This wraps all routes in the group with the SecurityHeadersMiddleware
$router->group('', function(Router $router) use ($app) {

	$router->group('/users', function() use ($router) {
		$router->post('/add', [ UserController::class, 'add' ]);
		$router->post('/login', [ UserController::class, 'verifier' ]);
		$router->post('/logout', [ UserController::class, 'logout' ]);
		$router->delete('/@id:[0-9]', [ UserController::class, 'delete' ]);
		$router->post('/@id:[0-9]', [ UserController::class, 'update' ]);
	});

	$router->get('/', function() use ($app) {
		$app->render('login');
	});

	$router->get('/login', function() use ($app) {
		$app->render('login');
	});

	$router->get('/inscription', function() use ($app) {
		$app->render('inscription');
	});

	$router->group('/objet', function() use ($router) {
		$router->get('/mesObjets', [ ObjetController::class, 'myObjects' ]);
		$router->get('/ajouterObjet', [ ObjetController::class, 'createObjet' ]);
		$router->post('/store', [ ObjetController::class, 'storeObjet' ]);
		$router->get('/@id:[0-9]+/edit', [ ObjetController::class, 'editObjet' ]);
		$router->post('/@id:[0-9]+/update', [ ObjetController::class, 'updateObjet' ]);
		$router->get('/@id:[0-9]+', [ ObjetController::class, 'getObjectById' ]);
		$router->post('/@id:[0-9]+/delete', [ ObjetController::class, 'deleteObjet' ]);
		$router->get('/accueil', [ ObjetController::class, 'getObjectHorsProprietaire' ]);
	});
	
	$router->get('/hello', function() use ($app) {
		$app->render('hello');
	});

	$router->get('/listCategories', [ CategorieController::class, 'getAllCategories' ]);

	$router->group('/categories', function() use ($router) {

		$router->get('', [ CategorieController::class, 'getAllCategories' ]);
	
		$router->post('/insert', [ CategorieController::class, 'insertCategorie' ]);
	
		$router->get('/delete/@id:[0-9]+', [ CategorieController::class, 'removeCategorie' ]);
	
		$router->post('/update', [ CategorieController::class, 'updateCategorie' ]);
	
	});
	

	//$router->get('/supprimer/@id', [ CategorieController::class, 'removeCategorie' ]);
}, [ SecurityHeadersMiddleware::class ]);