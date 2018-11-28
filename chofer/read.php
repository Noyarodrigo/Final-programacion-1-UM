<?php
//hora actual en milisegundos
$time1 = microtime(true);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/core.php';
include_once '../php-jwt/src/BeforeValidException.php';
include_once '../php-jwt/src/ExpiredException.php';
include_once '../php-jwt/src/SignatureInvalidException.php';
include_once '../php-jwt/src/JWT.php';
use \Firebase\JWT\JWT;

include_once '../config/database.php';
include_once '../objects/chofer.php';
include_once '../objects/auditoria.php';
 
$database = new Database();
$db = $database->getConnection();
$dbauditoria = $database->getConnection();

$chofer = new Chofer($db);
$auditoria= new Auditoria($dbauditoria);

$data = json_decode(file_get_contents("php://input"));
$jwt=isset($data->jwt) ? $data->jwt : "";

$stmt = $chofer->read();
$num = $stmt->rowCount();

if($jwt){

    try {

        $decoded = JWT::decode($jwt, $key, array('HS256'));
        //obtener usuario y apellido del token de seguridad, concatenarlo y guardarlo para usar en la tabla de auditoria
        $aux= get_object_vars($decoded);
        $usu= get_object_vars($aux[data]);        
        $usuario= $usu['nombre']." ".$usu['apellido'];

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
            //agrega una entrada a la tabla de auditoria cuando todo está correcto
            $time2= round(((microtime(true) - $time1)*1000), 2);
            $auditoria->response_time= $time2;            
            $auditoria->usuario= $usuario;
            $auditoria->created = date('Y-m-d H:i:s');
            //endpoint hay que cambiarlo para cada funcion seria el url de la pagina
            $auditoria->endpoint= "localhost/prog1final/chofer/read.php";
            //agregar auditoria
            $auditoria->create();
            
            //lista los choferes
            http_response_code(200);
            echo json_encode($chofer_arr);
        }
        
        else{
        
            http_response_code(404);
            echo json_encode(
                array("message" => "No se encontraron choferes.")
            );
        }
    }
    catch (Exception $e){

        http_response_code(401);
        echo json_encode(array(
            "message" => "Token invalido.",
            "error" => $e->getMessage()
        ));
        }
    }
?>