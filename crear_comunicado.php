<?php
include("conexion.php");

$mensaje = "";
if (isset($_POST['publicar'])) {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $categoria = $_POST['categoria'];
    $contenido = $_POST['contenido'];
    $stmt = $conexion->prepare("INSERT INTO comunicados (titulo, autor, categoria, contenido) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $titulo, $autor, $categoria, $contenido);

    if ($stmt->execute()) {
        $mensaje = "<p style='color: green; font-weight: bold;'>¡Comunicado publicado con éxito! <a href='index.php'>Ver en el inicio</a></p>";
    } else {
        $mensaje = "<p style='color: red;'>Error al publicar: " . $conexion->error . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Publicar Comunicado</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .container { max-width: 600px; margin: 40px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        h2 { color: #2b4c7e; margin-bottom: 20px; }
        input, select, textarea, button { width: 100%; padding: 10px; margin-top: 5px; margin-bottom: 15px; border-radius: 4px; border: 1px solid #ccc; box-sizing: border-box; }
        button { background: #2b4c7e; color: white; border: none; font-weight: bold; cursor: pointer; }
        button:hover { background: #1d3557; }
    </style>
</head>
<body>
    <div class="container">
        <p><a href="index.php" style="color: #666; text-decoration: none;">← Volver al Inicio</a></p>
        <h2>📢 Publicar Nuevo Comunicado</h2>
        <?php if($mensaje) echo $mensaje; ?>
        <form method="POST" action="">
            <label>Título del Anuncio:</label>
            <input type="text" name="titulo" required placeholder="Ej: Fechas de Exámenes Finales">
            <label>Autor:</label>
            <input type="text" name="autor" required placeholder="Ej: Prof. Alexa Rodríguez">
            <label>Categoría:</label>
            <select name="categoria">
                <option value="General">General</option>
                <option value="Importante">Importante</option>
                <option value="Exámenes">Exámenes</option>
                <option value="Institucional">Institucional</option>
            </select>
            <label>Mensaje / Contenido:</label>
            <textarea name="contenido" rows="5" required placeholder="Escribí aquí el comunicado oficial..."></textarea>
            <button type="submit" name="publicar">Publicar Anuncio</button>
        </form>
    </div>
</body>
</html>