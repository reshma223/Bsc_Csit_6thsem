<?php
$servername = "localhost";
$username = "root";
$password = "se4cure!";
$dbname = "shophere";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) {
    $ProductName = $_POST['ProductName'];
    $Price = $_POST['Price'];
    $CategoryId = $_POST['CategoryId'];
    
    // For simplicity, assuming Description is not included in form submission
    $sql = "INSERT INTO products (ProductName, Price, CategoryID) VALUES ('$ProductName', '$Price', '$CategoryId')";
    
    if ($conn->query($sql) === TRUE) {
        echo "New product created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$selected_CategoryId = isset($_GET['CategoryId']) && $_GET['CategoryId'] !== '' ? $_GET['CategoryId'] : null;

$product_sql = "SELECT ProductID, ProductName, Price, CategoryID FROM products";
if ($selected_CategoryId !== null) {
    $product_sql .= " WHERE CategoryID = '$selected_CategoryId'";
}
$product_result = $conn->query($product_sql);

// Define $category_sql before using it
$category_sql = "SELECT CategoryID, CategoryName FROM categories"; // Corrected table name
$category_result = $conn->query($category_sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Product</title>
</head>
<body>
    <h2>Add new Product</h2>
    <form method="post" action="">
        <label for="ProductName">Product Name:</label><br>
        <input type="text" id="ProductName" name="ProductName" required><br><br>
        <label for="Price">Price:</label><br>
        <input type="number" step="0.01" id="Price" name="Price" required><br><br>
        <label for="CategoryId">Category:</label><br>
        <select id="CategoryId" name="CategoryId" required>
            <?php
            if ($category_result->num_rows > 0) {
                while ($row = $category_result->fetch_assoc()) {
                    echo "<option value='" . $row["CategoryID"] . "'>" . $row["CategoryName"] . "</option>";
                }
            } else {
                echo "<option value=''>No categories found</option>";
            }
            ?>
        </select><br><br>
        <input type="submit" name="create" value="Create">
    </form>

    <h2>List of Products</h2>
    <form method="get" action="">
        <select id="CategoryId" name="CategoryId">
            <option value="">All Categories</option>
            <?php
            $category_result->data_seek(0); // Reset the result pointer
            if ($category_result->num_rows > 0) {
                while ($row = $category_result->fetch_assoc()) {
                    $selected = ($row["CategoryID"] == $selected_CategoryId) ? 'selected' : '';
                    echo "<option value='" . $row["CategoryID"] . "' $selected>" . $row["CategoryName"] . "</option>";
                }
            }
            ?>
        </select>
        <input type="submit" value="Filter">
    </form>

    <table border="1">
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Category ID</th>
        </tr>
        <?php
        if ($product_result->num_rows > 0) {
            while ($row = $product_result->fetch_assoc()) {
                echo "<tr><td>" . $row["ProductID"] . "</td><td>" . $row["ProductName"] . "</td><td>" . $row["Price"] . "</td><td>" . $row["CategoryID"] . "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No products found for the selected category</td></tr>";
        }
        ?>
    </table>
</body>
</html>
<?php
$conn->close();
?>
