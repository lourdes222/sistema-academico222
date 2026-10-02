<?php
include("conexion.php");
if (!isset($_GET['id_alumno'])) {
    header("Location: login_alumno.php");
    exit();
}
$id_alumno = $_GET['id_alumno'];
$consulta_alumno = $conexion->query("SELECT * FROM alumnos WHERE id_alumno = '$id_alumno'");
$alumno = $consulta_alumno->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Cursos - Portal Alumno</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .container { max-width: 900px; margin: 40px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        h2 { color: #f77f00; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #2b4c7e; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .btn-volver { display: inline-block; margin-bottom: 15px; color: #666; text-decoration: none; }
        .btn-volver:hover { text-decoration: underline; }
        .btn-ingresar { background-color: #2a9d8f; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 13px; font-weight: bold; display: inline-block; transition: background 0.3s; }
        .btn-ingresar:hover { background-color: #21867a; }
    </style>
</head>
<body>
    <div class="container">
        <a href="panel_alumno.php?id_alumno=<?php echo $id_alumno; ?>" class="btn-volver">← Volver a mi Panel</a>
        <h2>📚 Cursos en los que estás inscripto/a</h2>
        <p>Alumno: <strong><?php echo htmlspecialchars($alumno['nombre'] . ' ' . $alumno['apellido']); ?></strong></p>
        <table>
            <thead>
                <tr>
                    <th>Código / ID</th>
                    <th>Materia / Curso</th>
                    <th>Profesor a Cargo</th>
                    <th style="text-align: center;">Más...</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT c.id_curso, c.nombre_materia, p.nombre AS prof_nombre, p.apellido AS prof_apellido 
                        FROM inscripciones i
                        INNER JOIN cursos c ON i.id_curso = c.id_curso
                        LEFT JOIN profesores p ON c.id_profesor = p.id_profesor
                        WHERE i.id_alumno = '$id_alumno'";
                $resultado = $conexion->query($sql);
                if ($resultado && $resultado->num_rows > 0) {
                    while ($row = $resultado->fetch_assoc()) {
                        $profesor = ($row['prof_nombre']) ? $row['prof_nombre'] . " " . $row['prof_apellido'] : "Sin asignar";
                        echo "<tr>
                                <td>" . $row['id_curso'] . "</td>
                                <td>" . htmlspecialchars($row['nombre_materia']) . "</td>
                                <td>" . htmlspecialchars($profesor) . "</td>
                                <td style='text-align: center;'>
                                    <a href='ver_materia.php?id_curso=" . $row['id_curso'] . "&id_alumno=" . $id_alumno . "' class='btn-ingresar'>📖 Ingresar al Aula</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' style='text-align:center;'>Todavía no te inscribiste en ninguna materia.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>