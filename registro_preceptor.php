<?php
include("conexion.php");

$mensaje = "";
$tipo_alerta = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $turno = trim($_POST['turno']);
    $email = trim($_POST['email']);

    if (!empty($nombre) && !empty($apellido) && !empty($turno) && !empty($email)) {
        $sql = "INSERT INTO preceptores (nombre, apellido, turno, email) VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssss", $nombre, $apellido, $turno, $email);

        if ($stmt->execute()) {
            $mensaje = "¡Preceptor/a registrado/a exitosamente!";
            $tipo_alerta = "#2a9d8f";
        } else {
            $mensaje = "Error al registrar: " . $conexion->error;
            $tipo_alerta = "#e63946";
        }
        $stmt->close();
    } else {
        $mensaje = "Por favor, completa todos los campos obligatorios.";
        $tipo_alerta = "#e63946";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Preceptores - Sistema Académico</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body { 
            background-color: #f4f6f9; 
            color: #333; 
        }
        .navbar { 
            background-color: #2b4c7e; 
            color: white; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            padding: 15px 50px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.15); 
        }
        .navbar .logo { 
            font-size: 20px; 
            font-weight: bold; 
            display: flex; 
            align-items: center; 
            gap: 10px; 
        }
        .navbar ul { 
            list-style: none; 
            display: flex; 
            gap: 20px; 
            align-items: center; 
        }
        .navbar ul li a { 
            color: white; 
            text-decoration: none; 
            font-size: 14px; 
            font-weight: 500; 
            transition: color 0.3s; 
        }
        .navbar ul li a:hover { color: #ffd166; }
        
        .container { 
            max-width: 650px; 
            margin: 40px auto; 
            padding: 0 20px; 
        }
        .header-section { 
            margin-bottom: 20px; 
            border-bottom: 3px solid #f77f00; 
            display: inline-block; 
            padding-bottom: 5px; 
        }
        .header-section h2 { 
            color: #1d3557; 
            font-size: 24px; 
            margin: 0; 
        }
        
        .form-card {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .form-group {
            margin-bottom: 18px;
        }
        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
            color: #1d3557;
            font-size: 14px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            outline: none;
        }
        .form-group input:focus, .form-group select:focus {
            border-color: #2b4c7e;
        }
        .btn-enviar {
            background: #f77f00;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            font-size: 15px;
            width: 100%;
            transition: background 0.3s;
            margin-top: 10px;
        }
        .btn-enviar:hover { background: #d66d00; }
        
        .alerta {
            padding: 12px;
            border-radius: 4px;
            color: white;
            margin-bottom: 20px;
            font-weight: 500;
            text-align: center;
        }
        .btn-volver { 
            display: inline-block; 
            margin-bottom: 15px; 
            color: #2b4c7e; 
            text-decoration: none; 
            font-weight: bold; 
            font-size: 14px;
        }
        .btn-volver:hover { text-decoration: underline; }
        
        footer { 
            background-color: #1d3557; 
            color: white; 
            text-align: center; 
            padding: 20px; 
            margin-top: 50px; 
            font-size: 14px; 
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            🏫 <span>Sistema Académico N°222</span>
        </div>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="cursos.php">Cursos</a></li>
            <li><a href="registro_alumno.php" style="background-color: #f77f00; padding: 6px 12px; border-radius: 4px; color: white;">Soy Alumno</a></li>
            <li><a href="login_profesor.php" style="background-color: #0077b6; padding: 6px 12px; border-radius: 4px; color: white;">Soy Profesor</a></li>
        </ul>
    </nav>
    <div class="container">
        <a href="index.php" class="btn-volver">← Volver al Inicio</a>
        
        <div class="header-section">
            <h2>📋 Registro de Nuevos Preceptores</h2>
        </div>
        <p style="color: #666; margin-bottom: 25px; font-size: 14px;">Completa el formulario para registrar un preceptor y asignarle su turno.</p>

        <?php if (!empty($mensaje)): ?>
            <div class="alerta" style="background-color: <?php echo $tipo_alerta; ?>;">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <div class="form-card">
            <form method="POST" action="registro_preceptor.php">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required placeholder="Ej. Carla">
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido:</label>
                    <input type="text" id="apellido" name="apellido" required placeholder="Ej. Gómez">
                </div>
                <div class="form-group">
                    <label for="turno">Turno:</label>
                    <select id="turno" name="turno" required>
                        <option value="">Selecciona un turno...</option>
                        <option value="Mañana">Mañana</option>
                        <option value="Tarde">Tarde</option>
                        <option value="Vespertino">Vespertino</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" id="email" name="email" required placeholder="Ej. carla.gomez@escuela.edu.ar">
                </div>
                <button type="submit" class="btn-enviar">Registrar Preceptor</button>
            </form>
        </div>
    </div>
    <footer>
        <p>Sistema Escolar. Elaborado desde taller práctico. Gracias por leer</p>
    </footer>

</body>
</html>