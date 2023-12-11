// SELECTED ROOM
// When page loads, get value of selectedRoomId (resides in index.php)
// If selectedRoomId is null or undefined, set value to 1
if (selectedRoomId === null || selectedRoomId === undefined) {
  selectedRoomId = 1;
}
// According to selectedRoomId, set class "selected" on corresponding room, both label and .room-info div
const selectedLabel = document.querySelector(
  '#choose-comfort-form label:nth-of-type(' + selectedRoomId + ')'
);
selectedLabel.classList.add('selected');
const selectedRoomInfo = document.querySelector(
  '.room-info:nth-of-type(' + selectedRoomId + ')'
);
selectedRoomInfo.classList.add('selected');

// When clicking on a label, remove class "selected" from all labels and .room-info divs, and add class "selected" to clicked label and corresponding .room-info div
const labels = document.querySelectorAll('#choose-comfort-form label');
labels.forEach((label) => {
  label.addEventListener('click', () => {
    // Get index of target label
    let targetLabelIndex;
    for (let i = 0; i < labels.length; i++) {
      if (labels[i] === label) {
        targetLabelIndex = i;
      }
    }
    // Remove class selected from all labels and .room-info divs with index other than targetLabelIndex
    for (let j = 0; j < labels.length; j++) {
      if (j !== targetLabelIndex) {
        labels[j].classList.remove('selected');
        document.querySelectorAll('.room-info')[j].classList.remove('selected');
      }
    }

    // Add class selected to labels and .room-info divs with index targetLabelIndex
    labels[targetLabelIndex].classList.add('selected');
    document
      .querySelectorAll('.room-info')
      [targetLabelIndex].classList.add('selected');

    // When clicking any label, add class hidden to .calendar
    document.querySelector('.calendar').classList.add('hidden');
  });
});

// CALENDAR
// When checking checkbox (".calendar-dates input"), toggle class "selected" on parent element, and remove class "available"
const calendarDates = document.querySelectorAll('.calendar-dates input');
calendarDates.forEach((date) => {
  date.addEventListener('click', () => {
    // If contains class "out-of-range", alert and return
    if (date.parentElement.classList.contains('out-of-range')) {
      alert('Please select consecutive dates');
      return;
    }

    date.parentElement.classList.toggle('selected');
    date.parentElement.classList.toggle('available');

    // Get index of selected date
    let selectedDateIndex;
    for (let i = 0; i < calendarDates.length; i++) {
      if (calendarDates[i].parentElement.classList.contains('selected')) {
        selectedDateIndex = i;
      }
    }

    // Get index of selected date in all dates
    const allDates = document.querySelectorAll('.calendar-dates li');
    let selectedDateIndexOfAll;
    for (let j = 0; j < allDates.length; j++) {
      if (allDates[j].classList.contains('selected')) {
        selectedDateIndexOfAll = j;
      }
    }
    // Starting at selectedDateIndexOfAll +1, loop through all higher dates and check if date has class "booked"
    let bookedFrom;
    for (let k = selectedDateIndexOfAll + 1; k < allDates.length; k++) {
      if (allDates[k].classList.contains('booked')) {
        bookedFrom = k;
        break;
      }
    }
    // Starting at selectedDateIndexOfAll -1, loop through all lower dates and check if date has class "booked"
    let bookedUntil;
    for (let k = selectedDateIndexOfAll - 1; k >= 0; k--) {
      if (allDates[k].classList.contains('booked')) {
        bookedUntil = k;
        break;
      }
    }
    // For all dates from bookedFrom and up, add class "out-of-range"
    for (let l = bookedFrom; l < allDates.length; l++) {
      allDates[l].classList.add('out-of-range');
    }
    // For all dates from bookedUntil and down, add class "out-of-range"
    for (let l = bookedUntil; l >= 0; l--) {
      allDates[l].classList.add('out-of-range');
    }

    // If no date is selected, remove class "out-of-range" from all dates
    if (document.querySelectorAll('.calendar-dates .selected').length <= 0) {
      for (let l = 0; l < allDates.length; l++) {
        allDates[l].classList.remove('out-of-range');
      }
    }

    // If any date is selected
    if (document.querySelectorAll('.calendar-dates .selected').length > 0) {
      for (let l = 0; l < calendarDates.length; l++) {
        // If date with index l is checked, get index store index of previous date and break loop
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

      // Turn into date format
      let firstSelectedDate = selectedDates[0].getAttribute('data');
      firstSelectedDate.length === 1
        ? (firstSelectedDate = '0' + firstSelectedDate)
        : firstSelectedDate;
      firstSelectedDate = '2024-01-' + firstSelectedDate;

      let lastSelectedDate =
        selectedDates[selectedDates.length - 1].getAttribute('data');
      lastSelectedDate.length === 1
        ? (lastSelectedDate = '0' + lastSelectedDate)
        : lastSelectedDate;
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
