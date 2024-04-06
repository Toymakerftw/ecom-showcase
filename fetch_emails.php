<?php
// Include your database connection file
include_once "includes/config.php";

// Query to fetch all email addresses
$sql = "SELECT email FROM email_addresses";
$result = mysqli_query($conn, $sql);

// Check if there are any results
if (mysqli_num_rows($result) > 0) {
    $emails = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $emails[] = $row['email'];
    }
    echo json_encode($emails);
} else {
    echo "No email addresses found";
}

// Close the database connection
mysqli_close($conn);
?>
