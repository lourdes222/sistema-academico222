<?php
include("conexion.php");

$mensaje = "";

if (isset($_POST['guardar'])) {
    $nombre_materia = $_POST['nombre_materia'];
    $cupo = intval($_POST['cupo']);
    
    $id_profesor = !empty($_POST['id_profesor']) ? intval($_POST['id_profesor']) : NULL;
    $id_preceptor = !empty($_POST['id_preceptor']) ? intval($_POST['id_preceptor']) : NULL;
    if ($id_profesor === NULL) {
        $sql = "INSERT INTO cursos (nombre_materia, cupo, id_profesor, id_preceptor) VALUES ('$nombre_materia', $cupo, NULL, " . ($id_preceptor ? $id_preceptor : "NULL") . ")";
        $exec = $conexion->query($sql);
    } else {
        $stmt = $conexion->prepare("INSERT INTO cursos (nombre_materia, cupo, id_profesor, id_preceptor) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siii", $nombre_materia, $cupo, $id_profesor, $id_preceptor);
        $exec = $stmt->execute();
    }
    if ($exec) {
        $mensaje = "<p style='color: green; font-weight: bold;'>¡Curso creado con éxito! <a href='cursos.php'>Ver oferta de cursos</a></p>";
    } else {
        $mensaje = "<p style='color: red;'>Error al guardar el curso: " . $conexion->error . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Nuevo Curso</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .container { max-width: 500px; margin: 40px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        h2 { color: #1d3557; margin-bottom: 20px; }
        input, select, button { width: 100%; padding: 10px; margin-top: 5px; margin-bottom: 15px; border-radius: 4px; border: 1px solid #ccc; box-sizing: border-box; }
        button { background: #2a9d8f; color: white; border: none; font-weight: bold; cursor: pointer; }
        button:hover { background: #21867a; }
    </style>
</head>
<body>
    <div class="container">
        <p><a href="panel_directivo.php" style="color: #666; text-decoration: none;">← Volver al Panel Directivo</a></p>
        <h2>📚 Registrar Nuevo Curso</h2>
        <?php if($mensaje) echo $mensaje; ?>
        <form method="POST" action="">
            <label>Nombre de la Materia:</label>
            <input type="text" name="nombre_materia" required placeholder="Ej: Bases de Datos">
            <label>Cupo de Alumnos:</label>
            <input type="number" name="cupo" required placeholder="Ej: 30">
            <label>Profesor a Cargo:</label>
            <select name="id_profesor" required>
                <option value="">Seleccionar Profesor</option>
                <?php
                $profes = $conexion->query("SELECT id_profesor, nombre FROM profesores");
                if ($profes && $profes->num_rows > 0) {
                    while ($p = $profes->fetch_assoc()) {
                        echo "<option value='" . $p['id_profesor'] . "'>" . htmlspecialchars($p['nombre']) . "</option>";
                    }
                }
                ?>
            </select>
            <label>Preceptor Asignado (Opcional):</label>
            <select name="id_preceptor">
                <option value="">Sin Preceptor</option>
                <?php
                $preceptores = $conexion->query("SELECT id_preceptor, nombre FROM preceptores");
                if ($preceptores && $preceptores->num_rows > 0) {
                    while ($pr = $preceptores->fetch_assoc()) {
                        echo "<option value='" . $pr['id_preceptor'] . "'>" . htmlspecialchars($pr['nombre']) . "</option>";
                    }
                }
                ?>
            </select>
            <button type="submit" name="guardar">Crear Curso</button>
        </form>
    </div>
</body>
</html>