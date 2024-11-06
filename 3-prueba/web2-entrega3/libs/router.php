    <?php

    require_once './libs/request.php';
    require_once './libs/response.php';

    class Route {
        private $url;
        private $verb;
        private $controller;
        private $method;
        private $params;
        private $protected;

        public function __construct($url, $verb, $controller, $method,$protected = false){
            $this->url = $url;
            $this->verb = $verb;
            $this->controller = $controller;
            $this->method = $method;
            $this->params = [];
            $this->protected = $protected;
        }

        public function isProtected() {
            return $this->protected;
        }
        public function match($url, $verb) {
            if($this->verb != $verb){
                return false;
            }
            $partsURL = explode("/", trim($url,'/'));
            $partsRoute = explode("/", trim($this->url,'/'));
            if(count($partsRoute) != count($partsURL)){
                return false;
            }
            foreach ($partsRoute as $key => $part) {
                if($part[0] != ":"){
                    if($part != $partsURL[$key])
                    return false;
                } //es un parametro
                else
                $this->params[''.substr($part,1)] = $partsURL[$key];
            }
            return true;
        }
        public function run($request, $response){
            $controller = $this->controller;  
            $method = $this->method;
            $request->params = (object) $this->params;
        
            (new $controller())->$method($request, $response);
        }
    }

    class Router {
        private $routeTable = [];
        private $middlewares = [];
        private $defaultRoute;
        private $request;
        private $response;

        public function __construct() {
            $this->defaultRoute = null;
            $this->request = new Request();
            $this->response = new Response();
        }

        public function route($url, $verb) {
            foreach ($this->routeTable as $route) {
                if($route->match($url, $verb)){
                    // Solo ejecutar middleware si la ruta está protegida
                    if($route->isProtected()) {
                        foreach ($this->middlewares as $middleware) {
                            // Si el middleware falla, debería retornar false o lanzar una excepción
                            $result = $middleware->run($this->request, $this->response);
                            if (!$result) {
                                return; // O manejar el error apropiadamente
                            }
                        }
                    }
                    $route->run($this->request, $this->response);
                    return;
                }
            }
            if ($this->defaultRoute != null){
                $this->defaultRoute->run($this->request, $this->response);
            }
        }

        public function addMiddleware($middleware) {
            $this->middlewares[] = $middleware;
        }
        
        public function addRoute ($url, $verb, $controller, $method, $protected = false) {
            $this->routeTable[] = new Route($url, $verb, $controller, $method, $protected);
        }

        public function setDefaultRoute($controller, $method) {
            $this->defaultRoute = new Route("", "", $controller, $method);
        }
    }
