<?php
require_once './models/clientes.model.php';
require_once './models/turnos.model.php';
require_once './view/view.php';

class ClientesController {
    private $model;
    private $view;

   public function __construct() {
        $this->model = new ClientesModel();
        $this->view = new View();
    } 
    
    // Obtener todos los clientes
    public function getAll($req, $res) {
        
        $filters = [];

        if (isset($req->query->nombre)) {
            $filters['nombre'] = $req->query->nombre;
        }
        if (isset($req->query->telefono)) {
            $filters['telefono'] = $req->query->telefono;
        }
        if (isset($req->query->email)) {
            $filters['email'] = $req->query->email;
        }

        $orderBy = false;
        if (isset($req->query->orderBy)) {
            $orderBy = $req->query->orderBy;
        }
    
        $orderDirection = isset($req->query->orderDirection) ? $req->query->orderDirection : 'ASC'; // Default a 'ASC'
        $page = isset($req->query->page) ? (int)$req->query->page : 1;
        $limit = isset($req->query->limit) ? (int)$req->query->limit : 10;

        $clientes = $this->model->getClientes([
            'filters' => $filters,
            'orderBy' => $orderBy,
            'orderDirection' => $orderDirection,
            'page' => $page,
            'limit' => $limit,
        ]);

        return $this->view->response($clientes);
        
    }

    // Obtener un cliente por ID
    public function get($req, $res) {
        $id = $req->params->id;
        $cliente = $this->model->getClienteById($id);


        if (!$cliente) {
            return $this->view->response("El cliente con el ID $id no existe", 404);
        }

        return $this->view->response($cliente);
    }

    // Crear un cliente
    public function create($req, $res) {
        if (!$res->user) {
            return $this->view->response("No autorizado", 401);
        }
        if (
            empty($req->body->nombre) || 
            empty($req->body->telefono) || 
            empty($req->body->email) 
        ) {
            return $this->view->response("Faltan datos obligatorios", 400);
        }

        $id = $this->model->insertCliente($req->body->nombre, $req->body->telefono, $req->body->email, $req->body->foto);
        return $this->view->response("Cliente creado con ID $id", 201);
    }

    // Actualizar un cliente
    public function update($req, $res) {
        if (!$res->user) {
            return $this->view->response("No autorizado", 401);
        }
        $id = $req->params->id;
        $cliente = $this->model->getClienteById($id);

        if (!$cliente) {
            return $this->view->response("El cliente con el ID $id no existe", 404);
        }
        
        if (
            empty($req->body->nombre) || !isset($req->body->nombre) ||
            empty($req->body->telefono) || !isset($req->body->telefono) ||
            empty($req->body->email) || !isset($req->body->email)
        ) {
            return $this->view->response('Faltan completar datos', 400);
        }

        $this->model->updateCliente($id, $req->body->nombre, $req->body->telefono, $req->body->email);
        return $this->view->response("Cliente actualizado con exito", 200);
    }

    // Eliminar un cliente
    public function delete($req, $res) {
        if (!$res->user) {
            return $this->view->response("No autorizado", 401);
        }
        $id = $req->params->id;
        $cliente = $this->model->getClienteById($id);

        if (!$cliente) {
            return $this->view->response("El cliente con el ID $id no existe", 404);
        }

        $this->model->deleteCliente($id);
        return $this->view->response("Cliente eliminado con exito", 200);
    }
}
