<?php
include("conexion.php");

$mensaje = "";
$nombre = "";
$apellido = "";
$dni = "";
$cargo = "";
$email = "";

if (isset($_POST['guardar_personal'])) {
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $dni = $_POST['dni'] ?? '';
    $cargo = $_POST['cargo'] ?? '';
    $email = $_POST['email'] ?? '';

    if (!empty($nombre) && !empty($apellido) && !empty($dni) && !empty($cargo)) {
        $sql = "INSERT INTO personal (nombre, apellido, dni, cargo, email) VALUES ('$nombre', '$apellido', '$dni', '$cargo', '$email')";
        
        if ($conexion->query($sql) === TRUE) {
            $mensaje = "<div style='background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px;'>¡Personal registrado con éxito!</div>";
            $nombre = $apellido = $dni = $cargo = $email = "";
        } else {
            $mensaje = "<div style='background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;'>Error (Quizás el DNI ya está registrado): " . $conexion->error . "</div>";
        }
    } else {
        $mensaje = "<div style='background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;'>Por favor completa todos los campos obligatorios.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Personal - Sistema Escolar</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .container { max-width: 800px; margin: 40px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .navbar-back { margin-bottom: 20px; }
        .navbar-back a { color: #2b4c7e; text-decoration: none; font-weight: bold; }
        form div { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: 600; color: #333; }
        input, select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; }
        button { background: #2b4c7e; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-size: 15px; font-weight: bold; }
        button:hover { background: #1d3557; }
        table { width: 100%; border-collapse: collapse; margin-top: 30px; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; font-size: 14px; }
        th { background-color: #2b4c7e; color: white; }
    </style>
</head>
<body>

    <div class="container">
        <div class="navbar-back">
            <a href="index.php">← Volver al Inicio</a>
        </div>
        
        <h2>👨‍💼 Gestión de Personal (Directivos y Preceptores)</h2>
        <p style="color: #666; margin-bottom: 20px;">Registrá autoridades, secretarios y preceptores.</p>
        
        <?= $mensaje ?>
        
        <form action="" method="POST">
            <div>
                <label>Nombre:</label>
                <input type="text" name="nombre" value="<?= htmlspecialchars($nombre) ?>" required>
            </div>
            <div>
                <label>Apellido:</label>
                <input type="text" name="apellido" value="<?= htmlspecialchars($apellido) ?>" required>
            </div>
            <div>
                <label>DNI:</label>
                <input type="text" name="dni" value="<?= htmlspecialchars($dni) ?>" required>
            </div>
            <div>
                <label>Cargo Institucional:</label>
                <select name="cargo" required>
                    <option value="">Seleccione un cargo...</option>
                    <option value="Preceptor/a" <?= ($cargo == 'Preceptor/a') ? 'selected' : '' ?>>Preceptor/a</option>
                    <option value="Secretario/a" <?= ($cargo == 'Secretario/a') ? 'selected' : '' ?>>Secretario/a</option>
                    <option value="Director/a" <?= ($cargo == 'Director/a') ? 'selected' : '' ?>>Director/a</option>
                    <option value="Vicedirector/a" <?= ($cargo == 'Vicedirector/a') ? 'selected' : '' ?>>Vicedirector/a</option>
                </select>
            </div>
            <div>
                <label>Email Institucional:</label>
                <input type="email" name="email" value="<?= htmlspecialchars($email) ?>">
            </div>
            <button type="submit" name="guardar_personal">Registrar Personal</button>
        </form>

        <h2>Personal Registrado</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre y Apellido</th>
                    <th>DNI</th>
                    <th>Cargo</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $resultado = $conexion->query("SELECT * FROM personal");
                if ($resultado && $resultado->num_rows > 0) {
                    while($row = $resultado->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['id_personal'] . "</td>
                                <td>" . $row['nombre'] . " " . $row['apellido'] . "</td>
                                <td>" . $row['dni'] . "</td>
                                <td><span style='background: #e2e8f0; padding: 3px 8px; border-radius: 4px; font-weight: bold;'>" . $row['cargo'] . "</span></td>
                                <td>" . $row['email'] . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' style='text-align:center;'>No hay personal registrado todavía.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>