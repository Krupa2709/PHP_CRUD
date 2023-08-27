<?php 
 	include('connection.php');
	session_start();

	if (!isset($_SESSION['username'])) {
	    header('Location: login.php');
	    exit();
	}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Management</title>
</head>
<body>
	<div class="container mt-5">
	    <h2 class="mb-3" style="text-align: center;">Product Management</h2>

	    <!-- Add Product -->
	    <a href="add_product.php" target='_blank' class="btn btn-primary mb-3" style="float: right">Add Product</a>
	    <a href="logout.php" class="btn btn-danger mb-3" style="float: left">Logout</a>

	    <!-- Product Listing -->
	    <table border="1" class="table table-striped">
	        <tr>
	            <th>Name</th>
	            <th>Description</th>
	            <th>Category</th>
	            <th>Price</th>
	            <th>Status</th>
	            <th>Actions</th>
	        </tr>
	        <!-- Get rows from the database -->
	        <?php

				$query = "SELECT * FROM products where deleted is null";
				$result = $conn->query($query);

				while ($row = $result->fetch_assoc()) {
				    echo "<tr>";
				    echo "<td>" . $row["name"] . "</td>";
				    echo "<td>" . $row["description"] . "</td>";

				    $category_query = "SELECT name FROM categories WHERE id =".$row['category'];
					$category_result = $conn->query($category_query)->fetch_assoc();

				    echo "<td>" . $category_result["name"] . "</td>";
				    echo "<td>" . $row["price"] . "</td>";
				    echo "<td>" . $row["status"] . "</td>";
				    echo "<td><a class='btn btn-success mb-3' href='edit_product.php?id=" . $row["id"] . "'>Edit</a>  <a class='btn btn-danger mb-3' href='delete_product.php?id=" . $row["id"] . "'>Delete</a></td>";
				    echo "</tr>";
				}
				$conn->close();
			?>

	    </table>
	    <a href="category_manager.php" target="_blank" class="btn btn-success mb-3" style="float: left">Category Manager</a>
	</div>
</body>
</html>
