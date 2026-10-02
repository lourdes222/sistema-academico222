<?php
include("conexion.php");

$error = "";
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $clave = $_POST['clave'];
    $consulta = $conexion->query("SELECT * FROM profesores WHERE email = '$email' AND clave = '$clave'");
    if ($consulta && $consulta->num_rows > 0) {
        $profesor = $consulta->fetch_assoc();
        header("Location: panel_profesor.php?id_profesor=" . $profesor['id_profesor']);
        exit();
    } else {
        $error = "Credenciales incorrectas o el profesor no está registrado.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Portal Docente - Acceso Seguro</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .container { max-width: 450px; margin: 60px auto; background: white; padding: 35px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        h2 { color: #0077b6; margin-bottom: 20px; text-align: center; }
        input { width: 100%; padding: 12px; margin: 10px 0 20px 0; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        button { width: 100%; background: #0077b6; color: white; padding: 12px; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; font-size: 15px; }
        button:hover { background: #005f87; }
        .aviso-nuevo { background: #e8f4f8; border-left: 4px solid #0077b6; padding: 12px; font-size: 13px; color: #333; margin-top: 25px; border-radius: 4px; }
        .aviso-nuevo a { color: #0077b6; font-weight: bold; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <p><a href="index.php" style="color: #666; text-decoration: none;">← Volver al Inicio</a></p>
        <h2>👨‍🏫 Portal Docente</h2>
        <?php if($error) echo "<p style='color:red; text-align:center; font-size:14px;'>$error</p>"; ?>
        <form method="POST" action="">
            <label>Email Institucional:</label>
            <input type="email" name="email" required placeholder="profesor@colegio.com">
            <label>Contraseña:</label>
            <input type="password" name="clave" required placeholder="********">
            <button type="submit" name="login">Ingresar al Panel</button>
        </form>
        <div class="aviso-nuevo">
            <p><strong>¿Sos docente nuevo y no estás registrado?</strong></p>
            <p>El alta de nuevos profesores requiere validación institucional mediante contrato y secretaría. Podés solicitar el alta administrativa acá: <a href="registro_profesor.php">Ir a Alta de Profesores</a>.</p>
        </div>
    </div>
</body>
</html>