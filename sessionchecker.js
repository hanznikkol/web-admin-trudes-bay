// redirect to login if no user is logged in
var session = sessionStorage.getItem("admintrudes_session")
var user = JSON.parse(session)
if(!session) {
    window.location.href = 'Login.php'
}

// manipulate the ui for respective user position
document.addEventListener("DOMContentLoaded", function () { 
    if(user.position == 'ADMIN' || user.position == 'SUPERUSER') return
    var adminAccountNav = document.querySelectorAll(`a[href="AdminAccount.php"]`);
    adminAccountNav.forEach(nav => {
        nav.style.display = "none"
    })
})

function logout() {
    sessionStorage.clear()
    window.location.href = "Login.php"
}

function openReservationForm() {
    // Get the current location
    const currentLocation = window.location;

    // Extract the hostname (e.g., 'localhost')
    const hostname = currentLocation.hostname;

    // Define the rest of the URL you want to append
    const newPath = '/reservation.php';

    // Combine the hostname with the new path
    const newUrl = `${currentLocation.protocol}//${hostname}${newPath}`;

    // open new window
    window.open(newUrl, '_blank');

}
