<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bento Grid</title>
  <!-- Include the Tailwind CSS file -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <link rel="stylesheet" href="assets/css/styles.css">
  <?php include 'includes/config.php' ?>
</head>
<body>

<?php include 'includes/navbar.php'?>

  <form id="filter-form" class="max-w-screen-xl mx-auto px-4 py-4">
    <label for="category" class="block font-medium text-gray-700">Filter by Category:</label>
    <select id="category" name="category" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
      <option value="">All Categories</option>
      <?php
      // Fetch category names from the categories table
      $categoryQuery = "SELECT * FROM categories";
      $categoryResult = mysqli_query($conn, $categoryQuery);

      if ($categoryResult && mysqli_num_rows($categoryResult) > 0) {
        while ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
          echo '<option value="' . $categoryRow['name'] . '">' . $categoryRow['name'] . '</option>';
        }
      }
      ?>
    </select>
    <button type="submit" class="mt-2 px-4 py-2 bg-green-600 text-white rounded-md shadow-md hover:bg-green-700">Filter</button>
  </form>

  <!-- Container to hold filtered products -->
  <div id="product-list-container" class="max-w-screen-xl mx-auto px-4 py-4"></div>

  <?php include 'footer.php' ?>
  <script>
    $(document).ready(function() {
      // Initial AJAX request to load all products
      $.ajax({
        url: 'filter_products.php',
        type: 'GET',
        success: function(response) {
          $('#product-list-container').html(response); // Update the product list container with all products
        },
        error: function(xhr, status, error) {
          console.error(xhr.responseText);
        }
      });

      $('#filter-form').submit(function(event) {
        event.preventDefault(); // Prevent default form submission

        console.log('Form submitted'); // Debugging log

        var selectedCategory = $('#category').val();
        console.log('Selected category:', selectedCategory); // Debugging log

        var url = 'filter_products.php?category=' + selectedCategory;
        console.log('AJAX URL:', url); // Debugging log

        $.ajax({
          url: url,
          type: 'GET',
          success: function(response) {
            $('#product-list-container').html(response); // Update the product list container with filtered products
          },
          error: function(xhr, status, error) {
            console.error(xhr.responseText);
          }
        });
      });
    });
  </script>

</body>
</html>
