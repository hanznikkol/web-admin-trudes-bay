let btn = document.querySelector('#btn');
let sidebar = document.querySelector('.sidebar');

btn.onclick = function () {
    sidebar.classList.toggle('active');
};

document.addEventListener('DOMContentLoaded', (event) => {
    fetchAmenities();

    // Function to fetch and display amenities
    function fetchAmenities() {
        fetch('Amenities_handler.php')
            .then(response => response.json())
            .then(data => {
                const amenitiesContainer = document.getElementById('selected-amenities');
                amenitiesContainer.innerHTML = ''; // Clear existing content

                data.forEach(amenity => {
                    const amenityDiv = document.createElement('div');
                    // Create unique ID for each entry (use both category and ID)
                    amenityDiv.id = `${amenity.category}-${amenity.id}`;
                    amenityDiv.className = 'amenity';
                    amenityDiv.setAttribute('data-category', amenity.category); // Store category for filtering
                    amenityDiv.setAttribute('data-id', amenity.id); // Include the ID for deletion
                    amenityDiv.innerHTML = `
                        <span class="delete-btn">X</span>
                        <img src="data:${amenity.image_type};base64,${amenity.image}" alt="Amenity Image">
                        <h3>${amenity.category}</h3>
                    `;
                    amenitiesContainer.appendChild(amenityDiv);
                });
            })
            .catch(error => console.error('Error fetching amenities:', error));
    }

    // Show only selected amenities based on category
    function showSelectedAmenities() {
        const selectedAmenities = document.querySelectorAll('#amenities-form input[type="checkbox"]:checked');
        const amenitiesContainer = document.getElementById('selected-amenities');
        const amenities = amenitiesContainer.querySelectorAll('.amenity');

        // Hide all amenities first
        amenities.forEach(amenity => {
            amenity.style.display = 'none';
        });

        // Show only the amenities that match the selected categories
        if (selectedAmenities.length > 0) {
            selectedAmenities.forEach(selected => {
                const category = selected.value; // Get the category from the checked checkbox
                const matchingAmenities = amenitiesContainer.querySelectorAll(`[data-category="${category}"]`); // Select all matching amenities
                matchingAmenities.forEach(amenity => {
                    amenity.style.display = 'block'; // Show all matching amenities
                });
            });
        } else {
            // If no checkbox is selected, show all amenities
            amenities.forEach(amenity => {
                amenity.style.display = 'block';
            });
        }
    }

    // Add event listeners to checkboxes for filtering amenities
    const checkboxes = document.querySelectorAll('#amenities-form input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', showSelectedAmenities);
    });
    showSelectedAmenities(); // Initial display

    // Handle deletion of amenities
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('delete-btn')) {
            const amenity = event.target.closest('.amenity');
            const amenityId = amenity.getAttribute('data-id'); // Get the amenity ID for deletion

            fetch('Amenities_handler.php', {
                method: 'DELETE',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: amenityId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    amenity.remove(); // Remove element from DOM
                } else {
                    console.error('Failed to delete amenity:', data.message);
                }
            })
            .catch(error => console.error('Error deleting amenity:', error));
        }
    });

    // Show the upload form
    document.getElementById('upload-btn').addEventListener('click', function() {
        document.getElementById('gallery-form').style.display = 'block';
    });

    // Save new amenity and upload
    document.getElementById('save-btn').addEventListener('click', function(e) {
        e.preventDefault(); // Prevent default form submission

        const category = document.getElementById('gallery-category').value;
        const imageInput = document.getElementById('activity-image');
        const formData = new FormData();

        formData.append('category', category);
        formData.append('image', imageInput.files[0]);

        fetch('Amenities_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text()) // Use text() instead of json() to catch any HTML errors
        .then(text => {
            try {
                const data = JSON.parse(text); // Attempt to parse as JSON
                console.log("Response from PHP:", data); // Log the response for debugging
                if (data.success) {
                    fetchAmenities(); // Refresh amenities list
                    document.getElementById('gallery-form').style.display = 'none'; // Hide the form
                } else {
                    console.error("Upload failed:", data.message); // Show error message
                }
            } catch (error) {
                console.error("Invalid JSON:", text); // Log the raw response in case of an error
            }
        })
        .catch(error => console.error('Error uploading amenity:', error));
    });

    // Cancel upload form
    document.getElementById('cancel-btn').addEventListener('click', function() {
        document.getElementById('gallery-form').style.display = 'none'; // Hide form
    });
});
