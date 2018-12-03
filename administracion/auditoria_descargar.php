<?php
$enlace = "registro.txt";
header ("Content-Disposition: attachment; filename=registro.txt ");
header ("Content-Type: application/octet-stream");
header ("Content-Length: ".filesize($enlace));
readfile($enlace);
?>