<?php
$host = "localhost"; 
$user = "root";  
$pass = "";      // change if needed
$dbname = "esp8266_leds";

// Connect to DB
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}

// If user clicks buttons (web UI)
if (isset($_GET['led']) && isset($_GET['state'])) {
    $led = intval($_GET['led']);
    $state = intval($_GET['state']);
    $sql = "UPDATE leds SET state=$state WHERE id=$led";
    $conn->query($sql);
}
$result = $conn->query("SELECT state FROM leds ORDER BY id ASC");
$response = "";
while ($row = $result->fetch_assoc()) {
    $response .= $row['state'];
}
echo $response;
$conn->close();
?>
