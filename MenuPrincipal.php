
<?php
session_start();
if (!isset($_SESSION['id_cliente'])) {
    header("Location: Login.html");
    exit();
}

// Prefijo único basado en el ID de cliente
$cookiePrefix = 'user_' . $_SESSION['id_cliente'];

$ultimoAcceso = isset($_COOKIE[$cookiePrefix . '_ultimo_acceso']) ? $_COOKIE[$cookiePrefix . '_ultimo_acceso'] : 'Primera vez que ingresas';
$numAccesos = isset($_COOKIE[$cookiePrefix . '_num_accesos']) ? $_COOKIE[$cookiePrefix . '_num_accesos'] : 1;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="EstilosMenu.css">
    <title>Menú Principal</title>
</head>
<body>

<header>
    <nav>
        <a href="#" class="logo">CE Videojuegos</a>
        <ul class="menu">
            <li><a href="#">Inicio</a></li>
            <li><a href="#">Ofertas</a></li>
            <li><a href="#">Nuevos lanzamientos</a></li>
            <li><a href="#">Consolas y accesorios</a></li>
        </ul>
        <div class="search-bar">
            <input type="text" placeholder="Buscar...">
            <button>Buscar</button>
            <a href="#" class="cart-icon">🛒 Carrito</a>
        </div>
    </nav>
</header>

<div style="text-align: center;">
    <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?>!</h1>
    <p>Último acceso: <?php echo htmlspecialchars($ultimoAcceso); ?></p>
    <p>Has accedido <?php echo htmlspecialchars($numAccesos); ?> veces.</p>
    <a href="logout.php" style="color: #f00; text-decoration: none;">Cerrar Sesión</a>
</div>


<div class="products">
    <?php
    require 'conexionPDO.php';

    // Consulta para obtener productos de la base de datos
    $sql = "SELECT * FROM productos";
    $stmt = $conexionPDO->prepare($sql);
    $stmt->execute();

    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($productos as $producto) {
        echo "<div class='product'>";
        
        // Asignar imagen estática según el nombre del producto
        switch ($producto['nombre']) {
            case 'God Of War':
                echo "<img src='./Imagenes/Juego1.jpg' width='160' height='200' alt='Imagen 1'>";
                break;
            case 'Battlefield V':
                echo "<img src='./Imagenes/battlefield.jpg' width='150' height='200' alt='Imagen 2'>";
                break;
            case 'Forza Horizon 4':
                echo "<img src='./Imagenes/fh.jpg' width='150' height='200' alt='Imagen 3'>";
                break;
            case 'Mario Kart 8':
                echo "<img src='./Imagenes/Mario.jpg' width='150' height='200' alt='Imagen 3'>";
                break;
            case 'Los Simpsons':
                echo "<img src='./Imagenes/the_simpsons_game.jpg' width='150' height='200' alt='Imagen 3'>";
                break;
            case 'Minecraft':
                echo "<img src='./Imagenes/minecraft.jpg' width='150' height='200' alt='Imagen 3'>";
                break;
            case 'EAFC-25':
                echo "<img src='./Imagenes/ea_sports_fc_25.jpg' width='150' height='200' alt='Imagen 3'>";
                break;
            default:
                echo "<img src='./Imagenes/default.jpg' width='150' height='200' alt='Imagen por defecto'>";
                break;
        }

        // Mostrar los datos del producto
        echo "<h4>" . htmlspecialchars($producto['nombre']) . "</h4>";
        echo "<p>" . htmlspecialchars($producto['descripcion']) . "</p>";
        echo "<p class='price'>$" . number_format($producto['precio'], 2) . "</p>";
        echo "<button>Agregar al carrito</button>";
        echo "<button style='background-color: #00d800;'>Comprar ya</button>";
        echo "</div>";
    }
    ?>
</div>

</body>
</html>
