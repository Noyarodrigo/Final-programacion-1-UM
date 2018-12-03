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
    <a href="add_usu.php" class="btn btn-success">Agregar</a>
    <a href="del_usu.php" class="btn btn-success">Eliminar</a>
    <a href="search_usu.php" class="btn btn-success">Buscar</a>
    <a href="list_usu.php" class="btn btn-success">Listar</a>
    <a href="logout.php" class="btn btn-success">Cerrar sesion</a>
  </div>
  <!--Auditoria-->
  <div>
    <h2>Auditoria</h2>
    <a href="auditoria_form.php" class="btn btn-success">Ver Auditoria</a>
  </div>
</body>
</html>
