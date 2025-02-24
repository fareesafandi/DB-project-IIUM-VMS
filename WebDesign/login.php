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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Prepare and execute an SQL statement to check credentials
    $stmt = $conn->prepare("SELECT EMAIL, PASSWORD FROM BOOKER WHERE EMAIL = ? AND PASSWORD = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    $row = $result -> fetch_assoc(); 

    $stmtADMIN = $conn->prepare("SELECT ADMIN_ID, PASSWORD FROM ADMINISTRATOR WHERE ADMIN_ID = ? AND PASSWORD = ?");
    $stmtADMIN->bind_param("ss", $email, $password);
    $stmtADMIN->execute();
    $resultADMIN = $stmtADMIN->get_result();

    $rowADMIN = $resultADMIN -> fetch_assoc(); 
    // Check user for real credential
    if (($email == $row['EMAIL'] && ($password == $row['PASSWORD']))) {
        // Login successful, redirect to index.html
        header("Location: index.html");
        exit();
    } elseif(($email == $rowADMIN['ADMIN_ID'] && ($password == $rowADMIN['PASSWORD']))){
        header("Location: admin.php");
        exit();
    } else {
        // Login failed, display an error message
        echo "Invalid username or password.";
    }

    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="description" content="IIUM Venue Management System login page">
    <link rel="stylesheet" href="web.css">
    <title>IIUM VMS Login Page</title>
</head>
<body>
    <div id="home" onclick="document.location='login.php'">
        <img src="img/IIUM.svg" alt="IIUMlogo" id="titlelogo">
        <h1 id="title" style="text-align: left;">IIUM VMS</h1>
    </div>
    <div class="mainbody">
    <h2>Login IIUM Venue Management System</h2>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="bookingform" style="text-align:center;">
        Email: <input type="text" name="email" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>
    <div>
    <div>
        <footer class="footer">
            <p>IIUM Venue Management System</p>
            <p>By Group 5</p>
            <p>BIIT 1301 SEM 1 2024/2025</p>
        </footer>
    </div>
</body>
</html>