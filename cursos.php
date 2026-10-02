<?php
include("conexion.php");
$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Oferta Académica - Cursos</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333; margin: 0; padding: 0; }
        .navbar { background-color: #2b4c7e; color: white; display: flex; justify-content: space-between; align-items: center; padding: 15px 50px; box-shadow: 0 2px 10px rgba(0,0,0,0.15); }
        .navbar .logo { font-size: 20px; font-weight: bold; display: flex; align-items: center; gap: 10px; }
        .navbar ul { list-style: none; display: flex; gap: 20px; align-items: center; }
        .navbar ul li a { color: white; text-decoration: none; font-size: 14px; font-weight: 500; transition: color 0.3s; }
        .navbar ul li a:hover { color: #ffd166; }
        .container { max-width: 1100px; margin: 40px auto; padding: 0 20px; }
        .header-section { margin-bottom: 30px; border-bottom: 3px solid #e63946; display: inline-block; padding-bottom: 5px; }
        .header-section h2 { color: #1d3557; font-size: 26px; margin: 0; }
        .search-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 25px;
        }
        .search-form {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .search-input {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            outline: none;
        }
        .search-input:focus { border-color: #2b4c7e; }
        .btn-buscar {
            background: #0077b6;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
            transition: background 0.3s;
        }
        .btn-buscar:hover { background: #005f87; }
        .btn-limpiar {
            background: #e63946;
            color: white;
            padding: 10px 15px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            transition: background 0.3s;
        }
        .btn-limpiar:hover { background: #c52833; }
        .cursos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px;
        }
        .curso-card {
            background: white;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            border-top: 5px solid #2a9d8f;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .curso-card.sin-cupo {
            border-top-color: #e63946;
        } 
        .curso-card h3 {
            color: #1d3557;
            margin-top: 0;
            margin-bottom: 12px;
            font-size: 20px;
        }
        .curso-info {
            font-size:14px;
            color: #555;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .curso-info strong {
            color: #333;
        }
        
        .btn-volver {
            display:inline-block;
            margin-bottom: 20px;
            color: #2b4c7e;
            text-decoration: none;
            font-weight: bold;
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
            <li><a href="cursos.php" style="color: #ffd166; font-weight: bold;">Cursos</a></li>
            <li><a href="personal_institucional.php">Personal</a></li>
            <li><a href="registro_alumno.php" style="background-color: #f77f00; padding: 6px 12px; border-radius: 4px; color: white;">Soy Alumno</a></li>
            <li><a href="login_profesor.php" style="background-color: #0077b6; padding: 6px 12px; border-radius: 4px; color: white;">Soy Profesor</a></li>
        </ul>
    </nav>
    <div class="container">
        <a href="index.php" class="btn-volver">← Volver al Inicio</a>
        <div class="header-section">
            <h2>📚 Oferta Académica y Materias Disponibles</h2>
        </div>
        <p style="color: #666; margin-bottom: 30px;">Conocé las asignaturas vigentes, los profesores a cargo y la disponibilidad de cupos en tiempo real.</p>
        <div class="search-box">
            <form method="GET" action="cursos.php" class="search-form">
                <input type="text" name="busqueda" class="search-input" placeholder="Buscar por nombre de materia o profesor..." value="<?php echo htmlspecialchars($busqueda); ?>">
                <button type="submit" class="btn-buscar">Buscar</button>
                <?php if(!empty($busqueda)): ?>
                    <a href="cursos.php" class="btn-limpiar">Limpiar</a>
                <?php endif; ?>
            </form>
        </div>
        <div class="cursos-grid">
            <?php
            $sql = "SELECT c.id_curso, c.nombre_materia, c.cupo, p.nombre AS nombre_profesor,
                            COUNT(i.id_inscripcion) AS total_inscriptos
                    FROM cursos c 
                    LEFT JOIN profesores p ON c.id_profesor = p.id_profesor
                    LEFT JOIN inscripciones i ON c.id_curso = i.id_curso";
            if (!empty($busqueda)) {
                $busq_segura = $conexion->real_escape_string($busqueda);
                $sql .= " WHERE c.nombre_materia LIKE '%$busq_segura%' OR p.nombre LIKE '%$busq_segura%'";
            }
            $sql .= " GROUP BY c.id_curso";
            $resultado = $conexion->query($sql);
            if ($resultado && $resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                    $materia = $row['nombre_materia'];
                    $cupo = intval($row['cupo']);
                    $inscriptos = intval($row['total_inscriptos']);
                    $profesor = !empty($row['nombre_profesor']) ? $row['nombre_profesor'] : 'A asignar';                    if ($inscriptos >= $cupo) {
                        $estado_html = "<span style='color: #e63946; font-weight: bold;'>Sin Cupo ($inscriptos de $cupo ocupados)</span>";
                        $clase_card = "curso-card sin-cupo";
                    } else {
                        $estado_html = "<span style='color: #2a9d8f; font-weight: bold;'>Inscripciones Abiertas ($inscriptos de $cupo ocupados)</span>";
                        $clase_card = "curso-card";
                    }
                    
                    echo "
                    <div class='" . $clase_card . "'>
                        <div>
                            <h3>📖 " . htmlspecialchars($materia) . "</h3>
                            <div class='curso-info'>👨‍🏫 <strong>Profesor/a:</strong> " . htmlspecialchars($profesor) . "</div>
                            <div class='curso-info'>👥 <strong>Cupo Máximo:</strong> " . htmlspecialchars($cupo) . " alumnos</div>
                            <div class='curso-info'>📝 <strong>Inscriptos actual:</strong> " . $inscriptos . "</div>
                        </div>
                        <div style='margin-top: 15px; border-top: 1px solid #eee; padding-top: 10px; font-size: 13px; color: #555;'>
                            Estado: " . $estado_html . "
                        </div>
                    </div>";
                }
            } else {
                echo "<p style='color: #777; font-style: italic; grid-column: 1 / -1; text-align: center; padding: 40px;'>No se encontraron cursos que coincidan con tu búsqueda.</p>";
            }
            ?>
        </div>
    </div>
    <footer>
        <p>Sistema Escolar. Elaborado desde taller práctico. Gracias por leer</p>
    </footer>
</body>
</html>