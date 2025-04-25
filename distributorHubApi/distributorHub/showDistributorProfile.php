<?php
// Headers for JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
// Connecting to database
include('dbConnect.php');
$userId = $_GET['userId'] ?? null;

if (!$userId) {
    echo json_encode(["success" => false, "message" => "User ID is required."]);
    exit();
}

try {
    $query = "SELECT * FROM distributors WHERE distributorSL = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo json_encode(["success" => true, "data" => $user]);
    } else {
        echo json_encode(["success" => false, "message" => "User not found."]);
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
} finally {
    $stmt->close();
    $conn->close();
}

?>