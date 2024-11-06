<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once './libs/router.php';
require_once './controllers/Controller.turnos.php';
require_once './controllers/user.controller.php';
require_once './middlewares/jwt.auth.middleware.php';

$router = new Router();

// Rutas públicas (protected = false por defecto)
$router->addRoute('usuarios/token', 'GET', 'UserApiController', 'getToken'); //en authorization usuario y contra (webadmin, admin), recibe el jwt y con ese hace peticiones rstringidas(Bearer jwt)


// middleware para las rutas protegidas
$router->addMiddleware(new JWTAuthMiddleware());

// Rutas protegidas (protected = true)
$router->addRoute('turnos', 'GET', 'TurnosController', 'getAll', false);
$router->addRoute('turnos/:id', 'GET', 'TurnosController', 'get', false);
$router->addRoute('turnos/:id', 'DELETE', 'TurnosController', 'delete', true);
$router->addRoute('turnos', 'POST', 'TurnosController', 'create', true);
$router->addRoute('turnos/:id', 'PUT', 'TurnosController', 'update', true);
$router->addRoute('turnos/:id/finalizado', 'PUT', 'TurnosController', 'setFinalize', true);

$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);