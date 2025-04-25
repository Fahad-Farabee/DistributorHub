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

    if (!isset($inputData['cartid'])) {
        throw new Exception("Cart ID is required");
    }

    $cartid = $inputData['cartid'];

    // Prepare SQL to delete the product
    $deleteProductSQL = "DELETE FROM mycart WHERE cartId = ?";
    $stmt = $conn->prepare($deleteProductSQL);
    $stmt->bind_param("i", $cartid);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(["success" => true, "message" => "cart item deleted successfully"]);
        } else {
            throw new Exception("No cart item found with the given ID");
        }
    } else {
        throw new Exception("Failed to delete cart item");
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
} finally {
    $conn->close();
}
?>
