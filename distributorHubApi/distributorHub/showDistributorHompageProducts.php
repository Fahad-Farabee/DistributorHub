<?php
// Headers for JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Connecting to database
include('dbConnect.php');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        throw new Exception("Invalid Request Method");
    }

    /* $sqlAllProduct = "SELECT * FROM products"; */
    $sqlAllProduct = "SELECT * FROM distributors INNER JOIN products ON distributors.distributorSL = products.distributorSL ";
    $sqlAllProductResult = mysqli_query($conn, $sqlAllProduct);
    $result = [];

    while ($row = mysqli_fetch_assoc($sqlAllProductResult)) {
        $result[] = $row; // Add each product to the result array
    }

    if (!empty($result)) {
        echo json_encode(["success" => true, "data" => $result]);
    } else {
        throw new Exception("No Data Found!");
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
} finally {
    $conn->close();
}
?>