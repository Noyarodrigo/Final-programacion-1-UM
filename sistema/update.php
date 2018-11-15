<?php
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

$vehiculo->vehiculo_id = $data->vehiculo_id;
$vehiculo->patente = $data->patente;
$vehiculo->anho_patente = $data->anho_patente;
$vehiculo->anho_fabricacion = $data->anho_fabricacion;
$vehiculo->marca = $data->marca;
$vehiculo->modelo = $data->modelo;
$vehiculo->updated = date('Y-m-d H:i:s');

if($vehiculo->update()){
    http_response_code(200);
    echo json_encode(array("message" => "vehiculo modificado Correctamente."));
}
 
else{
    http_response_code(503);
    echo json_encode(array("message" => "No se pudo modificar al vehiculo."));
}
?>