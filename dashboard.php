<?php
session_start();

// Función para registrar el log de cierre de sesión
function registrar_log($mensaje) {
    $fecha = date('Y-m-d H:i:s');
    // Mostrar log en la terminal
    echo "[$fecha] $mensaje\n";
    // Registrar el log en un archivo
    file_put_contents('logs.txt', "[$fecha] $mensaje\n", FILE_APPEND);
}

// Registrar el cierre de sesión
if (isset($_GET['logout'])) {
    $usuario = $_SESSION['usuario'];
    registrar_log("El usuario $usuario cerró sesión.");
    session_destroy();
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>

<h2>Bienvenido, <?php echo $_SESSION['usuario']; ?>!</h2>

<p>Has iniciado sesión exitosamente.</p>
<p><a href="?logout=true">Cerrar sesión</a></p>

</body>
</html>
