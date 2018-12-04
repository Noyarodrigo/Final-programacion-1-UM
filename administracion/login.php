
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  </head>
<body>
<div class="container" style="background-color:#9fd5d1; " >  <h1 class="text-center" >INICIO DE SESIÓN</h1></div>
<div class="container " style="background-color:#9fd5d1; ">
  <form action="logincheck.php" method="post">
    <div class="form-group ">
    <label for="nombre">Nombre </label>
    <input type="text" name="nombre" class="form-control" placeholder="Ingrese nombre">
     </div>
     <div class="form-group">
    <label for="apellido">Apellido </label>
    <input type="text" name="apellido" class="form-control" placeholder="Ingrese apellido">
     </div>
    <div class="form-group">
      <label for="password">Contraseña:</label>
      <input type="password" class="form-control" name="password" placeholder="Ingrese contraseña">
    </div>
    <button type="submit" class="btn btn-default">Ingresar</button>
  </form>
</div>

</body> 
</html>
