<?php
include("conexion.php");
if(!isset($_GET['id_alumno'])){
    header("Location: login_alumno.php");
    exit();
}
$id_alumno = $_GET['id_alumno'];
$consulta_alumno = $conexion->query("SELECT * FROM alumnos WHERE id_alumno = '$id_alumno'");
$alumno = $consulta_alumno->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Panel de Alumno - Sistema Acádemico N°222</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        body{background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;}
        .container{max-width: 700px; margin: 50px auto; background: white; padding: 35px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);}
        .bienvenida{text-align: center; margin-bottom: 30px;}
        .bienvenida h2{color: #f77f00; ,margin-bottom: 5px;}
        .bienvenida p{color: #666; font-size: 15px;}
        .opciones-grid{display:grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;}
        .card-opcion{background:#ffffff; border: 2px solid #e2e8f0; border-radius: 10px; padding: 25px; text-align: center; text-decoration: none; color: #333; transition: all 0.3s ease;}
        .card-opcion:hover{border-color: #f77f00; transform: translateY(-3px); box-shadow: 0 5px 15px rgba(247, 127, 0, 0.15);}
        .card-opcion h3{color: #f77f00; margin-top: 10px; margin-bottom: 8px; font-size:18px;}
        .card-opcion p{font-size: 13px; color: #666; margin: 0px;}
        .icon{font-size: 40px;}
        .logout{text-align:center; margin-top:30px;}
        .logout a{color:#e74c3c; text-decoration: none; font-weight: bold; font-size: 14px;}
        </style>
</head>
<body>
    <div class="container">
        <div class="bienvenida">
            <h2>¡Hola. <?php echo $alumno['nombre'] . '' . $alumno['apellido']; ?>!</h2>
            <p>Bienvenid@ a tu portal de estudiante. ¿Qué querés hacer hoy?</p>
</div>
<div class="opciones-grid">
    <a href="inscribir.php?id=<?php echo $id_alumno; ?>" class="card-opcion">
        <div class="icon">📝</div>
                <h3>Inscribirme a Cursos</h3>
                <p>Ver materias disponibles e inscribirme en las asignaturas de mi interés.</p>
            </a>
            <a href="mis_cursos.php?id_alumno=<?php echo $id_alumno; ?>" class="card-opcion">
                <div class="icon">📚</div>
                <h3>Mis Cursos Inscriptos</h3>
                <p>Consultar la lista de materias en las que ya figurás registrado.</p>
            </a>
        </div>
        <div class="logout">
            <a href="login_alumno.php">← Cerrar Sesión</a>
        </div>
    </div>
</body>
</html>