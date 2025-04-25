<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include ('dbConnect.php');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
        throw new Exception("Invalid Request Method");
    }

    // Read the raw input data to get the id
    $inputData = json_decode(file_get_contents("php://input"), true);

    if (!isset($inputData['prodId'])) {
        throw new Exception("Product ID is required");
    }

    $productId = $inputData['prodId'];

    // Prepare SQL to delete the product
    $deleteProductSQL = "DELETE FROM products WHERE prodId = ?";
    $stmt = $conn->prepare($deleteProductSQL);
    $stmt->bind_param("i", $productId);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(["success" => true, "message" => "Product deleted successfully"]);
        } else {
            throw new Exception("No product found with the given ID");
        }
    } else {
        throw new Exception("Failed to delete product");
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
} finally {
    $conn->close();
}
?>
