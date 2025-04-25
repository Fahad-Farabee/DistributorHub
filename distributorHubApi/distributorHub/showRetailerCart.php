<?php
// Headers for JSON response
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Include the database connection
include('dbConnect.php');

try {
    // Check if the request method is GET
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        throw new Exception("Invalid Request Method");
    }

    // Get pagination parameters (offset and limit) with defaults
    $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10; // Default limit = 10

    // Validate the parameters
    if ($offset < 0 || $limit <= 0) {
        throw new Exception("Invalid pagination parameters");
    }

    // SQL query to fetch products with pagination
    $sqlAllProduct = "SELECT * FROM products LIMIT ?, ?";
    $stmt = $conn->prepare($sqlAllProduct);
    $stmt->bind_param("ii", $offset, $limit);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch products as an array
    $products = $result->fetch_all(MYSQLI_ASSOC);

    // Check if products exist
    if (!empty($products)) {
        echo json_encode(["success" => true, "data" => $products]);
    } else {
        echo json_encode(["success" => true, "data" => [], "message" => "No products found"]);
    }
} catch (Exception $e) {
    // Handle exceptions
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
} finally {
    // Close the database connection
    $conn->close();
}
?>
