<?php

require_once "../core/Database.php";

class Book
{

    public $id;
    public $nombre;
    public $fecha;
    public $precio;
    public function __construct($nombre = "", $fecha = "", $precio = "")
    {
        $this->nombre = $nombre;
        $this->fecha = $fecha;
        $this->precio = $precio;
    }


    /**
     * Guarda un nuevo libro en la BD.
     * @return bool Retorna true si se pudo guardar correctamente, false en caso contrario.
     */
    public function saveBook()
    {
        $mysqli = Database::getInstanceDB();
        $stmt = $mysqli->prepare("INSERT INTO libro (nombre, fecha, precio) VALUES (?, ?, ?)");

        if (!$stmt) {
            throw new Exception('Error en la preparación de la consulta: ' . $mysqli->error);
        }

        $stmt->bind_param("sss", $this->nombre, $this->fecha, $this->precio);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }


    /**
     * Actualiza la información de un libro en la BD.
     * @return bool Retorna true si se pudo actualizar correctamente, false en caso contrario.
     */
    public function updateBook()
    {
        $mysqli = Database::getInstanceDB();
        $stmt = $mysqli->prepare("UPDATE libro SET nombre=?, fecha=?, precio=? WHERE id=?");

        if (!$stmt) {
            throw new Exception('Error en la preparación de la consulta: ' . $mysqli->error);
        }

        $stmt->bind_param("sssi", $this->nombre, $this->fecha, $this->precio, $this->id);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    /**
     * Elimina un libro de la BD.
     * @param int $id El ID del libro a eliminar.
     * @return bool Retorna true si se pudo eliminar correctamente, false en caso contrario.
     */
    public static function deleteBook($id)
    {
        $mysqli = Database::getInstanceDB();
        $stmt = $mysqli->prepare("DELETE FROM libro WHERE id=?");

        if (!$stmt) {
            throw new Exception('Error en la preparación de la consulta: ' . $mysqli->error);
        }

        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    /**
     * Busca un libro por su ID en la BD.
     * @param int $id El ID del libro a buscar.
     * @return array|null Retorna los datos del libro si se encontró, o null si no se encontró.
     */
    public static function findBook($id)
    {
        $mysqli = Database::getInstanceDB();
        $stmt = $mysqli->prepare("SELECT * FROM libro WHERE id=?");

        if (!$stmt) {
            throw new Exception('Error en la preparación de la consulta: ' . $mysqli->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $book = $result->fetch_assoc();
        $stmt->close();

        return $book;
    }

    /**
     * Obtiene todos los libros de la base de datos.
     * @return array|null Retorna todos los libros si se encontraron, o null si no se encontraron.
     */
    public static function showBooks()
    {
        $mysqli = Database::getInstanceDB();
        $stmt = $mysqli->prepare("SELECT * FROM libro");

        if (!$stmt) {
            throw new Exception('Error en la preparación de la consulta: ' . $mysqli->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $listBooks = [];

        if ($result) {
            while ($book = $result->fetch_assoc()) {
                $listBooks[] = $book;
            }
        }

        $stmt->close();
        return $listBooks;
    }

    /**
     * Obtiene todos los libros de la base de datos ORDENADOS POR PRECIO.
     * @return array|null Retorna todos los libros si se encontraron, o null si no se encontraron.
     */
    public static function showBooksPerPrice()
    {
        $mysqli = Database::getInstanceDB();
        $stmt = $mysqli->prepare("SELECT * FROM libro ORDER BY precio ASC");

        if (!$stmt) {
            throw new Exception('Error en la preparación de la consulta: ' . $mysqli->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $listBooks = [];

        if ($result) {
            while ($book = $result->fetch_assoc()) {
                $listBooks[] = $book;
            }
        }

        $stmt->close();
        return $listBooks;
    }
}
