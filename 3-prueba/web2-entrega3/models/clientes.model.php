<?php

class ClientesModel {
    private $db;

    public function __construct() {
       $this->db = new PDO('mysql:host=localhost;dbname=gestion_turnos;charset=utf8', 'root', '');
    }

    public function getClienteById($id_cliente) {    
        $query = $this->db->prepare('SELECT * FROM clientes WHERE id_cliente = ?');
        $query->execute([$id_cliente]);   
    
        $cliente = $query->fetch(PDO::FETCH_OBJ);
    
        return $cliente;
    }



}
 