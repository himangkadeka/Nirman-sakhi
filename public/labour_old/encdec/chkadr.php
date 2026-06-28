<?php
include 'AES.php';

// Database connection parameters
$host = "localhost";
$user = "root";
$password = "";
$database = "abaocwwb_old";

// Connect to the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

// SQL query to fetch data
$sql = "SELECT * FROM `user` WHERE `aadhar_status` = 2 AND `aadhar` IS NOT NULL";

// Prepare and execute the SQL query
try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
} catch(PDOException $e) {
    echo "Query failed: " . $e->getMessage();
    exit();
}

// Instantiate AES class
$key = '1234567890123456'; // Replace with your encryption key
$aes = new AES('', $key);

// Fetch and decrypt data
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    try {
        // Decrypt Aadhar value
        $decryptedAadhar = $aes->decrypt($row['aadhar']);

        // Output decrypted Aadhar value
        echo "Decrypted Aadhar: $decryptedAadhar <br>";
    } catch (Exception $e) {
        // Handle decryption error
        echo "Decryption error: " . $e->getMessage() . "<br>";
    }
}

?>
