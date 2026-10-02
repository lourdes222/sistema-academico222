<?php
session_start();
if (!isset($_SESSION['directivo'])) {
    header("Location: login_directivo.php");
    exit();
}
include("conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Gestión Directiva</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .container { max-width: 900px; margin: 40px auto; padding: 0 20px; }
        .header-panel { background: #1d3557; color: white; padding: 25px; border-radius: 8px; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; }
        .grid-opciones { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
        .card { background: white; border-radius: 8px; padding: 25px; text-decoration: none; color: #333; box-shadow: 0 4px 10px rgba(0,0,0,0.05); transition: transform 0.2s; border-top: 4px solid #1d3557; display: block; }
        .card:hover { transform: translateY(-5px); }
        .card h3 { color: #1d3557; margin-bottom: 10px; margin-top: 0; }
        .card p { margin: 0; color: #666; font-size: 14px; }
        .btn-salir { color: #ffd166; text-decoration: none; font-weight: bold; }
        h2 { margin: 0; color: #fff; font-size: 22px; }
    </style>
</head>
<body>
    <div class="container">
 <div class="header-panel">
    <div>
        <h2>🏛️ Panel de Equipo Directivo y Personal</h2>
        <p style="margin: 5px 0 0 0; color: #a5a0b4;">Gestión institucional del establecimiento</p>
    </div>
    <div>
        <a href="index.php" class="btn-salir" style="margin-right: 15px;">← Volver al Inicio</a>
    </div>
</div>
        <div class="grid-opciones">
            <a href="crear_comunicado.php" class="card">
                <h3>📢 Publicar Comunicado</h3>
                <p>Emitir avisos institucionales, fechas de exámenes o novedades en la portada.</p>
            </a>
            <a href="registro_profesor.php" class="card">
                <h3>👨‍🏫 Alta de Profesores</h3>
                <p>Registrar nuevos docentes en la base de datos del colegio.</p> 
            </a>
            <a href="registro_preceptor.php" class="card">
                <h3>📋 Registro de Preceptores</h3>
                <p>Registrar nuevos preceptores y asignar turnos.</p>
            </a>
            <a href="cursos.php" class="card">
                <h3>📚 Gestión de Cursos</h3>
                <p>Administrar materias, horarios y asignación de profesores.</p>
            </a>
            <a href="crear_curso.php" class="card">
                <h3>➕ Crear Nuevo Curso</h3>
                <p>Dar de alta materias y asignarles profesor a cargo y cupos.</p>
            </a>
        </div>
    </div>
</body>
</html>