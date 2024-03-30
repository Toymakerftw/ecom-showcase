<?php
include 'includes/config.php';

// Get the visitor's IP address
$ip = $_SERVER['REMOTE_ADDR'];

// Check if the IP has visited recently (within the last 24 hours)
$timestampThreshold = date('Y-m-d H:i:s', strtotime('-24 hours'));
$checkIpQuery = "SELECT COUNT(*) AS ip_count FROM visitor_logs WHERE ip_address = '$ip' AND visit_time > '$timestampThreshold'";
$checkIpResult = $conn->query($checkIpQuery);

if ($checkIpResult && $checkIpResult->num_rows > 0) {
    $row = $checkIpResult->fetch_assoc();
    $ipCount = $row['ip_count'];

    if ($ipCount == 0) {
        // IP has not visited recently, update count and log the visit
        $updateCountQuery = "UPDATE visitor_counts SET count = count + 1 WHERE id = 1";
        $conn->query($updateCountQuery);

        $logVisitQuery = "INSERT INTO visitor_logs (ip_address, visit_time) VALUES ('$ip', NOW())";
        $conn->query($logVisitQuery);
    }
}

// Get updated visitor count
$getCountQuery = "SELECT count FROM visitor_counts WHERE id = 1";
$getCountResult = $conn->query($getCountQuery);

if ($getCountResult && $getCountResult->num_rows > 0) {
    $row = $getCountResult->fetch_assoc();
    $count = $row['count'];
    echo json_encode(['count' => $count]);
} else {
    echo json_encode(['count' => 0]);
}

// Close database connection
$conn->close();
?>