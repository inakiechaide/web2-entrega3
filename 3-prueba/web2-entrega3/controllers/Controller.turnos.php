<?php
require_once './models/turnos.model.php';
require_once './models/clientes.model.php';
require_once './view/view.php';

class TurnosController
{
    private $model;
    private $view;
    private $clientesModel;

    public function __construct()
    {
        $this->model = new TurnosModel();
        $this->view = new View();
        $this->clientesModel = new ClientesModel();
    }

    // /api/turnos
    public function getAll($req, $res)
{
    
    $filters = []; // Array para los filtros

    // Capturar todos los posibles filtros
    if (isset($req->query->id_cliente)) {
        $filters['id_cliente'] = $req->query->id_cliente;
    }
    if (isset($req->query->fecha_turno)) {
        $filters['fecha_turno'] = $req->query->fecha_turno;
    }
    if (isset($req->query->hora_turno)) {
        $filters['hora_turno'] = $req->query->hora_turno;
    }
    if (isset($req->query->finalizado)) {
        $filters['finalizado'] = $req->query->finalizado; 
    }

    $orderBy = false;
    if (isset($req->query->orderBy)) {
        $orderBy = $req->query->orderBy;
    }

    $orderDirection = isset($req->query->orderDirection) ? $req->query->orderDirection : 'ASC'; // Default a 'ASC'
    $page = isset($req->query->page) ? (int)$req->query->page : 1;
    $limit = isset($req->query->limit) ? (int)$req->query->limit : 10;

    $turnos = $this->model->getTurnos([
        'filters' => $filters,
        'orderBy' => $orderBy,
        'orderDirection' => $orderDirection,
        'page' => $page, 
        'limit' => $limit,
    ]);

    // mando los turnos a la vista
    return $this->view->response($turnos);
}


    // /api/turnos/:id
    public function get($req, $res)
    {
        // obtengo el id del turno desde la ruta
        $id = $req->params->id;

        // obtengo el turno de la DB
        $turno = $this->model->getTurno($id);

        if (!$turno) {
            return $this->view->response("El turno con el id=$id no existe", 404);
        }

        // mando el turno a la vista
        return $this->view->response($turno);
    }

    // api/turnos/:id (DELETE)
    public function delete($req, $res)
    {

        if (!$res->user) {
            return $this->view->response("No autorizado", 401);
        }

        $id = $req->params->id;

        $turno = $this->model->getTurno($id);

        if (!$turno) {
            return $this->view->response("El turno con el id=$id no existe", 404);
        }

        $this->model->deleteTurno($id);
        $this->view->response("El turno con el id=$id se eliminó con éxito");  
    }

    // api/tareas (POST)
    public function create($req, $res)
    {

        if (!$res->user) {
            return $this->view->response("No autorizado", 401);
        }

        // valido los datos
        if (
            empty($req->body->id_cliente) || !isset($req->body->id_cliente) ||
            empty($req->body->fecha_turno) || !isset($req->body->fecha_turno) ||
            empty($req->body->hora_turno) || !isset($req->body->hora_turno)
        ) {
            return $this->view->response('Faltan completar datos', 400);
        }


        // obtengo los datos
        $id_cliente = $req->body->id_cliente;
        $fecha_turno = $req->body->fecha_turno;
        $hora_turno = $req->body->hora_turno;
        $finalizado = $req->body->finalizado;

        // valido cliente exista
        $cliente = $this->clientesModel->getClienteById($id_cliente);     // Buscar cliente por id en el model de clientes
        if (!$cliente) {
            return $this->view->response("El cliente con el id=$id_cliente no existe", 404);
        }

       

        // inserto los datos
        $id = $this->model->insertTurno($id_cliente, $fecha_turno, $hora_turno, $finalizado);

        if (!$id) {
            return $this->view->response("Error al insertar el turno", 500);
        }

        // devuelvo el id del turno insertado
      
        return $this->view->response("el turno id:$id se inserto con exito", 201);
    }

    // api/turnoss/:id (PUT)
    public function update($req, $res)
    {

        if (!$res->user) {
            return $this->view->response("No autorizado", 401);
        }
        $id = $req->params->id;

        // verifico que exista
        $turno = $this->model->getTurno($id);
        if (!$turno) {
            return $this->view->response("El turno con el id=$id no existe", 404);
        }

        // valido los datos
        if (
            empty($req->body->id_cliente) || !isset($req->body->id_cliente) ||
            empty($req->body->fecha_turno) || !isset($req->body->fecha_turno) ||
            empty($req->body->hora_turno) || !isset($req->body->hora_turno)
        ) {
            return $this->view->response('Faltan completar datos', 400);
        }

        // obtengo los datos
        $id_cliente = $req->body->id_cliente;
        $fecha_turno = $req->body->fecha_turno;
        $hora_turno = $req->body->hora_turno;
        $finalizado = $req->body->finalizado;

        // actualizo el turno
        $this->model->updateTurno($id, $id_cliente, $fecha_turno, $hora_turno, $finalizado);

        // obtengo el turno modificado y la devuelvo en la respuesta
        $turno = $this->model->getTurno($id);
        $this->view->response($turno, 200);
    }


    /**
     * Método para actualizar el subrecurso "finalizada" de tareas.
     * 
     * api/tareas/:id/finalizada (respeta RESTFul)
     * 
     * NOTA: se podria (y es mejor) usar un PATCH a api/tareas/:id
     * ya que es similar al PUT pero solo modifica lo que envias en
     * el body, el resto de los campos los deja igual.
     * (más dificil de implementar) 
     * 
     */
    public function setFinalize($req, $res)
    {
        if (!$res->user) {
            return $this->view->response("No autorizado", 401);
        }
        $id = $req->params->id;

        // verifico que exista
        $turno = $this->model->getTurno($id);
        if (!$turno) {
            return $this->view->response("El turno con el id=$id no existe", 404);
        }

        // valido los datos obligatorios
        if (!isset($req->body->finalizado)) {
            return $this->view->response('Faltan completar datos', 400);
        }

        // valido tipo de datos
        if ($req->body->finalizado !== 1 && $req->body->finalizado !== 0) {
            return $this->view->response('Tipo de dato incorrecto', 400);
        }

        // finalizamos
        $this->model->setFinalize($id, $req->body->finalizado);

        // obtengo el turno modificado y lo devuelvo en la respuesta
        $turno = $this->model->getTurno($id);
        $this->view->response($turno, 200);
    }
}
