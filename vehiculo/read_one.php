<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
include_once '../config/database.php';
include_once '../objects/vehiculo.php';
 
$database = new Database();
$db = $database->getConnection();
 
$vehiculo = new Vehiculo($db);
 
$vehiculo->vehiculo_id = isset($_GET['id']) ? $_GET['id'] : die();
 
$vehiculo->readOne();
 
if($vehiculo->patente!=null){

    $vehiculo_arr = array(
        "vehiculo_id" =>  $vehiculo->vehiculo_id,
        "patente" =>     $vehiculo->patente,
        "anho_patente" =>   $vehiculo->anho_patente,
        "anho_fabricacion" =>  $vehiculo->anho_fabricacion,
        "marca" =>      $vehiculo->marca,
        "modelo" => $vehiculo->modelo,
        "created" =>    $vehiculo->created,
        "updated" =>    $vehiculo->updated,
    );
 
    http_response_code(200); 
    echo json_encode($vehiculo_arr);
}
 
else{
    http_response_code(404);
    echo json_encode(array("message" => "No se encontró al vehiculo."));
}
?>