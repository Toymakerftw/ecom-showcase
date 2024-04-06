<style>
    /* Styles for the slider container */
    .slider-container {
        width: 100%;
        max-width: 800px;
        margin: auto;
        overflow: hidden;
        position: relative;       
    }

    /* Styles for the slider images */
    .slider-image {
        width: 100%;
        display: none;
        transition: transform 0.5s ease-in-out; /* Changed transition to transform */
        border-radius: 10px; /* Add border-radius for rounded corners */
    }

    /* Styles for the pagination dots */
    .pagination {
        text-align: center;
        margin-top: 10px;
    }

    .dot {
        display: inline-block;
        width: 10px;
        height: 10px;
        background-color: #bbb;
        border-radius: 50%;
        margin: 0 5px;
        cursor: pointer;
    }

    .dot.active {
        background-color: #333;
    }

    /* Media query for desktop screens */
    @media screen and (min-width: 768px) {
        .slider-container {
            max-width: 1000px; /* Increase max-width for better layout */
        }
    }
</style>

<div class="slider-container">
    <img class="slider-image" src="https://via.placeholder.com/800x400/ff0000/ffffff?text=Image+1" alt="Image 1">
    <img class="slider-image" src="https://via.placeholder.com/800x400/00ff00/ffffff?text=Image+2" alt="Image 2">
    <img class="slider-image" src="https://via.placeholder.com/800x400/0000ff/ffffff?text=Image+3" alt="Image 3">
    <img class="slider-image" src="https://via.placeholder.com/800x400/0000ff/ffffff?text=Image+4" alt="Image 3">

    <div class="pagination" id="pagination-container"></div>
</div>

<script>
    let slideIndex = 1;
    let slideInterval;

    showSlides(slideIndex);
    startSlideInterval();

    function currentSlide(n) {
        clearInterval(slideInterval);
        showSlides(slideIndex = n);
        startSlideInterval();
    }

    function showSlides(n) {
        const slides = document.getElementsByClassName("slider-image");
        const paginationContainer = document.getElementById("pagination-container");

        if (n > slides.length) {
            slideIndex = 1;
        }
        if (n < 1) {
            slideIndex = slides.length;
        }

        for (let i = 0; i < slides.length; i++) {
            slides[i].style.opacity = 0; // Start with opacity 0
            slides[i].style.display = "none";
        }

        slides[slideIndex - 1].style.display = "block";

        // Remove existing pagination dots
        paginationContainer.innerHTML = "";

        // Generate and append new pagination dots
        for (let i = 0; i < slides.length; i++) {
            const dot = document.createElement("span");
            dot.className = "dot";
            dot.onclick = function() { currentSlide(i + 1); };
            paginationContainer.appendChild(dot);
        }

        const dots = document.getElementsByClassName("dot");
        dots[slideIndex - 1].className += " active";

        setTimeout(() => {
            slides[slideIndex - 1].style.opacity = 1; // Fade in
        }, 1); // Delay to ensure display:block takes effect first
    }

    function startSlideInterval() {
        slideInterval = setInterval(() => {
            slideIndex++;
            showSlides(slideIndex);
        }, 5000); // Change the interval (in milliseconds) as desired
    }
</script>
