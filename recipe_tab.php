<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Categories - CraveCrafter</title>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
    <style>
      
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #ff7eb9, #ff2a68, #1e90ff); /* Pink to Blue Gradient */
            background-size: 400% 400%;
            animation: gradientBG 8s ease infinite;
            color: #fff;
            text-align: center;
            height: 100vh;
            overflow: hidden;
        }

       
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

      
        header {
            padding-top: 80px;
            padding-bottom: 30px;
        }

        h1 {
            font-family: 'Dancing Script', cursive; /* Custom cursive font */
            font-size: 3em;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 3px;
            animation: fadeIn 2s ease-out;
            color: #ffffff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); /* Added shadow for better visibility */
        }

                nav {
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin-top: 50px;
            flex-wrap: wrap;
            position: relative;
            width: 100%;
        }

      
        .category-block {
            display: flex; 
            flex-direction: column; 
            justify-content: space-between; 
            width: 250px;
            text-align: center;
            margin: 20px;
            padding: 30px; 
            background: linear-gradient(135deg, #2a9d8f, #264653);
            border-radius: 15px;
            transition: box-shadow 0.3s ease, background-color 0.3s ease;
            height: 350px;
            animation: fadeInBlock 1.5s forwards;
            position: relative;
            z-index: 1;
        }

               @keyframes fadeInBlock {
            0% { opacity: 0; transform: translateY(50px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        /* Continuous Left-Right Animation */
        @keyframes moveLeftRight {
            0% { transform: translateX(0); }
            50% { transform: translateX(20px); }
            100% { transform: translateX(0); }
        }

        .category-block {
            animation: moveLeftRight 2s ease-in-out infinite;        }

        
        nav a {
            margin-top: 20px; /* Increased space between the image and the button */
            text-decoration: none;
            font-size: 1.5em;
            padding: 15px 30px;
            border-radius: 30px;
            background: linear-gradient(135deg, #ff2a68, #ff7eb9); /* Initial Button Gradient */
            color: #fff;
            display: inline-block;
            transition: all 0.4s ease;
            animation: buttonBG 8s ease infinite; /* Synchronize with body background */
        }

        nav a:hover {
            transform: scale(1.1); /* Scale-up effect on hover */
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.3);
        }

        
        @keyframes buttonBG {
            0% { background: linear-gradient(135deg, #ff2a68, #ff7eb9); }
            50% { background: linear-gradient(135deg, #1e90ff, #ff2a68); }
            100% { background: linear-gradient(135deg, #ff2a68, #ff7eb9); }
        }

        
        .category-block img {
            width: 100%;
            height: 250px;
            max-height: 450px; /* Increased the max-height to make the image taller */
            object-fit: cover; /* Ensure images fill the container without stretching */
            border-radius: 10px;
            transition: transform 0.3s ease-in-out;
        }

        
        .category-block img:hover {
            transform: scale(1.05); /* Image zoom effect on hover */
        }

        
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(-30px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        
        .back-button {
            margin-top: 50px;
            padding: 15px 30px;
            font-size: 1.5em;
            border-radius: 30px;
            background: linear-gradient(135deg, #1e90ff, #2a9d8f); /* Bluish-green gradient */
            color: #fff;
            text-decoration: none;
            display: inline-block;
            transition: all 0.4s ease;
        }

        .back-button:hover {
            transform: scale(1.1); /* Scale-up effect on hover */
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.3);
        }

        /* Responsive Design for Smaller Screens */
        @media (max-width: 768px) {
            h1 {
                font-size: 2.5em;
            }
            nav a {
                font-size: 1.2em;
                padding: 10px 20px;
            }
            nav {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Choose Your Recipe Category</h1>
    </header>

    <nav>
        <!-- Breakfast Block -->
        <div class="category-block" style="animation-delay: 0.2s;">
            <div class="image-container">
                <img src="breakfast.jpeg" alt="Breakfast Image">
            </div>
            <a href="breakfast.php">Breakfast</a>
        </div>

        <!-- Main Course Block -->
        <div class="category-block" style="animation-delay: 0.4s;">
            <div class="image-container">
                <img src="maincourse.jpeg" alt="Main Course Image">
            </div>
            <a href="maincourse.php">Main Course</a>
        </div>

        <!-- Snacks Block -->
        <div class="category-block" style="animation-delay: 0.6s;">
            <div class="image-container">
                <img src="snacks.jpeg" alt="Snacks Image">
            </div>
            <a href="snacks.php">Snacks</a>
        </div>

        <!-- Desserts Block -->
        <div class="category-block" style="animation-delay: 0.8s;">
            <div class="image-container">
                <img src="dessert.jpeg" alt="Desserts Image">
            </div>
            <a href="dessert.php">Desserts</a>
        </div>
    </nav>

    <!-- Back Button -->
    <a href="index.php" class="back-button">Back to Home</a>

</body>
</html>
