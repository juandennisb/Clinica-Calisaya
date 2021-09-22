<?php session_start();

    if(isset($_SESSION['usuario'])) {
        header('location: index.php');
    }

    
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $correo = $_POST['correo'];
        $nombre = $_POST['nombre'];
        $hora = $_POST['hora'];
        $fecha = $_POST['fecha'];
        
        $error = '';
        
        if (empty($correo) or empty($nombre) or empty($hora) or empty($fecha)){
            
            $error .= '<i>Favor de rellenar todos los campos</i>';
        }else{
            try{
                $conexion = new PDO('mysql:host=localhost;dbname=login', 'root', '');
            }catch(PDOException $prueba_error){
                echo "Error: " . $prueba_error->getMessage();
            }
            
            $statement = $conexion->prepare('SELECT * FROM reservas WHERE nombre = :nombre LIMIT 1');
            $statement->execute(array(':nombre' => $nombre));
            $resultado = $statement->fetch();
            
                        
            if ($resultado != false){
                $error .= '<i style="color: white;">Este usuario ya se registro anteriormente</i>';
            }
            
        }
        
        if ($error == ''){
            $statement = $conexion->prepare('INSERT INTO reservas (id, correo, nombre, hora, fecha) VALUES (null, :correo, :nombre, :hora, :fecha)');
            $statement->execute(array(
                
                ':correo' => $correo,
                ':nombre' => $nombre,
                ':hora' => $hora,
                ':fecha' => $fecha
                
            ));
            
            $error .= '<i style="color: white;">Usuario registrado exitosamente</i>';
        }
    }


    require 'frontend/RegistrarReserva.php';

?>