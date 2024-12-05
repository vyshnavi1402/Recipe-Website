<?php
// my_recipes.php

// Include database connection
include 'db.php';

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$member_id = $_SESSION['user_id'];  // Use 'member_id' instead of 'user_id'

// Fetch all recipes for the logged-in user
$query = "SELECT * FROM recipes WHERE member_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $member_id);
$stmt->execute();
$result = $stmt->get_result();

// Handle recipe deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM recipes WHERE id = ?";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bind_param("i", $delete_id);
    $delete_stmt->execute();
    $delete_stmt->close();
    header("Location: my_recipes.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Recipes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            padding: 40px;
            margin: 0;
        }

        .recipe-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            margin: 20px 0;
            max-width: 600px;
            margin: 20px auto;
        }

        .recipe-image {
            width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .recipe-details {
            margin-top: 10px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .recipe-name {
            font-size: 24px;
            font-weight: bold;
        }

        /* Add Recipe Button at Top-Right */
        .add-recipe-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 12px 25px;
            font-size: 18px;
            background-color: #ff7e5f;
            color: white;
            border: none;
            border-radius: 50px;
            cursor: pointer;
        }

        .add-recipe-btn i {
            margin-right: 10px;
        }

        /* Edit/Delete Buttons */
        .action-buttons {
            margin-top: 10px;
        }

        .action-buttons a {
            padding: 8px 15px;
            background-color: #feb47b;
            color: #333;
            border-radius: 5px;
            text-decoration: none;
            margin-right: 10px;
        }

        .action-buttons a.delete-btn {
            background-color: #ff7e5f;
        }

        .action-buttons a:hover {
            opacity: 0.8;
        }

        /* Back Button - Top Left Alignment */
        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            padding: 12px 25px;
            font-size: 18px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .back-btn:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <h1>My Recipes</h1>

    <!-- Add Recipe Button positioned at the top-right -->
    <a href="add_recipe.php">
        <button class="add-recipe-btn">
            <i class="fas fa-plus"></i> Add Recipe
        </button>
    </a>

    <!-- Back Button positioned at the top-left -->
    <a href="index.php">
        <button class="back-btn">Back to Home</button>
    </a>

    <?php while ($recipe = $result->fetch_assoc()) { ?>
        <div class="recipe-card">
            <div class="recipe-details">
                <p class="recipe-name"><?php echo htmlspecialchars($recipe['name']); ?></p>
                <p><strong>Ingredients:</strong> <?php echo nl2br(htmlspecialchars($recipe['ingredients'])); ?></p>
                <p><strong>Instructions:</strong> <?php echo nl2br(htmlspecialchars($recipe['instructions'])); ?></p>
                
                <!-- Action Buttons: Edit and Delete -->
                <div class="action-buttons">
                    <a href="edit_recipe.php?id=<?php echo $recipe['id']; ?>">Edit</a>
                    <a href="?delete_id=<?php echo $recipe['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this recipe?')">Delete</a>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php $stmt->close(); ?>
</body>
</html>
