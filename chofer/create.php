<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/core.php';
include_once '../php-jwt/src/BeforeValidException.php';
include_once '../php-jwt/src/ExpiredException.php';
include_once '../php-jwt/src/SignatureInvalidException.php';
include_once '../php-jwt/src/JWT.php';
use \Firebase\JWT\JWT;

include_once '../config/database.php'; 
include_once '../objects/chofer.php';
 
$database = new Database();
$db = $database->getConnection();

$chofer = new Chofer($db);

$data = json_decode(file_get_contents("php://input"));
$jwt=isset($data->jwt) ? $data->jwt : "";
if($jwt){
    try {
        //si cambio $key no funciona (y)
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        $chofer->nombre = $data->nombre;
        $chofer->apellido = $data->apellido;
        $chofer->documento = $data->documento;
        $chofer->email = $data->email;
        $chofer->sistema_id = $data->sistema_id;
        $chofer->vehiculo_id = $data->vehiculo_id;
        $chofer->created = date('Y-m-d H:i:s');
        $chofer->updated = date('Y-m-d H:i:s');
        print_r($chofer);
    }
 
    catch (Exception $e){
 
        http_response_code(401);
        echo json_encode(array(
            "message" => "Token invalido.",
            "error" => $e->getMessage()
        ));
    }
}

else{
    http_response_code(401);
    echo json_encode(array("message" => "Error en el json."));
}
if(
    !empty($data->nombre) &&
    !empty($data->apellido) &&
    !empty($data->documento) &&
    !empty($data->email) &&
    !empty($data->sistema_id) &&
    !empty($data->vehiculo_id)
){
 
    if($chofer->create()){
 
        http_response_code(201);
        echo json_encode(array("message" => "Agregado correctamente."));
    }

    else{
        http_response_code(503); 
        echo json_encode(array("message" => "No se pudo agregar."));
    }
}
//FALTAN DATOS 
else{
 
    http_response_code(400);
    echo json_encode(array("message" => "No se pudo agregar, faltan datos."));
}
?>