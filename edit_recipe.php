<?php
// edit_recipe.php

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

// Fetch the recipe details from the database
if (isset($_GET['id'])) {
    $recipe_id = $_GET['id'];

    // Fetch the recipe from the database
    $query = "SELECT * FROM recipes WHERE id = ? AND member_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $recipe_id, $member_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $recipe = $result->fetch_assoc();
    } else {
        echo "Recipe not found!";
        exit();
    }

    $stmt->close();
}

// Handle form submission for updating the recipe
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $recipe_name = $_POST['name'];
    $ingredients = $_POST['ingredients']; // Capture ingredients
    $instructions = $_POST['instructions'];

    // Update recipe in the database
    $query = "UPDATE recipes SET name = ?, ingredients = ?, instructions = ? WHERE id = ? AND member_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $recipe_name, $ingredients, $instructions, $recipe_id, $member_id);
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        // Redirect to my_recipes.php after a successful update
        header("Location: my_recipes.php?update=success");
        exit();
    } else {
        $update_error = "Error updating recipe. Please try again.";
    }

    $stmt->close();
}
?>

<!-- Recipe Edit Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Recipe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            max-width: 800px;
            margin: 30px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        form {
            display: grid;
            gap: 15px;
        }
        label {
            font-size: 16px;
            color: #555;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 12px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
            box-sizing: border-box;
        }
        textarea {
            height: 150px;
            resize: none;
        }
        button {
            padding: 14px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #45a049;
        }
        .success-message {
            text-align: center;
            color: green;
            font-size: 16px;
            margin-top: 20px;
        }
        .error-message {
            text-align: center;
            color: red;
            font-size: 16px;
            margin-top: 20px;
        }
        .back-button {
            text-align: center;
            margin-top: 20px;
        }
        .back-button a {
            padding: 12px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-button a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Recipe</h2>
        
        <?php if (isset($update_error)): ?>
            <div class="error-message">
                <?php echo $update_error; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <label for="name">Recipe Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($recipe['name']); ?>" required>

            <label for="ingredients">Ingredients:</label>
            <textarea id="ingredients" name="ingredients" required><?php echo htmlspecialchars($recipe['ingredients']); ?></textarea>

            <label for="instructions">Instructions:</label>
            <textarea id="instructions" name="instructions" required><?php echo htmlspecialchars($recipe['instructions']); ?></textarea>

            <button type="submit">Update Recipe</button>
        </form>

        <?php if (isset($update_success)): ?>
            <div class="success-message">
                Recipe updated successfully!
            </div>
            <div class="back-button">
                <a href="my_recipes.php">Back to My Recipes</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
