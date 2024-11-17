<?php

class ClientesModel {
    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=gestion_turnos;charset=utf8', 'root', '');
    }

    // Obtener todos los clientes con filtros y paginación
   public function getClientes($params = []) {
        $page = isset($params['page']) ? (int)$params['page'] : 1;
        $limit = isset($params['limit']) ? (int)$params['limit'] : 10;
        $offset = ($page - 1) * $limit;

        $sql = 'SELECT * FROM clientes WHERE 1=1';
        $queryParams = [];

        // Filtros dinámicos
        if (!empty($params['filters'])) {
            foreach ($params['filters'] as $field => $value) {
                switch ($field) {
                    case 'nombre':
                    case 'telefono':
                    case 'email':
                        $sql .= " AND $field LIKE :$field";
                        $queryParams[$field] = "%$value%";
                        break;
                    case 'id_cliente':
                        $sql .= " AND $field = :$field";
                        $queryParams[$field] = $value;
                        break;
                }
            }
        }

        // Orden dinámico
        if (!empty($params['orderBy'])) {
            $campo = $params['orderBy'];
            $direccion = isset($params['orderDirection']) ? strtoupper($params['orderDirection']) : 'ASC';
            $direccion = in_array($direccion, ['ASC', 'DESC']) ? $direccion : 'ASC';

            $camposPermitidos = ['id_cliente', 'nombre', 'telefono', 'email'];
            if (in_array($campo, $camposPermitidos)) {
                $sql .= " ORDER BY $campo $direccion";
            }
        }

        $sql .= " LIMIT :limit OFFSET :offset";
        $queryParams['limit'] = $limit;
        $queryParams['offset'] = $offset;

        $query = $this->db->prepare($sql);

        foreach ($queryParams as $param => $value) {
            $query->bindValue(":$param", $value);
        }
        $query->bindValue(":limit", $limit, PDO::PARAM_INT);
        $query->bindValue(":offset", $offset, PDO::PARAM_INT);

        $query->execute();
        $clientes = $query->fetchAll(PDO::FETCH_OBJ);

        // Total de registros
        $sqlCount = 'SELECT COUNT(*) as total FROM clientes';
        $queryCount = $this->db->query($sqlCount);
        $total = $queryCount->fetch(PDO::FETCH_OBJ)->total;

        return [
            'data' => $clientes,
            'pagination' => [
                'total' => $total,
                'page' => $page,
                'limit' => $limit,
                'total_pages' => ceil($total / $limit),
            ],
        ];
    }

    // Obtener un cliente por ID
    public function getClienteById($id) {
        $query = $this->db->prepare('SELECT * FROM clientes WHERE id_cliente = ?');
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    // Crear un cliente
    public function insertCliente($nombre, $telefono, $email, $foto) {
        $query = $this->db->prepare('INSERT INTO clientes (nombre, telefono, email, foto) VALUES (?, ?, ?, ?)');
        $query->execute([$nombre, $telefono, $email, $foto]);
        return $this->db->lastInsertId();
    }

    // Actualizar un cliente
    public function updateCliente($id, $nombre, $telefono, $email) {
        $query = $this->db->prepare('UPDATE clientes SET nombre = ?, telefono = ?, email = ? WHERE id_cliente = ?');
        $query->execute([$nombre, $telefono, $email, $id]);
    }

    // Eliminar un cliente
    public function deleteCliente($id) {
        //elimino todos los turnos del cliente 
        $queryTurnos = $this->db->prepare('DELETE FROM turnos WHERE id_cliente = ?');
        $queryTurnos->execute([$id]);

        //elimino al cliente
        $query = $this->db->prepare('DELETE FROM clientes WHERE id_cliente = ?');
        $query->execute([$id]);
    }
}

 