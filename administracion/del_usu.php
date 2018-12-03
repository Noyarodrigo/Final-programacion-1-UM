<?php
$usuario="root";
$clave="1234";
$bd="transporte";
$servidor="localhost";
$conexionPDO= new PDO("mysql:host=$servidor;dbname=$bd;charset=UTF8","$usuario","$clave");

$sql="select usuario_id, nombre, apellido, tipo, created, updated from usuarios";

echo "<div> Usuarios </div>";
$ejecucionSQLPDO=$conexionPDO->prepare($sql);
$ejecucionSQLPDO->execute();
echo "<table border='1'>";
echo"<tr> <td>ID</td> <td>Nombre</td> <td>Apellido</td> <td>Tipo</td> <td>Created</td> <td>Updated</td> <td>Borrar</td> </tr>";
 
while($filaPDO=$ejecucionSQLPDO->fetch(PDO::FETCH_ASSOC)){
    echo "<tr>";
    foreach ($filaPDO as $campoPDO){
        echo "<td>$campoPDO</td>";
    }
    echo " <td align='center'><a href='del_usu2.php?ide={$filaPDO['usuario_id']}'>X</a></td>";
    echo "</tr>";
}
echo "</table> ";

?>
