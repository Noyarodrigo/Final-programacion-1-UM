<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
include_once '../config/database.php';
include_once '../objects/vehiculo.php';
 
$database = new Database();
$db = $database->getConnection();
 
$vehiculo = new Vehiculo($db);
 
$stmt = $vehiculo->read();
$num = $stmt->rowCount();
 
if($num>0){
 
    $vehiculo_arr=array();
    $vehiculo_arr["records"]=array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row); 
        $vehiculo_item=array(
            "vehiculo_id" => $vehiculo_id,
            "patente" => $patente,
            "anho_patente" => $anho_patente,
            "anho_fabricacion" => $anho_fabricacion,
            "marca" => $marca,
            "modelo" => $modelo,
            "created" => $created,
            "updated" => $updated,
        );
 
        array_push($vehiculo_arr["records"], $vehiculo_item);
    }
 
    http_response_code(200);
    echo json_encode($vehiculo_arr);
}
 
else{
 
    http_response_code(404);
    echo json_encode(
        array("message" => "No se encontraron vehiculos.")
    );
}
?>