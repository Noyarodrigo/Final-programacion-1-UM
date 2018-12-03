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

$fi=isset($_POST["fi"]) ? $_POST["fi"] : "";
$ff=isset($_POST["ff"]) ? $_POST["ff"] : "";

if ( $fi!="" && $ff!="") {
    
    $sql="select * from auditoria where created between \"$fi\" and \"$ff\"";
    
}else{

    $sql="select * from auditoria ";

}

$ejecucionSQLPDO=$conexionPDO->prepare($sql);
$ejecucionSQLPDO->execute();
echo "<div> Auditoria </div>";
echo "<table border='1'>";
echo"<tr> <td>ID</td> <td>Nombre y Apellido</td><td>Tpo de respuesta</td> <td>Endpoint</td> <td>Created</td> </tr>";
 
while($filaPDO=$ejecucionSQLPDO->fetch(PDO::FETCH_ASSOC)){
    echo "<tr>";
    foreach ($filaPDO as $campoPDO){
        echo "<td>$campoPDO</td>";
    }
    echo "</tr>";
}
echo "</table> ";

?>