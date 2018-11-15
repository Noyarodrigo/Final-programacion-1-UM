<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
include_once '../config/database.php';
include_once '../objects/sistema.php';
 
$database = new Database();
$db = $database->getConnection();
 
$sistema = new Sistema($db);
 
$keywords=isset($_GET["buscar"]) ? $_GET["buscar"] : "";
 
$stmt = $sistema->search($keywords);
$num = $stmt->rowCount();

if($num>0){
 
    $sistema_arr=array();
    $sistema_arr["records"]=array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);
        $sistema_item = array(
            "sistema_id" =>  $sistema_id,
            "patente" =>     $patente,
            "anho_patente" =>   $anho_patente,
            "anho_fabricacion" =>  $anho_fabricacion,
            "marca" =>      $marca,
            "modelo" => $modelo,
            "created" => $created,
            "updated" => $updated,
        );
 
        array_push($sistema_arr["records"], $sistema_item);
    }
 
    http_response_code(200);
    echo json_encode($sistema_arr);
}
 
else{

    http_response_code(404);
    echo json_encode(
        array("message" => "No se encontró ningún sistema.")
    );
}
?>