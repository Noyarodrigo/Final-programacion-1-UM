<!DOCTYPE html>
<html lang="en">
<head>
	<title>Agregar</title>
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
                <span class="login100-form-title">
                   Tabla de Usuarios
                </span>

                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Created</th>
                            <th scope="col">Updated</th>
                        </tr>
                    </thead>
                    <tbody>
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

                        $sql="select usuario_id, nombre, apellido, tipo, created, updated from usuarios";

                        $ejecucionSQLPDO=$conexionPDO->prepare($sql);
                        $ejecucionSQLPDO->execute();
                       
                        while($filaPDO=$ejecucionSQLPDO->fetch(PDO::FETCH_ASSOC)){
                            echo "<tr>";
                            foreach ($filaPDO as $campoPDO){
                                echo "<td>$campoPDO</td>";
                            }
                            echo "</tr>";
                        }

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>