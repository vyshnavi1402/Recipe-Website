<?php
session_start(); // Start session to track user login
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Culinary Canvas - Home</title>
    <style>
        
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700&family=Open+Sans:wght@300;400&display=swap');

        body {
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 0;
            background: url('index.jpeg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

       
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.8); /* Semi-transparent black */
            padding:15px 1px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            transition: transform 0.3s ease;
        }

        .navbar:hover {
            transform: translateY(-3px);
        }

        /* Logo styling (Text-based) */
        .navbar .logo {
            font-family: 'Merriweather', serif;
            font-size: 36px;
            font-weight: bold;
            text-decoration: none;
            color: #ffbf00; /* Golden yellow */
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .navbar .logo:hover {
            color: #ffa500; /* Bright orange */
            transform: scale(1.1);
        }

        /* Navigation links styling */
        .nav-links {
            display: flex;
            gap: 30px;
            justify-content: flex-start;
            align-items: center;
        }

        .nav-links a {
            font-family: 'Open Sans', sans-serif;
            color: #fff;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 6px;
            font-size: 18px;
            text-transform: uppercase;
            transition: background-color 0.3s ease, transform 0.3s ease, color 0.3s ease;
        }

        .nav-links a:hover {
            background-color: rgba(255, 165, 0, 0.8); /* Orange hover effect */
            color: #333;
            transform: scale(1.1);
        }

        /* Hero section styling */
        .hero {
            position: relative;
            text-align: center;
            color: white;
            padding: 150px 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            box-sizing: border-box;
            margin-top: 60px;
        }

        .hero h1 {
            font-family: 'Merriweather', serif;
            font-size: 4.5em;
position:absolute;
top:125%;
            margin: 0;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
        }

        .hero p {
            font-size: 2.1em;
            margin: 10px 0;
position:absolute;
top:160%;

            font-family: 'Lucida Handwriting', cursive;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.7);
        }

        /* Media Queries for better responsiveness */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                align-items: center;
                padding: 15px 10px;
            }

            .nav-links {
                flex-direction: column;
                gap: 15px;
                width: 100%;
                justify-content: center;
            }

            .nav-links a {
                padding: 10px 15px;
                width: 100%;
                text-align: center;
                font-size: 18px;
            }

            .hero h1 {
                font-size: 3em;
            }

            .hero p {
                font-size: 1.3em;
            }
        }
    </style>
</head>
<body>
    <div class="main-content">
        <header class="hero">
            <div class="navbar">
                <a href="index.php" class="logo">Culinary Canvas</a>
                <div class="nav-links">
                    <a href="recipe_tab.php">Recipes</a>
                    <a href="aboutus.php">About Us</a>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="my_recipes.php">My Recipes</a>
                        <a href="favorites.php">My Favorites</a>
                        <a href="logout.php" class="logout">Logout</a>
                    <?php else: ?>
                        <a href="login.php">Login</a>
                    <?php endif; ?>
                </div>
            </div>
            <!-- Hero section welcome message -->
            <?php if (isset($_SESSION['user_id'])): ?>
                <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
            <?php else: ?>
                <h1 >Welcome to Culinary Canvas!</h1>
            <?php endif; ?>
            <p>Your one-stop destination for mouth-watering recipes.</p>
        </header>
    </div>
</body>
</html>
