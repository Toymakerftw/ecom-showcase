<style>
    .category-card {
        position: relative;
        background-color: rgba(0, 0, 0, 0.5); /* Adjust the transparency as needed */
        height: 200px;
        cursor: pointer; /* Add cursor pointer for clickable effect */
    }

    .category-card img {
        object-fit: cover;
        width: 100%;
        height: 100%;
    }

    .category-card .overlay-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        color: #fff;
        z-index: 1;
    }
</style>

<div class="text-left max-w-screen-xl mx-auto py-8 px-4">
    <h2 class="text-xl font-bold text-gray-900 sm:text-3xl">
        Shop By Category
    </h2>
</div>

<div class="container max-w-screen-xl mx-auto py-8 px-4">
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4">
        <?php
        // Fetch categories from the database
        $query = "SELECT id, name, image FROM categories";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $categoryId = $row['id'];
                $categoryName = $row['name'];
                $categoryImage = $row['image'];

                // Fetch number of products for this category from products table
                $productCountQuery = "SELECT COUNT(*) as total FROM products WHERE category = '$categoryName'";
                $productCountResult = mysqli_query($conn, $productCountQuery);
                $productCountRow = mysqli_fetch_assoc($productCountResult);
                $productCount = $productCountRow['total'];
        ?>
                <!-- Example cards for categories -->
                <div class="relative bg-gray-300 rounded-lg overflow-hidden shadow-md category-card" onclick="redirectToCategoryPage('<?php echo $categoryId; ?>')">
                    <img class="blur-sm brightness-50 max-w-xs transition duration-300 ease-in-out hover:scale-110" src="<?php echo $categoryImage; ?>" alt="<?php echo $categoryName; ?>">
                    <div class="overlay-content">
                        <h3 class="[text-shadow:1px_1px_2px_var(--tw-shadow-color)] shadow-green-900 text-xl font-semibold"><?php echo $categoryName; ?></h3>
                        <p class="[text-shadow:1px_1px_2px_var(--tw-shadow-color)] shadow-green-900"><?php echo $productCount; ?> Products</p>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "No categories found.";
        }
        ?>
    </div>
</div>

<script>
    function redirectToCategoryPage(categoryId) {
        window.location.href = 'product_page.php?category=' + categoryId; // Replace 'product_page.php' with your actual product page URL
    }
</script>
