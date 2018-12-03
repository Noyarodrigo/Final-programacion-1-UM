<html>
<head> <title>BUSCAR</title></head>
<body>
<form onsubmit="return validate()" action="search_usu2.php" method="post">
    <div>Buscar</div>
    <div> <input type="text" name="buscar" id="bus" placeholder="Ingrese el nombre o apellido"></div>

    <input type="submit" value="Buscar" >
</form>
<script>
    function validate() {
        var n1=document.getElementById('bus');
        if(n1.value !=''){ return true;}
        alert("No puedes dejar cuadros vacios");
        return false;
    }
</script>
</body>
</html>