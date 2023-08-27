<?php
    include('connection.php');
    session_start();

    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit();
    }


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $product_id = $_GET["id"];
    $query = "SELECT * FROM products WHERE id = $product_id";
    $result = $conn->query($query);
    $product = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST["id"];
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

    if (move_uploaded_file($image_tmp, $image_path)) {
    } else {
        echo "Image upload failed.";
    }

    $query = "UPDATE products SET name = '$name', description = '$description', category = '$category', price = '$price', status = '$status', image = '$image_path' WHERE id = $product_id";
    if ($conn->query($query) === TRUE) {
        header("Location: product_listing.php");
        exit;
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}

// Get catagory
$category_query = "SELECT * FROM categories WHERE status = 'Active'";
$category_result = $conn->query($category_query);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-3" style="text-align: center;">Edit Product</h2>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $product['name']; ?>">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description"><?php echo $product['description']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select name="category" class="form-control form-select" id="category">
                    <?php
                    while ($row = $category_result->fetch_assoc()) {
                        $selected = ($product['category'] == $row['name']) ? 'selected' : '';
                        echo "<option value='" . $row["id"] . "' $selected>" . $row["name"] . "</option>";
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
                <input type="number" class="form-control" id="price"name="price" value="<?php echo $product['price']; ?>">
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-control form-select" id="status">
                    <option value="Active" <?php if ($product['status'] == 'Active') echo 'selected'; ?>>Active</option>
                    <option value="Inactive" <?php if ($product['status'] == 'Inactive') echo 'selected'; ?>>Inactive</option>
                </select>
            </div>
            <div style="text-align:center;">
                <button type="submit" class="btn btn-primary">Update Product</button>
                <a href="product_listing.php" class="btn btn-primary mb-3" style="float: right">Back</a>
            </div>
        </form>
    </div>
</body>
</html>
