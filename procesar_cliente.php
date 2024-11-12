<?php
// Incluimos el archivo de conexión a la base de datos
require 'conexionPDO.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recolectar y sanitizar los datos del formulario
    $nombre = htmlspecialchars($_POST['nombre']);
    $apellido = htmlspecialchars($_POST['apellido']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password']; // Contraseña sin hash, introducida por el usuario
    $direccion = isset($_POST['direccion']) ? htmlspecialchars($_POST['direccion']) : null;
    $telefono = isset($_POST['telefono']) ? htmlspecialchars($_POST['telefono']) : null;

    // Hashear la contraseña antes de almacenarla en la base de datos
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Insertar los datos en la base de datos
        $sql = "INSERT INTO clientes (nombre, apellido, email, password, direccion, telefono)
                VALUES (:nombre, :apellido, :email, :password, :direccion, :telefono)";
        $stmt = $conexionPDO->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);  // Guardar el hash de la contraseña
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':telefono', $telefono);

        $stmt->execute();
        
        // Redirigir al usuario a MenuPrincipal.php después de un registro exitoso
        header('Location: MenuPrincipal.php');
        exit(); // Detener la ejecución del script después de la redirección
    } catch (Exception $e) {
        echo "Error al registrar el cliente: " . $e->getMessage();
    }
}
?>
