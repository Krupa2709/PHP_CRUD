<?php 
 include('connection.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center">Login</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="login.php">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Verify credentials from the database
    $query = "SELECT * FROM administrator WHERE username = '$username'";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();

    if ($result->num_rows == 1 && password_verify($password, $row['pwd'])) {
        $_SESSION['username'] = $username;
        header('Location: product_listing.php');
        exit();
    } else {
        echo "<div style='text-align: center;'><span style='color: red;'>Invalid credentials.</span> <a href='login.php'>Try again</a>.</div>";
    }
    $conn->close();
}
?>

