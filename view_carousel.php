<?php
session_start();
include 'includes/config.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Handle AJAX request for deleting an image
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $sql_delete = "DELETE FROM carousel WHERE id = $delete_id";
    if ($conn->query($sql_delete) === TRUE) {
        echo "Image deleted successfully";
        exit();
    } else {
        echo "Error deleting image: " . $conn->error;
        exit();
    }
}

// Fetch all images from the carousel table
$sql = "SELECT * FROM carousel";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Carousel Images</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <?php include 'header.php' ?>
    <div class="flex min-h-screen items-center justify-center">
    <div>
        <div class="grid min-h-[140px] w-full place-items-center overflow-x-scroll rounded-lg p-6 lg:overflow-visible">
            <div role="alert" class="relative block w-full text-base font-regular px-4 py-4 rounded-lg bg-blue-100 text-white flex">
                <div class=" mr-12">
                    <p class="font-bold text-black">Don't add more than 3 images to Carousel as it would looks weird!
                    </p>
                </div>
            </div>
        </div>
    <div class="max-w-screen-xl px-4 mx-auto">
        <div class="container mx-auto py-8">
            <h1 class="text-3xl font-bold mb-6">Carousel Images</h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                <?php
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <div class="max-w-sm bg-blue-100 rounded p-5 border border-gray-200 rounded-lg shadow-md flex flex-col justify-between">
                            <a href="#">
                                <img class="rounded-t-lg" src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" />
                            </a>
                            <div class="p-1">
                                <button class="delete-btn inline-flex justify-center items-center px-3 py-2 text-sm font-medium text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300" data-id="<?php echo $row['id']; ?>">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>

                <?php
                    }
                } else {
                    echo '<p class="text-xl text-gray-600">No images found.</p>';
                }
                ?>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        $('.delete-btn').click(function() {
            var id = $(this).data('id');
            var cardToRemove = $(this).closest('.max-w-sm'); // Get the parent card element to remove

            $.ajax({
                url: 'delete_carousel.php',
                type: 'POST',
                data: {
                    delete_id: id
                },
                success: function(response) {
                    alert(response); // You can replace this with any action you want (e.g., removing the card from the grid)
                    cardToRemove.remove(); // Remove the card from the grid after successful deletion
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); // Log any errors to the console
                }
            });
        });
    });
</script>
</body>
</html>