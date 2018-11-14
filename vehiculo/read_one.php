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

    $chofer_arr = array(
        "chofer_id" =>  $chofer->chofer_id,
        "nombre" =>     $chofer->nombre,
        "apellido" =>   $chofer->apellido,
        "documento" =>  $chofer->documento,
        "email" =>      $chofer->email,
        "vehiculo_id" =>$chofer->vehiculo_id,
        "sistema_id" => $chofer->sistema_id,
        "created" =>    $chofer->created,
        "updated" =>    $chofer->updated,
        "patente" =>    $chofer->patente,           
        "servicio" =>   $chofer->servicio   
    );
 
    http_response_code(200); 
    echo json_encode($chofer_arr);
}
 
else{
    http_response_code(404);
    echo json_encode(array("message" => "No se encontró al chofer."));
}
?>