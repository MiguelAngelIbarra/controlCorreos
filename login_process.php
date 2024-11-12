<?php
session_start();
include 'config.php';

// Función para escribir en el log de errores
function log_error($message)
{
    $log_file = 'D:\xampp\htdocs\Seguridad\error_log.txt'; 
    $timestamp = date("Y-m-d H:i:s"); 
    $ip_address = $_SERVER['REMOTE_ADDR']; 
    $log_message = "[$timestamp] - $ip_address - $message\n";
    
    file_put_contents($log_file, $log_message, FILE_APPEND);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['correo_electronico']) && isset($_POST['contrasena'])) 
{
    $correo_electronico = filter_var($_POST['correo_electronico'], FILTER_SANITIZE_EMAIL);
    $contrasena = $_POST['contrasena'];

    // Consulta en la base de datos si el correo existe y verifica si es administrador
    $stmt = $pdo->prepare("SELECT * FROM estudiantes WHERE correo_electronico = :correo_electronico");
    $stmt->execute(['correo_electronico' => $correo_electronico]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) 
    {
        // Verifica si el usuario es administrador
        $_SESSION['usuario'] = $user['correo_electronico'];
        $_SESSION['admin'] = $user['admin']; 
        
        if ($user['admin'] == 1) {
            log_error("Administrador inició sesión correctamente: $correo_electronico");
            header("Location: adminCorreo.php"); 
        } else {
            log_error("Usuario inició sesión correctamente: $correo_electronico");
            header("Location: dashboard.php"); 
        }
        exit();
    } 
    else 
    {
   
        if (!isset($_SESSION['contEstatus'])) {
            $_SESSION['contEstatus'] = [];
        }

        
        if (!isset($_SESSION['contEstatus'][$correo_electronico])) {
            $_SESSION['contEstatus'][$correo_electronico] = 1;
        }
        if ($_SESSION['contEstatus'][$correo_electronico] == 1) {
            $stmt = $pdo->prepare("INSERT INTO correos_bloqueados (correo_electronico, estatus) VALUES (:correo_electronico, 'proceso')");
            $stmt->execute(['correo_electronico' => $correo_electronico]);
            $_SESSION['contEstatus'][$correo_electronico] = 2;

            log_error("Intento de inicio de sesión con correo no válido, PRIMER intento: $correo_electronico");

            $_SESSION['mensaje_alerta'] = "Correo no válido. Por favor, verifica tus datos e intenta nuevamente.";
            header("Location: index.php");
            exit();
        } 
        elseif ($_SESSION['contEstatus'][$correo_electronico] == 2) 
        {
            $stmt = $pdo->prepare("SELECT * FROM correos_bloqueados WHERE correo_electronico = :correo_electronico");
            $stmt->execute(['correo_electronico' => $correo_electronico]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $_SESSION['usuario'] = $user['correo_electronico'];
                
                // Bloquea el correo
                $stmt = $pdo->prepare("UPDATE correos_bloqueados SET estatus = 'bloqueado' WHERE correo_electronico = :correo_electronico");
                $stmt->bindParam(':correo_electronico', $user['correo_electronico']);
                $stmt->execute();

                log_error("Intento de inicio de sesión con correo no válido, SEGUNDO intento: {$user['correo_electronico']}");
                log_error("Se bloqueó el correo: {$user['correo_electronico']}");

                
                $_SESSION['mensaje_alerta_fin'] = "Se bloqueó el correo: {$user['correo_electronico']}. Comunícate con el administrador para desbloquearlo.";
                header("Location: error.php");
                exit();
            }
        }
    }
}
else 
{
    // Si no se recibieron los datos necesarios, redirigir al login
    header("Location: index.php");
    exit();
}
?>
