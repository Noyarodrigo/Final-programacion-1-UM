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

  $sql="update usuarios SET nombre = :nombre, apellido = :apellido, clave = :clave WHERE usuario_id = :ide ";
  $ejecucionSQL= $conexionPDO->prepare($sql);
  $ejecucionSQL->bindValue(':ide',$_POST['ide']);
  $ejecucionSQL->bindValue(':nombre',$_POST['nom']);
  $ejecucionSQL->bindValue(':apellido',$_POST['ape']);
  $ejecucionSQL->bindValue(':clave',$_POST['cla']);
  $ejecucionSQL ->execute($params);
  header("location: http://localhost/prog1final/administracion/panel_admin.php");		

?>