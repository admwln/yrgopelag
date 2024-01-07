// Slide width is the width of .feature element
let slideWidth = document.querySelector('.feature').offsetWidth;

// Slider width is identical to .room-info element width
let sliderWidth = document.querySelector('.room-info').offsetWidth;

// Arrow buttons for slider
const rightBtn = document.querySelector('.slider-btn.right');
const leftBtn = document.querySelector('.slider-btn.left');

leftBtn.addEventListener('click', () => {
  // Get the current width of the slide
  slideWidth = document.querySelector('.feature').offsetWidth;

  document.querySelector('.feature-slider').scrollLeft -= slideWidth;
  updateBtns();
});

rightBtn.addEventListener('click', () => {
  // Get the current width of the slide
  slideWidth = document.querySelector('.feature').offsetWidth;

  document.querySelector('.feature-slider').scrollLeft += slideWidth;
  updateBtns();
});

// Listen for scroll events on .feature-slider
const slider = document.querySelector('.feature-slider');
slider.addEventListener('scroll', () => {
  updateBtns();
});

function updateBtns() {
  // Get the current width of the slider
  sliderWidth = document.querySelector('.room-info').offsetWidth;

  // If not scrolled all the way to the right, show right button
  if (
    document.querySelector('.feature-slider').scrollLeft <
    document.querySelector('.feature-slider').scrollWidth - sliderWidth
  ) {
    rightBtn.style.display = 'block';
  }

  //If scrolled all the way to the left, hide left button
  if (document.querySelector('.feature-slider').scrollLeft === 0) {
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
    document.querySelector('.feature-slider').scrollLeft ===
    document.querySelector('.feature-slider').scrollWidth - sliderWidth
  ) {
    rightBtn.style.display = 'none';
  } else {
    rightBtn.style.display = 'block';
  }
}
