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
include_once './objects/vehiculo.php';

//conexiones
$database = new Database();
$dbauditoria = $database->getConnection();
$db = $database->getConnection();

//crear objetos
$auditoria= new Auditoria($dbauditoria);
$vehiculo = new Vehiculo($db);


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
            
            //CREATE
            case "POST":
                if(
                    !empty($data->patente) &&
                    !empty($data->anho_patente) &&
                    !empty($data->anho_fabricacion) &&
                    !empty($data->marca) &&
                    !empty($data->modelo)
                )
                {
                
                    $vehiculo->patente = $data->patente;
                    $vehiculo->anho_patente = $data->anho_patente;
                    $vehiculo->anho_fabricacion = $data->anho_fabricacion;
                    $vehiculo->marca = $data->marca;
                    $vehiculo->modelo = $data->modelo;
                    $vehiculo->created = date('Y-m-d H:i:s');
                    $vehiculo->updated = date('Y-m-d H:i:s');
                    
                    if($vehiculo->create()){
                        $time2= round(((microtime(true) - $time1)*1000), 2);
                        $auditoria->response_time= $time2;            
                        $auditoria->usuario= $usuario;
                        $auditoria->created = date('Y-m-d H:i:s');
                        //endpoint hay que cambiarlo para cada funcion seria el url de la pagina
                        $auditoria->endpoint= "localhost/prog1final/vehiculo/create.php";
                        //agregar auditoria
                        $auditoria->create();
        
                        http_response_code(201);
                        echo json_encode(array("message" => "Agregado correctamente."));
                    }
        
                    else{
                        http_response_code(503); 
                        echo json_encode(array("message" => "No se pudo agregar."));
                    }
                }
                break;
            
            //READ
            case "GET":
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
        
                    $time2= round(((microtime(true) - $time1)*1000), 2);
                    $auditoria->response_time= $time2;            
                    $auditoria->usuario= $usuario;
                    $auditoria->created = date('Y-m-d H:i:s');
                    //endpoint hay que cambiarlo para cada funcion seria el url de la pagina
                    $auditoria->endpoint= "localhost/prog1final/vehiculo/read.php";
                    //agregar auditoria
                    $auditoria->create();
        
                    http_response_code(200);
                    echo json_encode($vehiculo_arr);
                }
                
                else{
                
                    http_response_code(404);
                    echo json_encode(
                        array("message" => "No se encontraron vehiculos.")
                    );
                }
                break;

            //UPDATE
            /*case "PUT":
                $vehiculo->vehiculo_id = $data->vehiculo_id;
                $vehiculo->patente = $data->patente;
                $vehiculo->anho_patente = $data->anho_patente;
                $vehiculo->anho_fabricacion = $data->anho_fabricacion;
                $vehiculo->marca = $data->marca;
                $vehiculo->modelo = $data->modelo;
                $vehiculo->updated = date('Y-m-d H:i:s');
        
                if($vehiculo->update()){
        
                    $time2= round(((microtime(true) - $time1)*1000), 2);
                    $auditoria->response_time= $time2;            
                    $auditoria->usuario= $usuario;
                    $auditoria->created = date('Y-m-d H:i:s');
                    //endpoint hay que cambiarlo para cada funcion seria el url de la pagina
                    $auditoria->endpoint= "localhost/prog1final/vehiculo/update.php";
                    //agregar auditoria
                    $auditoria->create();
        
                    http_response_code(200);
                    echo json_encode(array("message" => "vehiculo modificado Correctamente."));
                }
                
                else{
                    http_response_code(503);
                    echo json_encode(array("message" => "No se pudo modificar al vehiculo."));
                }
                break;/*

            /*case "DELETE":
                if($vehiculo->delete()){
            
                    $time2= round(((microtime(true) - $time1)*1000), 2);
                    $auditoria->response_time= $time2;            
                    $auditoria->usuario= $usuario;
                    $auditoria->created = date('Y-m-d H:i:s');
                    //endpoint hay que cambiarlo para cada funcion seria el url de la pagina
                    $auditoria->endpoint= "localhost/prog1final/vehiculo/delete.php";
                    //agregar auditoria
                    $auditoria->create();
        
                    http_response_code(200);
                    echo json_encode(array("message" => "vehiculo eliminado."));
                }
                
                else{
                
                    http_response_code(503);
                    echo json_encode(array("message" => "Error al eliminar el vehiculo."));
                }
                break;*/
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