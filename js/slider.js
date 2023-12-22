//How far to scroll on each click
let sliderWidth = document.querySelector('.feature-slider').scrollWidth;
sliderWidth = sliderWidth / document.querySelectorAll('.feature').length;

const rightBtn = document.querySelector('.slider-btn.right');
const leftBtn = document.querySelector('.slider-btn.left');

leftBtn.addEventListener('click', () => {
  document.querySelector('.feature-slider').scrollLeft -= sliderWidth;

  //If not scrolled all the way to the right, show right button
  if (
    document.querySelector('.feature-slider').scrollLeft <
    document.querySelector('.feature-slider').scrollWidth - 3 * sliderWidth
  ) {
    rightBtn.style.display = 'block';
  }

  //If scrolled all the way to the left, hide left button
  if (document.querySelector('.feature-slider').scrollLeft <= 0) {
    leftBtn.style.display = 'none';
  } else {
    leftBtn.style.display = 'block';
  }
});

rightBtn.addEventListener('click', () => {
  document.querySelector('.feature-slider').scrollLeft += sliderWidth;

  //If not scrolled all the way to the left, show left button
  if (document.querySelector('.feature-slider').scrollLeft > 0) {
    leftBtn.style.display = 'block';
  } else {
    leftBtn.style.display = 'none';
  }

  //If scrolled all the way to the left, hide left button
  if (
    document.querySelector('.feature-slider').scrollLeft >
    document.querySelector('.feature-slider').scrollWidth - 3 * sliderWidth
  ) {
    rightBtn.style.display = 'none';
  } else {
    rightBtn.style.display = 'block';
  }
});
