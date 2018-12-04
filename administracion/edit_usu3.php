
            $usuario="root";
            $clave="1234";
            $bd="programacion1";
            $servidor="localhost";
            $conexionPDO= new PDO("mysql:host=$servidor;dbname=$bd;charset=UTF8","$usuario","$clave");

            $sql="update persona SET nombre = :nombre, apellido = :apellido, documento = :documento, edad = :edad WHERE persona.id = :ide ";
            $ejecucionSQL= $conexionPDO->prepare($sql);
            //$params=array('nombre' => "{$_POST[nombre]}", 'apellido' => "{$_POST[apellido]}", 'documento' => "{$_POST[documento]}", 'edad' => "{$_POST[edad]}");
            $ejecucionSQL->bindValue(':ide',$_POST['ide']);
            $ejecucionSQL->bindValue(':nombre',$_POST['nombre']);
            $ejecucionSQL->bindValue(':apellido',$_POST['apellido']);
            $ejecucionSQL->bindValue(':documento',$_POST['documento']);
            $ejecucionSQL->bindValue(':edad',$_POST['edad']);
            $ejecucionSQL ->execute($params);
            echo "SQL: $sql";
          }
          ?>