<?php
include('connection.php');
 session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $category_id = $_GET["id"];
    $query = "SELECT * FROM categories WHERE id = $category_id";
    $result = $conn->query($query);
    $category = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_id = $_POST["id"];
    $name = $_POST["name"];
    $status = $_POST["status"];

    $query = "UPDATE categories SET name = '$name', status = '$status' WHERE id = $category_id";
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
    <title>Edit Category</title>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-3" style="text-align: center;">Edit Category</h2>
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $category['name']; ?>">
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control form-select" id="status" name="status">
                    <option value="Active" <?php if ($category['status'] == 'Active') echo 'selected'; ?>>Active</option>
                    <option value="Inactive" <?php if ($category['status'] == 'Inactive') echo 'selected'; ?>>Inactive</option>
                </select>
            </div>
            <div style="text-align:center;">    
                <button type="submit" class="btn btn-primary">Update Category</button>
                <a href="category_manager.php" class="btn btn-primary mb-3" style="float: right">Back</a>
            </div>
        </form>
    </div>
</body>
</html>
