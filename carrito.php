<?php
session_start();
require 'conexionPDO.php';


if (!isset($_SESSION['id_cliente'])) {
    header("Location: Login.html");
    exit();
}


if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $accion = $_POST['accion'];
    $producto_id = isset($_POST['producto_id']) ? (int)$_POST['producto_id'] : null;
    $cantidad = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : 1;

    switch ($accion) {
        case 'agregar':
            if ($producto_id) {

                if (isset($_SESSION['carrito'][$producto_id])) {
                    $_SESSION['carrito'][$producto_id] += $cantidad;
                } else {
                    $_SESSION['carrito'][$producto_id] = $cantidad;
                }
            }
            break;
        case 'eliminar':
            if ($producto_id && isset($_SESSION['carrito'][$producto_id])) {
                unset($_SESSION['carrito'][$producto_id]);
            }
            break;
        case 'actualizar':
            if ($producto_id && isset($_SESSION['carrito'][$producto_id])) {
                if ($cantidad > 0) {
                    $_SESSION['carrito'][$producto_id] = $cantidad;
                } else {
                    unset($_SESSION['carrito'][$producto_id]);
                }
            }
            break;
        case 'vaciar':

            $_SESSION['carrito'] = [];
            break;
    }
}


$productos_carrito = [];
if (!empty($_SESSION['carrito'])) {
    $ids = implode(",", array_keys($_SESSION['carrito']));
    $sql = "SELECT * FROM productos WHERE id_producto IN ($ids)";
    $stmt = $conexionPDO->prepare($sql);
    $stmt->execute();
    $productos_carrito = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="EstilosMenu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
    <title>Carrito de Compras</title>

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
        button {
            background-color: #ff9933; 
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #e68a00; 
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #f9f9f9;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 15px;
            text-align: center;
        }

        th {
            background-color: #0073e6;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

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
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
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
            <li><a href="MenuPrincipal.php">Inicio</a></li>
            <li><a href="#">Ofertas</a></li>
            <li><a href="#">Nuevos lanzamientos</a></li>
            <li><a href="#">Consolas y accesorios</a></li>

        </ul>
        <div class="search-bar">
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

<div class="products">
    <h1 style="margin-bottom: 20px; text-align: center; color: white">Carrito de Compras</h1>
    <?php if (empty($productos_carrito)): ?>
        <p style="margin-top: 35px; text-align: center; color: white">Tu carrito está vacío.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                <?php foreach ($productos_carrito as $producto): ?>
                    <?php
                    $id = $producto['id_producto'];
                    $cantidad = $_SESSION['carrito'][$id];
                    $subtotal = $producto['precio'] * $cantidad;
                    $total += $subtotal;
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($producto['descripcion']); ?></td>
                        <td>$<?php echo number_format($producto['precio'], 2); ?></td>
                        <td>
                            <form action="carrito.php" method="POST" style="display:inline;">
                                <input type="hidden" name="producto_id" value="<?php echo $id; ?>">
                                <input type="hidden" name="accion" value="actualizar">
                                <input type="number" name="cantidad" value="<?php echo $cantidad; ?>" min="1" style="width: 50px;">
                                <button type="submit">Actualizar</button>
                            </form>
                        </td>
                        <td>$<?php echo number_format($subtotal, 2); ?></td>
                        <td>
                            <form action="carrito.php" method="POST" style="display:inline;">
                                <input type="hidden" name="producto_id" value="<?php echo $id; ?>">
                                <input type="hidden" name="accion" value="eliminar">
                                <button type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h2>Total: $<?php echo number_format($total, 2); ?></h2>
        <form action="carrito.php" method="POST">
            <input type="hidden" name="accion" value="vaciar">
            <button type="submit" style="background-color: #ff4d4d; color: white; padding: 15px; border-radius: 5px; cursor: pointer;">Vaciar Carrito</button>
        </form>
        <form action="checkout.php" method="POST">
            <button type="submit" style="background-color: #28a745; color: white; padding: 15px; border-radius: 5px; cursor: pointer;">Proceder al Pago</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
