<?php
// ... (keep existing PHP code) ...

// Add user preferences
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['preferences'])) {
    $user_id = $_POST['user_id']; // You need to get the user ID from the session
    $preferences = $_POST['preferences'];

    $sql = "INSERT INTO gusto (id_user, terror, comedia, drama, acción, ciencia_ficción, romance, fantasía, documental, animación) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE 
            terror = VALUES(terror),
            comedia = VALUES(comedia),
            drama = VALUES(drama),
            acción = VALUES(acción),
            ciencia_ficción = VALUES(ciencia_ficción),
            romance = VALUES(romance),
            fantasía = VALUES(fantasía),
            documental = VALUES(documental),
            animación = VALUES(animación)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiiiiiiii", $user_id, $preferences['terror'], $preferences['comedia'], $preferences['drama'], 
                      $preferences['accion'], $preferences['ciencia_ficcion'], $preferences['romance'], 
                      $preferences['fantasia'], $preferences['documental'], $preferences['animacion']);
    
    if ($stmt->execute()) {
        $mensaje_exito = 'Preferencias guardadas exitosamente.';
    } else {
        $mensaje_error = 'Error al guardar las preferencias.';
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- ... (keep existing head content) ... -->
</head>
<body>

    <!-- ... (keep existing navbar and login/register forms) ... -->

    <!-- Formulario de preferencias -->
    <div class="container">
        <h2>Tus preferencias</h2>
        <form method="POST" action="">
            <input type="hidden" name="user_id" value="1"> <!-- Replace with actual user ID -->
            <label>
                <input type="checkbox" name="preferences[terror]" value="1"> Terror
            </label>
            <label>
                <input type="checkbox" name="preferences[comedia]" value="1"> Comedia
            </label>
            <label>
                <input type="checkbox" name="preferences[drama]" value="1"> Drama
            </label>
            <label>
                <input type="checkbox" name="preferences[accion]" value="1"> Acción
            </label>
            <label>
                <input type="checkbox" name="preferences[ciencia_ficcion]" value="1"> Ciencia Ficción
            </label>
            <label>
                <input type="checkbox" name="preferences[romance]" value="1"> Romance
            </label>
            <label>
                <input type="checkbox" name="preferences[fantasia]" value="1"> Fantasía
            </label>
            <label>
                <input type="checkbox" name="preferences[documental]" value="1"> Documental
            </label>
            <label>
                <input type="checkbox" name="preferences[animacion]" value="1"> Animación
            </label>
            <button type="submit" name="preferences">Guardar preferencias</button>
        </form>
    </div>

    <!-- ... (keep existing JavaScript) ... -->

</body>
</html>

<?php
// Cerrar la conexión a la base de datos al final
$conn->close();
?>

