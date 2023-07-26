<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "class_ranks";

$conn = mysqli_connect($hostname, $username, $password, $database);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Extract the data from the form submission
  $name = $_POST["nama"];
  $score = $_POST["nilai"];

  // Insert the data into the database
  $sql = "INSERT INTO students (name, nilai) VALUES ('$name', $score)";
  if (mysqli_query($conn, $sql)) {
    echo "Data inserted successfully.";
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
}

// Fetch data from the database to display in the table
$sql = "SELECT * FROM students";
$result = mysqli_query($conn, $sql);

// Check if data retrieval was successful
if (!$result) {
  echo "Error fetching data: " . mysqli_error($conn);
} else {
  $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>