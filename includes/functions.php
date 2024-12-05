<?php
// Function to check if user is logged in
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Function to fetch user details
function get_user_details($user_id) {
    global $conn;
    $sql = "SELECT * FROM users WHERE id = '$user_id'";
    $result = $conn->query($sql);
    return $result->fetch_assoc();
}

// Function to handle login
function login_user($username, $password) {
    global $conn;
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);
    return $result->fetch_assoc();
}

// Function to register new user
function register_user($username, $email, $password) {
    global $conn;
    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    return $conn->query($sql);
}

// Function to add a recipe to favorites
function add_to_favorites($user_id, $recipe_id) {
    global $conn;
    // Check if the recipe is already in favorites
    $sql = "SELECT * FROM favorites WHERE user_id = '$user_id' AND recipe_id = '$recipe_id'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        // If not already in favorites, insert into the database
        $sql = "INSERT INTO favorites (user_id, recipe_id) VALUES ('$user_id', '$recipe_id')";
        return $conn->query($sql);
    }
    return false; // Recipe is already in favorites
}

// Function to remove a recipe from favorites
function remove_from_favorites($user_id, $recipe_id) {
    global $conn;
    $sql = "DELETE FROM favorites WHERE user_id = '$user_id' AND recipe_id = '$recipe_id'";
    return $conn->query($sql);
}

// Function to get all favorite recipes of a user
function get_favorite_recipes($user_id) {
    global $conn;
    $sql = "SELECT r.* FROM recipes r
            JOIN favorites f ON r.id = f.recipe_id
            WHERE f.user_id = '$user_id'";
    $result = $conn->query($sql);
    $recipes = [];
    while ($row = $result->fetch_assoc()) {
        $recipes[] = $row;
    }
    return $recipes;
}

// Function to check if a recipe is a favorite of the user
function is_favorite($user_id, $recipe_id) {
    global $conn;
    $sql = "SELECT * FROM favorites WHERE user_id = '$user_id' AND recipe_id = '$recipe_id'";
    $result = $conn->query($sql);
    return $result->num_rows > 0;
}
?>
