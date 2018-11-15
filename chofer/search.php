<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/chofer.php';
 
$database = new Database();
$db = $database->getConnection();
 
$chofer = new Chofer($db);
 
$keywords=isset($_GET["buscar"]) ? $_GET["buscar"] : "";
 
$stmt = $chofer->search($keywords);
$num = $stmt->rowCount();
 
if($num>0){
 
    $chofer_arr=array();
    $chofer_arr["records"]=array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);
        $chofer_item=array(
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
 
        array_push($chofer_arr["records"], $chofer_item);
    }
 
    http_response_code(200);
    echo json_encode($chofer_arr);
}
 
else{

    http_response_code(404);
    echo json_encode(
        array("message" => "No se encontró ningún chofer.")
    );
}
?>