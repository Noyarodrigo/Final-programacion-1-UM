<?php
if (session_start()) {
    if ($_SESSION[habilitado]!=1) {
        //a la casa a loguearse
        echo "<h3>Debe iniciar sesion</h3>";
        echo "<a href=\"http://localhost/prog1final/login/home.php\">Ingresar</a>";
        die();
    }
}
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../config/database.php';
include_once '../objects/chofer.php';
 
$database = new Database();
$db = $database->getConnection();
 
$chofer = new Chofer($db);
 
$data = json_decode(file_get_contents("php://input"));
 
$chofer->chofer_id = $data->chofer_id;
 
if($chofer->delete()){
 
    http_response_code(200);
    echo json_encode(array("message" => "Chofer eliminado."));
}
 
else{
 
    http_response_code(503);
    echo json_encode(array("message" => "Error al eliminar al chofer."));
}
?>