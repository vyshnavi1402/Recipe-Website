<?php 
session_start();
require_once 'db.php'; // Database connection

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['id']); // Check if 'id' is set in session (not 'user_id')

// Handle "Add to Favorites" action
if (isset($_POST['favorite'])) {
    if (!$isLoggedIn) {
        // Redirect to login page if not logged in
        header('Location: login.php');
        exit;
    }

    $recipeId = intval($_POST['id']); // Recipe ID from the form
    $userId = $_SESSION['id']; // Use 'id' from the session for the logged-in user

    // Check if the recipe is already in the favorites table
    $query = "SELECT * FROM favorites WHERE member_id = ? AND recipe_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $userId, $recipeId); // Bind parameters: user_id and recipe_id
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Add to favorites if not already added
        $insertQuery = "INSERT INTO favorites (member_id, recipe_id) VALUES (?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param('ii', $userId, $recipeId); // Bind parameters for insertion
        $insertStmt->execute();
        $insertStmt->close(); // Close insert statement
    }

    $stmt->close(); // Close select statement
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Menu</title>
    <style>
        /* General Styles */
       body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;

    /* Use the 'background' property for gradients */
       background-size: cover; /* Optional: Ensures the gradient covers the screen */
}
.menu-container {
    max-width: 1250px;
    margin: 20px auto;
    padding: 20px;
    background:url('bf.jpeg'); /* Add your image as the base layer */
    background-size: cover, 300% 300%; /* 'cover' for the image, size for gradient */
    background-position: center, 0% 50%; /* Center image and initial gradient position */
    background-blend-mode: overlay; /* Blend gradient with the image */
    animation: gradientMove 10s ease infinite; /* Animation for gradient movement */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease-in-out; /* Smooth transition for other properties */
    border-radius: 10px; /* Optional: rounded corners for better aesthetics */
}/* Keyframes for moving the gradient */
@keyframes gradientMove {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}
.centered-text{
text-align:center;
}

/* Optional: Adding a hover effect for smoother background transition */
.menu-container:hover {
    transform: scale(1.05); /* Slightly enlarges the container on hover */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); /* Stronger shadow on hover */
}
        h1 {
            text-align: center;
            color: white;
            font-size: 2.5rem;
        }

        h2, h3 {
            color: #555;

        }

        /* Breakfast Section Layout */
        .menu-category {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-between;
            margin-top: 20px;
        }

        /* Group three images into a block */
        .menu-item-block {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            width: 100%;
            margin-bottom: 20px;
        }

        /* Individual menu items */
        .menu-item {
            width: 30%;
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-align: center;
        }

        .menu-item:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .menu-image img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            max-height: 250px;
            object-fit: cover;
        }

        .menu-details h3 {
            font-size: 1.2rem;
            color: #333;
            margin-top: 10px;
        }

        .menu-details a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        .menu-details a:hover {
            color: #0056b3;
        }

 .favorite-form {
            margin-top: 10px;
        }

        .favorite-form button {
            background-color: #f39c12;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        .favorite-form button:hover {
            background-color: #e67e22;
        }
.header-container {
    display: flex;
    justify-content: space-between; /* Positions the items at both ends */
    align-items: center; /* Vertically centers the items */
    margin-bottom: 20px;
}


/* "Back to Breakfast" Button */
.back-button {
    background-color: #3498db;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
}

