<?php

require_once "../models/Book.php";

// Funciones permitidas para el controlador
$allowedFunctions = ["findBook", "allBooks", "saveBook", "updateBook", "deleteBook", "allBooksPerPrice"];

if (isset($_GET['function']) && in_array($_GET['function'], $allowedFunctions)) {

    // Crear una instancia del controlador de BookController
    $book = new BookController();

    switch ($_GET['function']) {
        case "findBook":
            $book->findBook();
            break;
        case "allBooks":
            $book->showBooks();
            break;
        case "saveBook":
            $book->saveBook();
            break;
        case "updateBook":
            $book->updateBook();
            break;
        case "deleteBook":
            $book->deleteBook();
            break;
        case "allBooksPerPrice":
            $book->showBooksPerPrice();
            break;
    }
} else {
    echo "Función no válida";
}

class BookController
{

    /**
     * Busca un libro por su ID e imprime los datos en formato JSON.
     * En caso de que no se encuentre un libro, se imprimirá un mensaje de error.
     * @return void
     */
    public function findBook()
    {
        if (!isset($_POST['idBook'])) {
            echo json_encode(['error' => 'No se encontró un ID para su búsqueda.']);
            return;
        }
        $id = $_POST['idBook'];
        $book = Book::findBook($id);
        echo json_encode($book);
    }

    /**
     * Obtiene todos los libros y los imprime en formato JSON.
     * En caso de que no se encuentren libros, se imprimirá un mensaje de error.
     *
     * @return void
     */
    public function showBooksPerPrice()
    {
        $listBooks = Book::showBooksPerPrice();
        echo json_encode($listBooks);
    }

    /**
     * Obtiene todos los libros ORDENADOS POR PRECIO y los imprime en formato JSON.
     * En caso de que no se encuentren libros, se imprimirá un mensaje de error.
     *
     * @return void
     */
    public function showBooks()
    {
        $listBooks = Book::showBooks();
        echo json_encode($listBooks);
    }

    /**
     * Guarda un nuevo libro e imprime un mensaje JSON de éxito o error.
     * @return void
     */
    public function saveBook()
    {
        $nombre = $_POST['nombre'] ?? '';
        $fecha = $_POST['fecha'] ?? '';
        $precio = $_POST['precio'] ?? '';

        $newBook = new Book($nombre, $fecha, $precio);
        $result = $newBook->saveBook();

        if ($result) {
           $msg = ['message' => 'Libro guardado correctamente'];
        } else {
           $msg = ['error' => 'Error al guardar el libro'];
        }

        echo json_encode($msg);
    }

    /**
     * Actualiza un libro e imprime un mensaje JSON de éxito o error.
     * @return void
     */
    public function updateBook()
    {
        if (!isset($_POST['id']) || empty($_POST['nombre']) || empty($_POST['fecha']) || empty($_POST['precio'])) {
            echo json_encode(['error' => 'ID o datos del libro no encontrados']);
            return;
        }

        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $fecha = $_POST['fecha'];
        $precio = $_POST['precio'];

        // Crear una instancia del libro con los datos actualizados
        $updatedBook = new Book($nombre, $fecha, $precio);
        $updatedBook->id = $id; // Asigna el ID al libro

        // Intenta actualizar el libro en la base de datos
        $result = $updatedBook->updateBook();

        if ($result) {
            $msg = ['message' => 'Libro actualizado correctamente'];
        } else {
            $msg = ['error' => 'Error al actualizar el libro'];
        }
        echo json_encode($msg);
    }

    /**
     * Elimina un libro por su ID e imprime un mensaje JSON de éxito o error.
     * @return void
     */
    public function deleteBook()
    {
        if (!isset($_GET['id'])) {
            echo json_encode(['error' => 'ID no proporcionado']);
            return;
        }

        $id = $_GET['id'];
        $result = Book::deleteBook($id);

        if ($result) {
            $msg = ['message' => 'Libro eliminado correctamente'];
        } else {
            $msg = ['error' => 'Error al eliminar el libro'];
        }

        echo json_encode($msg);
    }
}
