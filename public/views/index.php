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

        <button onclick="sortBooksByDate()" class="success">Ordenar por Fecha usando JS</button>
        <br>
        <button onclick="sortBooksByPrice()" class="warning">Ordenar por Precio usando PHP</button>

        <h1>Listado de registros</h1>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Fecha</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="bookList">
            </tbody>
        </table>
    </div>

    <script src="../assets/js/main.js"></script>
</body>

</html>