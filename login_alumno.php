<?php
include("conexion.php");

$error = "";
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $clave = $_POST['clave'];
    $consulta = $conexion->query("SELECT * FROM alumnos WHERE email = '$email' AND clave = '$clave'");
    if ($consulta && $consulta->num_rows > 0) {
        $alumno = $consulta->fetch_assoc();
        header("Location: panel_alumno.php?id_alumno=" . $alumno['id_alumno']);
        exit();
    } else {
        $error = "Email o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso de Alumnos - Sistema Escolar</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        body { 
            background-color: #f4f6f9; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
        }
        .container { 
            max-width: 450px; 
            margin: 60px auto; 
            background: white; 
            padding: 35px; 
            border-radius: 10px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.1); 
        }
        h2 { 
            color: #f77f00; 
            margin-bottom: 20px; 
            text-align: center; 
        }
        input { 
            width: 100%; 
            padding: 12px; 
            margin: 10px 0 20px 0; 
            border: 1px solid #ccc; 
            border-radius: 5px; 
            box-sizing: border-box; 
        }
        button { 
            width: 100%; 
            background: #f77f00; 
            color: white; 
            padding: 12px; 
            border: none; 
            border-radius: 5px; 
            font-weight: bold; 
            cursor: pointer; 
            font-size: 15px; 
        }
        button:hover { 
            background: #e67e22; 
        }
        .aviso-registro { 
            background: #fff8e7; 
            border-left: 4px solid #f77f00; 
            padding: 12px; 
            font-size: 13px; 
            color: #333; 
            margin-top: 25px; 
            border-radius: 4px; 
        }
        .aviso-registro a { 
            color: #f77f00; 
            font-weight: bold; 
            text-decoration: none; 
        }
    </style>
</head>
<body>
    <div class="container">
        <p><a href="index.php" style="color: #666; text-decoration: none;">← Volver al Inicio</a></p>
        <h2>👨‍🎓 Acceso de Alumnos</h2>
        <?php if($error) echo "<p style='color:red; text-align:center; margin-bottom:10px;'>$error</p>"; ?>
        <form method="POST" action="">
            <label>Correo Electrónico:</label>
            <input type="email" name="email" required placeholder="tu_correo@gmail.com">
            <label>Contraseña:</label>
            <input type="password" name="clave" required placeholder="********">
            <button type="submit" name="login">Ingresar a mi Panel</button>
        </form>
        <div class="aviso-registro">
            <p><strong>¿Sos alumno nuevo y no tenés cuenta?</strong></p>
            <p>Registrate con tus datos para poder anotarte a las materias: <a href="registro_alumno.php">Crear cuenta acá</a>.</p>
        </div>
    </div>
</body>
</html>