// Elementos del DOM
const loader = document.querySelector('#loader');
const formNewBook = document.querySelector("#formNewBook");
const updateForm = document.querySelector("#updateForm");
const tableBody = document.querySelector('#bookList');
const urlParams = new URLSearchParams(window.location.search);

// URL del controlador BookController
const apiUrl = 'http://localhost/crud_biblioteca_emanueloverlay/app/controllers/BookController.php';
const updateUrl = 'http://localhost/crud_biblioteca_emanueloverlay/public/views/updateBook.php';

// Función para mostrar el loader
function showLoader() {
    loader.style.display = 'block';
}

// Función para ocultar el loader
function hideLoader() {
    loader.style.display = 'none';
}

// Función async para obtener todos los libros y retornarlos en un array.
async function getAllBooks() {
    try {
        showLoader();
        const response = await fetch(apiUrl + '?function=allBooks');
        const data = await response.json();
        hideLoader();
        return data;
    } catch (error) {
        loader.style.display = 'none';
        console.error('Error al obtener los libros:', error);
    }
}

// Función para mostrar los libros en la tabla
function displayBooks(books) {
    tableBody.innerHTML = '';

    books.forEach(book => {
        const row = `<tr>
            <td>${book.id}</td>
            <td>${book.nombre}</td>
            <td>${book.fecha}</td>
            <td>$ ${book.precio}</td>
            <td>
                <a href="${updateUrl}?idBook=${book.id}" class="info">Modificar</a>
                <button onclick="deleteBook(${book.id})" class="danger">Eliminar</button>
            </td>
        </tr>`;
        tableBody.innerHTML += row;
    });
}

// Función async para cargar los libros y enviarlos al displayBooks
async function loadBooks() {
    try {
        const books = await getAllBooks();
        displayBooks(books);
    } catch (error) {
        console.error('Error al cargar los libros:', error);
    }
}

// Función async para solicitar el listado de libros y ordenarlos por fecha.
async function sortBooksByDate() {
    try {
        const books = await getAllBooks();
        const sortedBooks = books.sort((a, b) => new Date(a.fecha) - new Date(b.fecha));
        displayBooks(sortedBooks);

    } catch (error) {
        console.error('Error al ordenar los libros por fecha:', error);
    }
}

// Función async para solicitar el listado de libros ordenados por precio desde consulta PHP
async function sortBooksByPrice() {
    try {
        showLoader();
        const response = await fetch(apiUrl + '?function=allBooksPerPrice');
        const data = await response.json();
        displayBooks(data);
        hideLoader();
    } catch (error) {
        hideLoader();
        console.error('Error al obtener los libros:', error);
    }
}

// Función async para guardar un libro
async function saveBook() {
    const formData = new FormData(formNewBook);
    try {
        showLoader();
        const response = await fetch(apiUrl + '?function=saveBook', {
            method: 'POST',
            body: formData
        });
        const data = await response.json();
        hideLoader();
        data.error ? alert(data.error) : alert(data.message)
        location.href = 'index.php';
    } catch (error) {
        hideLoader();
        console.error('Error al guardar el libro:', error);
    }
}

// Función async para eliminar un libro con confirmación previa
async function deleteBook(id) {
    const confirmDelete = confirm("¿Estás seguro de que deseas eliminar este libro?");
    if (!confirmDelete) {
        return; // Si el usuario cancela, no se realiza la eliminación
    }
    try {
        showLoader();
        const response = await fetch(apiUrl + `?function=deleteBook&id=${id}`, {
            method: 'DELETE'
        });
        const data = await response.json();
        hideLoader();
        data.error ? alert(data.error) : alert(data.message)
    } catch (error) {
        hideLoader();
        console.error('Error:', error);
    }

    loadBooks();
}

// Función async para obtener un libro por ID.
async function getBook(idBook) {
    const idBookData = new FormData();
    idBookData.append('idBook', idBook)
    try {
        showLoader();
        const response = await fetch(apiUrl + '?function=findBook',
            {
                method: 'POST',
                body: idBookData
            }
        );
        const data = await response.json();
        hideLoader();
        return data;
    } catch (error) {
        hideLoader();
        console.error('Error al obtener los libros:', error);
    }
}

// Función para procesar la actualización de un libro específico.
async function processBookUpdate() {
    const idBook = urlParams.get('idBook');
    const nombre = document.querySelector("#nombre");
    const fecha = document.querySelector("#fecha");
    const precio = document.querySelector("#precio");
    const idBookPrint = document.querySelector("#idBook");
    idBookPrint.innerHTML = idBook;
    book = await getBook(idBook);
    if (book) {
        nombre.value = book.nombre;
        fecha.value = book.fecha;
        precio.value = book.precio;
    } else {
        alert("Error, libro no encontrado.")
    }
}

// Función async para actualizar un libro
async function updateBook() {
    const formData = new FormData(updateForm);
    const idBookPrint = document.querySelector("#idBook");
    formData.append('id', idBookPrint.innerText)
    try {
        showLoader();
        const response = await fetch(apiUrl + '?function=updateBook', {
            method: 'POST',
            body: formData
        });
        const data = await response.json();
        hideLoader();
        data.error ? alert(data.error) : alert(data.message)
        location.href = 'index.php';
    } catch (error) {
        hideLoader();
        console.error('Error:', error);
    }
}

// Inicialización de eventos
if (document.querySelector("#formNewBook") != null) {
    formNewBook.onsubmit = function (e) {
        e.preventDefault();
        saveBook()
    }
}

if (urlParams.get('idBook')) {
    processBookUpdate();
    updateForm.onsubmit = function (e) {
        e.preventDefault();
        updateBook();
    }
}

if (document.querySelector('#bookList') != null) {
    loadBooks();
}