<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once './libs/router.php';
require_once './controllers/Controller.turnos.php';
require_once './controllers/Controller.clientes.php';
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


// Rutas de Clientes
$router->addRoute('clientes', 'GET', 'ClientesController', 'getAll', false);
$router->addRoute('clientes/:id', 'GET', 'ClientesController', 'get', false);
$router->addRoute('clientes', 'POST', 'ClientesController', 'create', true);
$router->addRoute('clientes/:id', 'PUT', 'ClientesController', 'update', true);
$router->addRoute('clientes/:id', 'DELETE', 'ClientesController', 'delete', true);


$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);