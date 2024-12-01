// redirect to login if no user is logged in
var session = sessionStorage.getItem("admintrudes_session")
var user = JSON.parse(session)
if(!session) {
    window.location.href = 'login.php'
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
    window.location.href = "login.php"
}
