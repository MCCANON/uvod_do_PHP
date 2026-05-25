let current = 0;
const slides = document.querySelectorAll('.slide');

function changeSlide(direction) {
  const prev = slides[current];
  prev.classList.remove('active');
  prev.style.opacity = '0';

  setTimeout(() => {
    prev.style.display = 'none';
    current = (current + direction + slides.length) % slides.length;
    const next = slides[current];
    next.style.display = 'block';
    setTimeout(() => {
      next.style.opacity = '1';
      next.classList.add('active');
    }, 10);
  }, 300);
}