<?php
include("conexion.php");
session_start();
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $clave = $_POST['clave'];
    $sql = "SELECT * FROM directivos WHERE email = '$email' AND clave = '$clave'";
    $resultado = $conexion->query($sql);
    if ($resultado->num_rows == 1) {
        $row = $resultado->fetch_assoc();
        $_SESSION['directivo'] = $row['email'];
        header("Location: panel_directivo.php");
        exit();
    } else {
        $error = "Credenciales incorrectas. Verifique sus datos.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inicie sesión como Personal.</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        body{
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-card{
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            border-top: 5px solid #1d3557;
        }
        h2{
            color: #1d3557;
            margin-top: 0;
            text-align: center;
        }
        .form-group{
            margin-bottom: 20px;
        }
        label{
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
        }
        input{
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button{
            width: 100%;
            background: #1d3557;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px; 
            font-weight: bold;
            cursor: pointer;
        }
        button:hover{
            background: #14213d;
        }
        .error{
            color: #d90429;
            background: #ffe3e6;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 14px;
            text-align: center;
        }
        .btn-volver{
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #666;
            text-decoration: none;
            font-size: 14px;
        }
        .btn-volver:hover{
            text-decoration: underline;
        }
        </style>
</head>
<body>
    <div class="login-card">
        <h2>🏛️ Portal Directivo</h2>
        <p style="text-align: center; color: #666; font-size: 14px; margin-bottom: 25px;">Acceso exclusivo para autoridades y personal</p> 
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="login_directivo.php" method="POST">
            <div class="form-group">
                <label>Correo Electrónico:</label>
                <input type="email" name="email" required placeholder="correo@institucion.edu.ar">
            </div>
            <div class="form-group">
                <label>Contraseña:</label>
                <input type="password" name="clave" required placeholder="Tu contraseña">
            </div>
            <button type="submit">Ingresar al Panel</button>
        </form>
        <a href="index.php" class="btn-volver">← Volver al Inicio</a>
    </div>
</body>
</html>
</body>
</html>