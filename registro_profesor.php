<?php
include("conexion.php");

$mensaje = "";
if (isset($_POST['guardar_profesor'])) {
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $email = $_POST['email'] ?? '';
    if (!empty($nombre) && !empty($apellido)) {
        $sql = "INSERT INTO profesores (nombre, apellido, email) VALUES ('$nombre', '$apellido', '$email')";
        if ($conexion->query($sql) === TRUE) {
            $mensaje = "<div class='alerta verde'>¡Profesor guardado con éxito!</div>";
        } else {
            $mensaje = "<div class='alerta rojo'>Error: " . $conexion->error . "</div>";
        }
    } else {
        $mensaje = "<div class='alerta rojo'>Completá los campos obligatorios.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Profesores</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container">
        <p><a href="index.php">← Volver al Menú Principal</a></p>
        <h2>Registrar Nuevo Profesor</h2>
        <?= $mensaje ?>      
        <form action="" method="POST">
            <div>
                <label>Nombre:</label>
                <input type="text" name="nombre" required>
            </div>
            <div>
                <label>Apellido:</label>
                <input type="text" name="apellido" required>
            </div>
            <div>
                <label>Email:</label>
                <input type="email" name="email">
            </div>
            <button type="submit" name="guardar_profesor">Guardar Profesor</button>
        </form>

        <h2>Profesores Registrados</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $resultado = $conexion->query("SELECT * FROM profesores");
                if ($resultado->num_rows > 0) {
                    while($row = $resultado->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['id_profesor'] . "</td>
                                <td>" . $row['nombre'] . "</td>
                                <td>" . $row['apellido'] . "</td>
                                <td>" . $row['email'] . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' style='text-align:center;'>No hay profesores registrados.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>