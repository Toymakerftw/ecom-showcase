<?php
// Check if the form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    include_once "includes/config.php";

    // Retrieve and sanitize the email address
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Validate the email address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address";
        exit; // Stop script execution
    }

    // Check if the email already exists in the database
    $checkQuery = "SELECT * FROM email_addresses WHERE email = '$email'";
    $result = mysqli_query($conn, $checkQuery);
    if (mysqli_num_rows($result) > 0) {
        echo "Already Subscribed";
    } else {
        // Insert the email address into the database
        $sql = "INSERT INTO email_addresses (email) VALUES ('$email')";
        if (mysqli_query($conn, $sql)) {
            echo "Email address added successfully";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // Handle the case when the form data is not submitted
    echo "Form data not submitted";
}
?>
