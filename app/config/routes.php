<?php

use app\controllers\ApiExampleController;
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

	$router->get('/hello', function() use ($app) {
		$app->render('hello');
	});

}, [ SecurityHeadersMiddleware::class ]);