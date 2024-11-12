<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="EstilosMenu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
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
    <h1 style="color: white;">Productos disponibles</h1>
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
