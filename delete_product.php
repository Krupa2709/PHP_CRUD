<?php
    include('connection.php');
    session_start();

    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit();
    }

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $product_id = $_GET["id"];
    //soft delete
    $query = "UPDATE products SET deleted = 1 WHERE id = $product_id";
    if ($conn->query($query) === TRUE) {
        header("Location: product_listing.php");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>
