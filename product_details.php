<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgusIndia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <?php include 'includes/config.php' ?>
    <style>
        html,
        body {
            max-width: 100%;
            overflow-x: hidden;
        }
        img {
            max-width: 50%;
            max-height: auto;
        }
    </style>
</head>

<body>

<?php
include 'includes/navbar.php';

// Function to fetch product details by ID
function getProductDetailsById($productId, $conn)
{
    // Assume $conn is your database connection object
    $productId = mysqli_real_escape_string($conn, $productId);
    $query = "SELECT * FROM products WHERE id = '$productId'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    } else {
        return false; // Product not found
    }
}

// Check if the product ID is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Assuming you have a database connection named $conn
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Fetch product details using the getProductDetailsById function
    $productId = $_GET['id'];
    $productDetails = getProductDetailsById($productId, $conn);

    if ($productDetails) {
        $productName = $productDetails['name'];
        $productImage = $productDetails['image'];
        $productPrice = $productDetails['price'];
        $productDescription = $productDetails['description'];

        // Display product details
        echo '<section class="text-gray-700 body-font overflow-hidden bg-white">';
        echo '<div class="container px-5 py-24 mx-auto">';
        echo '<div class="lg:w-4/5 mx-auto flex flex-wrap">';
        echo '<img alt="ecommerce" class="lg:w-1/2 w-full object-cover object-center rounded border border-gray-200" src="assets/images/products/' . $productImage . '" alt="' . $productName . '">';
        echo '<div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">';
        echo '<h2 class="text-sm title-font text-gray-500 tracking-widest">AGUS INDIA</h2>';
        echo '<h1 class="text-gray-900 text-3xl title-font font-medium mb-1">' . $productName . '</h1>';
        echo '<div class="flex mb-4">';
        echo '<span class="flex items-center">';
        // Add your rating system here
        echo '</span>';
        echo '</div>';
        echo '<p class="leading-relaxed">' . $productDescription . '</p>';
        echo '<div class="flex mt-6 items-center pb-5 border-b-2 border-gray-200 mb-5">';
        echo '</div>';
        echo '<div class="flex">';
        echo '<span class="title-font font-medium text-2xl text-gray-900">₹' . $productPrice . ' Rs</span>';
        echo '<button class="ml-auto flex-shrink-0 text-white bg-red-500 border-0 py-2 px-6 focus:outline-none hover:bg-red-600 rounded" onclick="copyLink()">Share</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</section>';
    } else {
        echo '<p class="text-red-500">Product not found.</p>';
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    echo '<p class="text-red-500">Invalid product ID.</p>';
}
include 'includes/footer.php';
?>

    <script>
        function copyLink() {
            const currentUrl = window.location.href;
            navigator.clipboard.writeText(currentUrl)
                .then(() => {
                    alert('Product link copied to clipboard!');
                })
                .catch((err) => {
                    console.error('Failed to copy text: ', err);
                });
        }
    </script>

</body>
</html>