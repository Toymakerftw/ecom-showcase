<?php
session_start();
include 'includes/config.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    // Handle image upload
    $target_dir = "assets/images/products/";
    $target_file = $target_dir . uniqid() . "_" . basename($_FILES["image"]["name"]); // Create unique filename
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
        $response = array('success' => false, 'message' => $error_message);
    } else {
        // Try to upload the file
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Insert new product into database with image path
            $image_path = basename($target_file);
            $sql = "INSERT INTO products (name, description, price, category, image) VALUES ('$name', '$description', '$price', '$category', '$image_path')";
            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Product added successfully!');
            } else {
                $response = array('success' => false, 'message' => 'Error adding product to database.');
            }
        } else {
            $response = array('success' => false, 'message' => 'Error uploading image.');
        }
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
