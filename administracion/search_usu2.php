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
 
 $sql=" select usuario_id, nombre, apellido, tipo, created, updated from usuarios
        WHERE
            nombre LIKE :nom OR apellido LIKE :ape
        ORDER BY
            created DESC";
        
$ejecucionSQLPDO=$conexionPDO->prepare($sql);
$ejecucionSQLPDO->bindValue(':nom',$_POST['buscar']);
$ejecucionSQLPDO->bindValue(':ape',$_POST['buscar']);
$ejecucionSQLPDO->execute();

echo "<div> Usuarios </div>";
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