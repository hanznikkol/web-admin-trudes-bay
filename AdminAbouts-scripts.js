// Toggle sidebar functionality
let btn = document.querySelector('#btn');
let sidebar = document.querySelector('.sidebar');

btn.onclick = function () {
    sidebar.classList.toggle('active');
};

// Automatically load the About data on page load
document.addEventListener("DOMContentLoaded", function() {
    loadAboutData(); // Load all records on page load
});

function openAddForm() {
    // Show the about-form section
    const form = document.getElementById("addAbouts");
    form.style.display = "block";
}

function loadAboutData() {
    fetch("abouts_handler.php") // Fetch all records
        .then(response => response.json())
        .then(data => {
            let tableHtml = `
                <h3>Phone Number List</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Phone Number</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>`;

            data.forEach(reservation => {
                tableHtml += `
                    <tr data-id="${reservation.id}">
                        <td>${reservation.phone}</td>
                        <td>
                            <button class="edit-button" onclick="openEditForm(${reservation.id})">Edit</button>
                            <button class="remove-button" onclick="removeReservation(${reservation.id})">Remove</button>
                        </td>
                    </tr>`;
            });

            tableHtml += `
                    </tbody>
                </table>`;

            document.getElementById('about-list').innerHTML = tableHtml;
        })
        .catch(error => console.error("Error fetching reservations:", error));
}

function addAboutEntry() {
    const phone = document.getElementById("phone").value;

    const formData = new FormData();
    formData.append('phone', phone); // Only append phone

    fetch("abouts_handler.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            loadAboutData(); // Refresh the data
            closeAddForm();
        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error("Error adding entry:", error));
}

function openEditForm(id) {
    const editModal = document.getElementById('editModal');
    const editIdInput = document.getElementById('edit-id');
    const editPhoneInput = document.getElementById('edit-phone');

    fetch(`abouts_handler.php?id=${id}`) // Fetch the specific record
        .then(response => response.json())
        .then(data => {
            if (data.success !== false) { // Check for successful fetch
                editIdInput.value = data.id; // Set the hidden ID input
                editPhoneInput.value = data.phone; // Populate phone number
                editModal.style.display = 'block'; // Show the modal
            } else {
                alert(data.message); // Show error message if not found
            }
        })
        .catch(error => console.error("Error fetching entry for edit:", error));
}

function updateAboutEntry() {
    const id = document.getElementById('edit-id').value;
    const phone = document.getElementById('edit-phone').value; // Only handle phone

    const data = {
        id: id,
        phone: phone
    };

    fetch('abouts_handler.php', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        return response.json();
    })
    .then(result => {
        if (result.success) {
            alert(result.message);
            loadAboutData();
            closeEditModal();
        } else {
            alert("Error: " + result.message);
        }
    })
    .catch(error => console.error("Error updating entry:", error));
}

function removeReservation(id) {
    if (confirm("Are you sure you want to remove this entry?")) {
        fetch("abouts_handler.php", {
            method: "DELETE",
            body: JSON.stringify({ id: id }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                loadAboutData(); // Refresh the data
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error("Error removing entry:", error));
    }    
}

function closeEditModal() {
    document.getElementById('editModal').style.display = 'none'; // Hide the modal
}

function closeAddForm() {
    document.getElementById("addAbouts").style.display = "none"; // Hide the add form
}
