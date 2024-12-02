let btn = document.querySelector('#btn')
let sidebar = document.querySelector('.sidebar')

btn.onclick = function () {
    sidebar.classList.toggle('active');
};

// Function to convert 24-hour format to 12-hour format
function formatTimeTo12Hour(time) {
    let [hours, minutes] = time.split(':');
    let ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    return `${hours}:${minutes} ${ampm}`;
}


document.getElementById('cottage-select').addEventListener('change', function() {
    const selectedCottage = this.value;
    const cottageList = document.getElementById('cottage-list');

    cottageList.innerHTML = ''; // Clear the list before loading new data

    // Fetch reservations for the selected cottage or for all cottages if no specific cottage is selected
    fetchReservations(selectedCottage);
});

// Trigger fetching all reservations on page load if no cottage is selected
document.addEventListener('DOMContentLoaded', function() {
    const selectedCottage = document.getElementById('cottage-select').value;
    fetchReservations(selectedCottage);
});

// Function to fetch reservations for selected cottage or all cottages
function fetchReservations(selectcottage) {
    // If no cottage is selected, fetch all reservations
    const queryParam = selectcottage ? `?selectcottage=${selectcottage}` : '';
    console.log(selectcottage);
    fetch(`AdminReserveCottage.php${queryParam}`)
    .then(response => response.json())
    .then(data => {
        console.log("Data received:", data);  // Log the full response data for inspection

        // Determine the heading text based on the selection
        const headingText = selectcottage ? selectcottage : 'All Cottages';

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
                        <th>Actions</th>
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
                        <td>
                            <button class="remove-button" onclick="removeReservation(${reservation.id}, ${selectcottage})">Complete</button>
                        </td>
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






// Handle Add button click
function openAddForm(selectcottage) {
    // Set the cottage number in the hidden field
    document.getElementById('selectcottage').value = selectcottage;

    // Show the modal
    const modal = document.getElementById('addReservationModal');
    modal.style.display = "block";

    // Close the modal when the close button is clicked
    const closeButton = document.querySelector('.close-button');
    closeButton.onclick = function() {
        modal.style.display = "none";
    }

    // Close the modal when clicking outside of it
    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }

    // Handle form submission
    document.getElementById('reservationForm').onsubmit = function(event) {
        event.preventDefault(); // Prevent the default form submission

        const formData = new FormData(this); // Gather the form data

        fetch('AdminReserveCottage.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Reservation added successfully");

                // Close the modal upon successful submission
                modal.style.display = "none";

                fetchReservations(selectcottage); // Refresh the reservations table
                this.reset(); // Reset the form
            } else {
                alert("Error adding reservation: " + data.message);
            }
        })
        .catch(error => console.error("Error adding reservation:", error));
    }
}


// Open edit modal
function openEditModal() {
    document.getElementById('editReservationModal').style.display = "block";
}

// Close edit modal
function closeEditModal() {
    document.getElementById('editReservationModal').style.display = "none";
}

// Close the modal when the close button is clicked
const closeButton = document.querySelector('#editReservationModal .close-button');
if (closeButton) {
    closeButton.onclick = function() {
        closeEditModal();
    };
}

// Optional: Close the modal when clicking outside of the modal content
window.addEventListener('click', function(event) {
    const modal = document.getElementById('editReservationModal');
    if (event.target === modal) {
        closeEditModal();
    }
});

// Open edit form for existing reservation
function openEditForm(reservationId) {
    const reservationRow = document.querySelector(`tr[data-id='${reservationId}']`);
    const reservationData = Array.from(reservationRow.cells).map(cell => cell.innerText);

    // Assuming the data is in this order in the row:
    const [lastname, firstname, middlename, contactnumber, email, address, note, checkindate, checkoutdate, checkin, checkout, guests,  reference] = reservationData;

    // Set the fields in the modal form
    document.getElementById('editLastname').value = lastname;
    document.getElementById('editFirstname').value = firstname;
    document.getElementById('editMiddlename').value = middlename;
    document.getElementById('editContact').value = contactnumber;
    document.getElementById('editEmail').value = email;
    document.getElementById('editAddress').value = address;
    document.getElementById('editNote').value = note;
    document.getElementById('editCheck-inDate').value = checkindate;
    document.getElementById('editCheck-outDate').value = checkoutdate;
    document.getElementById('editCheckin').value = convertTo24Hour(checkin);
    document.getElementById('editCheckout').value = convertTo24Hour(checkout);
  
    document.getElementById('editGuests').value = guests;
    document.getElementById('editReference').value = reference;
    document.getElementById('editReservationId').value = reservationId;

    // Show the edit modal
    openEditModal();

    // Function to convert 12-hour to 24-hour format
function convertTo24Hour(timeStr) {
    const [time, modifier] = timeStr.split(" ");
    let [hours, minutes] = time.split(":");

    if (modifier === "PM" && hours !== "12") {
        hours = parseInt(hours, 10) + 12;
    } else if (modifier === "AM" && hours === "12") {
        hours = "00";
    }

    return `${hours}:${minutes}`;
}
}


