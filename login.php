<?php
session_start();
include 'includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to fetch user details by username
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username; // Set session variable for logged-in user
            header("Location: dashboard.php"); // Redirect to admin dashboard
        } else {
            $error_message = "Invalid username or password.";
        }
    } else {
        $error_message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Agus India Admin</title>
    <!-- Replace these URLs with your actual Tailwind CSS and Bootstrap (if needed) file paths -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <!-- <link href="../css/bootstrap.min.css" rel="stylesheet"> -->
    <style>
        /* Additional custom styles can be added here */
    </style>
</head>

<body class="bg-gray-100 flex justify-center items-center h-screen">

    <div class="w-full max-w-sm">
        <div class="bg-white shadow-md rounded px-8 py-6">
            <h1 class="text-2xl font-semibold text-center mb-4">Admin Login</h1>
            <form action="login.php" method="POST">
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" id="username" name="username"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                        required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                        required>
                </div>
                <button type="submit"
                    class="w-full py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-500 focus:ring-opacity-50">Login</button>
                <?php if (isset($error_message)) : ?>
                <div class="mt-2 text-red-600 text-sm"><?php echo $error_message; ?></div>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <!-- <script src="../js/bootstrap.min.js"></script> -->
    <!-- <script src="../js/jquery.min.js"></script> -->
    <!-- Your custom JavaScript file -->
    <!-- <script src="../js/custom.js"></script> -->
</body>

</html>
