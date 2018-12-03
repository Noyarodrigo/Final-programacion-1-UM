<pre>
<?php
    if ($_GET[id]="") {
      echo "<h3>ERROR</h3>";
      echo "<br><h4><a href='ejercicio4.php'>VOLVER</a> </h4>";
      die();
    }

  $usuario="root";
  $clave="1234";
  $bd="programacion1";
  $servidor="localhost";
  $conexionPDO= new PDO("mysql:host=$servidor;dbname=$bd;charset=UTF8","$usuario","$clave");

  $sql="select * from persona where id = :id";
  $ejecucionSQL= $conexionPDO->prepare($sql);
  $ejecucionSQL->bindValue(':id',$_GET['ide']);
  $ejecucionSQL ->execute();

  $filaPDO=$ejecucionSQL->fetch(PDO::FETCH_ASSOC);

  echo "<h3>INGRESE LOS NUEVOS DATOS</h3>\n";
  echo "<h4>o déjelos como están para no modificarlos<h4>";
  echo "<form action=\"edituser-2.php\" method=\"post\">\n";
  echo "<label for=\"nombre\">Nombre    </label>";
  echo  "<input type='text' name='nombre' value='{$filaPDO[nombre]}'>\n";
  echo  "<label for=\"apellido\">Apellido  </label>";
  echo  "<input type='text' name='apellido' value='{$filaPDO[apellido]}'>\n";
  echo  "<label for=\"documento\">Documento </label>";
  echo  "<input type='text' name='documento' value='{$filaPDO[documento]}'>\n";
  echo  "<label for=\"edad\">Edad      </label>";
  echo  "<input type='text' name='edad' value='{$filaPDO[edad]}'>\n";
  echo "<input type=\"hidden\" name=\"ide\" value='{$filaPDO[id]}'>";
  echo  "\n\n<input type='submit' value='Modificar'>";
  echo  "</form>";
?>
</pre>
