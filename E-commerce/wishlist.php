<?php
session_start();

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

// Handle adding products to the wishlist
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_wishlist'])) {
    $ProductId = $_POST['ProductId'];
    $CustomerId = 1; // Example: assuming customer ID is 1, adjust as per your login/session logic

    $sql = "INSERT INTO wishlist (customerid, productid) VALUES ('$CustomerId', '$ProductId')";
    if ($conn->query($sql) === TRUE) {
        echo "Product added to wishlist successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle removing products from the wishlist
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_from_wishlist'])) {
    $WishlistId = $_POST['WishlistId'];

    $sql = "DELETE FROM wishlist WHERE wishlistid = '$WishlistId'";
    if ($conn->query($sql) === TRUE) {
        echo "Product removed from wishlist successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch products available for adding to wishlist
$product_sql = "SELECT ProductId, ProductName, Price FROM products";
$product_result = $conn->query($product_sql);

// Fetch wishlist items
$wishlist_sql = "SELECT w.wishlistid, p.ProductId, p.ProductName, p.Price
                FROM wishlist w
                JOIN products p ON w.ProductId = p.ProductId
                WHERE w.customerid = 1"; // Adjust customer ID as per your session or login logic
$wishlist_result = $conn->query($wishlist_sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Wish List</title>
</head>
<body>
    <h2>Products</h2>
    <table border="1">
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
        <?php
        if ($product_result && $product_result->num_rows > 0) {
            while ($row = $product_result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["ProductId"] . "</td>
                        <td>" . $row["ProductName"] . "</td>
                        <td>" . $row["Price"] . "</td>
                        <td>
                            <form method='post' action=''>
                                <input type='hidden' name='ProductId' value='" . $row["ProductId"] . "'>
                                <input type='submit' name='add_to_wishlist' value='Add to Wish List'>
                            </form>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No products found</td></tr>";
        }
        ?>
    </table>

    <h2>Wish List</h2>
    <table border="1">
        <tr>
            <th>Wishlist ID</th>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
        <?php
        if ($wishlist_result && $wishlist_result->num_rows > 0) {
            while ($row = $wishlist_result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["wishlistid"] . "</td>
                        <td>" . $row["ProductId"] . "</td>
                        <td>" . $row["ProductName"] . "</td>
                        <td>" . $row["Price"] . "</td>
                        <td>
                            <form method='post' action=''>
                                <input type='hidden' name='WishlistId' value='" . $row["wishlistid"] . "'>
                                <input type='submit' name='remove_from_wishlist' value='Remove'>
                            </form>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No products in wish list</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
