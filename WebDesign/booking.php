<?php

$mysqli = new mysqli("localhost", "user1", "user1", "user1"); 

if($mysqli -> connect_error) {
    exit('Could not connect.'); 
}

$typeform = $_GET['type']; 

if($typeform == 'book') {

    //for displaying option
    $sql = "SELECT VN_NAME, VN_ID FROM VENUE WHERE KULLIYAH = ?";
    $stmt = $mysqli -> prepare($sql); 
    $stmt -> bind_param("s", $_GET['v']);
    $stmt -> execute(); 

    $result = $stmt -> get_result(); 

    echo "<h3> Venue Booking <h3>"; 
    echo "<form action ='insert.php' method='GET'>"; 
    echo "<label for='venue'> Venue :</label>"; 
    echo "<select id='venue' name='venues'>"; 
    echo "<option value=''>Select Venue</option>"; 

    while($row = $result -> fetch_assoc()) {

        echo "<option name='vid' value=" . $row['VN_ID'] . ">". $row['VN_NAME'] . "</option>";
    }
    echo "</select><br> "; 
    echo "<label for='identify'> ID :</label>"; 
    echo "<input id='identify' type='number' name='id'><br>";
    echo "<label for='date'> Date :</label>"; 
    echo "<input id='date' type='date' name='date'><br>";
    echo "<label for='time'> Time :</label>"; 
    echo "<input id='time' type='time' name='time'><br>";
    echo "<input type='submit' value='book'>"; 
    echo "</form>"; 

} elseif($typeform == 'update') {

    $sql = "SELECT VN_NAME, VN_ID FROM VENUE WHERE KULLIYAH = ?";
    $stmt = $mysqli -> prepare($sql); 
    $stmt -> bind_param("s", $_GET['v']);
    $stmt -> execute(); 

    $result = $stmt -> get_result(); 

    echo "<h3 style='margin:10px;'>Key-in details of your booking to update:</h3>"; 

    //action='update.php'
    echo "<form action='update.php' method='GET'>"; 
    echo "<label for='identify'> ID :</label>"; 
    echo "<input id='identify' type='number' name='id'><br>";
    echo "<label for='identify'> Venue :</label>";
    echo "<select id='venue' name='venues'>";
    while($row = $result -> fetch_assoc()) {

        echo "<option name='vid' value=" . $row['VN_ID'] . ">". $row['VN_NAME'] . "</option>";
    }
    echo "</select><br> "; 
    echo "<label for='date'> New Date :</label>"; 
    echo "<input id='date' type='date' name='date'><br>";
    echo "<label for='time'> New Time :</label>"; 
    echo "<input id='time' type='time' name='time'><br>";
    echo "<input type='submit' value='Update Booking'>"; 
    echo "</form>"; 
}


?>