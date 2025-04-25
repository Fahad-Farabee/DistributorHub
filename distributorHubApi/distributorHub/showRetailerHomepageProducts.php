<?php
// Headers for JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Connecting to database
include('dbConnect.php');
    $retaielrId = $_GET['retailerId'];
try {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        throw new Exception("Invalid Request Method");
    }

    $retailerRegion = "SELECT region FROM retailers WHERE retailerSL = $retaielrId";
    $retailerRegionResult = mysqli_query($conn, $retailerRegion);
    $regionRow = mysqli_fetch_assoc($retailerRegionResult);
    $region = $regionRow['region'];
    $sqlAllProduct = "SELECT * FROM products WHERE prodRegion = '$region' ";
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