<?php
    if (session_start()) {
		session_destroy();
		header("location: http://localhost/prog1final/administracion/login/index.html");		
    }
?>
