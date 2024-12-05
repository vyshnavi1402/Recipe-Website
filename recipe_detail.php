<?php
// Include database connection
include('db.php');

// Check if 'id' parameter is set in the URL (i.e., when a recipe is selected)
if (isset($_GET['id'])) {
    $recipe_id = $_GET['id'];

    // Prepare and execute the query to get the recipe details by ID
    $sql = "SELECT * FROM recipe WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $recipe_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the recipe is found
    if ($result->num_rows > 0) {
        $recipe = $result->fetch_assoc();
    } else {
        echo "Recipe not found.";
        exit;
    }
} else {
    echo "No recipe ID specified.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($recipe['title']); ?> - Recipe Details</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Styling for Recipe Detail Page */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, rgba(135, 206, 235, 0.8), rgba(255, 105, 180, 0.8));
        }

        .navbar {
            background-color: darkslategray;
            color: white;
            padding: 10px 0;
            text-align: center;
        }

        
        
        .recipe-detail {
            max-width: 800px;
            margin: 40px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.2);
            transition: box-shadow 0.3s ease;
        }

        .recipe-detail:hover {
            box-shadow: 0px 12px 20px rgba(0, 0, 0, 0.3);
        }

        .recipe-detail h1 {
            text-align: center;
            font-size: 36px;
            margin-bottom: 20px;
        }

        .recipe-image {
            display: block;
            margin: 0 auto;
            width: 100%;
            max-width: 600px;
            height: auto;
            border-radius: 8px;
        }

        h2 {
            font-size: 24px;
            margin-top: 30px;
        }

        p {
            font-size: 18px;
            line-height: 1.6;
            color: #555;
        }

        .back-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            display: block;
            text-align: center;
            width: 200px;
            margin: 20px auto;
        }

        .back-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <!-- Navbar section -->
    
    <div class="recipe-detail">
        <!-- Displaying Recipe Title -->
        <h1><?php echo htmlspecialchars($recipe['title']); ?></h1>

        <!-- Displaying Recipe Image (based on recipe_id) -->
        <?php
        $image_url = '';
        switch ($recipe['title']) {
            case 'Dosa': $image_url = 'dosa.jpeg'; break;
            case 'Idli': $image_url = 'idli.jpeg'; break;
            case 'Vada': $image_url = 'vada.jpeg'; break;
            case 'Croissant': $image_url = 'croissant.jpeg'; break;
            case 'Sandwich': $image_url = 'sandwich.jpeg'; break;
            case 'Pancakes': $image_url = 'pancakes.jpeg'; break;
            case 'Aloo Paratha': $image_url = 'Alooparata.jpeg'; break;
            case 'Avocado Toast': $image_url = 'Avacadotoast.jpeg'; break;
            case 'Puri': $image_url = 'puri.jpeg'; break;
            case 'Chicken Biryani': $image_url = 'chickenbiryani.jpeg'; break;
            case 'Paneer Biryani': $image_url = 'paneerbiryani.jfif'; break;
            case 'Paneer BM': $image_url = 'paneerBM.jpeg'; break;
            case 'Garlic Naan': $image_url = 'garlicnaan.jpeg'; break;
            case 'Butter Chicken': $image_url = 'butterchicken.jpeg'; break;
            case 'Fried Rice': $image_url = 'friedrice.jpeg'; break;
            case 'Soyapulav': $image_url = 'soyapulav.jpeg'; break;
            case 'Kadai Paneer': $image_url = 'kadaipaneer.jpeg'; break;
            case 'Murgh Masala': $image_url = 'murghmasala.jpeg'; break;
            case 'Pizza': $image_url = 'pizza.jpeg'; break;
            case 'Burger': $image_url = 'burger.jpeg'; break;
            case 'Pasta': $image_url = 'pasta.jpeg'; break;
            case 'Samosa': $image_url = 'samosa.jpeg'; break;
            case 'Cake': $image_url = 'cake.jpeg'; break;
    case 'Donuts': $image_url = 'donuts.jpeg'; break;
    case 'Ice Cream': $image_url = 'icecream.jpeg'; break;
    case 'Pie': $image_url = 'pie.jpeg'; break;
    case 'Brownie': $image_url = 'brownie.jpeg'; break;
    case 'Cupcake': $image_url = 'cupcake.jpeg'; break;

                        default: $image_url = 'default.jpeg'; break;
        }
        ?>
        <img src="<?php echo htmlspecialchars($image_url); ?>" alt="<?php echo htmlspecialchars($recipe['title']); ?>" class="recipe-image">

        <!-- Displaying Recipe Ingredients -->
        <h2>Ingredients</h2>
        <p><?php echo nl2br(htmlspecialchars($recipe['ingredients'])); ?></p>

        <!-- Displaying Recipe Instructions -->
        <h2>Instructions</h2>
        <?php 
        $instructions = explode("\n", $recipe['instructions']);
        foreach ($instructions as $step) {
            $step = trim($step);
            if (!empty($step)) {
                echo "<p>" . htmlspecialchars($step) . "</p>";
            }
        }
        ?>

        <!-- Back Button to go to the previous page -->
        <button class="back-button" onclick="window.history.back();">Back to options</button>
    </div>
</body>
</html>
