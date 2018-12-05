<?php  

if (session_start()) {
  if ($_SESSION[habilitado]!=1 && $_SESSION[rol]!="admin") {
    //a la casa a loguearse
    header("location: http://localhost/prog1final/administracion/login/index.html");		
    die();
  }
}

$usuario="root";
$clave="1234";
$bd="transporte";
$servidor="localhost";
$conexionPDO= new PDO("mysql:host=$servidor;dbname=$bd;charset=UTF8","$usuario","$clave");

$sql="select usuario_id, nombre, apellido, clave, tipo, created, updated from usuarios where usuario_id = {$_GET['ide']}";

$ejecucionSQLPDO=$conexionPDO->prepare($sql);
$ejecucionSQLPDO->execute();
$filaPDO=$ejecucionSQLPDO->fetch(PDO::FETCH_ASSOC);

$ide=$_GET['ide'];
$nombre=$filaPDO['nombre'];
$apellido=$filaPDO['apellido'];
$clave=$filaPDO[clave];

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Editar</title>
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
      <div class="container-login100">
        <div class="wrap-login100 row justify-content-center align-items-center">
          <?php
            if ($_GET['ide']="") {
              echo "<span class=\"login100-form-title\">Error, no ha seleccionado un usuario para modificar</span>";
              die();
            }
          ?>
				<form action="edit_usu3.php" class="login100-form validate-form" method="post">
          
          <input type="hidden" name="ide" value="<?php echo $ide; ?>">  
        
          <span class="login100-form-title">
              Modificar Usuario              
          </span>

					<div class="wrap-input100 validate-input" data-validate = "Debe ingresar su nombre">
          <input class="input100" type="text" name="nom" value="<?php echo $nombre;?>">
          <span class="focus-input100"></span>
          <span class="symbol-input100">
            <i class="fa fa-envelope" aria-hidden="true"></i>
          </span>
        </div>

        <div class="wrap-input100 validate-input" data-validate = "Debe ingresar su apellido">
          <input class="input100" type="text" name="ape" value="<?php echo $apellido;?>">
          <span class="focus-input100"></span>
          <span class="symbol-input100">
            <i class="fa fa-envelope" aria-hidden="true"></i>
          </span>
        </div>

        <div class="wrap-input100 validate-input" data-validate = "Ingrese su contraseña">
          <input class="input100" type="text" name="cla" value="<?php echo $clave;?>">
          <span class="focus-input100"></span>
          <span class="symbol-input100">
            <i class="fa fa-lock" aria-hidden="true"></i>
          </span>
        </div>
        
        <div class="container-login100-form-btn">
          <button class="login100-form-btn">
            Modificar
          </button>
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