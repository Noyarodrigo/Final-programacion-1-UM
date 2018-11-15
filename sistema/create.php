<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../config/database.php'; 
include_once '../objects/sistema.php';
 
$database = new Database();
$db = $database->getConnection();
 
$sistema = new Sistema($db);
 
$data = json_decode(file_get_contents("php://input"));
 
if(
    !empty($data->nombre) &&
    !empty($data->pais_procedencia) 
)
{
 
    $sistema->nombre = $data->nombre;
    $sistema->pais_procedencia = $data->pais_procedencia;
    $sistema->created = date('Y-m-d H:i:s');
    $sistema->updated = date('Y-m-d H:i:s');
     
    if($sistema->create()){
 
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