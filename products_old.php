<section>
    <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <header>
            <h2 class="text-xl font-bold text-gray-900 sm:text-3xl">
                Product Collection
            </h2>

            <p class="mt-4 max-w-md text-gray-500">
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Itaque
                praesentium cumque iure dicta incidunt est ipsam, officia dolor
                fugit natus?
            </p>
        </header>

        <?php

        // Fetch products from the database
        $query = "SELECT * FROM products LIMIT 8";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo '<ul class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">';

            while ($row = mysqli_fetch_assoc($result)) {
                $productName = $row['name'];
                $productImage = $row['image'];
                $productPrice = $row['price'];

                echo '<li>';
                echo '<a href="#" class="group block overflow-hidden">';
                echo '<img src="assets/images/products/' . $productImage . '" alt="' . $productName . '" class="h-[350px] w-full object-cover transition duration-500 group-hover:scale-105 sm:h-[450px]" />';
                echo '<div class="relative bg-white pt-3">';
                echo '<h3 class="text-xs text-gray-700 group-hover:underline group-hover:underline-offset-4">' . $productName . '</h3>';
                echo '<p class="mt-2">';
                echo '<span class="sr-only">Regular Price</span>';
                echo '<span class="tracking-wider text-gray-900">₹' . $productPrice . ' Rs</span>';
                echo '</p>';
                echo '</div>';
                echo '</a>';
                echo '</li>';
            }

            echo '</ul>';
        } else {
            echo 'No products found.';
        }

        // Close the database connection
        mysqli_close($conn);
        ?>

    </div>
    <div class="flex justify-center items-center">
        <a href="filter.php" class="flex justify-center items-center">
            <button type="button" class="text-black bg-white border border-green-300 focus:outline-none hover:bg-green-100 focus:ring-4 focus:ring-green-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-800 dark:text-white dark:border-green-600 dark:hover:bg-green-700 dark:hover:border-green-600 dark:focus:ring-green-700">
                View All Products
            </button>
        </a>
    </div>


</section>