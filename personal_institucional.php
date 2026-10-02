<?php
include("conexion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Personal Institucional - Sistema Académico</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background-color: #f4f6f9;
            color: #333;
        }
        .navbar {
            background-color: #2b4c7e;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 50px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
        }
        .navbar .logo {
            font-size: 20px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .navbar ul {
            list-style: none;
            display: flex;
            gap: 20px;
            align-items: center;
        }
        .navbar ul li a {
            color: white;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s;
        }
        .navbar ul li a:hover {
            color: #ffd166;
        }  
        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .header-section {
            margin-bottom: 25px;
            border-bottom: 3px solid #f77f00;
            display: inline-block;
            padding-bottom: 5px;
        }
        .header-section h2 {
            color: #1d3557;
            font-size: 26px;
            margin: 0;
        }
        .section-title {
            font-size: 20px;
            color: #1d3557;
            margin: 30px 0 15px 0;
            font-weight: 600;
            border-left: 4px solid #2b4c7e;
            padding-left: 10px;
        }
        .grid-personal {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .card-persona {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.06); 
            border-top: 4px solid #2a9d8f;
         }
        .card-directivo {
             border-top-color: #4a4e69;
            }
        .card-persona h4 {
            font-size: 18px;
            color: #1d3557;
            margin-bottom: 5px;
        }
        .card-persona p {
            font-size: 14px;
            color: #555;
            margin-bottom: 8px;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            background: #e9ecef;
            color: #333;
        }
        .btn-volver {
            display: inline-block;
            margin-bottom: 20px;
            color: #2b4c7e;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
        }
        .btn-volver:hover {
            text-decoration: underline;
        }
        footer { 
            background-color: #1d3557;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 50px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            🏫 <span>Sistema Académico N°222</span>
        </div>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="cursos.php">Cursos</a></li>
            <li><a href="personal_institucional.php" style="color: #ffd166; font-weight: bold;">Personal</a></li>
            <li><a href="registro_alumno.php" style="background-color: #f77f00; padding: 6px 12px; border-radius: 4px; color: white;">Soy Alumno</a></li>
            <li><a href="login_profesor.php" style="background-color: #0077b6; padding: 6px 12px; border-radius: 4px; color: white;">Soy Profesor</a></li>
        </ul>
    </nav>
    <div class="container">
        <a href="index.php" class="btn-volver">← Volver al Inicio</a>
        <div class="header-section">
            <h2>Personal Directivo y Preceptores</h2>
        </div>
        <p style="color: #666; margin-bottom: 20px; font-size: 14px;">Conoce al equipo de conducción y preceptoria de la institución escolar.</p>
        <div class="section-title">Directivos</div>
        <div class="grid-personal">
            <?php
            $sql_dir = "SELECT * FROM directivos";
            $result_dir = $conexion->query($sql_dir);
            if ($result_dir && $result_dir->num_rows > 0) {
                while($row = $result_dir->fetch_assoc()) {
                    echo '<div class="card-persona card-directivo">';
                    echo '<h4>' . htmlspecialchars($row['nombre']) . ' ' . htmlspecialchars($row['apellido']) . '</h4>';
                    echo '<p><strong>Cargo:</strong> <span class="badge">' . htmlspecialchars($row['cargo']) . '</span></p>';
                    echo '<p><strong>Email:</strong> ' . htmlspecialchars($row['email']) . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p style="color: #886; font-style: italic;">No hay directivos registrados actualmente.</p>';
            }
            ?>
        </div>
        <div class="section-title">Preceptores</div>
        <div class="grid-personal">
            <?php
            $sql_prec = "SELECT * FROM preceptores";
            $result_prec = $conexion->query($sql_prec);
            if ($result_prec && $result_prec->num_rows > 0) {
                while($row = $result_prec->fetch_assoc()) {
                    echo '<div class="card-persona">';
                    echo '<h4>' . htmlspecialchars($row['nombre']) . ' ' . htmlspecialchars($row['apellido']) . '</h4>';
                    echo '<p><strong>Turno:</strong> <span class="badge" style="background: #e0f2fe; color: #0369a1;">' . htmlspecialchars($row['turno']) . '</span></p>';
                    echo '<p><strong>Email:</strong> ' . htmlspecialchars($row['email']) . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p style="color: #886; font-style: italic;">No hay preceptores registrados actualmente.</p>';
            }
            ?>
        </div>
    </div>
    <footer>
        <p>Sistema Escolar. Elaborado desde taller práctico. Gracias por leer</p>
    </footer>
</body>
</html>