<?php
include("conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Alumnos</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container">
        <p><a href="index.php">← Volver al Menú Principal</a></p>
        <div style="background-color: #e8f4f8; border-left: 4px solid #2980b9; padding: 12px 15px; margin-bottom: 20px; border-radius: 4px;">
            <p style="margin: 0; color: #2c3e50; font-size: 14px;">
                <strong>¿Ya estás registrado?</strong> Si ya creaste tu cuenta anteriormente, podés 
                <a href="login_alumno.php" style="color: #2980b9; font-weight: bold; text-decoration: underline;">Iniciar Sesión acá</a>.
            </p>
        </div>
        <h2>Registrar Nuevo Alumno</h2>
        <?php if (isset($_GET['exito'])) { ?>
            <p style='color: green; font-weight: bold;'>¡Alumno guardado con éxito! Ya podés <a href="login_alumno.php">iniciar sesión</a>.</p>
        <?php } ?>
        <?php if (isset($_GET['error']) && $_GET['error'] == 'dni_repetido') { ?>
            <p style='color: red; font-weight: bold;'>¡Error! El DNI ingresado ya pertenece a un alumno registrado.</p>
        <?php } ?>

        <form action="guardar.php" method="POST">
            <div>
                <label>Nombre:</label>
                <input type="text" name="nombre" required>
            </div>
            <div>
                <label>Apellido:</label>
                <input type="text" name="apellido" required>
            </div>
            <div>
                <label>DNI:</label>
                <input type="text" name="dni" required>
            </div>
            <div>
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>
            <div>
                <label>Contraseña:</label>
                <input type="password" name="clave" required placeholder="Crea tu contraseña">
            </div>
            <button type="submit" name="guardar">Guardar Alumno</button>
        </form>
    </div>
</body>
</html>