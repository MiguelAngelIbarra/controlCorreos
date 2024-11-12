<?php
session_start();
include 'config.php';

function log_error($message) {
    $log_file = 'D:\xampp\htdocs\Seguridad\error_log.txt';
    $timestamp = date("Y-m-d H:i:s");
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $log_message = "[$timestamp] - $ip_address - $message\n";
    file_put_contents($log_file, $log_message, FILE_APPEND);
}

if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['correo']) && isset($_POST['nuevo_estatus'])) {
    $correo = $_POST['correo'];
    $nuevo_estatus = $_POST['nuevo_estatus'];
    $stmt = $pdo->prepare("UPDATE correos_bloqueados SET estatus = :nuevo_estatus WHERE correo_electronico = :correo");
    $stmt->execute(['nuevo_estatus' => $nuevo_estatus, 'correo' => $correo]);
    log_error(message: "El estatus de $correo ha sido actualizado a $nuevo_estatus.");
    header("Location: adminCorreo.php");
    exit();
}

$stmt = $pdo->prepare("SELECT correo_electronico, estatus FROM correos_bloqueados");
$stmt->execute();
$correos_bloqueados = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administrador</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        h1, h2 {
            color: #4a90e2;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: #fff;
        }
        .logout-button {
            background-color: #e74c3c;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }
        .logout-button:hover {
            background-color: #c0392b;
        }
        form {
            margin-top: 20px;
        }
        select, button {
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
        }
        button {
            background-color: #4a90e2;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #357abd;
        }
    </style>
</head>
<body>
    <div class="container">

        <?php
        if (isset($_SESSION['mensaje'])) {
            echo "<p>{$_SESSION['mensaje']}</p>";
            unset($_SESSION['mensaje']);
        }
        ?>

        <h2>Lista de Correos Bloqueados</h2>
        <table>
            <thead>
                <tr>
                    <th>Correo Electrónico</th>
                    <th>Estatus</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($correos_bloqueados as $correo): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($correo['correo_electronico']); ?></td>
                        <td><?php echo htmlspecialchars($correo['estatus']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Cambiar Estatus de un Correo</h2>
        <form method="POST" action="adminCorreo.php">
            <label for="correo">Correo Electrónico:</label>
            <select name="correo" id="correo" required>
                <?php foreach ($correos_bloqueados as $correo): ?>
                    <option value="<?php echo htmlspecialchars($correo['correo_electronico']); ?>">
                        <?php echo htmlspecialchars($correo['correo_electronico']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="nuevo_estatus">Nuevo Estatus:</label>
            <select name="nuevo_estatus" id="nuevo_estatus" required>
                <option value="activo">Activo</option>
            </select>

            <button type="submit">Actualizar Estatus</button>
        </form>

        <a href="index.php" class="logout-button">Cerrar Sesión</a>
    </div>
</body>
</html>
