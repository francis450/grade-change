<?php
session_start();

// Include the autoloader
require_once 'autoload.php';

// Load configuration
require_once 'config/config.php';

// Create the router instance
$router = new Router(new Request);
// Define routes
$router->get('/', 'AuthController@login');
$router->get('/users', 'UserController@index');
$router->get('/users/show/{id}', 'UserController@show');
$router->get('/users/create', 'UserController@create');
$router->post('/users/store', 'UserController@store');
$router->get('/users/edit/{id}', 'UserController@edit');
$router->post('/users/update/{id}', 'UserController@update');
$router->get('/users/delete/{id}', 'UserController@delete');

$router->get('/login', 'AuthController@login');
$router->post('/login', 'AuthController@login');
$router->get('/register', 'AuthController@register');
$router->post('/register', 'AuthController@register');
$router->get('/logout', 'AuthController@logout');

$router->get('/dashboard', 'DashboardController@index');
$router->get('/dashboard/users', 'DashboardController@users');
$router->get('/dashboard/courses', 'DashboardController@courses');
$router->get('/dashboard/departments', 'DashboardController@departments');
$router->get('/dashboard/grades', 'DashboardController@grades');
$router->get('/dashboard/grade-change-requests', 'DashboardController@gradeChangeRequests');
$router->get('/dashboard/students', 'DashboardController@students');
$router->get('/dashboard/notifications', 'DashboardController@notifications');

$router->post('/departments/store', 'DepartmentController@store');
$router->get('/department/show', 'DepartmentController@show');

$router->get('/', 'AuthController@login');

$router->resolve();