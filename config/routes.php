<?php

$router = $container->getRouter();
$router->setNamespace('App\Controller');

/**
 * Routes de base
 */
$router->get('', 'PagesController@index'); // Page d'accueil


/**
 * Routes USER
 */
$router->get('/users', 'UsersController@index');
$router->get('/users/(\d+)/', 'UsersController@show');

$router->get('/users/new/', 'UsersController@new');     // Affiche le formulaire de création
$router->post('/users/new/', 'UsersController@create'); // Traite le formulaire de création puis redirige

$router->get('/users/(\d+)/edit/', 'UsersController@edit');     // Affiche le formulaire d'édition
$router->post('/users/(\d+)/edit/', 'UsersController@update');  // Traite le formulaire d'édition puis redirige

$router->get('/users/(\d+)/delete/', 'UsersController@delete'); // Action de supprimer un user

/**
 * Routes CAR
 */
$router->get('/cars', 'CarsController@index');
$router->get('/cars/(\d+)/', 'CarsController@show');

$router->get('/cars/new/', 'CarsController@new');     // Affiche le formulaire de création
$router->post('/cars/new/', 'CarsController@create'); // Traite le formulaire de création puis redirige

$router->get('/cars/(\d+)/edit/', 'CarsController@edit');     // Affiche le formulaire d'édition
$router->post('/cars/(\d+)/edit/', 'CarsController@update');  // Traite le formulaire d'édition puis redirige

$router->get('/cars/(\d+)/delete/', 'CarsController@delete'); // Action de supprimer une voiture

/**
 * Routes LOCATION
 */
$router->get('/locations', 'LocationsController@index');
$router->get('/locations/(\d+)/', 'LocationsController@show');

$router->get('/locations/new/', 'LocationsController@new');     // Affiche le formulaire de création
$router->post('/locations/new/', 'LocationsController@create'); // Traite le formulaire de création puis redirige

$router->get('/locations/(\d+)/edit/', 'LocationsController@edit');     // Affiche le formulaire d'édition
$router->post('/locations/(\d+)/edit/', 'LocationsController@update');  // Traite le formulaire d'édition puis redirige

$router->get('/locations/(\d+)/delete/', 'LocationsController@delete'); // Action de supprimer une location


$router->run();