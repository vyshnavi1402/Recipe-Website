<?php
// Database connection (include your database config here)
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize input data
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);
    $instructions = mysqli_real_escape_string($conn, $_POST['instructions']);
    $image_url = mysqli_real_escape_string($conn, $_POST['image_url']);
    $video_url = mysqli_real_escape_string($conn, $_POST['video_url']);

    // SQL query to insert recipe data into the database
    $sql = "INSERT INTO recipe (title, ingredients, instructions, image_url, video_url) 
            VALUES ('$title', '$ingredients', '$instructions', '$image_url', '$video_url')";

    if (mysqli_query($conn, $sql)) {
        echo "Recipe added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Recipe</title>
</head>
<body>
    <h1>Insert Recipe</h1>

    <form method="POST" action="insert_recipe.php">
        <label for="title">Recipe Title:</label>
        <input type="text" name="title" id="title" required><br><br>

        <label for="ingredients">Ingredients:</label>
        <textarea name="ingredients" id="ingredients" required></textarea><br><br>

        <label for="instructions">Instructions:</label>
        <textarea name="instructions" id="instructions" required></textarea><br><br>

        <label for="image_url">Image URL:</label>
        <input type="text" name="image_url" id="image_url" required><br><br>

        <label for="video_url">Video URL (Optional):</label>
        <input type="text" name="video_url" id="video_url"><br><br>

        <button type="submit">Insert Recipe</button>
    </form>
</body>
</html>
