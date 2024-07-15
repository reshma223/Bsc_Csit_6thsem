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

// Initialize cart session if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Handle adding products to the cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $ProductId = $_POST['ProductId'];
    $Quantity = $_POST['Quantity'];
    $CId = $_POST['CId']; // Assuming this is the Category ID for the product

    // If product already in cart, update quantity; otherwise, add new entry
    if (isset($_SESSION['cart'][$ProductId])) {
        $_SESSION['cart'][$ProductId]['Quantity'] += $Quantity;
    } else {
        $_SESSION['cart'][$ProductId] = array('CId' => $CId, 'Quantity' => $Quantity);
    }
}

// Handle updating quantities in the cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_cart'])) {
    $ProductId = $_POST['ProductId'];
    $Quantity = $_POST['Quantity'];

    // Update quantity for the selected product in cart
    if (isset($_SESSION['cart'][$ProductId])) {
        $_SESSION['cart'][$ProductId]['Quantity'] = $Quantity;
    }
}

// Handle removing products from the cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_from_cart'])) {
    $ProductId = $_POST['ProductId'];

    // Remove product from cart
    unset($_SESSION['cart'][$ProductId]);
}

// Fetch product details for products in the cart
$cart_details = array();
if (!empty($_SESSION['cart'])) {
    $productIds = array_keys($_SESSION['cart']);
    $productIdsString = implode(",", $productIds);

    $product_sql = "SELECT ProductId, ProductName, Price FROM products WHERE ProductId IN ($productIdsString)";
    $product_result = $conn->query($product_sql);

    if ($product_result->num_rows > 0) {
        while ($row = $product_result->fetch_assoc()) {
            $ProductId = $row['ProductId'];
            $row['Quantity'] = $_SESSION['cart'][$ProductId]['Quantity'];
            $row['Total'] = $row['Price'] * $_SESSION['cart'][$ProductId]['Quantity'];
            $cart_details[] = $row;
        }
    }
}

// Calculate total amount in the cart
$total_amount = array_sum(array_column($cart_details, 'Total'));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart</title>
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
        // Display products available for purchase
        $product_sql = "SELECT ProductId, ProductName, Price FROM products";
        $product_result = $conn->query($product_sql);

        if ($product_result->num_rows > 0) {
            while ($row = $product_result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["ProductId"] . "</td>
                        <td>" . $row["ProductName"] . "</td>
                        <td>" . $row["Price"] . "</td>
                        <td>
                            <form method='post' action=''>
                                <input type='hidden' name='ProductId' value='" . $row["ProductId"] . "'>
                                <input type='hidden' name='CId' value='1'> <!-- Assuming CId is 1 for simplicity -->
                                <input type='number' name='Quantity' value='1' min='1'>
                                <input type='submit' name='add_to_cart' value='Add to Cart'>
                            </form>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No products found</td></tr>";
        }
        ?>
    </table>

    <h2>Shopping Cart</h2>
    <table border="1">
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
        <?php
        // Display products in the shopping cart
        foreach ($cart_details as $product) {
            echo "<tr>
                    <td>" . $product['ProductId'] . "</td>
                    <td>" . $product['ProductName'] . "</td>
                    <td>" . $product['Price'] . "</td>
                    <td>
                        <form method='post' action=''>
                            <input type='hidden' name='ProductId' value='" . $product['ProductId'] . "'>
                            <input type='number' name='Quantity' value='" . $product['Quantity'] . "' min='1'>
                            <input type='submit' name='update_cart' value='Update'>
                        </form>
                    </td>
                    <td>" . $product['Total'] . "</td>
                    <td>
                        <form method='post' action=''>
                            <input type='hidden' name='ProductId' value='" . $product['ProductId'] . "'>
                            <input type='submit' name='remove_from_cart' value='Remove'>
                        </form>
                    </td>
                </tr>";
        }
        ?>
        <tr>
            <td colspan="4">Total Amount</td>
            <td><?php echo $total_amount; ?></td>
            <td></td>
        </tr>
    </table>
</body>
</html>

<?php
$conn->close();
?>
