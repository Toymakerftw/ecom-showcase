<?php
session_start();
include 'includes/config.php';

// Function to delete image file
function deleteImageFile($filename) {
    // Construct the full path to the file
    $file_path = "assets/images/products/" . $filename;

    // Check if the file exists
    if (file_exists($file_path)) {
        // Attempt to delete the file
        if (unlink($file_path)) {
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
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Check if the product exists in the database
    $check_sql = "SELECT * FROM products WHERE id='$product_id'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        // Product exists, delete it
        $row = $result->fetch_assoc();
        $image_filename = $row['image'];

        // Delete the image file
        if (deleteImageFile($image_filename)) {
            // Prepare and execute the SQL query to delete the product from the database
            $delete_sql = "DELETE FROM products WHERE id='$product_id'";
            if ($conn->query($delete_sql) === TRUE) {
                $success_message = "Product deleted successfully!";
            } else {
                $error_message = "Error deleting product: " . $conn->error;
            }
        } else {
            $error_message = "Error deleting image file";
        }
    } else {
        // Product does not exist
        $error_message = "Product not found!";
    }
} else {
    // Product ID not provided in the URL
    $error_message = "Product ID is missing!";
}

// Redirect back to the edit page with success or error message
if (isset($success_message)) {
    header("Location: edit_products.php?success=" . urlencode($success_message));
} elseif (isset($error_message)) {
    header("Location: edit_products.php?error=" . urlencode($error_message));
} else {
    header("Location: edit_products.php");
}
exit();
?>
