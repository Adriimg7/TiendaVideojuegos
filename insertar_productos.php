<?php
require 'conexionPDO.php';

$sql = "INSERT INTO productos (nombre, descripcion, precio, stock, categoria, fecha_lanzamiento) VALUES (:nombre, :descripcion, :precio, :stock, :categoria, :fecha_lanzamiento)";
$stmt = $conexionPDO->prepare($sql);

$productos = [
    [
        'nombre' => 'God Of War', 
        'descripcion' => 'Aventura épica en mundos fantásticos', 
        'precio' => 70, 
        'stock' => 50, 
        'categoria' => 'Aventura', 
        'fecha_lanzamiento' => '2024-01-15'
    ],
    [
        'nombre' => 'Battlefield V', 
        'descripcion' => 'Acción intensa en cada batalla', 
        'precio' => 39.99, 
        'stock' => 30, 
        'categoria' => 'Acción', 
        'fecha_lanzamiento' => '2024-03-10'
    ],
    [
        'nombre' => 'Forza Horizon 4', 
        'descripcion' => 'Corre en las pistas más desafiantes', 
        'precio' => 29.99, 
        'stock' => 40, 
        'categoria' => 'Carreras', 
        'fecha_lanzamiento' => '2024-05-20'
    ],
    [
        'nombre' => 'Mario Kart 8', 
        'descripcion' => 'Corre con Mario y sus amigos', 
        'precio' => 40, 
        'stock' => 40, 
        'categoria' => 'Carreras', 
        'fecha_lanzamiento' => '2024-05-20'
    ],
    [
        'nombre' => 'EAFC-25', 
        'descripcion' => 'Demuestra lo que vales en cada partido', 
        'precio' => 70, 
        'stock' => 40, 
        'categoria' => 'Deportes', 
        'fecha_lanzamiento' => '2024-05-20'
    ],
    [
        'nombre' => 'Los Simpsons', 
        'descripcion' => 'Juega aventuras como en la serie animada', 
        'precio' => 10, 
        'stock' => 40, 
        'categoria' => 'Acción', 
        'fecha_lanzamiento' => '2024-05-20'
    ],
    [
        'nombre' => 'Minecraft', 
        'descripcion' => 'Sobrevive o muere', 
        'precio' => 15, 
        'stock' => 40, 
        'categoria' => 'Acción', 
        'fecha_lanzamiento' => '2024-05-20'
    ]
];

foreach ($productos as $producto) {
    $stmt->execute([
        ':nombre' => $producto['nombre'],
        ':descripcion' => $producto['descripcion'],
        ':precio' => $producto['precio'],
        ':stock' => $producto['stock'],
        ':categoria' => $producto['categoria'],
        ':fecha_lanzamiento' => $producto['fecha_lanzamiento']
    ]);
}

echo "Productos insertados exitosamente.";
?>
