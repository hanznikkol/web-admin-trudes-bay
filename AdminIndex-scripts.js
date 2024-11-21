let btn = document.querySelector('#btn');
let sidebar = document.querySelector('.sidebar');

btn.onclick = function () {
    sidebar.classList.toggle('active');
};



let slideIndex = 0;

// Show slides in the hero section
function showSlides(n) {
    let slides = document.getElementsByClassName("hero-slide");
    if (n >= slides.length) {
        slideIndex = 0;
    } else if (n < 0) {
        slideIndex = slides.length - 1;
    } else {
        slideIndex = n;
    }
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
        slides[i].classList.remove("active");
    }
    slides[slideIndex].style.display = "block";
    slides[slideIndex].classList.add("active");
}

// Change slide based on user input
function changeSlide(n) {
    showSlides(slideIndex + n);
}

// Function to preview image and open modal when an image is selected
function imageSelected(event) {
    const fileInput = event.target;
    const file = fileInput.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('image-preview').src = e.target.result;
            openModal();
        };
        reader.readAsDataURL(file);
    }
}

// Function to open the modal
function openModal() {
    const modal = document.getElementById('imagePreviewModal');
    modal.style.display = 'block';
}

// Function to close the modal
function closeModal() {
    const modal = document.getElementById('imagePreviewModal');
    modal.style.display = 'none';
}

// Reopen the modal when a new image is selected
document.getElementById("image-input").addEventListener("change", function(event) {
    imageSelected(event);
});

// Handle modal close events
window.addEventListener("click", function(event) {
    const modal = document.getElementById('imagePreviewModal');
    if (event.target === modal) {
        closeModal();
    }
});
document.querySelector('.close-btn').addEventListener("click", function() {
    closeModal();
});
