<?php

$time1 = microtime(true);

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
include_once '../objects/auditoria.php';

$database = new Database();
$db = $database->getConnection();
$dbauditoria = $database->getConnection();

$chofer = new Chofer($db);
$auditoria= new Auditoria($dbauditoria);
 
$data = json_decode(file_get_contents("php://input"));
$jwt=isset($data->jwt) ? $data->jwt : "";

if($jwt){

    try {
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        //obtener datos del jwt
        $aux= get_object_vars($decoded);
        $usu= get_object_vars($aux[data]);        
        $usuario= $usu['nombre']." ".$usu['apellido'];

        $chofer->chofer_id = $data->chofer_id;
        $chofer->nombre = $data->nombre;
        $chofer->apellido = $data->apellido;
        $chofer->documento = $data->documento;
        $chofer->email = $data->email;
        $chofer->sistema_id = $data->sistema_id;
        $chofer->vehiculo_id = $data->vehiculo_id;
        $chofer->updated = date('Y-m-d H:i:s');

        if($chofer->update()){

            $time2= round(((microtime(true) - $time1)*1000), 2);
            $auditoria->response_time= $time2;            
            $auditoria->usuario= $usuario;
            $auditoria->created = date('Y-m-d H:i:s');
            //endpoint hay que cambiarlo para cada funcion seria el url de la pagina
            $auditoria->endpoint= "localhost/prog1final/chofer/update.php";
            //agregar auditoria
            $auditoria->create();

            http_response_code(200);
            echo json_encode(array("message" => "chofer modificado Correctamente."));
        }
        
        else{
            http_response_code(503);
            echo json_encode(array("message" => "No se pudo modificar al chofer."));
        }
    }catch (Exception $e){
        http_response_code(401);
        echo json_encode(array(
            "message" => "Token invalido.",
            "error" => $e->getMessage()
            ));
    }
}
?>