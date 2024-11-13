<?php
session_start();
if (!isset($_SESSION['id_cliente'])) {
    header("Location: Login.html");
    exit();
}

$cookiePrefix = 'user_' . $_SESSION['id_cliente'];

$ultimoAcceso = isset($_COOKIE[$cookiePrefix . '_ultimo_acceso']) ? $_COOKIE[$cookiePrefix . '_ultimo_acceso'] : 'Primera vez que ingresas';
$numAccesos = isset($_COOKIE[$cookiePrefix . '_num_accesos']) ? $_COOKIE[$cookiePrefix . '_num_accesos'] : 1;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="EstilosMenu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
    <title>Menú Principal</title>

    <script>
        function openModal() {
            document.getElementById('modalOverlay').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('modalOverlay').style.display = 'none';
        }

        function confirmLogout() {
            window.location.href = 'logout.php';
        }
    </script>

    <style> 
    /* El modal no lo detecta en el css */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        justify-content: center;
        align-items: center;
    }
    .modal {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
        max-width: 300px;
        width: 100%;
    }
    .modal h3 {
        margin-top: 0;
    }
    .modal button {
        margin: 10px 5px;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: box-shadow 0.3s ease;
    }
    .modal button:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); /* Sombra de hover solo en los botones del modal */
    }
    .modal .confirm-btn {
        background-color: #0073e6;
        color: white;
    }
    .modal .cancel-btn {
        background-color: #ff4d4d;
        color: white;
    }
    </style>
</head>

<body>

<header>
    <nav>
        <a href="MenuPrincipal.php" class="logo">CE Videojuegos <i class="fa-solid fa-gamepad"></i></a>
        <ul class="menu">
            <li><a href="#">Inicio</a></li>
            <li><a href="#">Ofertas</a></li>
            <li><a href="#">Nuevos lanzamientos</a></li>
            <li><a href="#">Consolas y accesorios</a></li>
            
        </ul>
        <div class="search-bar">
            <a href="carrito.php" class="cart-icon">🛒 Carrito (<?php echo array_sum(isset($_SESSION['carrito']) ? $_SESSION['carrito'] : []); ?>)</a>
            
            <form action="" method="GET" style="display: inline;">
        <input type="text" name="busqueda" placeholder="Buscar..." autocomplete="off" style="margin-left: 10px;" value="<?php echo isset($_GET['busqueda']) ? htmlspecialchars($_GET['busqueda']) : ''; ?>">
        <button type="submit">Buscar <i class="fa-solid fa-binoculars"></i></button>
    </form>

            <button onclick="openModal()" style="background-color: #ff4d4d; color: white; margin-left: 5px;"> Salir<i class="fa-solid fa-door-open"></i></button>
        </div>
    </nav>
</header>

<!-- MODAL -->
<div class="modal-overlay" id="modalOverlay" style="display: none;">
    <div class="modal">
        <h3>¿Deseas cerrar sesión?</h3>
        <button class="confirm-btn" onclick="confirmLogout()">Sí</button>
        <button class="cancel-btn" onclick="closeModal()">No</button>
    </div>
</div>

<div style="text-align: center; color: white">
    <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?>!</h1>
    <p>Último acceso: <?php echo htmlspecialchars($ultimoAcceso); ?></p>
    <p>Has accedido <?php echo htmlspecialchars($numAccesos); ?> veces.</p>
</div>

<div class="products">
    <?php
    require 'conexionPDO.php';

    // Verifica si hay un término de búsqueda
    $busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';

    // Modifica la consulta SQL para que incluya la búsqueda
    $sql = "SELECT * FROM productos";
    if (!empty($busqueda)) {
        $sql .= " WHERE nombre LIKE :busqueda";
    }
    $stmt = $conexionPDO->prepare($sql);

    // Si hay una búsqueda, enlaza el parámetro con el valor de búsqueda
    if (!empty($busqueda)) {
        $stmt->bindValue(':busqueda', '%' . $busqueda . '%', PDO::PARAM_STR);
    }

    $stmt->execute();
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($productos as $producto) {
        echo "<div class='product'>";
        
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

        echo "<h4>" . htmlspecialchars($producto['nombre']) . "</h4>";
        echo "<p>" . htmlspecialchars($producto['descripcion']) . "</p>";
        echo "<p class='price'>$" . number_format($producto['precio'], 2) . "</p>";
        echo "<form action='carrito.php' method='POST' style='display:inline;'>";
        echo "<input type='hidden' name='producto_id' value='" . $producto['id_producto'] . "'>";
        echo "<input type='hidden' name='accion' value='agregar'>";
        echo "<input type='number' name='cantidad' value='1' min='1' style='width: 50px;'>";
        echo "<button type='submit'>Agregar al carrito</button>";
        echo "</form>";
        echo "<button style='background-color: #00d800;'>Comprar ya</button>";
        echo "</div>";
    }
    ?>
</div>

</body>
</html>