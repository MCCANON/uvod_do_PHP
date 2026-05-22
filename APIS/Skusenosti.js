let current = 0;
const slides = document.querySelectorAll('.slide');

function changeSlide(direction) {
  slides[current].classList.remove('active');
  current = (current + direction + slides.length) % slides.length;
  slides[current].classList.add('active');
}