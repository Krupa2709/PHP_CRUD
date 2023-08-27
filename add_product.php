<?php
    include('connection.php');
    session_start();

    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit();
    }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $category = $_POST["category"];
    $price = $_POST["price"];
    $status = $_POST["status"];

    // Image Upload
    $image_dir = "uploads/"; 
    $image_name = $_FILES["image"]["name"];
    $image_tmp = $_FILES["image"]["tmp_name"];
    $image_path = $image_dir . $image_name;

    if (move_uploaded_file($image_tmp, $image_path)) { // store image in uploads folder and save path in the db
    } else {
        echo "Image upload failed.";
    }

    $query = "INSERT INTO products (name, description, category, price, status, image) VALUES ('$name', '$description', '$category', '$price', '$status', '$image_path')";
    if ($conn->query($query) === TRUE) {
        header("Location: product_listing.php");
        exit;
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-3" style="text-align: center;">Add Product</h2>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4"></textarea>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select name="category" class="form-control form-select" id="category">
                        <?php
                        $query = "SELECT * FROM categories WHERE status = 'Active' and deleted is null";
                        $result = $conn->query($query);

                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
                        }
                        $conn->close();
                        ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control form-select" id="status" name="status">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>
            <div style="text-align:center;">
                <button type="submit" class="btn btn-primary">Add Product</button>
                <a href="product_listing.php" class="btn btn-primary mb-3" style="float: right">Back</a>
            </div>
        </form>
    </div>
</body>
</html>
