<?php
//Conecto la base de datos
$usuario="root";
$clave="";
$bd="programacioni";
$servidor="localhost";
$conexionPDO= new PDO('mysql:host=localhost;dbname=programacioni;charset=UTF8','root','');
$sql="delete FROM persona WHERE persona.id = :id";
$ejecucionSQL= $conexionPDO->prepare($sql);
$ejecucionSQL->bindValue(':id',$_GET['ide']);
$ejecucionSQL ->execute($params);
header("location: http://localhost/TP4/ej4.php");

