<?php
include("conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema Acádemico - Inicio</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        *{
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body{
            background-color: #f4f6f9;
            color: #333;
        }
        .navbar{
            background-color: #2b4c7e;
            color:white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 50px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
        }
        .navbar .logo{
            font-size: 20px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .navbar ul{
            list-style: none;
            display: flex;
            gap: 20px;
            align-items: center;
        }
        .navbar ul li a{
            color: white;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s;
        }
        .navbar ul li a:hover{
            color: #ffd166;
        }
        .btn-modo {
            padding: 6px 12px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 13px !important;
        }
        .btn-modo-alumno { background-color: #f77f00; color: white !important; }
        .btn-modo-profesor { background-color: #0077b6; color: white !important; }

        .hero{
            background: linear-gradient(135deg, #1d3557, #457b9d);
            color: white;
            padding: 40px 50px;
            text-align: center;
            box-shadow: inset 0 -5px 10px rgba(0,0,0,0.1);
        }
        .hero h1{
            font-size: 32px;
            margin-bottom: 10px;
        }
        .hero p{
            font-size: 16px;
            opacity: 0.9;
        }
        .main-container{
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        .section-title{
            font-size: 22px;
            color: #1d3557;
            margin-bottom: 20px;
            border-bottom: 3px solid #e63946;
            display: inline-block;
            padding-bottom: 5px;
        }
        .portal-grid{
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }
        .portal-card{
            border-radius: 8px;
            padding: 25px;
            color: white;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 160px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .portal-card:hover{
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);   
        }
        .portal-card h3{
            font-size: 20px;
            margin-bottom: 8px;
        }
        .portal-card p{
            font-size: 14px;
            opacity: 0.9;
        }
        .card-alumnos{background: linear-gradient(135deg, #f77f00, #fcbf49);}
        .card-docentes{background: linear-gradient(135deg, #0077b6,#00b4d8);}
        .card-cursos{background: linear-gradient(135deg, #2a9d8f, #e9c46a)}
        .card-admin{background: linear-gradient(135deg, #e63946, #f1faee); color: #1d3557;}
        .card-admin p{ color: #457b9d;}
        footer{
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
            <li><a href="personal_institucional.php">Personal</a></li>
            <li><a href="registro_alumno.php" class="btn-modo btn-modo-alumno">Soy Alumno</a></li>
            <li><a href="login_profesor.php" class="btn-modo btn-modo-profesor">Soy Profesor</a></li>
        </ul>
    </nav>
    <header class="hero">
        <h1>Plataforma de Gestión Educativa</h1>
        <p>Ciclo Lectivo 2026 — Acceso unificado para alumnos, profesores y administración</p>
    </header>
    <div class="main-container">
        <h2 class="section-title">Portales y Trámites</h2>
        <div class="portal-grid">
            <a href="registro_alumno.php" class="portal-card card-alumnos">
                <div>
                    <h3>👨‍🎓 Gestión de Alumnos</h3>
                    <p>Registrar nuevos estudiantes e inscripciones a materias.</p>
                </div>
                <span>Acceder →</span>
            </a>
            <a href="login_profesor.php" class="portal-card card-docentes">
                <div>
                    <h3>👨‍🏫 Portal Docente</h3>
                    <p>Acceso a materias asignadas y listas de alumnos por curso.</p>
                </div>
                <span>Ingresar →</span>
            </a>
        <a href="login_directivo.php" class="portal-card" style="background: linear-gradient(135deg, #4a4e69, #9a8c98);">
            <div>
                <h3>👥 Personal y Directivos</h3>
                <p>Alta de preceptores, secretarios y directivos.</p>
            </div>
            <span>Ingresar →</span>
        </a>
            <a href="cursos.php" class="portal-card card-cursos">
                <div>
                    <h3>📚 Cursos y Oferta Académica</h3>
                    <p>Creación de materias, asignación de cupos y docentes a cargo.</p>
                </div>
                <span>Ver Materias →</span>
            </a>
        </div>
        <h2 class="section-title">Novedades Institucionales</h2>
        <div style="background: white; border-radius: 8px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
            <?php
            $comunicados = $conexion->query("SELECT * FROM comunicados ORDER BY fecha_publicacion DESC LIMIT 5");
            if ($comunicados && $comunicados->num_rows > 0) {
                while ($c = $comunicados->fetch_assoc()) {
                    $fecha = date("d/m/Y H:i", strtotime($c['fecha_publicacion']));
                    echo "
                    <div style='background: #f8f9fa; border-left: 4px solid #f77f00; padding: 15px; margin-bottom: 15px; border-radius: 4px;'>
                        <div style='display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;'>
                            <h4 style='margin: 0; color: #1d3557; font-size: 16px;'>" . htmlspecialchars($c['titulo']) . "</h4>
                            <span style='font-size: 11px; background: #e2e8f0; color: #4a5568; padding: 3px 8px; border-radius: 10px;'>" . $fecha . "</span>
                        </div>
                        <div style='font-size: 13px; color: #2980b9; margin-bottom: 8px; font-weight: 500;'>
                            Publicado por: <strong>" . htmlspecialchars($c['autor']) . "</strong> 
                            <span style='background: #edf2f7; color: #4a5568; padding: 1px 6px; border-radius: 4px; margin-left: 8px; font-size: 11px;'>" . htmlspecialchars($c['categoria']) . "</span>
                        </div>
                        <p style='margin: 0; color: #555; font-size: 14px; line-height: 1.4;'>" . nl2br(htmlspecialchars($c['contenido'])) . "</p>
                    </div>";
                }
            } else {
                echo "<p style='color: #777; font-style: italic; text-align: center; padding: 20px;'>No hay comunicados publicados por el momento.</p>";
            }
            ?>
        </div>
    </div>
    <footer>
        <p>Sistema Escolar. Elaborado desde taller práctico. Gracias por leer</p>
    </footer>
</body>
</html>