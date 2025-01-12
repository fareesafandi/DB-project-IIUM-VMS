<?php

$mysqli = new mysqli("localhost", "user1", "user1", "user1"); 

if($mysqli -> connect_error) {
    exit('Could not connect.'); 
}

$user_id = $_GET['id']; 
$vn_id = $_GET['venues']; 
$newTime = $_GET['time']; 
$newDate = $_GET['date']; 

$sql = "SELECT B_ID, VN_ID, TIME, VN_DATE FROM BOOKEDVENUE"; 

$stmt = $mysqli -> prepare($sql); 
$stmt -> execute(); 

$result = $stmt -> get_result(); 

while($row = $result -> fetch_assoc()) {

    if(($user_id == $row['B_ID']) && ($vn_id == $row['VN_ID'])) {
        
        $oldDate = $row['VN_DATE']; 
        $oldTime = $row['TIME']; 

        echo "<p>Venue Available</p>"; 

        echo "<p>Old Date: " . $oldDate . "</p>";
        echo "<p>New Date: " . $newDate . "</p>";
        echo "<p>Old Time: " . $oldTime . "</p>";
        echo "<p>New Time: " . $newTime . "</p>";

        $update = "UPDATE BOOKEDVENUE SET VN_DATE = ?, TIME = ? WHERE VN_ID = ? AND B_ID = ?"; 

        $updateQuery = $mysqli -> prepare($update); 
        $updateQuery -> bind_param("ssii", $newDate, $newTime, $vn_id, $user_id); 
        $status = $updateQuery -> execute(); 

        if(!$status) {
            echo "<p>Update Attempt Unsuccesful.</p>"; 
        } else {
            echo "<p>Update Attempt Successful.</p>"; 
        }
        break; 
    }

}

echo "<button onclick='javascript:history.back()'>Return to page</button>"; 


?>