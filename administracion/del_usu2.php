
<?php
if (session_start()) {
    if ($_SESSION[habilitado]!=1 && $_SESSION[rol]!="admin") {
      //a la casa a loguearse
      header("location: http://localhost/prog1final/administracion/login.php");
      die();
    }
  }
$usuario="root";
$clave="1234";
$bd="transporte";
$servidor="localhost";
$conexionPDO= new PDO("mysql:host=$servidor;dbname=$bd;charset=UTF8","$usuario","$clave");

$sql="delete FROM usuarios WHERE usuarios.usuario_id = :id";
$ejecucionSQL= $conexionPDO->prepare($sql);
$ejecucionSQL->bindValue(':id',$_GET['ide']);
$ejecucionSQL ->execute($params);
header("location: http://localhost/prog1final/administracion/panel_admin.php");

?>
