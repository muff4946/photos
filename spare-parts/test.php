<?php
$servername = "localhost";
$username = "images";
$password = "F0t0b0mb";
$dbname = "anderson_images";

echo "<pre>";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT tag_id, tag_names, tag_type FROM tags";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "id: " . $row["tag_id"]. " - Names: " . $row["tag_names"]. "<br>";
  }
} else {
  echo "0 results";
}
$conn->close();
?>
