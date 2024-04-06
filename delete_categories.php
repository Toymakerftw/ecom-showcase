<?php
session_start();
include 'includes/config.php';

// Function to delete image file
function deleteImageFile($filename) {
    // Check if the file exists
    if (file_exists($filename)) {
        // Attempt to delete the file
        if (unlink($filename)) {
            return true; // File deleted successfully
        } else {
            return false; // Unable to delete file
        }
    } else {
        return true; // File doesn't exist, consider it deleted
    }
}

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    // Return an error message if the user is not logged in
    echo "Error: User not logged in";
    exit();
}

// Handle AJAX request for deleting an image
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];

    // Prepare and execute the SQL query to select the image filename based on its ID
    $sql_select_filename = "SELECT image FROM categories WHERE id = ?";
    $stmt_select = $conn->prepare($sql_select_filename);
    $stmt_select->bind_param("i", $delete_id);
    $stmt_select->execute();
    $stmt_select->store_result();

    if ($stmt_select->num_rows == 1) {
        // Bind the result variable
        $stmt_select->bind_result($filename);
        $stmt_select->fetch();

        // Delete the image file
        if (deleteImageFile($filename)) {
            // Prepare and execute the SQL query to delete the image entry from database
            $sql_delete = "DELETE FROM categories WHERE id = ?";
            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bind_param("i", $delete_id);

            if ($stmt_delete->execute()) {
                // Return success message if deletion is successful
                echo "Image deleted successfully";
                exit();
            } else {
                // Return error message if deletion from database fails
                echo "Error deleting image from database: " . $conn->error;
                exit();
            }
        } else {
            // Return error message if file deletion fails
            echo "Error deleting image file";
            exit();
        }
    } else {
        // Return error message if image not found in database
        echo "Error: Image not found";
        exit();
    }
} else {
    // Return an error message if the request method is not POST or delete_id is not set
    echo "Error: Invalid request";
    exit();
}
?>
