<?php
require_once './models/clientes.model.php';

$model = new ClientesModel();
$clientes = $model->getClientes();

echo json_encode($clientes);
