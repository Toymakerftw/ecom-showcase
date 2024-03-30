<div class="mx-auto max-w-md">
        <strong class="block text-center text-xl font-bold text-gray-900 sm:text-3xl">
          Want us to email you with the latest blockbuster news?
        </strong>

        <form id="emailForm" class="mt-6" onsubmit="submitForm(event)">
          <div class="relative max-w-lg">
            <label class="sr-only" for="email">Email</label>
            <input class="w-full rounded-full border-gray-200 bg-gray-100 p-4 pe-32 text-sm font-medium" id="email" name="email" type="email" placeholder="john@doe.com" required />
            <button class="absolute end-1 top-1/2 -translate-y-1/2 rounded-full bg-green-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-green-700" type="submit">
              Subscribe
            </button>
          </div>
        </form>

        <div id="resultMessage" class="mt-4 text-sm text-gray-800"></div>

        <script>
          function submitForm(event) {
            event.preventDefault(); // Prevent default form submission

            // Get form data
            let formData = new FormData(document.getElementById("emailForm"));

            // Send form data using AJAX
            fetch('email_addresses.php', {
                method: 'POST',
                body: formData
              })
              .then(response => response.text())
              .then(data => {
                document.getElementById("resultMessage").innerHTML = data; // Display result or status message
                document.getElementById("emailForm").reset(); // Reset the form

                // Hide the message after 5 seconds
                setTimeout(() => {
                  document.getElementById("resultMessage").style.display = 'none';
                }, 5000); // 5000 milliseconds = 5 seconds

              })
              .catch(error => {
                console.error('Error:', error);
                // Display error message if AJAX request fails
                document.getElementById("resultMessage").innerHTML = 'An error occurred while submitting the form.';
              });
          }
        </script>


      </div>