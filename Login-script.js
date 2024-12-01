var session = sessionStorage.getItem("admintrudes_session")
if(session) {
    window.location.href = 'AdminIndex.php'
}

// Show/Hide Password Function
function togglePassword() {
    var passwordField = document.getElementById("password");
    if (passwordField.type === "password") {
        passwordField.type = "text";
    } else {
        passwordField.type = "password";
    }
}

function loginUser() {
    const username = document.querySelector(`input[name="username"]`).value
    const password = document.querySelector(`input[name="password"]`).value

    fetch(`function.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded' // Required for POST data
            },
            body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`, // Pass data in the body
        })
        .then(response => {
            return response.json() 
        })
        .then(data => {
            if(data.error) {
                return alert(data.error)
            }
            sessionStorage.setItem("admintrudes_session", JSON.stringify(data))
            window.location.href = "AdminIndex.php"
        })
}