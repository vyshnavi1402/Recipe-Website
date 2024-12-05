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
    <title>Main Course Menu</title>
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
    background:url('mc.jfif'); /* Add your image as the base layer */
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

    </style>
</head>
<body>
    <div class="menu-container">
        <div class="header-container">
               <a href="recipe_tab.php" class="back-button">Back to recipe page</a>
  <h1 style="color:white">Masterpiece Mains</h1>

         <a href="favorites.php" class="back-button">My Favorites</a>

    </div>
        <div class="menu-category">
            <!-- Block with 3 items: Chicken Biryani, Paneer Biryani, Paneer Butter Masala -->
            <div class="menu-item-block">
                <!-- Chicken Biryani -->
                <div class="menu-item">
                    <div class="menu-image">
                        <img src="chickenbiryani.jpeg" alt="Chicken Biryani" height="300px">
                    </div>
                    <div class="menu-details">
                        <h3>Chicken Biryani</h3>
                        <a href="recipe_detail.php?id=11">View Recipe</a>
                        <form method="POST" class="favorite-form" action="add_favorite.php">
                            <input type="hidden" name="recipe_id" value="11">
                            <button type="submit" name="favorite">⭐ Favorite</button>
                        </form>
                    </div>
                </div>

                <!-- Paneer Biryani -->
                <div class="menu-item">
                    <div class="menu-image">
                        <img src="paneerbiryani.jfif" alt="Paneer Biryani">
                    </div>
                    <div class="menu-details">
                        <h3>Paneer Biryani</h3>
                        <a href="recipe_detail.php?id=12">View Recipe</a>
                        <form method="POST" class="favorite-form" action="add_favorite.php">
                            <input type="hidden" name="recipe_id" value="12">
                            <button type="submit" name="favorite">⭐ Favorite</button>
                        </form>
                    </div>
                </div>

                <!-- Paneer Butter Masala -->
                <div class="menu-item">
                    <div class="menu-image">
                        <img src="paneerBM.jpeg" alt="Paneer Butter Masala">
                    </div>
                    <div class="menu-details">
                        <h3>Paneer Butter Masala</h3>
                        <a href="recipe_detail.php?id=13">View Recipe</a>
                        <form method="POST" class="favorite-form" action="add_favorite.php">
                            <input type="hidden" name="recipe_id" value="13">
                            <button type="submit" name="favorite">⭐ Favorite</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Block with 3 items: Garlic Naan, Butter Chicken, Fried Rice -->
            <div class="menu-item-block">
                <!-- Garlic Naan -->
                <div class="menu-item">
                    <div class="menu-image">
                        <img src="garlic naan.jpeg" alt="Garlic Naan">
                    </div>
                    <div class="menu-details">
                        <h3>Garlic Naan</h3>
                        <a href="recipe_detail.php?id=15">View Recipe</a>
                        <form method="POST" class="favorite-form" action="add_favorite.php">
                            <input type="hidden" name="recipe_id" value="15">
                            <button type="submit" name="favorite">⭐ Favorite</button>
                        </form>
                    </div>
                </div>

                <!-- Butter Chicken -->
                <div class="menu-item">
                    <div class="menu-image">
                        <img src="butterchicken.jpeg" alt="Butter Chicken">
                    </div>
                    <div class="menu-details">
                        <h3>Butter Chicken</h3>
                        <a href="recipe_detail.php?id=16">View Recipe</a>
                        <form method="POST" class="favorite-form" action="add_favorite.php">
                            <input type="hidden" name="recipe_id" value="15">
                            <button type="submit" name="favorite">⭐ Favorite</button>
                        </form>
                    </div>
                </div>

                <!-- Fried Rice -->
                <div class="menu-item">
                    <div class="menu-image">
                        <img src="friedrice.jpeg" alt="Fried Rice">
                    </div>
                    <div class="menu-details">
                        <h3>Fried Rice</h3>
                        <a href="recipe_detail.php?id=19">View Recipe</a>
                        <form method="POST" class="favorite-form" action="add_favorite.php">
                            <input type="hidden" name="recipe_id" value="19">
                            <button type="submit" name="favorite">⭐ Favorite</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Block with 3 items: Soya Pulav, Kadai Paneer, Murgh Masala -->
            <div class="menu-item-block">
                <!-- Soya Pulav -->
                <div class="menu-item">
                    <div class="menu-image">
                        <img src="soyapulav.jpeg" alt="Soya Pulav">
                    </div>
                    <div class="menu-details">
                        <h3>Soya Pulav</h3>
                        <a href="recipe_detail.php?id=14">View Recipe</a>
                        <form method="POST" class="favorite-form" action="add_favorite.php">
                            <input type="hidden" name="recipe_id" value="14">
                            <button type="submit" name="favorite">⭐ Favorite</button>
                        </form>
                    </div>
                </div>

                <!-- Kadai Paneer -->
                <div class="menu-item">
                    <div class="menu-image">
                        <img src="kadaipaneer.jpeg" alt="Kadai Paneer">
                    </div>
                    <div class="menu-details">
                        <h3>Kadai Paneer</h3>
                        <a href="recipe_detail.php?id=18">View Recipe</a>
                        <form method="POST" class="favorite-form" action="add_favorite.php">
                            <input type="hidden" name="recipe_id" value="18">
                            <button type="submit" name="favorite">⭐ Favorite</button>
                        </form>
                    </div>
                </div>

                <!-- Murgh Masala -->
                <div class="menu-item">
                    <div class="menu-image">
                        <img src="Murgh masala.jpeg" alt="Murgh Masala">
                    </div>
                    <div class="menu-details">
                        <h3>Murgh Masala</h3>
                        <a href="recipe_detail.php?id=17">View Recipe</a>
                        <form method="POST" class="favorite-form" action="add_favorite.php">
                            <input type="hidden" name="recipe_id" value="17">
                            <button type="submit" name="favorite">⭐ Favorite</button>
                        </form>
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