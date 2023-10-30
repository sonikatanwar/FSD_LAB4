<?php
$host = "localhost";
$username = "myuser";
$password = "password";
$database = "FSD_LAB4";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM students";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $records = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $records[] = $row;
    }
    echo json_encode($records);
} else {
    echo json_encode(array()); // Return an empty array if no records found
}

mysqli_close($conn);
?>
