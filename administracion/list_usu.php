<?php
//Conecto la base de datos
$usuario="root";
$clave="";
$bd="programacioni";
$servidor="localhost";
$conexionPDO= new PDO('mysql:host=localhost;dbname=programacioni;charset=UTF8','root','');
$sql="select * from persona";
echo "<div> Usuarios </div>";
$ejecucionSQLPDO=$conexionPDO->prepare($sql);
$ejecucionSQLPDO->execute();
echo "<table border='1'>";
while($filaPDO=$ejecucionSQLPDO->fetch(PDO::FETCH_ASSOC)){
    echo "<tr>";
    foreach ($filaPDO as $campoPDO){
        echo "<td>$campoPDO</td>";
    }
    echo "</tr>";
}
echo "</table> ";

