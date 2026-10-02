<?php
include("conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Aula Virtual - Sistema Académico</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f4f6f9; color: #333; }
        .navbar { background-color: #2b4c7e; color: white; display: flex; justify-content: space-between; align-items: center; padding: 15px 50px; }
        .navbar a { color: white; text-decoration: none; font-size: 14px; font-weight: 500; }
        .container { max-width: 900px; margin: 30px auto; padding: 0 20px; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.06); margin-bottom: 20px; border-left: 5px solid #0077b6; }
        .tag-materia { background: #e0f2fe; color: #0369a1; padding: 3px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; display: inline-block; margin-bottom: 8px; }
        .profesor-info { font-size: 13px; color: #666; margin-bottom: 8px; font-style: italic; }
        .link-btn { display: inline-block; margin-top: 10px; background: #2a9d8f; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 13px; font-weight: bold; }
        .link-btn:hover { background: #21867a; }
    </style>
</head>
<body>
    <nav class="navbar">
        <div style="font-weight: bold; font-size: 18px;">💻 Aula Virtual Básica — Sistema Acádemico N°222</div>
        <div>
            <a href="index.php">← Volver al Inicio</a>
        </div>
    </nav>
    <div class="container">
        <h2>📚 Contenidos y Clases Publicadas</h2>
        <p style="color: #666; margin-bottom: 25px;">Espacio de consulta de recursos educativos, apuntes y tareas para los alumnos.</p>
        <?php
        $sql = "SELECT a.*, p.nombre AS prof_nombre, p.apellido AS prof_apellido 
                FROM aula_virtual a 
                LEFT JOIN profesores p ON a.id_profesor = p.id_profesor 
                ORDER BY a.id_material DESC";
        $res = $conexion->query($sql);
        if ($res && $res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                echo '<div class="card">';
                echo '<span class="tag-materia">' . htmlspecialchars($row['materia']) . '</span>';
                if (!empty($row['prof_apellido'])) {
                    echo '<div class="profesor-info">Publicado por: Prof. ' . htmlspecialchars($row['prof_apellido']) . ' ' . htmlspecialchars($row['prof_nombre']) . '</div>';
                }
                echo '<h4 style="color: #1d3557; font-size: 18px;">' . htmlspecialchars($row['titulo']) . '</h4>';
                echo '<p style="color: #555; margin-top: 8px; font-size: 14px; line-height: 1.5;">' . nl2br(htmlspecialchars($row['descripcion'])) . '</p>';
                if (!empty($row['enlace_recurso'])) {
                    echo '<br><a href="' . htmlspecialchars($row['enlace_recurso']) . '" target="_blank" class="link-btn">🔗 Abrir Recurso / Apunte</a>';
                }
                echo '</div>';
            }
        } else {
            echo '<p style="color: #888; font-style: italic; background: white; padding: 20px; border-radius: 8px; text-align: center;">No hay materiales publicados en el aula virtual aún.</p>';
        }
        ?>
    </div>
</body>
</html>