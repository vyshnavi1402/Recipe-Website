<?php
// add_recipe.php

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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = $_POST['name'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];

    // Ensure ingredients and instructions are not empty
    if (empty($ingredients) || empty($instructions)) {
        echo "<script>alert('Ingredients and Instructions cannot be empty');</script>";
    } else {
        // Handle file upload (image)
        $image = '';  // Default empty
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $image = 'uploads/' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $image);
        }

        // Insert recipe into the database
        $query = "INSERT INTO recipes (member_id, name, ingredients, instructions, image) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("issss", $member_id, $name, $ingredients, $instructions, $image);
        $stmt->execute();
        $stmt->close();

        // Redirect to my_recipes.php after adding the recipe
        header("Location: my_recipes.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Recipe</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #f0f0f0;
            margin: 0;
            padding: 40px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        label {
            font-size: 18px;
            margin-bottom: 8px;
            display: block;
        }

        input[type="text"],
        input[type="file"] {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        /* Styling for contenteditable div */
        .contenteditable {
            width: 100%;
            min-height: 100px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            background-color: #f9f9f9;
            margin: 10px 0;
            resize: vertical;
        }

        button {
            background-color: #ff7e5f;
            color: white;
            padding: 12px 20px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #feb47b;
        }
    </style>
</head>
<body>
    <h1>Add Recipe</h1>
    
    <div class="form-container">
        <form action="add_recipe.php" method="POST" enctype="multipart/form-data" onsubmit="copyContent();">
            <label for="name">Recipe Name</label>
            <input type="text" name="name" id="name" required>

            <label for="ingredients">Ingredients</label>
            <div class="contenteditable" name="ingredients" id="ingredients" contenteditable="true" required>
             
            </div>

            <label for="instructions">Instructions</label>
            <div class="contenteditable" name="instructions" id="instructions" contenteditable="true" required>
            
            </div>

            <label for="image">Recipe Image</label>
            <input type="file" name="image" id="image" accept="image/*">

            <!-- Hidden fields to hold the content of contenteditable divs -->
            <input type="hidden" name="ingredients" id="hidden_ingredients">
            <input type="hidden" name="instructions" id="hidden_instructions">

            <button type="submit">Add Recipe</button>
        </form>
    </div>

    <script>
        function copyContent() {
            // Copy the content from contenteditable divs into hidden inputs before submitting
            document.getElementById('hidden_ingredients').value = document.getElementById('ingredients').innerHTML;
            document.getElementById('hidden_instructions').value = document.getElementById('instructions').innerHTML;
        }
    </script>
</body>
</html>
