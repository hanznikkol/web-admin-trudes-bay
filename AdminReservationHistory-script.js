let btn = document.querySelector('#btn')
let sidebar = document.querySelector('.sidebar')

btn.onclick = function () {
    sidebar.classList.toggle('active');
};

const yearPicker = document.getElementById('yearPicker');
const monthPicker = document.getElementById('monthPicker');

// Populate years dynamically
const currentYear = new Date().getFullYear();
const currentMonth = new Date().getMonth();
const startYear = 2020; // Set the starting year
for (let year = currentYear; year >= startYear; year--) {
  const option = document.createElement('option');
  option.value = year;
  option.textContent = year;
  yearPicker.appendChild(option);
}

monthPicker.value = currentMonth + 1;
yearPicker.value = currentYear;

// Event Listeners (Optional)
monthPicker.addEventListener('change', () => {
  console.log(`Selected Month: ${monthPicker.value}`);
  fetchReservations(yearPicker.value, monthPicker.value)
});

yearPicker.addEventListener('change', () => {
  console.log(`Selected Year: ${yearPicker.value}`);
  fetchReservations(yearPicker.value, monthPicker.value)
});


// Function to convert 24-hour format to 12-hour format
function formatTimeTo12Hour(time) {
    let [hours, minutes] = time.split(':');
    let ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    return `${hours}:${minutes} ${ampm}`;
}

// Trigger fetching all reservations on page load if no cottage is selected
document.addEventListener('DOMContentLoaded', function() {
    fetchReservations(yearPicker.value, monthPicker.value)
});

// Function to fetch reservations for selected cottage or all cottages
function fetchReservations(year, month) {
    // If no cottage is selected, fetch all reservations
    const queryParam = `?year=${year}&month=${month}`
    console.log(queryParam)
    fetch(`AdminHistoryfunction.php${queryParam}`)
    .then(response => response.json())
    .then(data => {
        console.log("Data received:", data);  // Log the full response data for inspection

        // Determine the heading text based on the selection
        const headingText = `${(Array.isArray(data) ? data.length : 'No')} Reservations`;

        // Start building the table HTML regardless of the data
        let tableHtml = `
            <h3>${headingText}</h3>
            <table>
                <thead>
                    <tr>
                        <th>Firstname</th>
                        <th>Middlename</th>
                        <th>Lastname</th>
                        <th>Reservation</th>
                        <th>Contact Number</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Note</th>
                        <th>Check-in Date</th>
                        <th>Check-out Date</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Number of Guests</th>
                        <th>Payment reference</th>
                    </tr>
                </thead>
                <tbody>`;

        // Check if data is an array and contains entries
        if (Array.isArray(data) && data.length > 0) {
            data.forEach(reservation => {
                const checkinFormatted = formatTimeTo12Hour(reservation.check_in);
                const checkoutFormatted = formatTimeTo12Hour(reservation.check_out);

                tableHtml += `
                    <tr data-id="${reservation.id}">
                        <td>${reservation.first_name || 'N/A'}</td>
                        <td>${reservation.middle_name || 'N/A'}</td>
                        <td>${reservation.last_name || 'N/A'}</td>
                        <td>${reservation.concatenated_values}</td>
                        <td>${reservation.contact_number || 'N/A'}</td>
                        <td>${reservation.email || 'N/A'}</td>
                        <td>${reservation.address || 'N/A'}</td>
                        <td>${reservation.note || 'N/A'}</td>
                        <td>${reservation.check_in_date || 'N/A'}</td>
                        <td>${reservation.check_out_date || 'N/A'}</td>
                        <td>${checkinFormatted || 'N/A'}</td>
                        <td>${checkoutFormatted || 'N/A'}</td>
                        <td>${reservation.guests || 'N/A'}</td>
                        <td>${reservation.reference || 'N/A'}</td>
                    </tr>`;
            });
        } else {
            // If no reservations are found, display a message within the table
            tableHtml += `
                <tr>
                    <td colspan="14">No reservations found.</td>
                </tr>`;
        }

        // Close the table HTML and add the Add button
        tableHtml += `
                </tbody>
            </table>
            <button class="Abtn add-button" onclick="openReservationForm()">Add Reservation</button>`;

        // Insert the table into the cottage list container
        document.getElementById('cottage-list').innerHTML = tableHtml;
    })
    .catch(error => {
        console.error("Error fetching reservations:", error);
        // Handle error and display an error message to the user
        document.getElementById('cottage-list').innerHTML = "<p>Error loading reservations. Please try again later.</p>";
    });
}


// Open edit modal
function openEditModal() {
    document.getElementById('editReservationModal').style.display = "block";
}


