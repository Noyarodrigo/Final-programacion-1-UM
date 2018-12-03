<?php
    if (session_start()) {
        session_destroy();
        echo "<h3>Ha cerrado sesion</h3>";   
        echo "<br><h4><a href='login.php'>VOLVER</a> </h4>";
    }
?>