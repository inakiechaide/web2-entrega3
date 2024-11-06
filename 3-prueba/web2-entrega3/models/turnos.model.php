<!-- <?php

class TurnosModel {
    private $db;

    public function __construct() {
       $this->db = new PDO('mysql:host=localhost;dbname=gestion_turnos;charset=utf8', 'root', '');
    }
 
    public function getTurnos($params = []) {
        // Valores por defecto para la paginación
        $page = isset($params['page']) ? (int)$params['page'] : 1;
        $limit = isset($params['limit']) ? (int)$params['limit'] : 10;
        $offset = ($page - 1) * $limit;

        
    
        // Construir la consulta base
        $sql = 'SELECT * FROM turnos WHERE 1=1';
        $queryParams = [];
    
        // Aplicar filtros dinámicos
        if (!empty($params['filters'])) {
            foreach ($params['filters'] as $field => $value) {
                switch ($field) {
                    case 'id_cliente':
                    case 'fecha_turno':
                    case 'hora_turno':
                    case 'finalizado':
                        $sql .= " AND $field = :$field";
                        $queryParams[$field] = $value;
                        break;
                
                }
            }
        }
    
        
    
        // Construir el ORDER BY dinámico
        if (!empty($params['orderBy'])) {
            $campo = $params['orderBy'];
            $direccion = isset($params['orderDirection']) ? strtoupper($params['orderDirection']) : 'ASC';
            
            // Validar que la dirección sea ASC o DESC
            $direccion = in_array($direccion, ['ASC', 'DESC']) ? $direccion : 'ASC';
            
            // Validar que el campo exista en la tabla
            $camposPermitidos = ['id_cliente', 'fecha_turno', 'hora_turno', 'finalizado'];
            if (in_array($campo, $camposPermitidos)) {
                $sql .= " ORDER BY $campo $direccion";
            }
        }
    
        // Agregar paginación
        $sql .= " LIMIT :limit OFFSET :offset";
        $queryParams['limit'] = $limit;
        $queryParams['offset'] = $offset;
    
        // Preparar y ejecutar la consulta
        $query = $this->db->prepare($sql);
        
        // Bindear los parámetros
        foreach ($queryParams as $param => $value) {
            $query->bindValue(":$param", $value);
        }
         $query->bindValue(":limit", $limit, PDO::PARAM_INT);
         $query->bindValue(":offset", $offset, PDO::PARAM_INT);
        $query->execute();
    
        // Obtener resultados
        $turnos = $query->fetchAll(PDO::FETCH_OBJ);
    
        // Obtener el total de registros para la paginación
        $sqlCount = 'SELECT COUNT(*) as total FROM turnos';
        $queryCount = $this->db->query($sqlCount);
        $total = $queryCount->fetch(PDO::FETCH_OBJ)->total;
    
        // Retornar resultados con metadata de paginación
        return [
                'data' => $turnos,
                'pagination' => [
                    'total' => $total,
                    'page' => $page,
                    'limit' => $limit,
                    'total_pages' => ceil($total / $limit)
                  ]
        ];
    }
 
    public function getTurno($id) {    
        $query = $this->db->prepare('SELECT * FROM turnos WHERE id_turno = ?');
        $query->execute([$id]);   
    
        $turno = $query->fetch(PDO::FETCH_OBJ);
    
        return $turno;
    }
 
    public function insertTurno($id_cliente, $fecha_turno, $hora_turno, $finalizado= false) { 
        $query = $this->db->prepare('INSERT INTO turnos(id_cliente, fecha_turno, hora_turno, finalizado) VALUES (?, ?, ?, ?)');
        $query->execute([$id_cliente, $fecha_turno, $hora_turno, $finalizado]);
    
        $id = $this->db->lastInsertId();
    
        return $id;
    }
 
    public function deleteTurno($id) {
        $query = $this->db->prepare('DELETE FROM turnos WHERE id_turno = ?');
        $query->execute([$id]);
    }

    public function setFinalize($id, $finalizado) {        
        $query = $this->db->prepare('UPDATE turnos SET finalizado = ? WHERE id_turno = ?');
        $query->execute([$finalizado, $id,]);
    }

    function updateTurno($id,$id_cliente, $fecha_turno, $hora_turno, $finalizado) {    
        $query = $this->db->prepare('UPDATE turnos SET id_cliente=?, fecha_turno=?, hora_turno=?, finalizado=? WHERE id_turno = ?');
        $query->execute([$id_cliente, $fecha_turno, $hora_turno, $finalizado, $id]);

    
    }
}
