<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

$router->options('/api/login', 'ApiAuthController::login');
$router->get('/api/login', 'ApiAuthController::login');
$router->post('/api/login', 'ApiAuthController::login');

$router->options('/api/refresh', 'ApiAuthController::refresh');
$router->get('/api/refresh', 'ApiAuthController::refresh');
$router->post('/api/refresh', 'ApiAuthController::refresh');

$router->options('/api/logout', 'ApiAuthController::logout');
$router->get('/api/logout', 'ApiAuthController::logout');
$router->post('/api/logout', 'ApiAuthController::logout');

$router->options('/api/products', 'ProductApiController::index');
$router->get('/api/products', 'ProductApiController::index');
$router->post('/api/products', 'ProductApiController::store');

$router->options('/api/products/{id}', 'ProductApiController::show');
$router->get('/api/products/{id}', 'ProductApiController::show')
       ->where_number('id');
$router->put('/api/products/{id}', 'ProductApiController::update');
$router->delete('/api/products/{id}', 'ProductApiController::delete');
