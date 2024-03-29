const SELECTED_CLASS = 'selected';
const AVAILABLE_CLASS = 'available';
const OUT_OF_RANGE_CLASS = 'out-of-range';
const BOOKED_CLASS = 'booked';

// Determine which room is selected
selectedRoomId = parseInt(selectedRoomId);

function onLoad() {
  // SELECTED ROOM
  // When page loads, get value of selectedRoomId (resides in index.php)
  // If selectedRoomId is null or undefined, set value to 1
  if (selectedRoomId !== 1 && selectedRoomId !== 2 && selectedRoomId !== 3) {
    //console.log('selectedRoomId is null or undefined, will give it value 1');
    selectedRoomId = 1;
  }
  //console.log('selectedRoomId is ' + selectedRoomId);
  // According to selectedRoomId, set class "selected" on corresponding room, both input[submit] and .room-info div
  const selectedTag = document.querySelector(
    '#choose-comfort-form input:nth-of-type(' + selectedRoomId + ')'
  );
  selectedTag.classList.add(SELECTED_CLASS);

  const selectedRoomInfo = document.querySelector(
    '.room-info:nth-of-type(' + selectedRoomId + ')'
  );
  selectedRoomInfo.classList.add(SELECTED_CLASS);
}

onLoad();

// CALENDAR
// When checking checkbox (".calendar-dates input"), toggle class "selected" on parent element, and remove class "available"
const selectableCalendarDates = document.querySelectorAll(
  '.calendar-dates input'
);
selectableCalendarDates.forEach((date) => {
  date.addEventListener('click', () => {
    processDate(date);
  });
});

