<?php
include("conexion.php");

if (isset($_POST['guardar'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $dni = $_POST['dni'];
    $email = $_POST['email'];
    $clave = $_POST['clave'];
    $verificar_dni = $conexion->query("SELECT * FROM alumnos WHERE dni = '$dni'");
    if ($verificar_dni->num_rows > 0) {
        header("Location: registro_alumno.php?error=dni_repetido");
        exit();
    }
    $sql = "INSERT INTO alumnos (nombre, apellido, dni, email, clave) VALUES ('$nombre', '$apellido', '$dni', '$email', '$clave')";
    if ($conexion->query($sql) === TRUE) {
        header("Location: registro_alumno.php?exito=1");
    } else {
        echo "Error: " . $conexion->error;
    }
}
?>