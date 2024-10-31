<?php
// Database connection settings
$host = 'localhost'; // Database host
$db = 'library'; // Database name
$user = 'root'; // Database username
$pass = ''; // Database password

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // CRUD Operations
    // Create a new book
    function createBook($title, $author, $published_year, $genre) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO books (title, author, published_year, genre) VALUES (:title, :author, :published_year, :genre)");
        return $stmt->execute([':title' => $title, ':author' => $author, ':published_year' => $published_year, ':genre' => $genre]);
    }

    // Read all books
    function readBooks() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM books");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update a book's details
    function updateBook($id, $title) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE books SET title = :title WHERE id = :id");
        return $stmt->execute([':title' => $title, ':id' => $id]);
    }

    // Delete a book
    function deleteBook($id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM books WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    // Example usage
    createBook('The Great Gatsby', 'F. Scott Fitzgerald', 1925, 'Novel');
    $books = readBooks();

    echo "Books in the library:\n";
    foreach ($books as $book) {
        echo "ID: {$book['id']}, Title: {$book['title']}, Author: {$book['author']}, Year: {$book['published_year']}, Genre: {$book['genre']}\n";
    }

    // Update a book (assuming the book with ID 1 exists)
    updateBook(1, 'The Great Gatsby - Updated');

    // Delete a book (assuming the book with ID 1 exists)
    deleteBook(1);

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