// Handle form submission for editing a reservation
document.getElementById('editReservationForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    // Prepare data to be sent
    const reservationId = document.getElementById('editReservationId').value;
    const lastname = document.getElementById('editLastname').value;
    const firstname = document.getElementById('editFirstname').value;
    const middlename = document.getElementById('editMiddlename').value;
    const contact = document.getElementById('editContact').value;
    const email = document.getElementById('editEmail').value;
    const address = document.getElementById('editAddress').value;
    const note = document.getElementById('editNote').value;
    const checkindate = document.getElementById('editCheck-inDate').value;
    const checkoutdate = document.getElementById('editCheck-outDate').value;
    const checkin = document.getElementById('editCheckin').value;
    const checkout = document.getElementById('editCheckout').value;
    const selectcottage = document.getElementById('editSelectCottage').value;
    const guests = document.getElementById('editGuests').value;
    const reference = document.getElementById('editReference').value;

    // Prepare the data as a query string
    const data = `id=${reservationId}&firstname=${firstname}&lastname=${lastname}&middlename=${middlename}&contactnumber=${contact}&email=${email}&address=${address}&note=${note}&checkindate=${checkindate}&checkoutdate=${checkoutdate}&selectcottage=${selectcottage}&checkin=${checkin}&checkout=${checkout}&guests=${guests}&reference=${reference}`;

    // Create an AJAX request
    const xhr = new XMLHttpRequest();
    xhr.open('PUT', 'AdminReserveCottage.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(data);

    // Handle the response
    xhr.onload = function() {
        if (xhr.status === 200) {
            try {
                console.log('Response:', xhr.responseText); // Log the raw response
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    alert(response.message); // Success alert
                    updateReservationRow(reservationId, lastname, firstname, middlename, contact, email, address, note, checkindate, checkoutdate, checkin, checkout, selectcottage, guests);
                    closeEditModal();
                } else {
                    alert(response.message); // Error alert
                }
            } catch (e) {
                console.error('Error parsing JSON:', e);
                console.log(xhr.responseText); // Log the response for debugging
            }
        } else {
            alert('An error occurred while updating the reservation.');
        }
    };
});


// Function to update the reservation row after editing
function updateReservationRow(reservationId, lastname, firstname, middlename, contact, email, address, note, checkindate, checkoutdate, checkin, checkout, selectcottage, guests, reference) {
    const reservationRow = document.querySelector(`tr[data-id='${reservationId}']`);

    // Update the corresponding table row with new values
    reservationRow.cells[0].innerText = lastname;
    reservationRow.cells[1].innerText = firstname;
    reservationRow.cells[2].innerText = middlename;
    reservationRow.cells[3].innerText = contact;
    reservationRow.cells[4].innerText = email;
    reservationRow.cells[5].innerText = address;
    reservationRow.cells[6].innerText = note;
    reservationRow.cells[7].innerText = checkindate;
    reservationRow.cells[8].innerText = checkoutdate;
    reservationRow.cells[9].innerText = checkin;
    reservationRow.cells[10].innerText = checkout;
    reservationRow.cells[11].innerText = guests;
    reservationRow.cells[12].innerText = selectcottage;
    reservationRow.cells[13].innerText = reference;
}



// Handle remove reservation
function removeReservation(reservationId, cottage_no) {
    if (confirm("Are you sure you want to complete this reservation?")) {
        fetch('AdminReserveCottage.php', {
            method: 'DELETE',
            body: JSON.stringify({ id: reservationId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                fetchReservations(cottage_no); // Refresh the reservations table
            } else {
                alert("Error completing reservation: " + data.message);
            }
        })
        .catch(error => console.error("Error completing reservation:", error));
    }    
}

