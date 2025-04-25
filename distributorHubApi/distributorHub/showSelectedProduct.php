<?php
// Headers for JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
// Connecting to database
include('dbConnect.php');
$prodId = $_GET['prodId'] ?? null;

if (!$prodId) {
    echo json_encode(["success" => false, "message" => "Product ID is required."]);
    exit();
}

try {
    /* $query = "SELECT * FROM products WHERE prodId = ?"; */
    $query = "SELECT *
              FROM products 
              JOIN distributors ON products.distributorSL = distributors.distributorSL
              WHERE prodId = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $prodId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        echo json_encode(["success" => true, "data" => $product]);
    } else {
        echo json_encode(["success" => false, "message" => "PRODUCT not found."]);
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
} finally {
    $stmt->close();
    $conn->close();
}

?>