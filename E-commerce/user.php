<?php
$servername = "localhost";
$username = "root";
$password = "se4cure!";
$dbname = "shophere";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $Name = $_POST['Name'];
    $Email = $_POST['Email'];
    $Address = $_POST['Address'];
    $PhoneNo = $_POST['PhoneNo'];

    $sql = "INSERT INTO customer (Name, Email, Address, PhoneNo) 
    VALUES ('$Name', '$Email', '$Address', '$PhoneNo')";
    if ($conn->query($sql) === TRUE) {
        echo "New customer created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT CustomerID, Name, Email, Address, PhoneNo FROM customer";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
<title>Customer Registration</title>
</head>
<body>
<h2>Register Customer</h2>
<form method="post" action="">
    <label for="Name">Name:</label><br>
    <input type="text" id="Name" name="Name" required><br><br>
    <label for="Email">Email:</label><br>
    <input type="email" id="Email" name="Email" required><br><br>
    <label for="Address">Address:</label><br>
    <input type="text" id="Address" name="Address" required><br><br>
    <label for="PhoneNo">Phone Number:</label><br>
    <input type="text" id="PhoneNo" name="PhoneNo" required><br><br>
    <input type="submit" name="register" value="Register">
</form>

<h2>List of Customers</h2>
<table border="1">
<tr>
    <th>Customer ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Address</th>
    <th>Phone Number</th>
</tr>
<?php
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["CustomerID"]. "</td><td>" . $row["Name"]. "</td><td>" . $row["Email"]. "</td><td>" . $row["Address"]. "</td><td>" . $row["PhoneNo"]. "</td></tr>";
    }
} else {
    echo "<tr><td colspan='5'>No customers found</td></tr>";
}
?>
</table>
</body>
</html>
<?php
$conn->close();
?>
