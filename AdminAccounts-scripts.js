let btn = document.querySelector('#btn');
let sidebar = document.querySelector('.sidebar');

btn.onclick = function () {
    sidebar.classList.toggle('active');
};



// Fetch all reservations from the database on page load
window.onload = function() {
    fetchAllReservations(); // Fetch all reservations
};

// Fetch all reservations from the database
function fetchAllReservations() {
    fetch(`Adminfunction.php`) // No need for cottage_no now
        .then(response => response.json())
        .then(data => {
            let tableHtml = `
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Contact Number</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>`;

            data.forEach(reservation => {
                tableHtml += `
                    <tr data-id="${reservation.id}">
                        <td>${reservation.name || 'N/A'}</td>
                        <td>${reservation.contact_number || 'N/A'}</td>
                        <td>${reservation.email || 'N/A'}</td>
                        <td>${reservation.address || 'N/A'}</td>
                        <td>${reservation.username || 'N/A'}</td>
                        <td>${reservation.password || 'N/A'}</td>
                        <td>${reservation.status || 'N/A'}</td>
                        <td>
                            <button class="edit-button" onclick="openEditForm(${reservation.id})">Edit</button>
                            <button class="remove-button" onclick="removeReservation(${reservation.id})">Remove</button>
                        </td>
                    </tr>`;
            });

            tableHtml += `
                    </tbody>
                </table>
                <button class="Abtn add-button" onclick="openAddForm()">Add Staff</button>`; // Removed cottage_no for Add List

            document.getElementById('cottage-list').innerHTML = tableHtml;
        })
        .catch(error => console.error("Error fetching reservations:", error));
}

// Function to open the edit form
function openEditForm(reservationId) {
    // Fetch the reservation data for the selected ID and populate the form
    fetch(`Adminfunction.php?reservation_id=${reservationId}`)
        .then(response => response.json())
        .then(data => {
            // Populate the form fields with the fetched data
            document.getElementById('editReservationId').value = data.id;
            document.getElementById('editName').value = data.name;
            document.getElementById('editContact').value = data.contact_number;
            document.getElementById('editEmail').value = data.email;
            document.getElementById('editAddress').value = data.address;
            document.getElementById('editUsername').value = data.username;
            document.getElementById('editPassword').value = data.password;
            document.getElementById('editStatus').value = data.status;
           
             // Show the modal
             openEditModal(); // Change this line

             
        })
        .catch(error => console.error("Error fetching Admins data:", error));
}

// Function to update the reservation row in the table
function updateReservationRow(reservationId, name, contact, email, address, username, password, status) {
    const reservationRow = document.querySelector(`tr[data-id='${reservationId}']`);
    if (reservationRow) {
        reservationRow.cells[0].innerText = name; // Name
        reservationRow.cells[1].innerText = contact; // Contact Number
        reservationRow.cells[2].innerText = email; // Email
        reservationRow.cells[3].innerText = address; // Address
        reservationRow.cells[4].innerText = username; // Username
        reservationRow.cells[5].innerText = password; // Password
        reservationRow.cells[6].innerText = status; // Status
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

        fetch('Adminfunction.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Staff added successfully");
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

    const [name, contact, email, address, username, password, status] = reservationData;
    
    // Set the fields in the modal form
    document.getElementById('editName').value = name;
    document.getElementById('editContact').value = contact;
    document.getElementById('editEmail').value = email;
    document.getElementById('editAddress').value = address;
    document.getElementById('editUsername').value = username;
    document.getElementById('editPassword').value = password;
    document.getElementById('editStatus').value = status == 'Active' ? 'Pending' : 'Confirmed';
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
    const username = document.getElementById('editUsername').value;
    const password = document.getElementById('editPassword').value;
    const status = document.getElementById('editStatus').value; 

    // Prepare the data as a query string
    const data = `id=${reservationId}&name=${name}&contact_number=${contact}&email=${email}&address=${address}&username=${username}&password=${password}&status=${status}`;


    // Create an AJAX request
    const xhr = new XMLHttpRequest();
    xhr.open('PUT', 'Adminfunction.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    // Handle the response
    xhr.onload = function() {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                alert(response.message);
                // Update the reservation row in the table
                updateReservationRow(reservationId, name, contact, email, address, username, password);
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
    if (confirm("Are you sure you want to remove this Staff?")) {
        fetch('Adminfunction.php', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: reservationId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Staff removed successfully");
                fetchAllReservations(); // Refresh the reservations table
            } else {
                alert("Error removing Staff: " + data.message);
            }
        })
        .catch(error => console.error("Error removing reservation:", error));
    }
}