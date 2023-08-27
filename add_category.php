<?php
include('connection.php');
 session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $status = $_POST["status"];

    $query = "INSERT INTO categories (name, status) VALUES ('$name', '$status')";
    if ($conn->query($query) === TRUE) {
        header("Location: category_manager.php");
        exit;
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Category</title>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-3" style="text-align: center;">Add Category</h2>
        <form action="" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control form-select" id="status" name="status">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>
            <div style="text-align:center;">
                <button type="submit" class="btn btn-primary">Add Category</button>
                <a href="category_manager.php" class="btn btn-primary mb-3" style="float: right">Back</a>
            </div>
        </form>
    </div>
</body>
</html>
