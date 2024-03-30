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
    $offerName = $_POST['offerName'];
    $imageFile = $_FILES['offerImage'];

    // Check if category name and image are provided
    if (!empty($offerName) && $imageFile['size'] > 0) {
        $target_dir = "assets/images/offers/"; // Specify target directory for image uploads
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
            // Check if maximum images limit is reached
            $sql_count = "SELECT COUNT(*) as image_count FROM offers";
            $result_count = $conn->query($sql_count);
            if ($result_count && $result_count->num_rows > 0) {
                $row = $result_count->fetch_assoc();
                $image_count = $row['image_count'];
                if ($image_count >= 5) {
                    $response['success'] = false;
                    $response['message'] = "Maximum image upload limit reached (5 images allowed).";
                } else {
                    if (move_uploaded_file($imageFile["tmp_name"], $target_file)) {
                        // Image uploaded successfully, insert category into database
                        $imagePath = $target_file; // Store the image path in the database
                        $sql = "INSERT INTO offers (name, image) VALUES ('$offerName', '$imagePath')";
                        if ($conn->query($sql) === TRUE) {
                            $response['success'] = true;
                            $response['message'] = "Offer added successfully!";
                        } else {
                            $response['success'] = false;
                            $response['message'] = "Error: " . $sql . "<br>" . $conn->error;
                        }
                    } else {
                        $response['success'] = false;
                        $response['message'] = "Sorry, there was an error uploading your file.";
                    }
                }
            } else {
                $response['success'] = false;
                $response['message'] = "Error counting images.";
            }
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Offer name and image are required.";
    }
}

// Return JSON response
echo json_encode($response);
?>
