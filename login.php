<?php
session_start();

if (isset($_SESSION['user_id'])) {
    // If already logged in, redirect to the index page
    header("Location: index.php");
    exit();
}

include('db.php');  // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form inputs safely
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM members WHERE username = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "s", $username);
        
        // Execute the statement
        mysqli_stmt_execute($stmt);
        
        // Get the result
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) > 0) {
            // Fetch the user data
            $row = mysqli_fetch_assoc($result);
            
            // Verify the password
            if (password_verify($password, $row['password'])) {
                // Store user info in session variables
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                
                // Redirect to the index page
                header("Location: index.php");
                exit();
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "No user found with that username.";
        }
    }
}
?>
<!DOCTYPE html>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background: url('login.jpeg') no-repeat center center fixed;
            background-size: cover;
            padding: 50px;
            margin: 0;
        }
        h2 {
            font-size: 48px;
            color: #8B4513; 
        }
        form {
            display: inline-block;
            padding: 30px;
            border: 3px solid #000;
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.9); 
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            position: absolute;
            top: 38%;
            left: 30%;
            transform: translate(-50%, 0);
            animation: moveBox 4s infinite alternate ease-in-out;  
       }
        @keyframes moveBox {
            0% {
                transform: translate(-50%, 0) translateX(-30px); 
            }
            100% {
                transform: translate(-50%, 0) translateX(30px);      
       }
        }
        .input-container {
            margin: 20px 0;
        }
        input[type="text"], input[type="password"] {
            width: 350px;
            padding: 20px;
            font-size: 24px;
            border: 3px solid #000;
            border-radius: 5px;
        }
        button {
            background-color: #8B4513; 
            color: white;
            padding: 20px;
            width: 100%;
            border: none;
            font-size: 26px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #A0522D; 
        }
        .error {
            color: red;
            font-size: 22px;
        }
        a {
            font-size: 22px;
            text-decoration: none;
            color: #8B4513; 
        }
        a:hover {
            text-decoration: underline;
        }
        .footer-text {
            margin-top: 20px;
            font-size: 20px;
            color: #000;
        }
    </style>
</head>
<body>
    <?php
    if (!empty($error)) {
        echo '<p class="error">' . $error . '</p>';
    }
    ?>
    <form method="POST" action="login.php">
        <div class="input-container">
            <input type="text" name="username" placeholder="Username" required>
        </div>
        <div class="input-container">
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit">Login</button>
        <p class="footer-text">Don't have an account? <a href="signup.php">Sign up here</a></p>
    </form>
</body>
</html>
