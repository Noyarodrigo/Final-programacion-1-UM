<?php
if (session_start()) {
    if ($_SESSION[habilitado]!=1 && $_SESSION[rol]!="admin") {
      //a la casa a loguearse
      header("location: http://localhost/prog1final/administracion/login/index.html");
      die();
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Panel Adm</title>
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
<div class="limiter">
    <span >
      <button class="login100-form-btn" onclick = "location='logout.php'">
        Cerrar sesion
      </button>
    </span>
		<div class="container-login100">
			<div class="wrap-login100 row justify-content-center align-items-center">
					<span class="login100-form-title">
            USUARIO
					</span>
          <div class="container-login100-form-btn">
          <span >
            <button class="login100-form-btn" onclick = "location='list_usu.php'">
							Listar
						</button>
					</span>
          <span >
            <button class="login100-form-btn " onclick = "location='search_usu.php'">
							Buscar
						</button>
					</span>
          <span>
            <button class="login100-form-btn"onclick = "location='edit_usu.php'">
							Editar
						</button>
					</span>
          <span>
            <button class="login100-form-btn" onclick = "location='add_usu.php'">
							Agregar
						</button>
					</span>
          <span>
            <button class="login100-form-btn" onclick = "location='del_usu.php'">
							Eliminar
						</button>
					</span>
			<div class="wrap-login100 row justify-content-center align-items-center">
					<span class="login100-form-title" >
            AUDITORIA
					</span>
          <div class="container-login100-form-btn">
          <span >
            <button class="login100-form-btn" onclick = "location='auditoria_form.php'">
							Mostar
						</button>
					</span>
          </div>
        </div>
		</div>
	</div>
	
<!--===============================================================================================-->	
<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>
