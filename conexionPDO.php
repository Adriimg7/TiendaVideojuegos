<?php
try {
    $conexionPDO = new PDO("mysql:host=localhost;dbname=tienda;charset=utf8", "root", "");
    $conexionPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}
?>
