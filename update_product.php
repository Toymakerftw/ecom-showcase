<?php
session_start();
include '../includes/config.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Check if image file is uploaded
    if ($_FILES['image']['size'] > 0) {
        // Handle image upload
        $target_dir = "../uploads/";
        $random_chars = uniqid(); // Generate unique identifier
        $target_file = $target_dir . $random_chars . "_" . basename($_FILES["image"]["name"]); // Create unique filename
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file is a valid image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            $error_message = "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["image"]["size"] > 500000) {
            $error_message = "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $error_message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $error_message .= " Your file was not uploaded.";
        } else {
            // Try to upload the file
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // Update product with new image path
                $image_path = $random_chars . "_" . basename($_FILES["image"]["name"]);
                $update_sql = "UPDATE products SET name='$name', description='$description', price='$price', image='$image_path' WHERE id='$product_id'";
                if ($conn->query($update_sql) === TRUE) {
                    $success_message = "Product updated successfully!";
                } else {
                    $error_message = "Error updating product: " . $conn->error;
                }
            } else {
                $error_message = "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        // Update product without changing the image
        $update_sql = "UPDATE products SET name='$name', description='$description', price='$price' WHERE id='$product_id'";
        if ($conn->query($update_sql) === TRUE) {
            $success_message = "Product updated successfully!";
        } else {
            $error_message = "Error updating product: " . $conn->error;
        }
    }
}

// Redirect back to the edit page with success or error message
if (isset($success_message)) {
    header("Location: edit_product.php?success=" . urlencode($success_message));
} elseif (isset($error_message)) {
    header("Location: edit_product.php?error=" . urlencode($error_message));
} else {
    header("Location: edit_product.php");
}
exit();
?>
