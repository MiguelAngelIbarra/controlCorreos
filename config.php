<?php
// Configuración de la base de datos
$host = 'localhost:3307'; // Host de la base de datos (por ejemplo, localhost)
$dbname = 'seguridad'; // Nombre de la base de datos
$username = 'root'; // Usuario de la base de datos
$password = '123456'; // Contraseña de la base de datos

// Crear la conexión a la base de datos
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Configurar para que PDO maneje los errores
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   //echo "Conexión exitosa a la base de datos"; 
} catch (PDOException $e) {
    die("Conexión fallida: " . $e->getMessage());
}
?>
