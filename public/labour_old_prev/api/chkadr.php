<?php
// Include AES decryption file
require_once('AES.php');

// Database connection parameters
$servername = "localhost"; // Change if your MySQL server is on a different host
$username = "labour"; // Change to your MySQL username
$password = "labour@123"; // Change to your MySQL password
$database = "labourolddb"; // Change to your MySQL database name

// Encryption key
$key = "1234567890123456"; // Your encryption key

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to select Aadhar numbers from the user table
$sql = "SELECT aadhar FROM user";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Loop through each row of the result set
    while($row = $result->fetch_assoc()) {
        // Decrypt Aadhar number
        $decryptedAadhar = AES::decrypt($row["aadhar"], $key); // Assuming AES class and decrypt method from AES.php
        
        // Output decrypted Aadhar number
        echo "Decrypted Aadhar: " . $decryptedAadhar . "<br>";
    }
} else {
    echo "0 results";
}

// Close connection
$conn->close();
?>
