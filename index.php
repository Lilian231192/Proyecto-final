<?php
include('conexion.php');

// Check if user is logged in
$is_logged_in = isset($_SESSION['user_id']);
$is_admin = $is_logged_in && $_SESSION['is_admin'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Recomendación de Películas y Series</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        nav {
            background-color: #1e1e1e;
            padding: 10px 20px;
        }
        nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: space-between;
        }
        nav ul li {
            display: inline;
            margin-right: 20px;
        }
        nav ul li:last-child {
            margin-right: 0;
        }
        nav ul li a {
            color: #f5f5f5;
            text-decoration: none;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #00aaff;
        }
        .welcome-message {
            text-align: center;
            margin-bottom: 20px;
        }
        .options {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
        }
        .option-card {
            background-color: #1e1e1e;
            border-radius: 10px;
            padding: 20px;
            width: 200px;
            text-align: center;
        }
        .option-card h2 {
            color: #00aaff;
        }
        .option-card a {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #00aaff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }
        .option-card a:hover {
            background-color: #0088cc;
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="pelis.php">Películas</a></li>
            <li><a href="#">Series</a></li>
            <?php if ($is_logged_in): ?>
                <li><a href="preferences.php">Preferencias</a></li>
                <li><a href="logout.php">Cerrar sesión</a></li>
            <?php else: ?>
                <li><a href="login_registro.php">Iniciar sesión / Registrarse</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="container">
        <h1>Bienvenido al Sistema de Recomendación de Películas y Series</h1>
        
        <?php if ($is_logged_in): ?>
            <div class="welcome-message">
                <p>Hola, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>
            </div>
        <?php endif; ?>

        <div class="options">
            <div class="option-card">
                <h2>Películas</h2>
                <p>Explora nuestra colección de películas y obtén recomendaciones personalizadas.</p>
                <a href="pelis.php">Ver Películas</a>
            </div>
            <div class="option-card">
                <h2>Series</h2>
                <p>Descubre series emocionantes y nuevas temporadas de tus favoritas.</p>
                <a href="#">Ver Series</a>
            </div>
            <?php if ($is_logged_in): ?>
                <div class="option-card">
                    <h2>Mis Preferencias</h2>
                    <p>Actualiza tus géneros y títulos favoritos para mejorar las recomendaciones.</p>
                    <a href="preferences.php">Editar Preferencias</a>
                </div>
            <?php endif; ?>
            <?php if ($is_admin): ?>
                <div class="option-card">
                    <h2>Gestión de Usuarios</h2>
                    <p>Administra las cuentas de usuario del sistema.</p>
                    <a href="user_management.php">Gestionar Usuarios</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

