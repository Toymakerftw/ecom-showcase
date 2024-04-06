<?php
session_start();
include 'includes/config.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Fetch logged-in user's information from the database (optional)
$username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = $conn->query($sql);
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $user_id = $row['user_id'];
    // You can fetch more user information if needed
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .emailList {
            min-height: 200px;
            max-height: 200px;
            /* Set a maximum height for the scrollable div */
            overflow-y: auto;
            /* Enable vertical scrolling */
            padding: 10px;
            scrollbar-width: thin;
            scrollbar-color: #999 transparent;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="mx-auto max-w-screen-xl p-4 md:p-6 lg:p-8 xl:p-10  text-black-800 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 grid-rows-3 gap-4 md:gap-6 lg:gap-8 xl:gap-10">
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
            <?php
            // Fetch total number of categories
            $sql = "SELECT COUNT(*) AS total_categories FROM categories";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $total_categories = $row['total_categories'];
            ?>
            <h1 class="font-black text-xl pb-5">Total No. Of Products Categories</h1>
            <h5><?php echo $total_categories; ?></h5>
        </div>
        <div class="bg-blue-100 rounded p-5 row-span-3">
            <h1 class="font-black text-xl pb-5">Total No. Of Site Visitors</h1>
            <p><span id="visitorCount">0</span></p>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Make an AJAX request to fetch the visitor count from the server
                    fetch('get_visitor_count.php')
                        .then(response => response.json())
                        .then(data => {
                            // Display the visitor count on the webpage
                            document.getElementById('visitorCount').textContent = data.count;
                        })
                        .catch(error => console.error('Error fetching visitor count:', error));
                });
            </script>
        </div>
        <div class="bg-blue-100 rounded p-5 row-span-3">
            <h1 class="font-black text-xl pb-5">Add Product</h1>
            <form action="add_product.php" method="POST" enctype="multipart/form-data" id="addProductForm" class="max-w-sm mx-auto">
                <div class="mb-5">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter Product Name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                </div>
                <div class="mb-5">
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                    <textarea id="description" name="description" placeholder="Enter Product Description" rows="5" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required></textarea>
                </div>
                <div class="mb-5">
                    <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
                    <input type="text" id="price" name="price" placeholder="Enter Product Price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                </div>
                <div class="mb-5">
                    <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                    <select id="category" name="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option selected disabled>Select category...</option>
                        <!-- Add options dynamically from database categories -->
                        <?php
                        $categories_sql = "SELECT name FROM categories";
                        $categories_result = $conn->query($categories_sql);
                        while ($category = $categories_result->fetch_assoc()) {
                            echo "<option value='" . $category['name'] . "'>" . $category['name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-5">
                    <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product Image</label>
                    <input type="file" id="image" name="image" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                </div>
                <button type="button" id="addProductBtn" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add Product</button>
            </form>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    // Get form and button elements
                    const form = document.getElementById('addProductForm');
                    const addProductBtn = document.getElementById('addProductBtn');

                    // Event listener for button click
                    addProductBtn.addEventListener('click', function() {
                        // Create FormData object to store form data
                        const formData = new FormData(form);

                        // Send AJAX request
                        fetch('add_product.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                // Handle response
                                if (data.success) {
                                    // Show success alert
                                    alert(data.message);
                                    // Clear the form
                                    form.reset();
                                } else {
                                    // Show error alert
                                    alert(data.message);
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                // Show error alert
                                alert('An error occurred. Please try again later.');
                            });
                    });
                });
            </script>


        </div>
        <div class="grid grid-row-1 md:grid-row-2 gap-5 row-span-3">
            <div class="bg-blue-100 rounded p-5 row-span-2">
                <h1 class="font-black text-xl pb-5">Add Product Category</h1>
                <form id="addCategoryForm" enctype="multipart/form-data" class="max-w-sm mx-auto">
                    <div class="mb-5">
                        <label for="categoryName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category Name</label>
                        <input type="text" id="categoryName" name="categoryName" placeholder="Enter Category Name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    </div>
                    <div class="mb-5">
                        <label for="categoryImage" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category Image</label>
                        <input type="file" id="categoryImage" name="categoryImage" accept="image/*" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    </div>
                    <div class="mb-5">
                        <button type="button" id="addCategoryBtn" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add Category</button>
                    </div>
                </form>
                <script>
                document.addEventListener("DOMContentLoaded", function() {
                    // Get form and button elements
                    const form = document.getElementById('addCategoryForm');
                    const addProductBtn = document.getElementById('addCategoryBtn');

                    // Event listener for button click
                    addProductBtn.addEventListener('click', function() {
                        // Create FormData object to store form data
                        const formData = new FormData(form);

                        // Send AJAX request
                        fetch('add_category.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                // Handle response
                                if (data.success) {
                                    // Show success alert
                                    alert(data.message);
                                    // Clear the form
                                    form.reset();
                                } else {
                                    // Show error alert
                                    alert(data.message);
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                // Show error alert
                                alert('An error occurred. Please try again later.');
                            });
                    });
                });
                </script>
            </div>
            <div class="bg-blue-100 rounded p-5 row-span-2">
                <h1 class="font-black text-xl pb-5">Add Carousel Image</h1>

                <form id="addCarouselForm" enctype="multipart/form-data" class="max-w-sm mx-auto" onclick="addCarousel()">
                    <div class="mb-5">
                        <label for="CarouselName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Carousel Text</label>
                        <input type="text" id="CarouselName" name="CarouselName" placeholder="Enter Carousel Text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    </div>
                    <div class="mb-5">
                        <label for="CarouselImage" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Carousel Image</label>
                        <input type="file" id="CarouselImage" name="CarouselImage" accept="image/*" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    </div>
                    <div class="mb-5">
                        <button type="button" id="addCarouselBtn" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add Carousel Image</button>
                    </div>
                </form>
                <script>
                document.addEventListener("DOMContentLoaded", function() {
                    // Get form and button elements
                    const form = document.getElementById('addCarouselForm');
                    const addProductBtn = document.getElementById('addCarouselBtn');

                    // Event listener for button click
                    addProductBtn.addEventListener('click', function() {
                        // Create FormData object to store form data
                        const formData = new FormData(form);

                        // Send AJAX request
                        fetch('add_carousel.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                // Handle response
                                if (data.success) {
                                    // Show success alert
                                    alert(data.message);
                                    // Clear the form
                                    form.reset();
                                } else {
                                    // Show error alert
                                    alert(data.message);
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                // Show error alert
                                alert('An error occurred. Please try again later.');
                            });
                    });
                });
                </script>
            </div>
        </div>
        <div class="grid grid-row-1 md:grid-row-2 gap-5 row-span-3">
            <div class="bg-blue-100 rounded p-5 row-span-2">
                <h1 class="font-black text-xl pb-5">Add New Offer</h1>
                <form action="add_offer.php" method="POST" enctype="multipart/form-data" class="max-w-sm mx-auto" id="addOfferForm" onclick="addOfferForm()">
                    <div class="mb-5">
                        <label for="offerName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Offer Text</label>
                        <input type="text" id="offerName" name="offerName" placeholder="Enter offer Name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    </div>
                    <div class="mb-5">
                        <label for="offerImage" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Offer Image</label>
                        <input type="file" id="offerImage" name="offerImage" accept="image/*" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    </div>
                    <div class="mb-5">
                        <button type="button" id="addOfferBtn" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add Offer</button>
                    </div>
                </form>
                <script>
                document.addEventListener("DOMContentLoaded", function() {
                    // Get form and button elements
                    const form = document.getElementById('addOfferForm');
                    const addProductBtn = document.getElementById('addOfferBtn');

                    // Event listener for button click
                    addProductBtn.addEventListener('click', function() {
                        // Create FormData object to store form data
                        const formData = new FormData(form);

                        // Send AJAX request
                        fetch('add_offer.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                // Handle response
                                if (data.success) {
                                    // Show success alert
                                    alert(data.message);
                                    // Clear the form
                                    form.reset();
                                } else {
                                    // Show error alert
                                    alert(data.message);
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                // Show error alert
                                alert('An error occurred. Please try again later.');
                            });
                    });
                });
                </script>

            </div>
            <div class="bg-blue-100 rounded p-5 row-span-2">
                <h1 class="font-black text-xl pb-5">Email Addresses</h1>
                <div class="emailList" id="emailList"></div>
                <button id="downloadButton" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Download CSV
                </button>
                <script>
                    // Fetch email addresses using AJAX
                    fetch('fetch_emails.php')
                        .then(response => response.json())
                        .then(data => {
                            // Display email addresses in the emailList div
                            const emailList = document.getElementById('emailList');
                            data.forEach(email => {
                                emailList.innerHTML += `<p class="font-semibold text-gray-900 pb-5 dark:text-black">${email}</p>`;
                            });
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            // Display error message if AJAX request fails
                            const emailList = document.getElementById('emailList');
                            emailList.innerHTML = '<p>An error occurred while fetching email addresses.</p>';
                        });

                    // Function to convert array of email addresses to CSV format
                    function convertToCSV(data) {
                        const csvContent = "data:text/csv;charset=utf-8," +
                            data.map(email => email).join("\n");

                        // Create a temporary anchor element to trigger the download
                        const encodedUri = encodeURI(csvContent);
                        const link = document.createElement("a");
                        link.setAttribute("href", encodedUri);
                        link.setAttribute("download", "email_addresses.csv");
                        document.body.appendChild(link); // Required for Firefox
                        link.click();
                    }

                    document.getElementById('downloadButton').addEventListener('click', () => {
                        fetch('fetch_emails.php')
                            .then(response => response.json())
                            .then(data => {
                                convertToCSV(data);
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('An error occurred while fetching email addresses.');
                            });
                    });
                </script>
            </div>
        </div>
    </div>
</body>

</html>