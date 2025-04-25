<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include('dbConnect.php');

try {
    
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {

        throw new Exception("Invalid Request Method");

    }

    $productName = $_GET['prodname'] ?? null;

    if (empty($productName)) {

        throw new Exception("No product name provided");

    }

    $stmt = $conn->prepare("SELECT * FROM distributors INNER JOIN products ON distributors.distributorSL = products.distributorSL WHERE prodName LIKE ?");

    $searchTerm = "%" . $productName . "%";

    $stmt->bind_param("s", $searchTerm);

    $stmt->execute();

    $resultQuery = $stmt->get_result();

    $result = [];

    while ($row = $resultQuery->fetch_assoc()) {

        $result[] = $row;

    }

    if (empty($result)) {

        throw new Exception("No products found matching the given name");

    }

    echo json_encode(["success" => true, "data" => $result]);

} catch (Exception $e) {

    echo json_encode(["success" => false, "message" => $e->getMessage()]);

} finally {

    $conn->close();

}

?>
