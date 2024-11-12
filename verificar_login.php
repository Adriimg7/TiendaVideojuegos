<?php
session_start();
require 'conexionPDO.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM clientes WHERE email = :email";
    $stmt = $conexionPDO->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($password, $cliente['password'])) {
            // Iniciar sesión
            $_SESSION['id_cliente'] = $cliente['id_cliente'];
            $_SESSION['nombre'] = $cliente['nombre'];
            $_SESSION['email'] = $cliente['email'];

            // Prefijo único para las cookies basadas en el ID de cliente
            $cookiePrefix = 'user_' . $cliente['id_cliente'];

            // Manejo de cookies específicas para cada usuario
            $ultimoAcceso = isset($_COOKIE[$cookiePrefix . '_ultimo_acceso']) ? $_COOKIE[$cookiePrefix . '_ultimo_acceso'] : 'Primera vez que ingresas';
            $numAccesos = isset($_COOKIE[$cookiePrefix . '_num_accesos']) ? $_COOKIE[$cookiePrefix . '_num_accesos'] + 1 : 1;

            // Establecer las cookies con el prefijo específico del usuario
            setcookie($cookiePrefix . '_ultimo_acceso', date("Y-m-d H:i:s"), time() + (86400 * 30), "/");
            setcookie($cookiePrefix . '_num_accesos', $numAccesos, time() + (86400 * 30), "/");

            // Redirigir al menú principal
            header("Location: MenuPrincipal.php");
            exit();
        } else {
            // Contraseña incorrecta
            echo "<script>alert('Contraseña incorrecta.'); window.location.href='Login.html';</script>";
        }
    } else {
        // Usuario no encontrado
        echo "<script>alert('El usuario con el email ingresado no existe.'); window.location.href='Login.html';</script>";
    }
}
?>
