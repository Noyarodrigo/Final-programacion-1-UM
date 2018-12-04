<!DOCTYPE html>
<html lang="en">
<head>
	<title>Auditoria</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="login/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="login/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/css/util.css">
	<link rel="stylesheet" type="text/css" href="login/css/main.css">
<!--===============================================================================================-->
</head>
<body>
<?php
if (session_start()) {
    if ($_SESSION[habilitado]!=1 && $_SESSION[rol]!="admin") {
      //a la casa a loguearse
      header("location: http://localhost/prog1final/administracion/login.php");
      die();
    }
  }
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Panel de Usuarios</title>
</head>
<body>
  <!--usuario-->
  <h2>Usuarios</h2>
  <div>
    <a href="list_usu.php" class="btn btn-success">Listar</a>
    <a href="search_usu.php" class="btn btn-success">Buscar</a>
    <a href="edit_usu.php" class="btn btn-success">Editar</a>
    <a href="add_usu.php" class="btn btn-success">Agregar</a>
    <a href="del_usu.php" class="btn btn-success">Eliminar</a>
    <a href="logout.php" class="btn btn-success">Cerrar sesion</a>
  </div>
  <!--Auditoria-->
  <div>
    <h2>Auditoria</h2>
    <a href="auditoria_form.php" class="btn btn-success">Ver Auditoria</a>
  </div>
</body>
</html>
