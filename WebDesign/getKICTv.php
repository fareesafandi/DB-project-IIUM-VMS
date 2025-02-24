<?php

$mysqli = new mysqli("localhost", "user1", "user1", "user1"); 
if($mysqli -> connect_error) {
    exit('Could not connect'); 
}

$sql = "SELECT VN_NAME, KULLIYAH, BLOCK, VN_LEVEL FROM VENUE WHERE KULLIYAH = ?"; 

$stmt = $mysqli -> prepare($sql);

if(!$stmt) {
    echo "<p>This array is empty.</p>";
    echo "<p>" . $sql . "</p>"; 
}

$stmt -> bind_param("s", $_GET['v']); 
//fetch results
$stmt -> execute(); 

$result = $stmt -> get_result(); 

echo "<h3>Available venues:</h3>";
echo "<table>"; 
echo "<tr>"; 
echo "<th> Venue </th>"; 
echo "<th> Kulliyah </th>";
echo "<th> Block </th>";
echo "<th> Level </th>";
echo "</tr>"; 

while($row = $result -> fetch_assoc()) { 
    $vname = $row['VN_NAME'];
    $vkulliyah = $row['KULLIYAH'];
    $vblock = $row['BLOCK']; 
    $vlevel = $row['VN_LEVEL'];
    
    echo "<tr>"; 
    echo "<td>" . $vname . "</td>"; 
    echo "<td>" . $vkulliyah . "</td>";
    echo "<td>" . $vblock . "</td>";
    echo "<td>" . $vlevel . "</td>";
    echo "</tr>"; 
}
echo "</table>"; 

mysqli_free_result($result); 

$sql = "SELECT VN_NAME, VN_DATE, TIME, B_STATUS FROM BOOKEDVENUE JOIN VENUE 
        ON VENUE.VN_ID = BOOKEDVENUE.VN_ID WHERE KULLIYAH = ?";

$stmt = $mysqli -> prepare($sql);

$stmt -> bind_param("s", $_GET['v']); 
//fetch results
$stmt -> execute(); 

$result = $stmt -> get_result(); 

echo "<h3>Booked Venues:</h3>";
echo "<table>";
echo "<tr>";  
echo "<th>Venue</th>";
echo "<th>Date</th>";
echo "<th>Time</th>";
echo "<th>Status</th>";
echo "</tr>"; 


while($row = $result -> fetch_assoc()) {
    $vname = $row['VN_NAME']; 
    $date = $row['VN_DATE']; 
    $time = $row['TIME']; 
    $status = $row['B_STATUS']; 

    echo "<tr>"; 
    echo "<td>" . $vname . "</td>";
    echo "<td>" . $date . "</td>";
    echo "<td>" . $time . "</td>";

    if($status == 'Confirmed') {
        echo "<td style='color: yellowgreen;'>" . $status . "</td>"; 
    } elseif($status == 'Pending') {
        echo "<td style='color: orange;'>" . $status . "</td>";
    } else {
        echo "<td style='color: red;'>" . $status . "</td>";
    }
    echo "</tr>";   
}
echo "</table>"; 


$result -> close(); 
?>