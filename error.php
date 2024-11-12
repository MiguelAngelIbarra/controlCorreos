<?php
session_start();


if (isset($_SESSION['mensaje_alerta_fin'])) 
{
    echo "
    <div class='fondo-modal' id='modalAlerta'>
        <div class='modal-alerta'>
            <button class='cerrar' onclick='cerrarModal()'>×</button>
            <h2>¡Atención!</h2>
            <p>{$_SESSION['mensaje_alerta_fin']}</p>
            <button class='aceptar' onclick='aceptar()'>Aceptar</button>
        </div>
    </div>";

    unset($_SESSION['mensaje_alerta_fin']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alerta Modal</title>
    <style>
        /* Fondo de la ventana modal */
        .fondo-modal 
        {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        /* Estilo de la alerta modal */
        .modal-alerta 
        {
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

        /* Título */
        .modal-alerta h2 
        {
            /*font-size: 24px;
            margin-bottom: 10px;
            color: #333;*/
            margin: 20px 0;
            font-weight: 500;
            color: #333;
        }
        .modal-alerta p 
        {
            margin: 20px 0;
            font-weight: 500;
            color: #333;
        }

        .cerrar {
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

        
        .aceptar {
            margin-top: 20px;
            padding: 10px 20px;
            background: #4CAF50;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .aceptar:hover {
            background: #45a049;
        }

        /* Animación del modal */
        @keyframes zoomIn {
            from { transform: scale(0.7); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
    </style>
</head>
<body>

<script>
    function cerrarModal() {
        document.getElementById('modalAlerta').style.display = 'none';
    }

    function aceptar() {
        cerrarModal();
        window.location.href = 'index.php';  // Cambia 'index.php' por la URL deseada
    }
</script>

</body>
</html>
