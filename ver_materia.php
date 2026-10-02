<?php
include("conexion.php");
if (!isset($_GET['id_curso']) || !isset($_GET['id_alumno'])) {
    header("Location: login_alumno.php");
    exit();
}
$id_curso = intval($_GET['id_curso']);
$id_alumno = intval($_GET['id_alumno']);
$sql_check = "SELECT * FROM inscripciones WHERE id_alumno = '$id_alumno' AND id_curso = '$id_curso'";
$res_check = $conexion->query($sql_check);
if ($res_check->num_rows == 0) {
    echo "
    <div style='max-width: 600px; margin: 50px auto; font-family: sans-serif; text-align: center; padding: 30px; background: #fff3f3; border: 1px solid #ffcdd2; border-radius: 8px;'>
        <h2 style='color: #c62828;'>⛔ Acceso Restringido</h2>
        <p>No estás inscripto en esta materia, por lo tanto no tenés permiso para ver sus contenidos.</p>
        <a href='panel_alumno.php?id_alumno=$id_alumno' style='display: inline-block; margin-top: 15px; padding: 10px 20px; background: #2b4c7e; color: white; text-decoration: none; border-radius: 4px;'>Volver a mi panel</a>
    </div>";
    exit();
}
$sql_curso = "SELECT * FROM cursos WHERE id_curso = '$id_curso'";
$res_curso = $conexion->query($sql_curso);
$curso = $res_curso->fetch_assoc();
$nombre_materia = $curso['nombre_materia'];
$sql_materiales = "SELECT * FROM aula_virtual WHERE materia = '$nombre_materia'";
$res_materiales = $conexion->query($sql_materiales);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clase - <?php echo htmlspecialchars($nombre_materia); ?></title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; }
        .container { max-width: 900px; margin: 40px auto; padding: 0 20px; background: white; padding: 35px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .curso-header { background: #2b4c7e; color: white; padding: 25px 30px; border-radius: 8px; margin-bottom: 25px; }
        .curso-header h1 { margin: 0 0 8px 0; font-size: 24px; color: #ffffff; }
        .curso-header p { margin: 0; color: #dcdcdc; font-size: 14px; }
        h2 { color: #2b4c7e; margin-bottom: 20px; font-size: 20px; border-bottom: 2px solid #e2e8f0; padding-bottom: 8px; }
        .material-card { background: #ffffff; border: 1px solid #e2e8f0; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); margin-bottom: 15px; border-left: 5px solid #2a9d8f; }
        .material-card h3 { margin-top: 0; color: #333; }
        .btn-volver { display: inline-block; margin-bottom: 20px; color: #666; text-decoration: none; font-weight: bold; font-size: 14px; }
        .btn-volver:hover { text-decoration: underline; }
        .btn-recurso { background: #2a9d8f; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; font-size: 14px; display: inline-block; margin-top: 10px; font-weight: bold; }
        .btn-recurso:hover { background: #21867a; }
        .sin-contenido { color: #666; font-style: italic; background: #f9f9f9; padding: 25px; text-align: center; border-radius: 8px; border: 1px dashed #cbd5e1; }
    </style>
</head>
<body>
    <div class="container">
        <a href="mis_cursos.php?id_alumno=<?php echo $id_alumno; ?>" class="btn-volver">← Volver a Mis Cursos</a>
        
        <div class="curso-header">
            <h1>📖 <?php echo htmlspecialchars($nombre_materia); ?></h1>
            <p>Espacio de clases y materiales exclusivos para alumnos inscriptos.</p>
        </div>
        <h2>📚 Contenidos Publicados</h2>
        <?php if ($res_materiales && $res_materiales->num_rows > 0): ?>
            <?php while($mat = $res_materiales->fetch_assoc()): ?>
                <div class="material-card">
                    <h3><?php echo htmlspecialchars($mat['titulo']); ?></h3>
                    <p><?php echo nl2br(htmlspecialchars($mat['descripcion'])); ?></p>
                    <small style="color: #888;">Publicado el: <?php echo $mat['fecha_publicacion']; ?></small><br>      
                    <?php if (!empty($mat['enlace_recurso'])): ?>
                        <a href="<?php echo htmlspecialchars($mat['enlace_recurso']); ?>" target="_blank" class="btn-recurso">📥 Ver / Descargar Recurso</a>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="sin-contenido">
                <p style="margin: 0;">Todavía no hay materiales publicados en esta materia.</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>