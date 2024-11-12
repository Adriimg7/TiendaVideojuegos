<?php
// Incluimos el archivo de conexión a la base de datos
require 'conexionPDO.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitizar y recoger las credenciales
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password']; // Contraseña sin hash, introducida por el usuario

    // Consulta para seleccionar el cliente por email
    $sql = "SELECT * FROM clientes WHERE email = :email";
    $stmt = $conexionPDO->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    // Verificamos si el usuario existe
    if ($stmt->rowCount() > 0) {
        // Obtenemos el registro del cliente
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificamos la contraseña introducida contra el hash almacenado
        if (password_verify($password, $cliente['password'])) {
            // Si la contraseña es correcta, iniciamos la sesión
            session_start();
            $_SESSION['id_cliente'] = $cliente['id_cliente'];
            $_SESSION['nombre'] = $cliente['nombre'];
            $_SESSION['email'] = $cliente['email'];

            // Redirigimos al menú principal o a la página de bienvenida
            header("Location: MenuPrincipal.php");
            exit();
        } else {
            // Contraseña incorrecta
            echo "Contraseña incorrecta.";
        }
    } else {
        // Usuario no encontrado
        echo "El usuario con el email ingresado no existe.";
    }
}
?>
