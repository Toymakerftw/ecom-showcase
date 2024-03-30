<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Hero Section with Carousel and Pagination</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    .hero-section {
      display: flex;
      flex-direction: column;
      padding: 50px;
    }

    .text-content {
      text-align: center;
    }

    .text-content h1 {
      font-size: 2rem;
      margin-bottom: 20px;
    }

    .text-content p {
      font-size: 1rem;
      line-height: 1.6;
    }

    .carousel-container {
      width: 100%;
      max-width: 800px;
      /* Set maximum width for the carousel */
      height: auto;
      position: relative;
      overflow: hidden;
      margin: 0 auto;
      /* Center the carousel horizontally */
    }

    .carousel {
      display: flex;
      transition: transform 0.5s ease;
    }

    .carousel img {
      max-width: 100%;
      height: auto;
      object-fit: cover;
      /* Maintain aspect ratio and cover the entire container */
    }

    .carousel-prev,
    .carousel-next {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background-color: rgba(255, 255, 255, 0.5);
      padding: 10px;
      cursor: pointer;
    }

    .carousel-prev {
      left: 10px;
    }

    .carousel-next {
      right: 10px;
    }

    .pagination {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }

    .pagination-dot {
      width: 10px;
      height: 10px;
      background-color: #bbb;
      border-radius: 50%;
      margin: 0 5px;
      cursor: pointer;
    }

    .pagination-dot.active {
      background-color: #333;
    }

    /* Media queries for responsiveness */
    @media screen and (min-width: 768px) {
      .hero-section {
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
      }

      .text-content {
        width: 50%;
        text-align: left;
      }

      .text-content h1 {
        font-size: 2.5rem;
      }

      .text-content p {
        font-size: 1.2rem;
      }

      .carousel-container {
        width: 50%;
        /* Adjust width as needed */
        max-width: 550px;
        /* Adjust maximum width as needed */
      }
    }
  </style>
</head>

<body>
  <div class="hero-section max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
    <div class="text-left">
      <h2 class="text-xl font-bold text-gray-900 sm:text-3xl">
        Modern Interior Design Studio
      </h2>
      <p class="mx-auto p-4">Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
    </div>
    <div class="carousel-container">
      <div class="carousel">
        <?php

        // Fetch categories from the database
        $query = "SELECT id, name, image FROM carousel";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            $carouselImage = $row['image'];
        ?>
            <img src="<?php echo $carouselImage; ?>" alt="Carousel-Image">
        <?php
          }
        } else {
          echo "No categories found.";
        }
        ?>
      </div>

      <div class="carousel-prev" style="display: none;" onclick="prevSlide()">&#10094;</div>
      <div class="carousel-next" style="display: none;" onclick="nextSlide()">&#10095;</div>
      <div class="pagination"></div>
    </div>
  </div>

  <script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('.carousel img');
    const totalSlides = slides.length;
    const paginationContainer = document.querySelector('.pagination');
    let autoplayInterval;

    function showSlide(index) {
      if (index < 0) {
        currentSlide = totalSlides - 1;
      } else if (index >= totalSlides) {
        currentSlide = 0;
      } else {
        currentSlide = index;
      }

      const offset = -currentSlide * 100;
      document.querySelector('.carousel').style.transform = `translateX(${offset}%)`;

      // Update pagination dots
      const paginationDots = document.querySelectorAll('.pagination-dot');
      paginationDots.forEach(dot => dot.classList.remove('active'));
      paginationDots[currentSlide].classList.add('active');
    }

    function nextSlide() {
      showSlide(currentSlide + 1);
    }

    function prevSlide() {
      showSlide(currentSlide - 1);
    }

    // Create pagination dots
    for (let i = 0; i < totalSlides; i++) {
      const dot = document.createElement('div');
      dot.classList.add('pagination-dot');
      if (i === currentSlide) {
        dot.classList.add('active');
      }
      dot.onclick = () => showSlide(i);
      paginationContainer.appendChild(dot);
    }

    function startAutoplay() {
      autoplayInterval = setInterval(nextSlide, 3000);
    }

    function stopAutoplay() {
      clearInterval(autoplayInterval);
    }

    startAutoplay();

    // Pause autoplay on mouse enter, resume on mouse leave
    const carouselContainer = document.querySelector('.carousel-container');
    carouselContainer.addEventListener('mouseenter', stopAutoplay);
    carouselContainer.addEventListener('mouseleave', startAutoplay);
  </script>
</body>

</html>