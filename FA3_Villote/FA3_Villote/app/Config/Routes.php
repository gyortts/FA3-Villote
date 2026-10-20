<?php
use CodeIgniter\Router\RouteCollection;
/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('customers', 'CustomersController::index');
$routes->get('customers/new', 'CustomersController::new');
$routes->post('customers', 'CustomersController::create');
$routes->get('customers/(:num)/edit', 'CustomersController::edit/$1');
$routes->post('customers/(:num)', 'CustomersController::update/$1');
$routes->get('users', 'UsersController::index');
$routes->get('users/new', 'UsersController::new');
$routes->post('users', 'UsersController::create');
$routes->get('users/(:num)/edit', 'UsersController::edit/$1');
$routes->post('users/(:num)', 'UsersController::update/$1');
