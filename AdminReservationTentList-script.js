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

document.getElementById('cottage-select').addEventListener('change', function () {
    const selectedCottage = this.value;
    const cottageList = document.getElementById('cottage-list');

    cottageList.innerHTML = ''; // Clear the list before loading new data

    // Fetch reservations for the selected cottage or for all cottages if no specific cottage is selected
    fetchReservations(selectedCottage);
});

// Trigger fetching all reservations on page load if no cottage is selected
document.addEventListener('DOMContentLoaded', function () {
    const selectedCottage = document.getElementById('cottage-select').value;
    fetchReservations(selectedCottage);
});

// Function to fetch reservations for selected cottage or all cottages
function fetchReservations(tentquantity) {
    // If no tentquantity is selected, fetch all reservations
    const queryParam = tentquantity ? `?tentquantity=${tentquantity}` : '';

    fetch(`AdminTentfunction.php${queryParam}`)
        .then(response => response.json())
        .then(data => {
            console.log("Data received:", data);  // Log the full response data for inspection

            // Determine the heading text based on the selection
            const headingText = tentquantity ? `Tent ${tentquantity}` : 'All Tents';

            // Start building the table HTML
            let tableHtml = `
                <h3>${headingText}</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Firstname</th>
                            <th>Middlename</th>
                            <th>Lastname</th>
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
                                <button class="edit-button" onclick="openEditForm(${reservation.id})">Edit</button>
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
                <button class="Abtn add-button" onclick="openAddForm(${tentquantity || 'null'})">Add List</button>`;

            document.getElementById('cottage-list').innerHTML = tableHtml;
        })
        .catch(error => {
            console.error("Error fetching reservations:", error);
            document.getElementById('cottage-list').innerHTML = "<p>Error loading reservations. Please try again later.</p>";
        });
}

// Handle Add button click
function openAddForm(tentquantity) {
    // Set the cottage number in the hidden field
    document.getElementById('tentquantity').value = tentquantity;

    // Show the modal
    const modal = document.getElementById('addReservationModal');
    modal.style.display = "block";

    // Close the modal when the close button is clicked
    const closeButton = document.querySelector('.close-button');
    closeButton.onclick = function () {
        modal.style.display = "none";
    }

    // Close the modal when clicking outside of it
    window.onclick = function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }

    // Handle form submission
    document.getElementById('reservationForm').onsubmit = function (event) {
        event.preventDefault(); // Prevent the default form submission

        const formData = new FormData(this); // Gather the form data

        fetch('AdminTentfunction.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Reservation added successfully");

                    // Close the modal upon successful submission
                    modal.style.display = "none";

                    fetchReservations(tentquantity); // Refresh the reservations table
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
    closeButton.onclick = function () {
        closeEditModal();
    };
}

// Optional: Close the modal when clicking outside of the modal content
window.addEventListener('click', function (event) {
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
    const [lastname, firstname, middlename, contactnumber, email, address, note, checkindate, checkoutdate, checkin, checkout, guests, reference] = reservationData;

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

    // Show the edit form modal
    openEditModal();
}

// Convert 12-hour time format to 24-hour format
function convertTo24Hour(time) {
    let [hour, minute] = time.split(":");
    let [time, ampm] = time.split(" ");
    if (ampm.toLowerCase() === "pm" && hour !== "12") {
        hour = parseInt(hour) + 12;
    } else if (ampm.toLowerCase() === "am" && hour === "12") {
        hour = 0;
    }
    return `${hour}:${minute}`;
}
