<?php
if (session_start()) {
    if ($_SESSION[habilitado]!=1 && $_SESSION[rol]!="admin") {
      //a la casa a loguearse
      header("location: http://localhost/prog1final/administracion/login/index.html");		
      die();
    }
  }
$usuario="root";
$clave="1234";
$bd="transporte";
$servidor="localhost";
$conexionPDO= new PDO("mysql:host=$servidor;dbname=$bd;charset=UTF8","$usuario","$clave");

$sql="insert into usuarios (nombre,apellido,clave,tipo,created) values (:usu,:ape,:cla,:tipo,:created)";

$ejecucionSQL= $conexionPDO->prepare($sql);
$params=array('usu' => $_POST['nom'],'ape' => $_POST['ape'], 'cla' => $_POST['cla'],'tipo' => "usuario", 'created'=> date('Y-m-d H:i:s'));
$ejecucionSQL ->execute($params);
header("location: http://localhost/prog1final/administracion/panel_admin.php");
?>