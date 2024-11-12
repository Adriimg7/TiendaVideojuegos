<?php
require 'conexionPDO.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = htmlentities(addslashes($_POST['nombre']));
    $descripcion = htmlentities(addslashes($_POST['descripcion']));
    $precio = filter_var($_POST['precio'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $stock = filter_var($_POST['stock'], FILTER_SANITIZE_NUMBER_INT);
    $categoria = htmlentities(addslashes($_POST['categoria']));
    $fecha_lanzamiento = $_POST['fecha_lanzamiento'];

    $sql = "INSERT INTO productos (nombre, descripcion, precio, stock, categoria, fecha_lanzamiento)
            VALUES (:nombre, :descripcion, :precio, :stock, :categoria, :fecha_lanzamiento)";
    $stmt = $conexionPDO->prepare($sql);
    $stmt->execute([
        ':nombre' => $nombre,
        ':descripcion' => $descripcion,
        ':precio' => $precio,
        ':stock' => $stock,
        ':categoria' => $categoria,
        ':fecha_lanzamiento' => $fecha_lanzamiento
    ]);

    echo "Producto registrado con éxito.";
}
?>
