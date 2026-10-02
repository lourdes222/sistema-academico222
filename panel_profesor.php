<?php
include("conexion.php");
$id_profesor = $_GET['id_profesor'] ?? null;
if(!$id_profesor){
    header("Location: login_profesor.php");
    exit();
}
$query_prof = $conexion->query("SELECT * FROM profesores WHERE id_profesor = $id_profesor");
$profesor = $query_prof->fetch_assoc();
$mensaje_aula = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['publicar_aula'])) {
    $materia = $_POST['materia'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $enlace = $_POST['enlace'];
    if (!empty($materia) && !empty($titulo) && !empty($descripcion)) {
        $stmt = $conexion->prepare("INSERT INTO aula_virtual (id_profesor, materia, titulo, descripcion, enlace_recurso) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $id_profesor, $materia, $titulo, $descripcion, $enlace);
        
        if ($stmt->execute()) {
            $mensaje_aula = "<p style='color: #27ae60; font-weight: bold; background: #e8f8f5; padding: 10px; border-radius: 5px; margin-bottom: 15px;'>¡Material publicado con éxito en el Aula Virtual!</p>";
        } else {
            $mensaje_aula = "<p style='color: #c0392b; font-weight: bold; background: #fadbd8; padding: 10px; border-radius: 5px; margin-bottom: 15px;'>Error al publicar el material.</p>";
        }
        $stmt->close();
    } else {
        $mensaje_aula = "<p style='color: #d35400; font-weight: bold; background: #fdebd0; padding: 10px; border-radius: 5px; margin-bottom: 15px;'>Por favor, completa los campos obligatorios.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del Profesor</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container">
        <p><a href="login_profesor.php">← Cambiar de Profesor</a> | <a href="index.php">Menú Principal</a></p>
        <h2>Bienvenido/a, Profesor/a <?= htmlspecialchars($profesor['nombre']) . " " . htmlspecialchars($profesor['apellido']) ?></h2>
        <p>Email de contacto: <strong><?= htmlspecialchars($profesor['email']) ?></strong></p>
        <hr style="margin: 20px 0; border: 0; border-top: 1px solid #ddd;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin-bottom: 25px;">
            <a href="crear_comunicado.php" class="card-opcion" style="background: linear-gradient(135deg, #0077b6, #00b4d8); color: white; text-decoration: none; padding: 20px; border-radius: 8px; display: block;">
                <div style="font-size: 24px;">📢</div>
                <h3 style="margin: 5px 0; color: white;">Publicar Comunicado</h3>
                <p style="font-size: 13px; opacity: 0.9;">Crear anuncios oficiales para que aparezcan en la portada de la escuela.</p>
            </a>
            <a href="#formulario-aula" class="card-opcion" style="background: linear-gradient(135deg, #2a9d8f, #e76f51); color: white; text-decoration: none; padding: 20px; border-radius: 8px; display: block;">
                <div style="font-size: 24px;">💻</div>
                <h3 style="margin: 5px 0; color: white;">Aula Virtual</h3>
                <p style="font-size: 13px; opacity: 0.9;">Subir material de estudio, consignas o enlaces de tareas para tus alumnos.</p>
            </a>
        </div>
        <div id="formulario-aula" style="background: #fdfdfd; border: 1px solid #e1e1e1; padding: 20px; border-radius: 8px; margin-bottom: 30px; border-top: 4px solid #2a9d8f;">
            <h3 style="color: #2c3e50; margin-top: 0; margin-bottom: 10px;">💻 Publicar Material en el Aula Virtual</h3>
            <p style="color: #7f8c8d; font-size: 14px; margin-bottom: 15px;">Completa el formulario para subir apuntes o clases que verán los alumnos.</p>
            <?= $mensaje_aula ?>
            <form action="panel_profesor.php?id_profesor=<?= $id_profesor ?>" method="POST">
                <input type="hidden" name="publicar_aula" value="1">
                <div style="margin-bottom: 12px;">
                    <label style="display: block; font-weight: bold; font-size: 14px; margin-bottom: 5px;">Materia:</label>
                    <select name="materia" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
                        <option value="">Selecciona una de tus materias</option>
                        <?php
                        $m_cursos = $conexion->query("SELECT nombre_materia FROM cursos WHERE id_profesor = $id_profesor");
                        while($mc = $m_cursos->fetch_assoc()){
                            echo "<option value='" . htmlspecialchars($mc['nombre_materia']) . "'>" . htmlspecialchars($mc['nombre_materia']) . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div style="margin-bottom: 12px;">
                    <label style="display: block; font-weight: bold; font-size: 14px; margin-bottom: 5px;">Título de la Clase / Tema:</label>
                    <input type="text" name="titulo" placeholder="Ej: Trabajo Práctico N°1 - Consultas SQL" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
                </div>
                <div style="margin-bottom: 12px;">
                    <label style="display: block; font-weight: bold; font-size: 14px; margin-bottom: 5px;">Explicación / Consigna:</label>
                    <textarea name="descripcion" rows="3" placeholder="Escribe las instrucciones para los alumnos..." style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required></textarea>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: bold; font-size: 14px; margin-bottom: 5px;">Enlace a Recurso / Drive (Opcional):</label>
                    <input type="url" name="enlace" placeholder="https://drive.google.com/..." style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                </div>
                <button type="submit" style="background-color: #2a9d8f; color: white; padding: 10px 18px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">Publicar Clase</button>
            </form>
        </div>
        <hr style="margin: 20px 0; border: 0; border-top: 1px solid #ddd;">
        <h3>Materias a tu Cargo y Alumnos Inscriptos</h3>
        <?php
        $query_cursos = $conexion->query("SELECT * FROM cursos WHERE id_profesor = $id_profesor");
        if($query_cursos->num_rows > 0){
            while($curso = $query_cursos->fetch_assoc()){
                echo "<div style='background: #fdfdfd; border: 1px solid #e1e1e1; padding: 15px; border-radius: 6px; margin-bottom: 20px;'>";
                echo "<h4 style='color: #2980b9; margin-top: 0;'>Materia: " . htmlspecialchars($curso['nombre_materia']) . " (Cupo máx: " . htmlspecialchars($curso['cupo']) . ")</h4>";
                $id_c = $curso['id_curso'];
                $query_alumnos = $conexion->query("SELECT alumnos.nombre, alumnos.apellido, alumnos.dni, alumnos.email
                FROM inscripciones
                INNER JOIN alumnos ON inscripciones.id_alumno = alumnos.id_alumno
                WHERE inscripciones.id_curso = $id_c");
                if($query_alumnos->num_rows > 0){
                    echo "<table style='margin-top: 10px; width: 100%; border-collapse: collapse;'>
                    <thead>
                        <tr style='background-color: #34495e; color: white;'>
                            <th style='padding: 8px; text-align: left;'>Nombre</th>
                            <th style='padding: 8px; text-align: left;'>Apellido</th>
                            <th style='padding: 8px; text-align: left;'>DNI</th>
                            <th style='padding: 8px; text-align: left;'>Email</th>
                        </tr>
                    </thead>
                    <tbody>";
                    while($alu = $query_alumnos->fetch_assoc()) {
                        echo "<tr style='border-bottom: 1px solid #ddd;'>
                                <td style='padding: 8px;'>" . htmlspecialchars($alu['nombre']) . "</td>
                                <td style='padding: 8px;'>" . htmlspecialchars($alu['apellido']) . "</td>
                                <td style='padding: 8px;'>" . htmlspecialchars($alu['dni']) . "</td>
                                <td style='padding: 8px;'>" . htmlspecialchars($alu['email']) . "</td>
                              </tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "<p style='color: #7f8c8d; font-style: italic; margin-top: 5px;'>Todavía no hay alumnos inscriptos en esta materia.</p>";
                }
                echo "</div>";
            }
        } else {
            echo "<p style='text-align: center; color: #e74c3c;'>Actualmente no tenés ninguna materia asignada en el sistema.</p>";
        }
        ?>
    </div>
</body>
</html>