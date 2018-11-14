<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../config/database.php'; 
include_once '../objects/vehiculo.php';
 
$database = new Database();
$db = $database->getConnection();
 
$vehiculo = new Vehiculo($db);
 
$data = json_decode(file_get_contents("php://input"));
 
if(
    !empty($data->patente) &&
    !empty($data->anho_patente) &&
    !empty($data->anho_fabricacion) &&
    !empty($data->marca) &&
    !empty($data->modelo)
)
{
 
    $vehiculo->patente = $data->patente;
    $vehiculo->anho_patente = $data->anho_patente;
    $vehiculo->anho_fabricacion = $data->anho_fabricacion;
    $vehiculo->marca = $data->marca;
    $vehiculo->modelo = $data->modelo;
    $vehiculo->created = date('Y-m-d H:i:s');
    $vehiculo->updated = date('Y-m-d H:i:s');
     
    if($vehiculo->create()){
 
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