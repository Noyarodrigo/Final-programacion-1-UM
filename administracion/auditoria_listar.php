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

$path="registro.txt";
$archivo=fopen($path,'w');
$i=0;
while($filaPDO=$ejecucionSQLPDO->fetch(PDO::FETCH_ASSOC)){
    echo "<tr>";
    foreach ($filaPDO as $campoPDO){
        echo "<td>$campoPDO</td>";
        $array[$i][]=$campoPDO;
    }
    $texto = $array[$i][0].",".$array[$i][1].",".$array[$i][2].",".$array[$i][3].",".$array[$i][4]."\n";
    fwrite($archivo,$texto);    
    echo "</tr>";
    $i++;
}
echo "</table> ";
echo "<form action=\"auditoria_descargar.php\" method=\"post\"><br><input type=\"submit\" value=\"Descargar Registro\"></form>";
fclose($archivo);

?>