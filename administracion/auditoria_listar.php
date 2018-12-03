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

$fi=isset($_GET["fi"]) ? $_GET["fi"] : "";
$ff=isset($_GET["ff"]) ? $_GET["ff"] : "";

if (isset($fi) && isset($ff)) {
    
    $sql="select * from auditoria where created between $fi and $ff";
    
}else{
    $sql="select * from auditoria ";
}

echo "<div> Auditoria </div>";
$ejecucionSQLPDO=$conexionPDO->prepare($sql);
$ejecucionSQLPDO->execute();
echo "<table border='1'>";
echo"<tr> <td>ID</td> <td>Nombre</td> <td>Apellido</td> <td>Tipo</td> <td>Created</td> <td>Updated</td> </tr>";
 
while($filaPDO=$ejecucionSQLPDO->fetch(PDO::FETCH_ASSOC)){
    echo "<tr>";
    foreach ($filaPDO as $campoPDO){
        echo "<td>$campoPDO</td>";
    }
    echo "</tr>";
}
echo "</table> ";

?>