.back-button:hover {
    background-color: #2980b9;
}    </style>
</head>
<body>
    <div class="menu-container">
    <div class="header-container">
              <a href="recipe_tab.php" class="back-button">Back to recipe page</a>
 <h1 class="centered-text">Dawn Delights</h1>

         <a href="favorites.php" class="back-button">My Favorites</a>

    </div>
        <!-- Breakfast Section -->
                <div class="menu-category">
            <!-- Block with 3 items: Idli, French Toast, and Omelette -->
            <div class="menu-item-block">
                <!-- Idli -->
                <div class="menu-item">
                    <div class="menu-image">
                        <img src="dosa.jpeg" alt="Idli">
                    </div>
                    <div class="menu-details">
                        <h3>Dosa</h3>
                        <a href="recipe_detail.php?id=1">View Recipe</a>    
                        <form method="POST" class="favorite-form"  action="add_favorite.php">
                            <input type="hidden" name="recipe_id" value="1">
                            <button type="submit" name="favorite">⭐ Favorite</button>
                        </form>
                    </div>
                </div>

                <!-- French Toast -->
              <div class="menu-item">
                    <div class="menu-image">
                        <img src="idli.jpeg" alt="French Toast">
                    </div>
                    <div class="menu-details">
                        <h3>Idli</h3>
                        <a href="recipe_detail.php?id=2">View Recipe</a>
                         <form method="POST" class="favorite-form"  action="add_favorite.php">
                            <input type="hidden" name="recipe_id" value="2">
                            <button type="submit" name="favorite">⭐ Favorite</button>
                        </form>
                    </div>
                </div>

                <!-- Omelette -->
                <div class="menu-item">
                    <div class="menu-image">
                        <img src="croissant.jpeg" alt="Omelette">
                    </div>
                    <div class="menu-details">
                        <h3>Croissant</h3>
                        <a href="recipe_detail.php?id=9">View Recipe</a>
                        <form method="POST" class="favorite-form" action="add_favorite.php">
                            <input type="hidden" name="recipe_id" value="9">
                            <button type="submit" name="favorite">⭐ Favorite</button>
                        </form>
                    </div>
                </div>
            </div>

 <!--<div class="menu-container">-->
     
        <!-- Breakfast Section -->
                <div class="menu-category">
            <!-- Block with 3 items: Idli, French Toast, and Omelette -->
            <div class="menu-item-block">
                <!-- Idli -->
                <div class="menu-item">
                    <div class="menu-image">
                        <img src="Avacadotoast.jpeg" alt="Idli" >
                    </div>
                    <div class="menu-details">
                        <h3>Avacado Toast</h3>
                        <a href="recipe_detail.php?id=7">View Recipe</a>
                        <form method="POST" class="favorite-form"  action="add_favorite.php">
                            <input type="hidden" name="recipe_id" value="7">
                            <button type="submit" name="favorite">⭐ Favorite</button>
                        </form>
                    </div>
                </div>

                
            <div class="menu-item">
    <div class="menu-image">
        <img src="Alooparata.jpeg" alt="French Toast" style="height: 280px; object-fit: cover;">
    </div>
    <div class="menu-details">
        <h3>Alooparata</h3>
        <a href="recipe_detail.php?id=8">View Recipe</a>
       <form method="POST" class="favorite-form"  action="add_favorite.php">
                            <input type="hidden" name="recipe_id" value="8">
                            <button type="submit" name="favorite">⭐ Favorite</button>
                        </form>    </div>
</div>


                <div class="menu-item">
                    <div class="menu-image">
                        <img src="puri.jpeg" alt="puri">
                    </div>
                    <div class="menu-details">
                        <h3>Puri</h3>
                        <a href="recipe_detail.php?id=10">View Recipe</a>
                        <form method="POST" class="favorite-form"  action="add_favorite.php">
                            <input type="hidden" name="recipe_id" value="10">
                            <button type="submit" name="favorite">⭐ Favorite</button>
                        </form>
                    </div>
                </div>
            </div>


            <!-- Block with next 2 items: Pancakes, Vada, and Sandwich -->
            <div class="menu-item-block">
                <!-- Pancakes -->
                <div class="menu-item">
                    <div class="menu-image">
                        <img src="pancakes.jpeg" alt="Pancakes">
                    </div>
                    <div class="menu-details">
                        <h3>Pancakes</h3>
                        <a href="recipe_detail.php?id=5">View Recipe</a>
                         <form method="POST" class="favorite-form"  action="add_favorite.php">
                            <input type="hidden" name="recipe_id" value="5">
                            <button type="submit" name="favorite">⭐ Favorite</button>
                        </form>
                    </div>
                </div>

                <!-- Vada -->
                <div class="menu-item">
                    <div class="menu-image">
                        <img src="vada.jpeg" alt="Vada">
                    </div>
                    <div class="menu-details">
                        <h3>Vada</h3>
                        <a href="recipe_detail.php?id=6">View Recipe</a>
                         <form method="POST" class="favorite-form">
                            <input type="hidden" name="recipe_id" value="6"  action="add_favorite.php">
                            <button type="submit" name="favorite">⭐ Favorite</button>
                        </form>
                    </div>
                </div>

               
                <!-- Sandwich (New Item) -->
                <div class="menu-item">
                    <div class="menu-image">
                        <img src="sandwich.jpeg" alt="Sandwich">
                    </div>
                    <div class="menu-details">
                        <h3>Sandwich</h3>
                        <a href="recipe_detail.php?id=3">View Recipe</a>
                        <form  method="POST" class="favorite-form"  action="add_favorite.php">
                            <input type="hidden" name="recipe_id" value="3">
                            <button type="submit" name="favorite">⭐ Favorite</button>
                        </form>
                    </div>
                </div>
            </div>
       <!--   </div>-->

        
       
            
</body>
</html><?php
$conn->close();
?>