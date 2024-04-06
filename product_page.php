<?php
include 'includes/navbar.php';

include 'includes/config.php';

// Check if the category ID is provided in the URL query string
if (isset($_GET['category'])) {
    $categoryId = $_GET['category'];

    // Fetch category name based on the category ID
    $categoryQuery = "SELECT name FROM categories WHERE id = '$categoryId'";
    $categoryResult = mysqli_query($conn, $categoryQuery);
    $categoryRow = mysqli_fetch_assoc($categoryResult);
    $categoryName = $categoryRow['name'];

    // Fetch products belonging to the specified category
    $productsQuery = "SELECT * FROM products WHERE category = '$categoryName'";
    $productsResult = mysqli_query($conn, $productsQuery);
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $categoryName; ?> Products</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
        <!-- Add any additional CSS or meta tags here -->
    </head>

    <body class="bg-gray-100">
        <section>
            <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
                <header>
                    <h2 class="text-xl font-bold text-gray-900 sm:text-3xl">
                        <?php echo $categoryName; ?> Products
                    </h2>

                    <p class="mt-4 max-w-md text-gray-500">
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Itaque
                        praesentium cumque iure dicta incidunt est ipsam, officia dolor
                        fugit natus?
                    </p>
                </header>

                <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <?php
                    if (mysqli_num_rows($productsResult) > 0) {
                        while ($productRow = mysqli_fetch_assoc($productsResult)) {
                            $productId = $productRow['id'];
                            $productName = $productRow['name'];
                            $productPrice = $productRow['price'];
                            $productImage = $productRow['image'];
                            $productDescription = $productRow['description'];
                    ?>
                            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                                <a href="product_details.php?id=<?php echo $productId; ?>" class="group block overflow-hidden">
                                <img src="assets/images/products/<?php echo $productImage; ?>" alt="<?php echo $productName; ?>" class="h-[350px] w-full object-cover transition duration-500 group-hover:scale-105 sm:h-[450px]" />
                                    <div class="p-4">
                                        <h3 class="text-gray-900 font-medium group-hover:underline"><?php echo $productName; ?></h3>
                                        <p class="mt-2 text-gray-700"><?php echo $productDescription; ?></p>
                                        <p class="mt-2 text-gray-900 font-semibold">₹<?php echo $productPrice; ?> Rs</p>
                                    </div>
                                </a>
                            </div>
                    <?php
                        }
                    } else {
                        echo '<p class="text-gray-700">No products found for this category.</p>';
                    }
                    ?>
                </div>
            </div>
            <div class="flex justify-center items-center mt-8">
                <a href="filter.php" class="flex justify-center items-center">
                    <button type="button" class="text-black bg-white border border-green-300 focus:outline-none hover:bg-green-100 focus:ring-4 focus:ring-green-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-800 dark:text-white dark:border-green-600 dark:hover:bg-green-700 dark:hover:border-green-600 dark:focus:ring-green-700">
                        View All Products
                    </button>
                </a>
            </div>
        </section>
        <!-- Add any additional HTML or JavaScript here -->
    </body>

    </html>
<?php
} else {
    // Redirect to a default page or display an error message
    header("Location: index.php"); // Change 'index.php' to your desired default page
    exit();
}
include 'includes/footer.php'
?>
