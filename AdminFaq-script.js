let btn = document.querySelector('#btn')
let sidebar = document.querySelector('.sidebar')

btn.onclick = function () {
    sidebar.classList.toggle('active');
};

// Add New FAQ
document.querySelector('.add-button').addEventListener('click', function() {
    document.querySelector('.faq-form').style.display = 'block';
});

function saveFAQ() {
    const question = document.getElementById('new-question').value;
    const answer = document.getElementById('new-answer').value;

    fetch('faq_operations.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'add', question, answer })
    })
    .then(response => response.text())
    .then(data => {
        location.reload(); // Refresh to display new FAQ
    });
}

// Edit FAQ
document.querySelectorAll('.edit-button').forEach(button => {
    button.addEventListener('click', function() {
        const questionDiv = this.closest('.question');
        const id = questionDiv.getAttribute('data-id');
        const question = questionDiv.querySelector('h3').innerText;
        const answer = questionDiv.querySelector('p').innerText;

        document.getElementById('new-question').value = question;
        document.getElementById('new-answer').value = answer;
        document.querySelector('.faq-form').style.display = 'block';

        // Save edited FAQ
        document.querySelector('.faq-form button').onclick = function() {
            fetch('faq_operations.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'edit', id, question: document.getElementById('new-question').value, answer: document.getElementById('new-answer').value })
            })
            .then(response => response.text())
            .then(data => {
                location.reload(); // Refresh to show changes
            });
        };
    });
});

// Remove FAQ
document.querySelectorAll('.remove-button').forEach(button => {
    button.addEventListener('click', function() {
        const id = this.closest('.question').getAttribute('data-id');

        fetch('faq_operations.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'remove', id })
        })
        .then(response => response.text())
        .then(data => {
            location.reload(); // Refresh to remove FAQ
        });
    });
});

