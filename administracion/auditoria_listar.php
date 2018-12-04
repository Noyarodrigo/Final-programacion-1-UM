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
<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 row justify-content-center align-items-center">
                <span class="login100-form-title">
                   Auditoria
                </span>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nombre y Apellido</th>
                            <th scope="col">Tpo Respuesta</th>
                            <th scope="col">Endpoint</th>
                            <th scope="col">Created</th>
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

                        $fi=isset($_POST["fi"]) ? $_POST["fi"] : "";
                        $ff=isset($_POST["ff"]) ? $_POST["ff"] : "";

                        if ( $fi!="" && $ff!="") {
                            
                            $sql="select * from auditoria where created between \"$fi\" and \"$ff\"";
                            
                        }else{

                            $sql="select * from auditoria ";

                        }

                        $ejecucionSQLPDO=$conexionPDO->prepare($sql);
                        $ejecucionSQLPDO->execute();

                        $path="registro.txt";
                        $archivo=fopen($path,'w');
                        $i=0;

                        while($filaPDO=$ejecucionSQLPDO->fetch(PDO::FETCH_ASSOC)){
                            echo "<tr>";
                            foreach ($filaPDO as $campoPDO){
                                echo "<td>$campoPDO</td>";
                                $array[$i][]=$campoPDO;
                            }
                            $texto = $array[$i][0].",".$array[$i][1].",".$array[$i][2].",".$array[$i][3].",".$array[$i][4]."\n";
                            fwrite($archivo,$texto);    
                            echo "</tr>";
                            $i++;
                        }

                        fclose($archivo);
                        ?>
                    </tbody>
                </table>
				
                <form action="auditoria_descargar.php" class="login100-form validate-form" method="post">
                    <div class="container-login100-form-btn">
                            <button class="login100-form-btn">
                                Descargar
                            </button>
                    </div>
            </div>
        </div>
    </div>
</body>
</html>