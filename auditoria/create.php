<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../config/database.php'; 
include_once '../objects/auditoria.php';
 
$database = new Database();
$db = $database->getConnection();
 
$auditoria = new Auditoria($db);
 
$data = json_decode(file_get_contents("php://input"));
 
if(
    !empty($data->user) &&
    !empty($data->response_time) &&
    !empty($data->endpoint)
)
{
 
    $auditoria->user = $data->user;
    $auditoria->response_time = $data->response_time;
    $auditoria->endpoint = $data->endpoint;
    $auditoria->created = date('Y-m-d H:i:s');
     
    if($auditoria->create()){
 
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