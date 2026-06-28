let sessionTimeoutMinutes = 15;
let sessionTimeoutMilliseconds = sessionTimeoutMinutes * 60 * 1000;
let warningTime = sessionTimeoutMilliseconds - 60000; // 14 minutes warning
let idleTimeLimit = 30 * 1000; // 30 seconds of inactivity
let countdownDisplay = document.getElementById('countdown');
let countdownTime = sessionTimeoutMinutes * 60;
let countdownInterval, idleTimeout;
let sessionTimeoutContainer = document.getElementById('sessionTimeoutContainer');

// Function to update the countdown
function updateCountdown() {
    let minutes = Math.floor(countdownTime / 60);
    let seconds = countdownTime % 60;
    minutes = minutes < 10 ? '0' + minutes : minutes;
    seconds = seconds < 10 ? '0' + seconds : seconds;

    countdownDisplay.textContent = minutes + ':' + seconds;

    countdownTime--;

    if (countdownTime < 0) {
        clearInterval(countdownInterval);
        Swal.fire({
            text: 'Your session has expired due to inactivity. You will be logged out.',
            icon: 'error',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = host; // Set your logout URL here
            }
        });
    }
}

// Function to reset idle time
function resetIdleTime() {
    clearTimeout(idleTimeout);
    idleTimeout = setTimeout(startSessionCountdown, idleTimeLimit);
    clearInterval(countdownInterval);
    countdownTime = sessionTimeoutMinutes * 60; // Reset countdown time
    sessionTimeoutContainer.style.display = 'none'; // Hide the session timeout container
}

// Function to start the session countdown after 30 seconds of inactivity
function startSessionCountdown() {
    sessionTimeoutContainer.style.display = 'flex'; // Show the session timeout container
    countdownInterval = setInterval(updateCountdown, 1000);

    // Show warning 1 minute before session expires
    // setTimeout(function() {
    //     Swal.fire({
    //         text: 'Your session will expire in 1 minute due to inactivity.',
    //         icon: 'warning',
    //         confirmButtonText: 'OK'
    //     });
    // }, warningTime);
}

// Add event listeners to detect user activity
window.onload = resetIdleTime;
window.onmousemove = resetIdleTime;
window.onkeypress = resetIdleTime;
window.onclick = resetIdleTime;
window.onscroll = resetIdleTime;
