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
    <title>Dessert Menu</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .menu-container {
    max-width: 1250px;
    margin: 20px auto;
    padding: 20px;
    background:url('d.jfif'); /* Add your image as the base layer */
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

        .menu-category {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-between;
            margin-top: 20px;
        }

        .menu-item-block {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            width: 100%;
            margin-bottom: 20px;
        }

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

        /* "Back to Snacks" Button */
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
        }
    </style>
</head>
<body>
    <div class="menu-container">
        <div class="header-container">
            <a href="recipe_tab.php" class="back-button">Back to Recipe Page</a>
            <h1 style="font-weight:bold">Sugar Symphony</h1>
            <a href="favorites.php" class="back-button">My Favorites</a>
        </div>
        <div class="menu-category">
            <!-- Block 1: Cake, Ice Cream, Brownies -->
            <div class="menu-item-block">
                <!-- Cake -->
                <div class="menu-item">
                    <div class="menu-image">
                        <img src="cake.jpeg" alt="Cake">
                    </div>
                    <div class="menu-details">
                        <h3>Cake</h3>
                        <a href="recipe_detail.php?id=35">View Recipe</a>
                        <form method="POST" class="favorite-form" action="add_favorite.php">
                            <input type="hidden" name="recipe_id" value="35">
                            <button type="submit" name="favorite">⭐ Favorite</button>
                        </form>
                    </div>
                </div>

                <!-- Ice Cream -->
                <div class="menu-item">
                    <div class="menu-image">
                        <img src="icecream.jpeg" alt="Ice Cream">
                    </div>
                    <div class="menu-details">
                        <h3>Ice Cream</h3>
                        <a href="recipe_detail.php?id=37">View Recipe</a>
                        <form method="POST" class="favorite-form" action="add_favorite.php">
                            <input type="hidden" name="recipe_id" value="37">
                            <button type="submit" name="favorite">⭐ Favorite</button>
                        </form>
                    </div>
                </div>

                <!-- Brownies -->
                <div class="menu-item">
                    <div class="menu-image">
                        <img src="brownie.jpeg" alt="Brownies">
                    </div>
                    <div class="menu-details">
                        <h3>Brownies</h3>
                        <a href="recipe_detail.php?id=39">View Recipe</a>
                        <form method="POST" class="favorite-form" action="add_favorite.php">
                            <input type="hidden" name="recipe_id" value="39">
                            <button type="submit" name="favorite">⭐ Favorite</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Block 2: Cupcakes, Pudding, Cookies -->
            <div class="menu-item-block">
                <!-- Cupcakes -->
                <div class="menu-item">
                    <div class="menu-image">
                        <img src="cupcake.jpeg" alt="Cupcakes">
                    </div>
                    <div class="menu-details">
                        <h3>Cupcakes</h3>
                        <a href="recipe_detail.php?id=40">View Recipe</a>
                        <form method="POST" class="favorite-form" action="add_favorite.php">
                            <input type="hidden" name="recipe_id" value="40">
                            <button type="submit" name="favorite">⭐ Favorite</button>
                        </form>
                    </div>
                </div>

                <!-- Pudding -->
                <div class="menu-item">
                    <div class="menu-image">
                        <img src="donuts.jpeg" alt="Pudding">
                    </div>
                    <div class="menu-details">
                        <h3>Donuts</h3>
                        <a href="recipe_detail.php?id=36">View Recipe</a>
                        <form method="POST" class="favorite-form" action="add_favorite.php">
                            <input type="hidden" name="recipe_id" value="36">
                            <button type="submit" name="favorite">⭐ Favorite</button>
                        </form>
                    </div>
                </div>

                <!--  -->
                <div class="menu-item">
                    <div class="menu-image">
                        <img src="pie.jpeg" alt="Cookies">
                    </div>
                    <div class="menu-details">
                        <h3>Pie</h3>
                        <a href="recipe_detail.php?id=38">View Recipe</a>
                        <form method="POST" class="favorite-form" action="add_favorite.php">
                            <input type="hidden" name="recipe_id" value="38">
                            <button type="submit" name="favorite">⭐ Favorite</button>                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
$conn->close();
?>