<?php
    // Database credentials
$servername = "localhost";
$username = "user1";
$password = "user1";
$dbname = "user1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    print_r($_POST); 
    $newStatus = $_POST['status']; 
    $userid = $_POST['bid'];
    $vid = $_POST['vid'];
    $time = $_POST['time'];
    $date = $_POST['date']; 

    echo "<pre>";
    echo "B_STATUS: " . htmlspecialchars($newStatus) . "\n";
    echo "B_ID: " . htmlspecialchars($userid) . "\n";
    echo "VN_ID: " . htmlspecialchars($vid) . "\n";
    echo "VN_DATE: " . htmlspecialchars($date) . "\n";
    echo "TIME: " . htmlspecialchars($time) . "\n";
    echo "</pre>";


    $sqld = "UPDATE BOOKEDVENUE SET B_STATUS = ? WHERE B_ID = ? AND VN_ID = ? AND VN_DATE = ? AND TIME = ?";
    //prepare statemtent
    $stmt2 = $conn->prepare($sqld);
    //binding values
    $stmt2->bind_param("siiss", $newStatus, $userid, $vid, $date, $time); 
    //execute statement : failed.
    $stmt2->execute();

    if ($stmt2->affected_rows > 0) {
        echo "<p>Changes successfully commited.</p>";
        header("Location: admin.php"); // Redirect to refresh the page
        exit();
    } else {
        echo "<p>No changes were made.</p>";
        echo "Execute failed: (" . $stmt2->errno . ") " . $stmt2->error;    
    }

    $stmt2->close(); 
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <meta name="description" content="IIUM Venue Management System">
        <link rel="stylesheet" href="web.css">

        <title>IIUM VMS</title>

    </head>
    <body>
        
        <div id="home" onclick="document.location='index.html'">
            <img src="img/IIUM.svg" alt="IIUMlogo" id="titlelogo">
            <h1 id="title" style="text-align: left;">IIUM VMS</h1>
        </div>
        

        <h1 id="title" style="font-family: Courier;margin-left: 50px;">Venue Management System ADMIN PAGE</h1>
        
        <div class="mainbody">

            <?php
            $sql = "SELECT BOOKEDVENUE.VN_ID, B_ID, VN_NAME, VN_DATE, TIME, B_STATUS FROM BOOKEDVENUE JOIN VENUE 
            ON VENUE.VN_ID = BOOKEDVENUE.VN_ID";
            
            $stmt = $conn -> prepare($sql);
            
            //fetch results
            $stmt -> execute(); 
            
            $result = $stmt -> get_result(); 

            //get name need bind_param
            
            echo "<h3>Booked Venues:</h3>";
            echo "<table>";
            echo "<tr>";  
            echo "<th>Name</th>";
            echo "<th>Type</th>"; 
            echo "<th>Venue</th>";
            echo "<th>Date</th>";
            echo "<th>Time</th>";
            echo "<th>Status</th>";
            echo "<th>Changes to...</th>"; 
            echo "</tr>"; 
            
            
            while($row = $result -> fetch_assoc()) {
                $vname = $row['VN_NAME']; 
                $date = $row['VN_DATE']; 
                $time = $row['TIME']; 
                $status = $row['B_STATUS']; 
                $userid = $row['B_ID']; 
                $vid = $row['VN_ID']; 

                $sql2 = "SELECT FNAME, LNAME, TYPE FROM BOOKER JOIN BOOKEDVENUE 
                ON BOOKER.B_ID = BOOKEDVENUE.B_ID WHERE BOOKER.B_ID = ? ";
                
                $stmtI = $conn -> prepare($sql2);
                
                $stmtI -> bind_param("i", $userid); 
                //fetch results
                $stmtI -> execute(); 
                
                $resultI = $stmtI -> get_result(); 
                $rowI = $resultI -> fetch_assoc(); 
                $fname = $rowI['FNAME']; 
                $lname = $rowI['LNAME']; 
                $type = $rowI['TYPE']; 
                
                echo "<tr>"; 
                echo "<td>" . $fname ." ". $lname . "</td>";
                echo "<td>" . $type . "</td>";
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
                echo "<td>";
                echo "<form action='admin.php' method='POST'>";
                echo "<select id='status' name='status'>"; 
                //Display only wanted. this might be too much...
                if($status == 'Confirmed') {
                    echo "<option value=''>" . $status . "</option>"; 
                    echo "<option value='Pending'>Pending</option>";
                    echo "<option value='Cancelled'>Cancelled</option>";  
                } elseif($status == 'Pending') {
                    echo "<option value=''>" . $status . "</option>"; 
                    echo "<option value='Confirmed'>Confirmed</option>";
                    echo "<option value='Cancelled'>Cancelled</option>"; 
                } else {
                    echo "<option value=''>" . $status . "</option>"; 
                    echo "<option value='Pending'>Pending</option>";
                    echo "<option value='Confirmed'>Confirmed</option>"; 
                }
                echo "</select>";
                //send hidden value.
                echo "<input type='hidden' name='bid' value='" . $userid . "'>"; 
                echo "<input type='hidden' name='vid' value='" . $vid . "'>";
                echo "<input type='hidden' name='time' value='" . $time . "'>";
                echo "<input type='hidden' name='date' value='" . $date . "'>";
                echo "<input type='submit' value='Make Changes'>"; 
                echo "</form>"; 
                echo "</td>"; 
                echo "</tr>";   
            }
            echo "</table>"; 
            
            
            $result -> close(); 
            
            ?>
        </div>
        
        <!--<a href="test.htm">Redirect to test page.</a>-->

        <div>
            <footer class="footer">
                <p>IIUM Venue Management System</p>
                <p>By Group 5</p>
                <p>BIIT 1301 SEM 1 2024/2025</p>
            </footer>
        </div>
    </body>

</html>