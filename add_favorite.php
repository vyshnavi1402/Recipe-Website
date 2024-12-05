<?php
// add_favorite.php

// Include database connection
include 'db.php';

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

$member_id = $_SESSION['user_id'];  // Use 'member_id' instead of 'user_id'
//echo("</br>member id is ".$member_id."</br>");
// Get the recipe ID from the URL (for adding or removing from favorites)
if (isset($_POST['recipe_id'])) {
    $recipe_id = $_POST['recipe_id'];

    // Check if the recipe is already in the user's favorites
    $check_query = "SELECT * FROM favorites WHERE member_id = ? AND recipe_id = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("ii", $member_id, $recipe_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Recipe is already in favorites, so remove it
        $delete_query = "DELETE FROM favorites WHERE member_id = ? AND recipe_id = ?";
        $stmt = $conn->prepare($delete_query);
        $stmt->bind_param("ii", $member_id, $recipe_id);
        $stmt->execute();

        echo "Recipe removed from favorites."; // Optionally, use JavaScript to show this message
    } else {
        // Recipe is not in favorites, so add it
        $insert_query = "INSERT INTO favorites (member_id, recipe_id) VALUES (?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("ii", $member_id, $recipe_id);
        $stmt->execute();

        echo "Recipe added to favorites."; // Optionally, use JavaScript to show this message
    }

    $stmt->close();
}

// Redirect back to the previous page or index
//header("Location: index.php");
exit();
?>
