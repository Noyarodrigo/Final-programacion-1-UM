<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
include_once '../config/database.php';
include_once '../objects/auditoria.php';
 
$database = new Database();
$db = $database->getConnection();
 
$auditoria = new Auditoria($db);
 
$stmt = $auditoria->read();
$num = $stmt->rowCount();
 
if($num>0){
 
    $auditoria_arr=array();
    $auditoria_arr["records"]=array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row); 
        $auditoria_item=array(
            "auditoria_id" => $auditoria_id,
            "user" => $user,
            "response_time" => $response_time,
            "endpoint" => $endpoint,
            "created" => $created
        );
 
        array_push($auditoria_arr["records"], $auditoria_item);
    }
 
    http_response_code(200);
    echo json_encode($auditoria_arr);
}
 
else{
 
    http_response_code(404);
    echo json_encode(
        array("message" => "No se encontraron auditorias.")
    );
}
?>