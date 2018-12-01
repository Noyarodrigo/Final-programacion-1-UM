<?php

//para obtener el tiempo de ejecucion
$time1 = microtime(true);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//librerias del jwt
include_once './config/core.php';
include_once './php-jwt/src/BeforeValidException.php';
include_once './php-jwt/src/ExpiredException.php';
include_once './php-jwt/src/SignatureInvalidException.php';
include_once './php-jwt/src/JWT.php';
use \Firebase\JWT\JWT;

//incluye las clases necesarias
include_once './config/database.php'; 
include_once './objects/auditoria.php';
include_once './objects/sistema.php';

//conexiones
$database = new Database();
$dbauditoria = $database->getConnection();
$db = $database->getConnection();

//crear objetos
$auditoria= new Auditoria($dbauditoria);
$sistema = new Sistema($db);

//decodificar json y obtener el token
$data = json_decode(file_get_contents("php://input"));
$jwt=isset($data->jwt) ? $data->jwt : "";

//si se envio token se trata de decodificar, si lo logra sigue en el try, si no salta al catch
if($jwt){

    try {
        //intenta decodificar
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        //obtener datos del jwt
        $aux= get_object_vars($decoded);
        $usu= get_object_vars($aux[data]);        
        $usuario= $usu['nombre']." ".$usu['apellido'];

        switch ($_SERVER['REQUEST_METHOD']){
            
            case "GET":
                
                $stmt = $sistema->read();
                $num = $stmt->rowCount();
                if($num>0){

                    $sistema_arr=array();
                    $sistema_arr["records"]=array();
        
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row); 
                        $sistema_item=array(
                            "sistema_id" => $sistema_id,
                            "nombre" => $nombre,
                            "pais_procedencia" => $pais_procedencia,
                            "created" => $created,
                            "updated" => $updated,
                        );
        
                        array_push($sistema_arr["records"], $sistema_item);
                    }
        
                    //agrega una entrada a la tabla de auditoria cuando todo está correcto
                    $time2= round(((microtime(true) - $time1)*1000), 2);
                    $auditoria->response_time= $time2;            
                    $auditoria->usuario= $usuario;
                    $auditoria->created = date('Y-m-d H:i:s');
                    //endpoint hay que cambiarlo para cada funcion seria el url de la pagina
                    $auditoria->endpoint= "localhost/prog1final/sistema/read.php";
                    //agregar auditoria
                    $auditoria->create();
        
                    http_response_code(200);
                    echo json_encode($sistema_arr);
                }
        
                else{
        
                    http_response_code(404);
                    echo json_encode(
                        array("message" => "No se encontraron sistemas.")
                    );
                }
            break;
        
        }
    }catch (Exception $e){
        http_response_code(401);
        echo json_encode(array(
            "message" => "Token invalido.",
            "error" => $e->getMessage()
            ));
    }
}
?>