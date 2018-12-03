<html>
<head> <title>REGISTRO</title></head>
<body>
<form onsubmit="return validate()" action="auditoria_listar.php" method="post">
    <div>Fecha Inicial</div>
    <div> <input type="text" name="fi" id="fi"></div>
    <div>Fecha Final</div>
    <div> <input type="text" name="ff" id="ff"></div>
    <input type="submit" value="Listar" >
</form>
<script>
    function validate() {
        var n1=document.getElementById('fi');
        var n2=document.getElementById('ff');
        if(n1.value !='' && n2.value !=''){ return true;}
        alert("No puedes dejar cuadros vacios");
        return false;
    }
</script>
</body>
</html>