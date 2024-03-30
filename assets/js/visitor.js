// script.js
document.addEventListener('DOMContentLoaded', function() {
    // Send an AJAX request to update the visitor count
    fetch('update_count.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('visitorCount').textContent = data.count;
        })
        .catch(error => console.error('Error:', error));
});
