<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Create connection
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Generate random ID with a random length between 1 and 24
    $randomLength = rand(1, 24);
    $randomId = generateRandomId($randomLength);

    // Prepare and execute the INSERT statement
    $stmt = $conn->prepare("INSERT INTO pastes (id, content, syntax) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $randomId, $_POST['content'], $_POST['syntax']);
    $stmt->execute();

    // Close statement and database connection
    $stmt->close();
    $conn->close();

    $redirectUrl = "view?id=" . $randomId;
    header("Location: " . $redirectUrl);
    exit;
}

// Function to generate random ID
function generateRandomId($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomId = '';

    for ($i = 0; $i < $length; $i++) {
        $randomId .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $randomId;
}
?>
