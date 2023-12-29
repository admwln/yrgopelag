//How wide is one slide?
const slideWidth =
  document.querySelector('.feature-slider').scrollWidth /
  document.querySelectorAll('.feature').length;

//How wide is the visible part of the slider? Depends on screen size
let sliderWidth = slideWidth * 3;
function checkScreen(x) {
  if (x.matches) {
    // If media query matches
    sliderWidth = slideWidth;
  } else {
    sliderWidth = slideWidth * 3;
  }
}

// Create a MediaQueryList object
var x = window.matchMedia('(max-width: 1200px)');

// Call listener function at run time
checkScreen(x);

// Attach listener function on state changes
x.addEventListener('change', function () {
  checkScreen(x);
});

const rightBtn = document.querySelector('.slider-btn.right');
const leftBtn = document.querySelector('.slider-btn.left');

leftBtn.addEventListener('click', () => {
  document.querySelector('.feature-slider').scrollLeft -= slideWidth;
  updateBtns();
});

rightBtn.addEventListener('click', () => {
  document.querySelector('.feature-slider').scrollLeft += slideWidth;
  updateBtns();
});

// Listen for scroll events on .feature-slider
const slider = document.querySelector('.feature-slider');
slider.addEventListener('scroll', () => {
  console.log('scrolling');
  updateBtns();
});

function updateBtns() {
  //If not scrolled all the way to the right, show right button
  if (
    document.querySelector('.feature-slider').scrollLeft <
    document.querySelector('.feature-slider').scrollWidth - sliderWidth
  ) {
    rightBtn.style.display = 'block';
  }

  //If scrolled all the way to the left, hide left button
  if (document.querySelector('.feature-slider').scrollLeft <= 0) {
    leftBtn.style.display = 'none';
  } else {
    leftBtn.style.display = 'block';
  }
  //If not scrolled all the way to the left, show left button
  if (document.querySelector('.feature-slider').scrollLeft > 0) {
    leftBtn.style.display = 'block';
  } else {
    leftBtn.style.display = 'none';
  }

  //If scrolled all the way to the right, hide right button
  if (
    document.querySelector('.feature-slider').scrollLeft >
    document.querySelector('.feature-slider').scrollWidth - sliderWidth
  ) {
    rightBtn.style.display = 'none';
  } else {
    rightBtn.style.display = 'block';
  }
}
