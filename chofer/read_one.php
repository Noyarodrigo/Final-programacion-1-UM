<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
include_once '../config/database.php';
include_once '../objects/chofer.php';
 
$database = new Database();
$db = $database->getConnection();
 
$chofer = new Chofer($db);
 
$chofer->chofer_id = isset($_GET['id']) ? $_GET['id'] : die();
 
$chofer->readOne();
 
if($chofer->nombre!=null){
    // create array
    $chofer_arr = array(
        "chofer_id" => $chofer_id,
        "nombre" => $nombre,
        "apellido" => $apellido,
        "documento" => $documento,
        "email" => $email,
        "vehiculo_id" => $vehiculo_id,
        "sistema_id" => $sistema_id,
        "created" => $created,
        "updated" => $updated,
        "patente" => $patente,           
        "servicio" => $servicio,   
    );
 
    http_response_code(200); 
    echo json_encode($chofer_arr);
}
 
else{
    http_response_code(404);
    echo json_encode(array("message" => "No se encontró al chofer."));
}
?>