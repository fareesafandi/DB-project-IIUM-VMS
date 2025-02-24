<?php

$mysqli = new mysqli("localhost", "user1", "user1", "user1"); 

if($mysqli -> connect_error) {
    exit('Could not connect.'); 
}

$user_id = $_GET['id']; 
$UserStat = "Pending"; 

//compare user id
$sql = "SELECT B_ID FROM BOOKER"; 

$stmt = $mysqli -> prepare($sql); 

$stmt -> execute(); 
$result = $stmt -> get_result(); 

while($row = $result -> fetch_assoc()) {

    if($user_id == $row['B_ID']) {

        echo "<p> User ID Valid <p>"; 

        $sqlinsert = "INSERT INTO BOOKEDVENUE (VN_ID, B_ID, VN_DATE, TIME, B_STATUS)
                      VALUES(?, ?, ?, ?, ?); ";

        $insert = $mysqli -> prepare($sqlinsert); 
        $insert -> bind_param("iisss", $_GET['venues'], $user_id, $_GET['date'], $_GET['time'], $UserStat); 
        $status = $insert -> execute(); 

        echo "<p>VENUE ID: " . $_GET['venues'] . "</p>";
        echo "<p>USER ID: " . $user_id ."</p>";
        echo "<p>DATE: " . $_GET['date'] . "</p>";
        echo "<p>TIME: " . $_GET['time'] . "</p>"; 
        echo "<p>Approval Status: Pending</p>"; 

        if(!$status) {
            echo "<p>There's an error</p>";
        } else {
            echo "<p>Booking Successful</p>"; 
            echo "<button onclick='javascript:history.back()'>Return to page</button>"; 
        } 
        break; 
    }

}

