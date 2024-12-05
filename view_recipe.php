<?php
// view_recipe.php

// Include database connection
include 'db.php';

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the recipe ID from the URL
if (isset($_GET['recipe_id'])) {
    $recipe_id = $_GET['recipe_id'];

    // Query to fetch the recipe details from the database
    $query = "SELECT * FROM recipes WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $recipe_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $recipe = $result->fetch_assoc();

    // Check if the recipe exists
    if (!$recipe) {
        echo "<script>alert('Recipe not found.'); window.location.href='index.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('No recipe ID specified.'); window.location.href='index.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Recipe</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            padding: 40px;
            margin: 0;
        }

        .recipe-container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            padding: 40px;
            max-width: 800px;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .recipe-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .recipe-details {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .recipe-image {
            width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .back-button {
            background: #ff7e5f;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s ease;
        }

        .back-button:hover {
            background: #feb47b;
        }
    </style>
</head>
<body>
    <div class="recipe-container">
        <h1>Recipe Details</h1>

        <!-- Display Recipe Name -->
        <div class="recipe-name">
            <?php echo htmlspecialchars($recipe['name']); ?>
        </div>

        <!-- Display Recipe Image -->
        <img class="recipe-image" src="<?php echo $recipe['image']; ?>" alt="Recipe Image">

        <!-- Display Ingredients -->
        <div class="recipe-details">
            <strong>Ingredients:</strong><br>
            <?php echo nl2br(htmlspecialchars($recipe['ingredients'])); ?>
        </div>

        <!-- Display Instructions -->
        <div class="recipe-details">
            <strong>Instructions:</strong><br>
            <?php echo nl2br(htmlspecialchars($recipe['instructions'])); ?>
        </div>

        <!-- Back Button -->
        <a href="index.php" class="back-button">Back to Recipe List</a>
    </div>
</body>
</html>
<?php
// view_recipe.php

// Include database connection
include 'db.php';

// Check if 'id' is set in the URL
if (isset($_GET['id'])) {
    $recipe_id = $_GET['id'];

    // Fetch recipe from the database
    $query = "SELECT * FROM recipes WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $recipe_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $recipe = $result->fetch_assoc();
    } else {
        echo "<script>alert('Recipe not found.');</script>";
        exit();
    }
} else {
    echo "<script>alert('No recipe ID specified.');</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Full Recipe</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            padding: 40px;
            margin: 0;
        }

        .recipe-container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            padding: 40px;
            max-width: 800px;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .recipe-image {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .recipe-details {
            font-size: 18px;
            color: #333;
            line-height: 1.6;
        }

        .ingredients, .instructions {
            margin: 20px 0;
        }

        .ingredients ul {
            list-style-type: disc;
            margin-left: 20px;
        }
    </style>
</head>
<body>
    <div class="recipe-container">
        <h1><?php echo htmlspecialchars($recipe['name']); ?></h1>

        <img class="recipe-image" src="<?php echo $recipe['image']; ?>" alt="Recipe Image">

        <div class="recipe-details">
            <div class="ingredients">
                <h2>Ingredients:</h2>
                <ul>
                    <?php
                    // Split ingredients by comma and display them
                    $ingredients = explode(",", $recipe['ingredients']);
                    foreach ($ingredients as $ingredient) {
                        echo "<li>" . htmlspecialchars(trim($ingredient)) . "</li>";
                    }
                    ?>
                </ul>
            </div>

            <div class="instructions">
                <h2>Instructions:</h2>
                <p><?php echo nl2br(htmlspecialchars($recipe['instructions'])); ?></p>
            </div>
        </div>
    </div>
</body>
</html>
