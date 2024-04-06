<?php
session_start();
include 'includes/config.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="mx-auto max-w-screen-xl p-4 md:p-6 lg:p-8 xl:p-10  text-black-800 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 grid-rows-2 gap-4 md:gap-6 lg:gap-8 xl:gap-10">
        <div class="bg-blue-100 rounded p-5 row-span-3">
            <?php
            // Fetch total number of products
            $sql = "SELECT COUNT(*) AS total_products FROM products";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $total_products = $row['total_products'];
            ?>
            <h1 class="font-black text-xl pb-5">Total No. Of Products</h1>
            <h5><?php echo $total_products; ?></h5>
        </div>
        <div class="bg-blue-100 rounded p-5 row-span-3">
            <div class="mb-5">
                <label for="filter" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Filter By Category:</label>
                <select id="filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="all" selected>All Products</option>
                    <!-- Add options dynamically from database categories -->
                    <?php
                    $categories_sql = "SELECT DISTINCT category FROM products";
                    $categories_result = $conn->query($categories_sql);
                    while ($category = $categories_result->fetch_assoc()) {
                        echo "<option value='" . $category['category'] . "'>" . $category['category'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <script>
                $(document).ready(function() {
                    // Filter products based on category selection
                    $('#filter').change(function() {
                        var category = $(this).val();
                        if (category == 'all') {
                            $('#product-list .group').show();
                        } else {
                            $('#product-list .group').hide();
                            $('#product-list .group').each(function() {
                                if ($(this).find('h3 a').text().includes(category)) {
                                    $(this).show();
                                }
                            });
                        }
                    });
                });
            </script>

        </div>
    </div>

<div class="bg-white">
    <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
        <h2 class="text-2xl font-bold tracking-tight text-gray-900">Filter By Category</h2>

        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8" id="product-list">
            <?php
            // Fetch all products from the database
            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) :
            ?>
                <div class="group relative">
                    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80 relative">
                        <!-- Image -->
                        <img src="assets/images/products/<?php echo $row['image']; ?>" alt="Product Image" class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                        <!-- Edit and Delete Icons -->
                        <div class="absolute top-2 right-2 flex gap-x-2">
                            <a href="#" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-edit"></i> <!-- Edit icon -->
                            </a>
                            <a href="delete_product.php?id=<?php echo $row['id']; ?>" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-trash-alt"></i> <!-- Delete icon -->
                            </a>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-between">
                        <!-- Product Details -->
                        <div>
                            <h3 class="text-sm text-gray-700">
                                <a href="#">
                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                    <?php echo $row['name']; ?>
                                </a>
                            </h3>
                            <p class="mt-1 text-sm text-gray-500"><?php echo $row['description']; ?></p>
                        </div>
                        <p class="text-sm font-medium text-gray-900">$<?php echo $row['price']; ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>

</body>

</html>