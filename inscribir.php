<?php
include("conexion.php");
$id_alumno = isset($_GET['id_alumno']) ? $_GET['id_alumno'] : (isset($_GET['id']) ? $_GET['id'] : null);
if (!$id_alumno) {
    header("Location: login_alumno.php");
    exit();
}
$consulta_alumno = $conexion->query("SELECT * FROM alumnos WHERE id_alumno = '$id_alumno'");
$alumno = $consulta_alumno->fetch_assoc();
$mensaje = "";
if (isset($_POST['inscribir'])) {
    $id_curso = $_POST['id_curso'];
    $verificar = $conexion->query("SELECT * FROM inscripciones WHERE id_alumno = '$id_alumno' AND id_curso = '$id_curso'");
    if ($verificar && $verificar->num_rows > 0) {
        $mensaje = "<p style='color: red; font-weight: bold;'>¡Ya estás inscripto/a en esta materia!</p>";
    } else {
        $query_cupo = $conexion->query("
            SELECT c.cupo, COUNT(i.id_inscripcion) AS total_inscriptos 
            FROM cursos c 
            LEFT JOIN inscripciones i ON c.id_curso = i.id_curso 
            WHERE c.id_curso = '$id_curso'
            GROUP BY c.id_curso
        ");
        $datos_cupo = $query_cupo->fetch_assoc();
        $cupo_max = intval($datos_cupo['cupo']);
        $inscriptos_actuales = intval($datos_cupo['total_inscriptos']);
        if ($inscriptos_actuales >= $cupo_max) {
            $mensaje = "<p style='color: red; font-weight: bold;'>❌ No fue posible inscribirse: Esta materia ya alcanzó el cupo máximo ($inscriptos_actuales / $cupo_max).</p>";
        } else {
            $insertar = $conexion->query("INSERT INTO inscripciones (id_alumno, id_curso) VALUES ('$id_alumno', '$id_curso')");
            if ($insertar) {
                $mensaje = "<p style='color: green; font-weight: bold;'>¡Inscripción realizada con éxito!</p>";
            } else {
                $mensaje = "<p style='color: red;'>Error al procesar la inscripción: " . $conexion->error . "</p>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inscripción a Materias - Portal Alumno</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .container { max-width: 600px; margin: 40px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        h2 { color: #f77f00; margin-bottom: 10px; }
        select, button { width: 100%; padding: 12px; margin-top: 10px; border-radius: 5px; font-size: 15px; }
        select { border: 1px solid #ccc; margin-bottom: 20px; }
        button { background: #f77f00; color: white; border: none; font-weight: bold; cursor: pointer; }
        button:hover { background: #e67e22; }
        .btn-volver { display: inline-block; margin-bottom: 15px; color: #666; text-decoration: none; }
        .btn-volver:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <a href="panel_alumno.php?id_alumno=<?php echo $id_alumno; ?>" class="btn-volver">← Volver a mi Panel</a>
        <h2>📝 Inscribirse a un Curso</h2>
        <p>Alumno: <strong><?php echo htmlspecialchars($alumno['nombre'] . ' ' . $alumno['apellido']); ?></strong></p>
        <?php if($mensaje) echo $mensaje; ?>
        <form method="POST" action="">
            <label for="id_curso">Seleccionar Materia Disponible:</label>
            <select name="id_curso" id="id_curso" required>
                <option value="">Seleccionar</option>
                <?php
                $cursos = $conexion->query("
                    SELECT c.id_curso, c.nombre_materia, c.cupo, COUNT(i.id_inscripcion) AS total_inscriptos 
                    FROM cursos c 
                    LEFT JOIN inscripciones i ON c.id_curso = i.id_curso 
                    GROUP BY c.id_curso
                ");
                while ($c = $cursos->fetch_assoc()) {
                    $cupo_m = intval($c['cupo']);
                    $inscriptos_m = intval($c['total_inscriptos']);
                    if ($inscriptos_m >= $cupo_m) {
                        echo "<option value='" . $c['id_curso'] . "' disabled style='color: red;'>❌ " . htmlspecialchars($c['nombre_materia']) . " - Sin Cupo ($inscriptos_m/$cupo_m)</option>";
                    } else {
                        echo "<option value='" . $c['id_curso'] . "'>" . htmlspecialchars($c['nombre_materia']) . " - ($inscriptos_m/$cupo_m cupos ocupados)</option>";
                    }
                }
                ?>
            </select>
            <button type="submit" name="inscribir">Confirmar Inscripción</button>
        </form>
    </div>
</body>
</html>