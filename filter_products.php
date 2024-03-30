<?php
include 'includes/config.php';

// Check if a category filter is selected
$categoryFilter = isset($_GET['category']) ? $_GET['category'] : '';

// Fetch products based on the category filter
$query = "SELECT * FROM products";
if (!empty($categoryFilter)) {
  $query .= " WHERE category = '$categoryFilter'";
}

$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
  $output = '<ul class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">';

  while ($row = mysqli_fetch_assoc($result)) {
    $productId = $row['id']; // Assuming 'id' is the primary key in your products table
    $productName = $row['name'];
    $productImage = $row['image'];
    $productPrice = $row['price'];

    $output .= '<li>';
    $output .= '<a href="product_details.php?id=' . $productId . '" class="group block overflow-hidden">';
    $output .= '<img src="assets/images/products/' . $productImage . '" alt="' . $productName . '" class="h-[350px] w-full object-cover transition duration-500 group-hover:scale-105 sm:h-[450px]" />';
    $output .= '<div class="relative bg-white pt-3">';
    $output .= '<h3 class="text-xs text-gray-700 group-hover:underline group-hover:underline-offset-4">' . $productName . '</h3>';
    $output .= '<p class="mt-2">';
    $output .= '<span class="sr-only">Regular Price</span>';
    $output .= '<span class="tracking-wider text-gray-900">₹' . $productPrice . ' Rs</span>';
    $output .= '</p>';
    $output .= '</div>';
    $output .= '</a>';
    $output .= '</li>';
  }

  $output .= '</ul>';
} else {
  $output = 'No products found.';
}

echo $output;

mysqli_close($conn);
?>