function processDate(date) {
  let firstSelectedDate;
  let lastSelectedDate;

  // If contains class "out-of-range", alert and return
  if (date.parentElement.classList.contains(OUT_OF_RANGE_CLASS)) {
    alert('Please select consecutive dates');
    return;
  }

  date.parentElement.classList.toggle(SELECTED_CLASS);
  date.parentElement.classList.toggle(AVAILABLE_CLASS);

  // Get index of selected date relative to all dates
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
    if (allDates[k].classList.contains(BOOKED_CLASS)) {
      bookedFrom = k;
      break;
    }
  }
  // Starting at selectedDateIndexOfAll -1, loop through all lower dates and check if date has class "booked"
  let bookedUntil;
  for (let k = selectedDateIndexOfAll - 1; k >= 0; k--) {
    if (allDates[k].classList.contains(BOOKED_CLASS)) {
      bookedUntil = k;
      break;
    }
  }
  // For all dates from bookedFrom and up, add class "out-of-range"
  for (let l = bookedFrom; l < allDates.length; l++) {
    allDates[l].classList.add(OUT_OF_RANGE_CLASS);
  }
  // For all dates from bookedUntil and down, add class "out-of-range"
  for (let l = bookedUntil; l >= 0; l--) {
    allDates[l].classList.add(OUT_OF_RANGE_CLASS);
  }

  // If no date is selected, remove class "out-of-range" from all dates
  // Disable #reserve-btn
  if (document.querySelectorAll('.calendar-dates .selected').length <= 0) {
    const reserveBtn = document.querySelector('#reserve-btn');
    reserveBtn.disabled = true;

    for (let l = 0; l < allDates.length; l++) {
      allDates[l].classList.remove(OUT_OF_RANGE_CLASS);
    }
  }

  // If any date is selected...
  // Enable #reserve-btn
  if (document.querySelectorAll('.calendar-dates .selected').length > 0) {
    const reserveBtn = document.querySelector('#reserve-btn');
    reserveBtn.disabled = false;
    // If two dates are checked, check all dates in between
    for (let l = 0; l < selectableCalendarDates.length; l++) {
      // If date with index l is checked, get index store index of previous date and break loop
      if (
        selectableCalendarDates[l].parentElement.classList.contains('selected')
      ) {
        // Get index of previous date
        const startDateIndex = l;

        // Get index of selected date relative to all selectable dates
        let selectedDateIndex;
        for (let i = 0; i < selectableCalendarDates.length; i++) {
          if (
            selectableCalendarDates[i].parentElement.classList.contains(
              'selected'
            )
          ) {
            selectedDateIndex = i;
          }
        }

        // Check if startDate is not equal to selectedDateIndex
        if (selectedDateIndex > startDateIndex) {
          // If startDateIndex is smaller than selectedDateIndex, loop from startDateIndex to selectedDateIndex and check all dates in between
          for (let m = startDateIndex; m <= selectedDateIndex; m++) {
            selectableCalendarDates[m].parentElement.classList.add(
              SELECTED_CLASS
            );
            selectableCalendarDates[m].parentElement.classList.remove(
              AVAILABLE_CLASS
            );
            // Check all checkboxes in between
            selectableCalendarDates[m].checked = true;
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
    firstSelectedDate = selectedDates[0].getAttribute('data');
    firstSelectedDate.length === 1
      ? (firstSelectedDate = '0' + firstSelectedDate)
      : firstSelectedDate;
    firstSelectedDate = '2024-01-' + firstSelectedDate;

    lastSelectedDate =
      selectedDates[selectedDates.length - 1].getAttribute('data');
    lastSelectedDate.length === 1
      ? (lastSelectedDate = '0' + lastSelectedDate)
      : lastSelectedDate;
    lastSelectedDate = '2024-01-' + lastSelectedDate;
  }
  // If no date is selected, unset value of input fields #arrival and #departure
  if (document.querySelectorAll('.calendar-dates .selected').length <= 0) {
    firstSelectedDate = '';
    lastSelectedDate = '';
  }
  // Set value of input fields #arrival and #departure
  document.querySelector('#arrival').value = firstSelectedDate;
  document.querySelector('#departure').value = lastSelectedDate;

  getPrice();
}

// FEATURES checkboxes
const checkboxes = document.querySelectorAll('.feature input[type="checkbox"]');
checkboxes.forEach((checkbox) => {
  checkbox.addEventListener('change', () => {
    if (checkbox.checked) {
      // If checkbox is checked, add class "selected" to parent .feature
      checkbox.parentElement.parentElement.parentElement.classList.add(
        SELECTED_CLASS
      );
    } else {
      checkbox.parentElement.parentElement.parentElement.classList.remove(
        SELECTED_CLASS
      );
    }
    getPrice();
  });
});

// Enable Room type dropdown on submit
const roomDropdown = document.querySelector('#room-type');

document
  .querySelector('#booking-form')
  .addEventListener('submit', function (event) {
    // Prevent the form from being submitted immediately
    event.preventDefault();

    // Enable room type dropdown
    roomDropdown.disabled = false;

    // Manually submit the form
    this.submit();
  });

function getPrice() {
  // Post to get-price.php: 1) room type (comfort level), 2) arrival date, 3) departure date, 4) selected features, if any
  // 1) room type
  const roomType = document.querySelector('#room-type').value;
  // 2) arrival date
  const arrivalDate = document.querySelector('#arrival').value;
  // 3) departure date
  const departureDate = document.querySelector('#departure').value;
  // 4) selected features, if any
  const selectedFeatures = [];
  const selectedFeaturesCheckboxes = document.querySelectorAll(
    '.feature input[type="checkbox"]'
  );
  selectedFeaturesCheckboxes.forEach((checkbox) => {
    if (checkbox.checked) {
      selectedFeatures.push(checkbox.value);
    }
  });

  // Send data to get-price.php
  const xhr = new XMLHttpRequest();
  xhr.open('POST', './php/get-price.php', true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  // Send parameters above to get-price.php, as JSON
  xhr.send(
    'roomType=' +
      roomType +
      '&arrivalDate=' +
      arrivalDate +
      '&departureDate=' +
      departureDate +
      '&selectedFeatures=' +
      selectedFeatures
  );
  // When response is received, console log response
  xhr.onload = function () {
    if (this.status == 200) {
      const totalPrice = this.responseText;
      const totalPriceInput = document.querySelector('#total-price');
      totalPriceInput.value = totalPrice;
    }
  };
}
