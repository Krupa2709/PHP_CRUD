<?php
include('connection.php');
 session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $category_id = $_GET["id"];
    //soft delete
    $query = "UPDATE categories SET deleted = 1 WHERE id = $category_id";
    if ($conn->query($query) === TRUE) {
        header("Location: category_manager.php");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>
