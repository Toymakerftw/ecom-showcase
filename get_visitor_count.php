<?php
include 'includes/config.php';

// Query to get visitor count from the database
$sql = "SELECT count FROM visitor_counts WHERE id = 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $count = $row['count'];
    echo json_encode(['count' => $count]);
} else {
    echo json_encode(['count' => 0]);
}

// Close database connection
$conn->close();
?>
