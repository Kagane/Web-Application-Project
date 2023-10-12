// from student.php
var swiper = new Swiper(".course-cards", {
  slidesPerView: 1,
  watchOverflow: true,
  spaceBetween: 30,
  loop: true,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  breakpoints: {
    320: {
      slidesPerView: 1,
    },
    430: {
      slidesPerView: 2,
    },
    768: {
      slidesPerView: 3,
    },
    1200: {
      slidesPerView: 4,
    },
  },
});

// from my-courses.php
document.getElementById('openImageLink').addEventListener('click', function() {
  var image = document.getElementById('imageDisplay');
  var imageName = 'logo.png'; // Replace with the actual name of the image file
  var imagePath = '../img/' + imageName;
  image.src = imagePath;
});


