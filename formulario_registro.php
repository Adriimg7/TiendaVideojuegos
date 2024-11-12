<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="EstilosFormularios.css">
    <title>Registro de Productos</title>
</head>
<body>
    <div class="form-container">
        <h1>Registrar un Producto</h1>
        <form action="procesar_registro.php" method="POST">
            <label for="nombre">Nombre del Producto:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" rows="4" required></textarea>

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" step="0.01" required>

            <label for="stock">Stock:</label>
            <input type="number" id="stock" name="stock" required>

            <label for="categoria">Categoría:</label>
            <input type="text" id="categoria" name="categoria" required>

            <label for="fecha_lanzamiento">Fecha de Lanzamiento:</label>
            <input type="date" id="fecha_lanzamiento" name="fecha_lanzamiento" required>

            <input type="submit" value="Registrar Producto">
            <input type="reset" value="Limpiar">
        </form>
    </div>
</body>
</html>
