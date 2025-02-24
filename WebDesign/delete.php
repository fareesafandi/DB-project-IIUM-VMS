<?php

$mysqli = new mysqli("localhost", "user1", "user1", "user1"); 

if($mysqli -> connect_error) {
    exit('Could not connect.'); 
}

$vid = $_GET['vid'];
$vname = $_GET['vname'];
$date = $_GET['date'];
$time = $_GET['time'];
//print_r($_GET);

$sql = "DELETE FROM BOOKEDVENUE WHERE VN_ID = ? AND VN_DATE = ? AND TIME = ?"; 

$deleteQuery = $mysqli -> prepare($sql); 
if (!$deleteQuery) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    exit;
  }
$deleteQuery -> bind_param("iss", $vid, $date, $time); 
$status = $deleteQuery -> execute(); 

if($deleteQuery -> affected_rows > 0) {
    echo "<p style='background-color:yellowgreen;'>Delete Successful! Please refresh page.</p>";  
} else {
    echo "<p style='color: red;'>Delete Failed</p>"; 
}


?>