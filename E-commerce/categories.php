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

// Handle form submission to create a new category
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) {
    $categoryName = mysqli_real_escape_string($conn, $_POST['categoryName']);
    
    $sql = "INSERT INTO categories (categoryName) VALUES ('$categoryName')";
    
    if ($conn->query($sql) === TRUE) {
        echo "New category created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Select all categories
$sql = "SELECT CategoryID, CategoryName FROM categories";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Category</title>
</head>
<body>
    <h2>Add new Category</h2>
    <form method="post" action="">
        <label for="categoryName">Category Name:</label><br>
        <input type="text" id="categoryName" name="categoryName" required><br><br>
        <input type="submit" name="create" value="Create">
    </form>

    <h2>List of Categories</h2>
    <table border="1">
        <tr>
            <th>Category ID</th>
            <th>Category Name</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["CategoryID"] . "</td><td>" . $row["CategoryName"] . "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='2'>No categories found</td></tr>";
        }
        ?>
    </table>
</body>
</html>
<?php
$conn->close();
?>
