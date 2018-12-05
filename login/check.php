<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
include_once '../config/database.php';
include_once '../objects/login.php';
 
include_once '../config/core.php';
include_once '../php-jwt/src/BeforeValidException.php';
include_once '../php-jwt/src/ExpiredException.php';
include_once '../php-jwt/src/SignatureInvalidException.php';
include_once '../php-jwt/src/JWT.php';
use \Firebase\JWT\JWT;

$database = new Database();
$db = $database->getConnection();

$login = new Login($db);

if ($_SERVER['REQUEST_METHOD'] !=  "GET"){
    die();
}

$data = json_decode(file_get_contents("php://input"));

$login->nom = $data->nombre;
$login->cla = $data->password;

$login->check();

if($login->nombre!=null && $login->tipo!=null){
    $token = array(
        "iss" => $iss,
        "aud" => $aud,
        "iat" => $iat,
        "nbf" => $nbf,
        "data" => array(
            "id" => $login->id,
            "nombre" => $login->nombre,
            "apellido"=> $login->apellido,
            "tipo" => $login->tipo,
        )
     );
     http_response_code(200);
     //jwt
    $jwt = JWT::encode($token, $key);
    echo json_encode(array("jwt" => "$jwt"));
}
 
else{
 
    http_response_code(401);
    echo json_encode(array("message" => "No se pudo iniciar sesion."));
}

?>