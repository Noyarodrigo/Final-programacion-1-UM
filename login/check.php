<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
include_once '../config/database.php';
include_once '../objects/login.php';
 
$database = new Database();
$db = $database->getConnection();

$login = new Login($db);

$login->nombre = isset($_POST['nombre']) ? $_POST['nombre'] : die();
$login->clave = isset($_POST['password']) ? $_POST['password'] : die();
$login->check();
if($login->nombre!=null){
    if (session_start()) {
        $_SESSION[tipo]=$login->tipo;
        $_SESSION[habilitado]=1;
        http_response_code(200); 
        echo json_encode(array("message" => "Sesion iniciada."));
    }
}
 
else{
    http_response_code(404);
    echo json_encode(array("message" => "Imposible iniciar sesion."));
    //header("location: http://localhost/prog1final/login/home.php");
}
?>