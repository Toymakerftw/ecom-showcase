$(document).ready(function() {
    $("#addProductForm").submit(function(e) {
        e.preventDefault(); // Prevent default form submission

        var formData = new FormData(this); // Collect form data

        $.ajax({
            url: "add_product.php", // Send data to this URL
            type: "POST",
            data: formData,
            contentType: false, // Required for form data
            processData: false, // Required for form data
            success: function(response) {
                // Handle successful response
                if (response == "success") {
                    $("#addProductForm")[0].reset(); // Clear form fields
                    alert("Product added successfully!"); // Display success message
                } else {
                    alert("Error adding product: " + response); // Display error message
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Handle AJAX errors
                alert("Something went wrong: " + textStatus + " - " + errorThrown);
            }
        });
    });
});