<?php
// delete_recipe.php

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

if (isset($_GET['id'])) {
    $recipe_id = $_GET['id'];
    $member_id = $_SESSION['user_id'];

    // Delete the recipe from the database
    $delete_query = "DELETE FROM recipes WHERE id = ? AND member_id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("ii", $recipe_id, $member_id);
    $stmt->execute();

    // Redirect back to My Recipes page
    header("Location: my_recipes.php");
    exit();
}
?>
