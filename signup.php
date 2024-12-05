<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form inputs
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if username or email already exists
    $sql = "SELECT * FROM members WHERE username = '$username' OR email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $error_message = "Username or email already exists.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user into the database
        $sql = "INSERT INTO members (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
        if (mysqli_query($conn, $sql)) {
            $success_message = "Registration successful! Please <a href='login.php'>login</a>.";
        } else {
            $error_message = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            padding: 50px;
        }
        h2 {
            font-size: 48px;
        }
        form {
            display: inline-block;
            padding: 30px;
            border: 3px solid #000;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        .input-container {
            margin: 20px 0;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 350px;
            padding: 20px;
            font-size: 24px;
            border: 3px solid #000;
            border-radius: 5px;
        }
        .signup-button {
            background-color: skyblue;
            color: white;
            padding: 20px;
            width: 100%;
            border: none;
            font-size: 26px;
            border-radius: 5px;
            cursor: pointer;
        }
        .signup-button:hover {
            background-color: #87CEEB; 
        }
        .error {
            color: red;
            font-size: 22px;
        }
        a {
            font-size: 22px;
        }
    </style>
</head>
<body>
    <h2>Sign Up</h2>
    
    <?php if (isset($error_message)): ?>
        <p class="error"><?php echo $error_message; ?></p>
    <?php endif; ?>
    
    <?php if (isset($success_message)): ?>
        <p class="success"><?php echo $success_message; ?></p>
    <?php endif; ?>
    
    <form method="POST" action="signup.php">
        <div class="input-container">
            <input type="text" name="username" placeholder="Username" required>
        </div>
        <div class="input-container">
            <input type="email" name="email" placeholder="Email" required>
        </div>
        <div class="input-container">
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <button class="signup-button" type="submit">Sign Up</button>
    </form>
    
    <p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>
