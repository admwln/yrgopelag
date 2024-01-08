// Confirm purge
const purgeBtn = document.querySelector('#purge-btn');
purgeBtn.addEventListener('click', (e) => {
  if (!confirm('Are you sure you want to purge all data?')) {
    e.preventDefault();
  }
});
