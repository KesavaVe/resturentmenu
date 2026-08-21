<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'CartController::index');
$routes->group('api', ['filter' => 'apiAuth'], function ($routes) {
    $routes->get('orders', 'Api\OrderController::index');
    $routes->get('orders/(:num)', 'Api\OrderController::show/$1');
});
$routes->get('cart', 'CartController::index');

$routes->post('cart/add', 'CartController::add');
$routes->post('cart/increase', 'CartController::increase');
$routes->post('cart/decrease', 'CartController::decrease');
$routes->post('cart/remove', 'CartController::remove');
$routes->post('cart/clear', 'CartController::clear');

$routes->post('cart/update-quantity', 'CartController::updateQuantity');