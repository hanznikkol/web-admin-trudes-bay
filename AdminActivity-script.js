let btn = document.querySelector('#btn')
let sidebar = document.querySelector('.sidebar')

btn.onclick = function () {
    sidebar.classList.toggle('active');
};


let editActivityId = null; // To keep track of the activity being edited

function toggleActivityForm() {
    const form = document.getElementById('activity-form');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

function saveActivity() {
    const title = document.getElementById('activity-title').value;
    const description = document.getElementById('activity-description').value;
    const image = document.getElementById('activity-image').files[0];

    const formData = new FormData();
    formData.append('title', title);
    formData.append('description', description);
    if (image) {
        formData.append('image', image);
    }
    if (editActivityId) {
        formData.append('id', editActivityId); // Add ID for editing
    }

    fetch('activities_handler.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        loadActivities(); // Refresh the activities list
        toggleActivityForm();
    })
    .catch(error => console.error('Error:', error));
}

function loadActivities() {
    fetch('activities_handler.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.statusText);
            }
            return response.json(); // Use json() to parse response directly
        })
        .then(data => {
            const activityList = document.getElementById('activity-list');
            activityList.innerHTML = ''; // Clear existing activities
            if (data.length === 0) {
                activityList.innerHTML = '<p>No activities found.</p>';
                return; // Exit if no activities
            }
            data.forEach(activity => {
                activityList.innerHTML += `
                    <div class="content-wrapper">
                        <div class="image-container">
                            <img src="data:${activity.image_type};base64,${activity.image_data}" alt="${activity.activity_title}" />
                        </div>
                        <div class="text-container">
                            <h3>${activity.activity_title}</h3>
                            <p>${activity.description}</p>
                            <div class="button-container">
                                <button class="btn edit-btn" onclick="editActivity(${activity.id}, '${activity.activity_title}', '${activity.description}')">Edit</button>
                                <button class="btn remove-btn" onclick="removeActivity(${activity.id})">Remove</button>
                            </div>
                        </div>
                    </div>
                `;
            });
        })
        .catch(error => console.error('Error loading activities:', error));
}






function editActivity(id, title, description) {
    editActivityId = id; // Set the ID of the activity to edit
    document.getElementById('activity-title').value = title;
    document.getElementById('activity-description').value = description;
    toggleActivityForm();
}

function removeActivity(id) {
    if (confirm('Are you sure you want to remove this activity?')) {
        fetch('activities_handler.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: id }),
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            loadActivities(); // Refresh the activities list
        })
        .catch(error => console.error('Error:', error));
    }
}

function cancelActivity() {
    editActivityId = null; // Reset edit ID
    document.getElementById('activity-form').reset(); // Clear form fields
    toggleActivityForm();
}

// Load activities on page load
document.addEventListener('DOMContentLoaded', loadActivities);
