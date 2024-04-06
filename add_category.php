<?php
session_start();
include 'includes/config.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $categoryName = mysqli_real_escape_string($conn, $_POST['categoryName']);
    $imageFile = $_FILES['categoryImage'];

    // Check if category name and image are provided
    if (!empty($categoryName) && $imageFile['size'] > 0) {
        $target_dir = "assets/images/categories/"; // Specify target directory for image uploads
        $random_chars = uniqid(); // Generate unique identifier
        $target_file = $target_dir . $random_chars . "_" . basename($imageFile["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file is an actual image
        $check = getimagesize($imageFile["tmp_name"]);
        if ($check === false) {
            $response['success'] = false;
            $response['message'] = "File is not an image.";
        } elseif ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            $response['success'] = false;
            $response['message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        } else {
            if (move_uploaded_file($imageFile["tmp_name"], $target_file)) {
                // Image uploaded successfully, insert category into database
                $imagePath = $target_file; // Store the image path in the database
                $sql = "INSERT INTO categories (name, image) VALUES ('$categoryName', '$imagePath')";
                if ($conn->query($sql) === TRUE) {
                    $response['success'] = true;
                    $response['message'] = "Category added successfully!";
                } else {
                    $response['success'] = false;
                    $response['message'] = "Error adding category to database.";
                }
            } else {
                $response['success'] = false;
                $response['message'] = "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Category name and image are required.";
    }
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
