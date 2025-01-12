<?php
$mysqli = new mysqli("localhost", "user1", "user1", "user1");
if($mysqli->connect_error) {
  exit('Could not connect');
}

$sql = "SELECT doc_id, doc_name, datehired, salpermon, area, supervisor_id, chgperappt, annnual_bonus
FROM doctor WHERE doc_name = ?";

$stmt = $mysqli->prepare($sql);

//Debug
if (!$stmt) {
  echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
  exit;
}
$stmt->bind_param("s", $_GET['q']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($docid, $dname, $date, $sal, $area, $spid, $chg, $bonus);
$stmt->fetch();
$stmt->close();

echo "<table>";
echo "<tr>";
echo "<th>Doctor ID</th>";
echo "<td>" . $docid . "</td>";
echo "</tr>"; 
echo "<tr>"; 
echo "<th>Doctor Name</th>";
echo "<td>" . $dname . "</td>";
echo "</tr>"; 
echo "<tr>"; 
echo "<th>Date Hired</th>";
echo "<td>" . $date . "</td>";
echo "</tr>"; 
echo "<tr>"; 
echo "<th>Salary per Month</th>";
echo "<td>" . $sal . "</td>";
echo "</tr>"; 
echo "<tr>"; 
echo "<th>Area</th>";
echo "<td>" . $area . "</td>";
echo "</tr>"; 
echo "<tr>"; 
echo "<th>Supervisor ID</th>";
echo "<td>" . $spid . "</td>";
echo "</tr>"; 
echo "<tr>"; 
echo "<th>Charge Per Appointment</th>";
echo "<td>" . $chg . "</td>";
echo "</tr>"; 
echo "<tr>"; 
echo "<th>Annual Bonus</th>"; 
echo "<td>" . $bonus . "</td>"; 
echo "</tr>";
echo "</table>";
?>