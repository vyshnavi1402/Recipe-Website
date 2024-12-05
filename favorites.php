<?php
// Include database connection
include 'db.php';

// Start the session to get the user details
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

$member_id = $_SESSION['user_id'];

// Query to get favorite recipes for the logged-in user
$query = "SELECT recipe.id, recipe.title, recipe.ingredients, recipe.instructions 
          FROM favorites 
          JOIN recipe ON favorites.recipe_id = recipe.id 
          WHERE favorites.member_id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $member_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Starry Recipe Cards</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            background: #000;
            animation: starry-bg 10s infinite linear;
            position: relative;
        }

        /* Starry Animated Background */
        @keyframes starry-bg {
            0% { background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 1px, transparent 1px) 0 0, radial-gradient(circle, rgba(255, 255, 255, 0.3) 1px, transparent 1px) 50% 50%; }
            100% { background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 1px, transparent 1px) 0 0, radial-gradient(circle, rgba(255, 255, 255, 0.3) 1px, transparent 1px) 50% 50%; }
            background-size: 50px 50px;
            animation: move-stars 1s linear infinite;
        }

        @keyframes move-stars {
            0% { background-position: 0 0; }
            100% { background-position: 100% 100%; }
        }

        header {
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 20px;
            text-align: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        h1 {
            font-size: 32px;
            margin: 0;
        }

        section {
            padding: 50px 20px;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        /* Card Container */
        .card-container {
            position: relative;
            width: 300px;
            height: 400px;
            perspective: 1000px;
            margin-bottom: 40px;
        }

        /* Card Style */
        .card {
            width: 100%;
            height: 100%;
            position: absolute;
            transform-style: preserve-3d;
            transition: transform 0.8s ease-in-out;
            border-radius: 10px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            border: 3px solid #fff;  /* Add border around the card */
        }

        .card.open {
            transform: rotateY(180deg);
        }

        /* Front and Back Styles */
        .card-face {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.5s;
            padding: 15px; /* Add padding for some spacing */
        }

        .card-face.front {
            background: linear-gradient(135deg, #ff7eb9, #ff2a68);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            box-sizing: border-box;
        }

        .card-face.front h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .card-face.front p {
            font-size: 14px;
            padding: 0 10px;
        }

        .card-face.back {
            background: #fff;
            transform: rotateY(180deg);
            color: #333;
            text-align: center;
            box-sizing: border-box;
            border: 2px solid #ff2a68; /* Border around the back face */
        }

        .card-face.back h3 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #ff2a68;
        }

        .card-face.back p {
            font-size: 14px;
            line-height: 1.5;
        }

        /* Hover Effects */
        .card-container:hover .card-face.front {
            transform: scale(1.05);
        }

        /* Glow Effect */
        .card-container:hover {
            animation: glow 1.5s infinite alternate;
        }

        @keyframes glow {
            0% { box-shadow: 0 0 10px rgba(255, 255, 255, 0.5); }
            100% { box-shadow: 0 0 30px rgba(255, 255, 255, 1); }
        }

        /* Home Tab */
     .home-tab {
    position: absolute;
    top: 20px;
    right: 20px;
    padding: 10px 20px;
    color:White;
    background-color:Hotpink; /* Pink background */
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    font-size: 30px; /* Increased font size */
    transition: background 0.3s ease;
}

.home-tab:hover {
    background-color: #ff4da6; /* Darker pink background on hover */
}

    </style>
</head>
<body>
    <header>
        <h1>Favorite Recipes</h1>
<a href="index.php" class="home-tab">Home</a>


    </header>

    
    <section>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card-container">
                    <div class="card">
                        <!-- Front Face -->
                        <div class="card-face front" onclick="toggleCard(this)">
                            <h2><?= htmlspecialchars($row['title']) ?></h2>
                            <p>Click to see details!</p>
                        </div>
                        <!-- Back Face -->
                        <div class="card-face back" onclick="toggleCard(this)">
                            <h3>Ingredients</h3>
                            <p><?= nl2br(htmlspecialchars($row['ingredients'])) ?></p>
                            <h3>Instructions</h3>
                            <p><?= nl2br(htmlspecialchars($row['instructions'])) ?></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align:center;">You don't have any favorite recipes yet.</p>
        <?php endif; ?>

        <?php
        $stmt->close();
        $conn->close();
        ?>
    </section>

    <script>
        // Toggle Card Functionality
        function toggleCard(element) {
            const card = element.closest('.card');
            card.classList.toggle('open');
        }
    </script>
</body>
</html>
