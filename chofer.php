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
include_once './objects/chofer.php';

//conexiones
$database = new Database();
$dbauditoria = $database->getConnection();
$db = $database->getConnection();

//crear objetos
$auditoria= new Auditoria($dbauditoria);
$chofer = new Chofer($db);

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

            case "POST":

                $chofer->nombre = $data->nombre;
                $chofer->apellido = $data->apellido;
                $chofer->documento = $data->documento;
                $chofer->email = $data->email;
                $chofer->sistema_id = $data->sistema_id;
                $chofer->vehiculo_id = $data->vehiculo_id;
                $chofer->created = date('Y-m-d H:i:s');
                $chofer->updated = date('Y-m-d H:i:s');
            
                if(
                    !empty($data->nombre) &&
                    !empty($data->apellido) &&
                    !empty($data->documento) &&
                    !empty($data->email) &&
                    !empty($data->sistema_id) &&
                    !empty($data->vehiculo_id)
                ){
                    
                    if($chofer->create()){
                    
                        $time2= round(((microtime(true) - $time1)*1000), 2);
                        $auditoria->response_time= $time2;            
                        $auditoria->usuario= $usuario;
                        $auditoria->created = date('Y-m-d H:i:s');
                        //endpoint hay que cambiarlo para cada funcion seria el url de la pagina
                        $auditoria->endpoint= "localhost/prog1final/chofer/create.php";
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
                //FALTAN DATOS 
                else{
                    
                    http_response_code(400);
                    echo json_encode(array("message" => "No se pudo agregar, faltan datos."));
                }
                break;
                
            case "GET":

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
                break;
                
            
            case "DELETE":

                $chofer->chofer_id = $data->chofer_id;
                if($chofer->delete()){
                    //agrega una entrada a la tabla de auditoria cuando todo está correcto
                    $time2= round(((microtime(true) - $time1)*1000), 2);
                    $auditoria->response_time= $time2;            
                    $auditoria->usuario= $usuario;
                    $auditoria->created = date('Y-m-d H:i:s');
                    //endpoint hay que cambiarlo para cada funcion seria el url de la pagina
                    $auditoria->endpoint= "localhost/prog1final/chofer/delete.php";
                    //agregar auditoria
                    $auditoria->create();
                
                    http_response_code(200);
                    echo json_encode(array("message" => "Chofer eliminado."));
                }      
                else{
                
                    http_response_code(503);
                    echo json_encode(array("message" => "Error al eliminar al chofer."));
                }
                break;

            case "PUT":
                
                $chofer->chofer_id = $data->chofer_id;
                $chofer->nombre = $data->nombre;
                $chofer->apellido = $data->apellido;
                $chofer->documento = $data->documento;
                $chofer->email = $data->email;
                $chofer->sistema_id = $data->sistema_id;
                $chofer->vehiculo_id = $data->vehiculo_id;
                $chofer->updated = date('Y-m-d H:i:s');
        
                if($chofer->update()){
        
                    $auditoria->usuario= $usuario;
                    $auditoria->created = date('Y-m-d H:i:s');
                    //endpoint hay que cambiarlo para cada funcion seria el url de la pagina
                    $auditoria->endpoint= "localhost/prog1final/chofer/update.php";
                    $time2= round(((microtime(true) - $time1)*1000), 2);
                    $auditoria->response_time= $time2;            
                    //agregar auditoria
                    $auditoria->create();
        
                    http_response_code(200);
                    echo json_encode(array("message" => "chofer modificado Correctamente."));
                }
                
                else{
                    http_response_code(503);
                    echo json_encode(array("message" => "No se pudo modificar al chofer."));
                }
                break;

            case "PROPFIND":
                
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
                    
                    $time2= round(((microtime(true) - $time1)*1000), 2);
                    $auditoria->response_time= $time2;            
                    $auditoria->usuario= $usuario;
                    $auditoria->created = date('Y-m-d H:i:s');
                    //endpoint hay que cambiarlo para cada funcion seria el url de la pagina
                    $auditoria->endpoint= "localhost/prog1final/chofer/search.php";
                    //agregar auditoria
                    $auditoria->create();
        
                    http_response_code(200);
                    echo json_encode($chofer_arr);
                }
        
                else{
        
                    http_response_code(404);
                    echo json_encode(
                        array("message" => "No se encontró ningún chofer.")
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
