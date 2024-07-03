// Function to load notifications from Firebase
function loadNotifications() {
    var tableBody = document.querySelector('#notificationTable tbody');
    tableBody.innerHTML = ""; // Clear previous notifications

    // Query to fetch notifications
    firebase.database().ref('notifications').once('value', function(snapshot) {
        snapshot.forEach(function(childSnapshot) {
            var data = childSnapshot.val();
            var row = `<tr><td>${data.title}</td></tr>`;
            tableBody.innerHTML += row;
        });
    });
}

// Load notifications on window load
window.onload = function() {
    loadNotifications();

    // Example of updating sensor values (you can adjust as per your data structure)
    firebase.database().ref('sensors').on('value', function(snapshot) {
        var sensorData = snapshot.val();
        // Update sensor values or trigger any other logic here
        updateSensorUI(sensorData);
    });
};
