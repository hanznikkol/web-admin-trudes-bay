let btn = document.querySelector('#btn');
let sidebar = document.querySelector('.sidebar');

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

// Fetch all reservations from the database on page load
window.onload = function() {
    fetchAllReservations(); // Fetch all reservations
};

// Fetch all reservations from the database
function fetchAllReservations() {
    fetch(`AdminEventfunction.php`) // No need for cottage_no now
        .then(response => response.json())
        .then(data => {
            console.log('received data', data)
            let tableHtml = `
                <h3>Event Hall Reservation List</h3>
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
                            <th>Payment Reference</th>
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
                            
                                <button class="remove-button" onclick="removeReservation(${reservation.id}, ${tentquantity})">Remove</button>
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
            tableHtml += `
                        </tbody>
                    </table>
                    <button class="Abtn add-button" onclick="openReservationForm()">Add Reservation</button>`; // Removed cottage_no for Add List

                document.getElementById('cottage-list').innerHTML = tableHtml;
        })
        .catch(error => console.error("Error fetching reservations:", error));
}

// Function to open the edit form
function openEditForm(reservationId) {
    // Fetch the reservation data for the selected ID and populate the form
    fetch(`AdminEventfunction.php?reservation_id=${reservationId}`)
        .then(response => response.json())
        .then(data => {
            // Populate the form fields with the fetched data
            document.getElementById('editReservationId').value = data.id;
            document.getElementById('editName').value = data.Name;
            document.getElementById('editContact').value = data.Contact_Number;
            document.getElementById('editEmail').value = data.Email;
            document.getElementById('editAddress').value = data.Address;
            document.getElementById('editNote').value = data.Note;
            document.getElementById('editDate').value = data.Date;
            document.getElementById('editCheckin').value = data.Check_in;
            document.getElementById('editCheckout').value = data.Check_out;
            document.getElementById('editTentQ').value = data.Event_quantity;
            document.getElementById('editGuests').value = data.Number_of_Guests;

             // Show the modal
             openEditModal(); // Change this line
        })
        .catch(error => console.error("Error fetching reservation data:", error));
}

// Function to update the reservation row in the table
function updateReservationRow(reservationId, name, contact, email, address, note, date, checkin, checkout, tentquantity,guests) {
    const reservationRow = document.querySelector(`tr[data-id='${reservationId}']`);
    if (reservationRow) {
        reservationRow.cells[0].innerText = name; // Name
        reservationRow.cells[1].innerText = contact; // Contact Number
        reservationRow.cells[2].innerText = email; // Email
        reservationRow.cells[3].innerText = address; // Address
        reservationRow.cells[4].innerText = note; // Note
        reservationRow.cells[5].innerText = date; // Date
        reservationRow.cells[6].innerText = checkin; // Check-in
        reservationRow.cells[7].innerText = checkout; // Check-out
        reservationRow.cells[8].innerText = tentquantity; // Tent Quantity
        reservationRow.cells[9].innerText = guests; // Number of Guests
    }
}

// Handle Add button click
function openAddForm() {
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

        fetch('AdminEventfunction.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Reservation added successfully");
                fetchReservations(cottage_no); // Refresh the reservations table
                modal.style.display = "none"; // Close the modal
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

    const [name, contact, email, address, note, date, checkins, checkouts, tentquantity, guests] = reservationData;
    
    // Set the fields in the modal form
    document.getElementById('editName').value = name;
    document.getElementById('editContact').value = contact;
    document.getElementById('editEmail').value = email;
    document.getElementById('editAddress').value = address;
    document.getElementById('editNote').value = note;
    document.getElementById('editDate').value = date;
    document.getElementById('editCheckin').value = checkins;
    document.getElementById('editCheckout').value = checkouts;
    document.getElementById('editTentQ').value = tentquantity;
    document.getElementById('editGuests').value = guests;
    document.getElementById('editReservationId').value = reservationId;

    // Show the edit modal
    openEditModal();
}

// Handle form submission for editing a reservation
document.getElementById('editReservationForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    // Prepare data to be sent
    const reservationId = document.getElementById('editReservationId').value;
    const name = document.getElementById('editName').value;
    const contact = document.getElementById('editContact').value;
    const email = document.getElementById('editEmail').value;
    const address = document.getElementById('editAddress').value;
    const note = document.getElementById('editNote').value;
    const date = document.getElementById('editDate').value;
    const checkin = document.getElementById('editCheckin').value;
    const checkout = document.getElementById('editCheckout').value;
    const tentquantity = document.getElementById('editTentQ').value;
    const guests = document.getElementById('editGuests').value;

    // Prepare the data as a query string
    const data = `id=${reservationId}&name=${name}&contact=${contact}&email=${email}&address=${address}&note=${note}&date=${date}&checkin=${checkin}&checkout=${checkout}&tentquantity=${tentquantity}&guests=${guests}`;


    // Create an AJAX request
    const xhr = new XMLHttpRequest();
    xhr.open('PUT', 'AdminEventfunction.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    // Handle the response
    xhr.onload = function() {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                alert(response.message);
                // Update the reservation row in the table
                updateReservationRow(reservationId, name, contact, email, address, note, date, checkin, checkout,tentquantity, guests);
                closeEditModal(); // Assuming you have a function to close the modal
            } else {
                alert(response.message);
            }
        } else {
            alert('An error occurred while updating the reservation.');
        }
    };

    // Send the request
    xhr.send(data);
});


// Function to remove a reservation
function removeReservation(reservationId) {
    if (confirm("Are you sure you want to remove this reservation?")) {
        fetch('AdminEventfunction.php', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: reservationId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Reservation removed successfully");
                fetchAllReservations(); // Refresh the reservations table
            } else {
                alert("Error removing reservation: " + data.message);
            }
        })
        .catch(error => console.error("Error removing reservation:", error));
    }
}