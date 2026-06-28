<video id="live-camera" width="640" height="480" autoplay></video>
<button id="capture-btn">Capture</button>
<canvas id="canvas" style="display:none;"></canvas>

<script>
    const video = document.getElementById('live-camera');
    const canvas = document.getElementById('canvas');
    const captureButton = document.getElementById('capture-btn');

    // Access the user's camera stream
    navigator.mediaDevices.getUserMedia({ video: true })
        .then(function(stream) {
            video.srcObject = stream;
        })
        .catch(function(err) {
            console.error('Error accessing camera:', err);
        });

    // Capture frame from video stream
    captureButton.addEventListener('click', function() {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
        const imageData = canvas.toDataURL('image/png'); // Convert canvas to base64 image data
        // Send imageData to Laravel backend using AJAX or form submission
    });
</script>
