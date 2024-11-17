<?php
require_once './libs/jwt.php';
require_once './view/view.php';

class JWTAuthMiddleware {
    public function run($req, $res) {
        // Verificar si existe el header de autorización
        if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            error_log("Authorization header missing");
           $res->response(['error' => 'No autorizado: falta el token de autorizacion.'], 401);
            return false;
        }

        $auth_header = $_SERVER['HTTP_AUTHORIZATION'];
        error_log("Authorization header value: " . $auth_header);
        $auth_header = explode(' ', $auth_header);

        // Verificar formato correcto del header
        if (count($auth_header) != 2 || $auth_header[0] != 'Bearer') {
            $res->response(['error' => 'Formato de autorizacion invalido'], 401);
            return false;
        }

        // Validar el token
        $jwt = $auth_header[1];
        $payload = validateJWT($jwt);

        error_log("JWT payload: " . json_encode($payload));

        // Verificar si el token es válido
        if ($payload === null) {
            $res->response(['error' => 'Token invalido o expirado'], 401);
            return false;
        }

        // Si todo está bien, guardar la información del usuario en el request
        $res->user = $payload;  
        return true;
    }
}