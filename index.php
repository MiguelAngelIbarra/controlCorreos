<?php
session_start();
if (isset($user) )
{
    // Iniciar sesión exitoso
    $_SESSION['usuario'] = $user['correo_electronico'];
    log_error("Usuario inicio sesion correcamente: $correo_electronico");
    header("Location: dashboard.php");
    exit();
} 
// Mostrar el mensaje modal si existe
if (isset($_SESSION['mensaje_alerta'])) {
    echo "<div class='fondo-modal' id='modalAlerta'>
            <div class='modal-alerta'>
                <button onclick='cerrarModal()'>×</button>
                {$_SESSION['mensaje_alerta']}
            </div>
          </div>";

    // Limpiar el mensaje de alerta de la sesión después de mostrarlo
    unset($_SESSION['mensaje_alerta']);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .login-container h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .login-container label {
            font-size: 14px;
            text-align: left;
            margin-top: 10px;
        }
        .login-container input[type="correo_electronico"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .login-container button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .login-container button:hover {
            background-color: #45a049;
        }
        .login-container .forgot-contrasena {
            margin-top: 10px;
            font-size: 14px;
        }
        .login-container .forgot-contrasena a {
            color: #007BFF;
            text-decoration: none;
        }
        .login-container .forgot-contrasena a:hover {
            text-decoration: underline;
        }
         /* Fondo oscuro semitransparente */
         .fondo-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        /* Contenedor del mensaje modal con estilo moderno */
        .modal-alerta {
            background: linear-gradient(135deg, #ffffff, #f3f3f3);
            padding: 30px;
            width: 90%;
            max-width: 500px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            text-align: center;
            font-size: 1.2em;
            color: #333;
            position: relative;
            animation: fadeIn 0.4s ease;
        }

        /* Animación de entrada */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Botón de cerrar con estilo moderno */
        .modal-alerta button {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #ff5e5e;
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            font-size: 1.2em;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        /* Hover en el botón de cerrar */
        .modal-alerta button:hover {
            background: #ff2e2e;
        }

        /* Estilo del mensaje de alerta */
        .mensaje-texto {
            margin: 20px 0;
            font-weight: 500;
            color: #333;
        }
        
        /* Botón adicional dentro del modal */
        .btn-modal {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            margin-top: 15px;
            transition: background 0.3s ease;
        }

        .btn-modal:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Iniciar Sesión</h2>

    <form action="login_process.php" method="POST">
        <label for="correo_electronico">correo electrónico:</label>
        <input type="correo_electronico" id="correo_electronico" name="correo_electronico" required>

        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required> <!-- Aquí se cambia a type="password" -->

        <button type="submit">Iniciar sesión</button>
    </form>
</div>
<script>
    // Función para cerrar el modal al hacer clic en el botón "×"
    function cerrarModal() {
        document.getElementById('modalAlerta').style.display = 'none';
    }

    // Cerrar automáticamente el modal después de 5 segundos
    setTimeout(cerrarModal, 5000);
</script>
</body>
</html>
