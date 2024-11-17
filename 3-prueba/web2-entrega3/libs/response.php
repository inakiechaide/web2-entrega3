<?php
    class Response {
        public $user = null;

        public function response($data, $statusCode = 200) {
            http_response_code($statusCode); // Configura el código HTTP
            header('Content-Type: application/json'); // Define el formato como JSON
            echo json_encode($data); // Convierte el cuerpo de la respuesta a JSON
            exit; // Finaliza la ejecución
        }
    }
