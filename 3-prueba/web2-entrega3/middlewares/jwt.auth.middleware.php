<?php
require_once './libs/jwt.php';

class JWTAuthMiddleware {
    public function run($req, $res) {
       

        $auth_header = $_SERVER['HTTP_AUTHORIZATION'];
        $auth_header = explode(' ', $auth_header);

        // Verificar formato correcto del header
        if (count($auth_header) != 2 || $auth_header[0] != 'Bearer') {
            
            return false;
        }

        // Validar el token
        $jwt = $auth_header[1];
        $res->user = validateJWT($jwt); 
        return true;
    }
}