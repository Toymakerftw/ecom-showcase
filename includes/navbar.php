<nav class="bg-white border-gray-200">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
      <a href="index.php" class="flex items-center space-x-3 rtl:space-x-reverse">
        <img src="assets/images/agus_logo.png" alt="AgusIndia" class="logo" /> <span style="display:none;" class="self-center text-2xl font-semibold whitespace-nowrap">AgusIndia</span>
        <span style="display:none;" class="self-center text-2xl font-semibold whitespace-nowrap">AgusIndia</span>
      </a>
      <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="navbar-default" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
        </svg>
      </button>
      <div class="hidden w-full md:block md:w-auto" id="navbar-default">
        <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white">
          <li>
            <a href="index.php" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-green-700 md:p-0">Home</a>
          </li>
          <li>
            <a href="filter.php" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-green-700 md:p-0">Products</a>
          </li>
          <li>
            <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-green-700 md:p-0">Services</a>
          </li>
          <li>
            <a href="contact.php" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-green-700 md:p-0">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <style>
    .logo {
      width: 8rem;
    }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
        var currentPageUrl = window.location.href;

        // Select all anchor tags in the navigation
        var navLinks = document.querySelectorAll('nav a');

        // Loop through each anchor tag and check if its href matches the current URL
        navLinks.forEach(function (link) {
            if (link.href === currentPageUrl) {
                // Remove blue classes and add white classes
                link.classList.remove('text-white', 'lg:text-white');
                link.classList.add('text-green-700', 'lg:text-green-700');
                link.style.textShadow = '2px 2px 25px #000000';
            }
        });
    });
</script>
<script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>