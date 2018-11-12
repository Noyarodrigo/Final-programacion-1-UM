<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
include_once '../config/database.php';
include_once '../objects/chofer.php';
 
$database = new Database();
$db = $database->getConnection();
 
$chofer = new Chofer($db);
 
$stmt = $chofer->read();
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
            "updated" => $updated            
        );
 
        array_push($chofer_arr["records"], $chofer_item);
    }
 
    http_response_code(200);
    echo json_encode($chofer_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No se encontraron choferes.")
    );
}
?>