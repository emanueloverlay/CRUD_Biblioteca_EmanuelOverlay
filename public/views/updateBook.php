<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu librero - Libreria virtual</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <header>
        <nav>
            <ul>
                <li>
                    <a href="index.php">Listar Libros</a>
                </li>
                <li>
                    <a href="insertBook.php">Agregar Libro</a>
                </li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div id="loader" class="loader" style="display: none;"></div>


        <h1>Actualización de registro</h1>

        <h3 id="idBook"></h3>

        <form id="updateForm">
            <div class="formGroup">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>

            <div class="formGroup">
                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" value="<?php echo date("Y-m-d"); ?>" required>
            </div>

            <div class="formGroup">
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" required>
            </div>

            <button type="submit" class="success">Actualizar Libro</button>
        </form>

    </div>

    <script src="../assets/js/main.js"></script>
</body>

</html>