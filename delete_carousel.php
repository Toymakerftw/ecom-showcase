<?php
session_start();
include 'includes/config.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    // Return an error message if the user is not logged in
    echo "Error: User not logged in";
    exit();
}

// Handle AJAX request for deleting an image
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];

    // Prepare and execute the SQL query to delete the image based on its ID
    $sql_delete = "DELETE FROM carousel WHERE id = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        // Return success message if deletion is successful
        echo "Image deleted successfully";
        exit();
    } else {
        // Return error message if deletion fails
        echo "Error deleting image: " . $conn->error;
        exit();
    }
} else {
    // Return an error message if the request method is not POST or delete_id is not set
    echo "Error: Invalid request";
    exit();
}
