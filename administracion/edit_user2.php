<pre>
<?php
if ($_POST[id]="") {
  echo "<h3>ERROR DE ID</h3>";
  echo "<br><h4><a href='ejercicio4.php'>VOLVER</a> </h4>";
  die();
}
print_r($_POST);

$usuario="root";
$clave="1234";
$bd="programacion1";
$servidor="localhost";
$conexionPDO= new PDO("mysql:host=$servidor;dbname=$bd;charset=UTF8","$usuario","$clave");

$sql="update persona SET nombre = :nombre, apellido = :apellido, documento = :documento, edad = :edad WHERE persona.id = :ide ";
$ejecucionSQL= $conexionPDO->prepare($sql);
//$params=array('nombre' => "{$_POST[nombre]}", 'apellido' => "{$_POST[apellido]}", 'documento' => "{$_POST[documento]}", 'edad' => "{$_POST[edad]}");
$ejecucionSQL->bindValue(':ide',$_POST['ide']);
$ejecucionSQL->bindValue(':nombre',$_POST['nombre']);
$ejecucionSQL->bindValue(':apellido',$_POST['apellido']);
$ejecucionSQL->bindValue(':documento',$_POST['documento']);
$ejecucionSQL->bindValue(':edad',$_POST['edad']);
$ejecucionSQL ->execute($params);
echo "SQL: $sql";


echo "<h3>Modificado correctamente</h3>";
echo "<br><h4><a href='ejercicio5.php'>VOLVER</a> </h4>";

?>
</pre>
