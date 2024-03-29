<?php
// Database configuration
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "ip_finder_db"; 

// Get the IP address of the visitor
function getIPAddress() {
    
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    
    else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

// Save the IP address into the database
function saveIPAddress($ip, $servername, $username, $password, $dbname) {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO ip_addresses (ip_address) VALUES (?)");
    $stmt->bind_param("s", $ip);

    // Execute SQL statement
    $stmt->execute();

    // Close statement and connection
    $stmt->close();
    $conn->close();
}

// Usage
$visitor_ip = getIPAddress();
echo "Your IP Address is: " . $visitor_ip;

// Save IP address into the database
saveIPAddress($visitor_ip, $servername, $username, $password, $dbname);
?>
