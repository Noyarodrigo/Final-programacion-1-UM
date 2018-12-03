<html>
<head> <title>REGISTRO</title></head>
<body>
<form onsubmit="return validate()" action="add_usu2.php" method="post">
    <div>Nombre</div>
    <div> <input type="text" name="usu" id="us"></div>
    <div>Apellido</div>
    <div> <input type="text" name="ape" id="ap"></div>
    <div>Clave</div>
    <div> <input type="password" name="cla" id="cl"></div>

    <input type="submit" value="Agregar" >
</form>
<script>
    function validate() {
        var n1=document.getElementById('us');
        var n2=document.getElementById('cl');
        var n3=document.getElementById('ap');
        if(n1.value !='' && n2.value !=''&& n3.value !=''){ return true;}
        alert("No puedes dejar cuadros vacios");
        return false;
    }
</script>
</body>
</html>
