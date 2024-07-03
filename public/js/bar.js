// Firebase configuration
var firebaseConfig = {
  apiKey: "AIzaSyBjww1OP44FkzdOGvCYVPT3iFk2Wq5m_hQ",
  authDomain: "soilsmart-b3c1c.firebaseapp.com",
  databaseURL: "https://soilsmart-b3c1c-default-rtdb.asia-southeast1.firebasedatabase.app",
  projectId: "soilsmart-b3c1c",
  storageBucket: "soilsmart-b3c1c.appspot.com",
  messagingSenderId: "410054572460",
  appId: "1:410054572460:web:8341b15bd964e09a50a209"
};

// Initialize Firebase
firebase.initializeApp(firebaseConfig);
var db = firebase.database();

// Function to create circular progress bar with different color
function createProgressBar(containerId, color, sensorLabel) {
  var container = document.getElementById(containerId);
  if (!container) {
    console.error("Element with ID '" + containerId + "' not found in the DOM.");
    return null; // Return early if element not found
  }
  container.innerHTML = ""; // Clear previous content if any
  var circle = document.createElement('div');
  circle.className = 'progress-bar-circle';
  container.appendChild(circle);

  // Initialize notified flag
  circle.notified = false;

  var bar = new ProgressBar.Circle(circle, {
    color: color,
    strokeWidth: 10,
    trailWidth: 10,
    easing: 'easeInOut',
    duration: 0, // Set duration to 0 to remove animation
    text: {
      value: '0%', // Initial value as 0%
      style: {
        color: '#333',
        position: 'absolute',
        left: '50%',
        top: '50%',
        padding: 0,
        margin: 0,
        fontSize: '20px',
        transform: {
          prefix: true,
          value: 'translate(-50%, -50%)'
        }
      }
    },
    from: { color: '#aaa', width: 10 },
    to: { color: '#333', width: 10 },
    step: function(state, circle) {
      circle.setText((circle.value() * 100).toFixed(1) + '%'); // Format to 0.0%
    }
  });

  return bar;
}

// Function to send notification to Firebase if value is above 700 (dry)
function sendNotificationIfNeeded(value, sensorLabel, circle) {
  var thresholdValue = 700; // Threshold value for notification

  if (isNaN(value) || value < 0) {
    return; // Exit early if value is NaN atau negative
  }

  if (value >= thresholdValue && !circle.notified) {
    circle.notified = true; // Prevent duplicate notifications
    sendNotification('Kelembaban ' + sensorLabel + ' di bawah 30%', sensorLabel);
  } else if (value < thresholdValue && circle.notified) {
    circle.notified = false; // Reset notification flag when value is below threshold
  }
}

// Function to send notification to Firebase
function sendNotification(message, sensorLabel) {
  var notificationData = {
    title: 'SoilSmart Notification',
    message: message,
    timestamp: new Date().toLocaleString(),
    read: false,
    sensor: sensorLabel
  };
  // Push notification data to Firebase database
  db.ref('notifications').push(notificationData);
}

// Function to initialize progress bars with current values from Firebase
function initializeProgressBars() {
  var sensor1Bar = createProgressBar('sensor1Value', '#523B3B', 'Sensor Tanah 1');
  var sensor2Bar = createProgressBar('sensor2Value', '#523B3B', 'Sensor Tanah 2');

  // Listen for changes in Sensor 1
  db.ref('sensors/sensor1Value').on('value', function(snapshot) {
    var value = snapshot.val() || 0; // Default to 0 if value is null
    var percentage = (1024 - value) / 1024; // Calculate percentage
    sensor1Bar.animate(percentage); // Animate to updated value
    sendNotificationIfNeeded(value, 'Sensor Tanah 1', sensor1Bar);
  });

  // Listen for changes in Sensor 2
  db.ref('sensors/sensor2Value').on('value', function(snapshot) {
    var value = snapshot.val() || 0; // Default to 0 if value is null
    var percentage = (1024 - value) / 1024; // Calculate percentage
    sensor2Bar.animate(percentage); // Animate to updated value
    sendNotificationIfNeeded(value, 'Sensor Tanah 2', sensor2Bar);
  });
}

// Function to initialize real-time notification listener
function initializeNotificationListener() {
  db.ref('notifications').on('child_added', function(snapshot) {
    var notification = snapshot.val();
    var tableRef = document.getElementById('notificationTable').getElementsByTagName('tbody')[0];
    var newRow = tableRef.insertRow(0);
    var cell1 = newRow.insertCell(0);
    var cell2 = newRow.insertCell(1);
    cell1.textContent = notification.message;
    cell2.textContent = notification.timestamp;
  });
}

// Initialize progress bars and notification listener when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function() {
  initializeProgressBars();
  initializeNotificationListener();
});
