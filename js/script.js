// When checking checkbox (".calendar-dates input"), toggle class "selected" on parent element, and remove class "available"
const calendarDates = document.querySelectorAll('.calendar-dates input');
calendarDates.forEach((date) => {
  date.addEventListener('click', () => {
    date.parentElement.classList.toggle('selected');
    date.parentElement.classList.toggle('available');

    // Get index of selected date
    let selectedDateIndex;
    for (let i = 0; i < calendarDates.length; i++) {
      if (calendarDates[i].parentElement.classList.contains('selected')) {
        selectedDateIndex = i;
      }
    }

    // If any date is selected
    if (document.querySelectorAll('.calendar-dates .selected').length > 0) {
      for (let l = 0; l < calendarDates.length; l++) {
        // If date with index i is checked, get index store index of previous date and break loop
        if (calendarDates[l].parentElement.classList.contains('selected')) {
          // Get index of previous date
          const startDateIndex = l;

          // Check if startDate is not equal to selectedDateIndex
          if (selectedDateIndex > startDateIndex) {
            // If startDateIndex is smaller than selectedDateIndex, loop from startDateIndex to selectedDateIndex and check all dates in between
            for (let m = startDateIndex; m <= selectedDateIndex; m++) {
              calendarDates[m].parentElement.classList.add('selected');
              calendarDates[m].parentElement.classList.remove('available');
              // Check all checkboxes in between
              calendarDates[m].checked = true;
            }
          }

          break;
        }
      }

      // Loop through all .calandar-dates li elements with class "selected" and get data value of the first and last element
      const selectedDates = document.querySelectorAll(
        '.calendar-dates li.selected'
      );
      let firstSelectedDate = selectedDates[0].getAttribute('data');
      firstSelectedDate = '2024-01-' + firstSelectedDate;
      let lastSelectedDate =
        selectedDates[selectedDates.length - 1].getAttribute('data');
      lastSelectedDate = '2024-01-' + lastSelectedDate;
      // Set value of input fields #arrival and #departure
      document.querySelector('#arrival').value = firstSelectedDate;
      document.querySelector('#departure').value = lastSelectedDate;
    }
    // If no date is selected
    if (document.querySelectorAll('.calendar-dates .selected').length <= 0) {
      // Set value of input fields #arrival and #departure
      document.querySelector('#arrival').value = '';
      document.querySelector('#departure').value = '';
    }
  });
});
