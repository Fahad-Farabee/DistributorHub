<?php 

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PATCH");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include('dbConnect.php');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'PATCH') {
        throw new Exception("Invalid Request Method");
    }

    // Parse PATCH request data
    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input) {
        throw new Exception("Invalid JSON input");
    }

    $prod_id = $input['prod_id'] ?? null;
    $prod_name = $input['productName'] ?? null;
    $prod_Min_Qtn = $input['productMinQtn'] ?? null;
    $prod_Price_Per_piece = $input['productPricePerPiece'] ?? null;
    $prod_Type = $input['productType'] ?? null;
    $prod_Category = $input['productCategory'] ?? null;
    $prod_Company = $input['productCompany'] ?? null;
    $prod_Region = $input['productRegion'] ?? null;

    if (!$prod_id) {
        throw new Exception("Product ID is required");
    }

    // Build the update query dynamically based on provided fields
    $fieldsToUpdate = [];
    if (!empty($prod_name)) {
        $fieldsToUpdate[] = "prodName = '" . mysqli_real_escape_string($conn, $prod_name) . "'";
    }
    if (!empty($prod_Min_Qtn)) {
        $fieldsToUpdate[] = "prodMinQtn = '" . mysqli_real_escape_string($conn, $prod_Min_Qtn) . "'";
    }
    if (!empty($prod_Price_Per_piece)) {
        $fieldsToUpdate[] = "prodPerPiecePrice = '" . mysqli_real_escape_string($conn, $prod_Price_Per_piece) . "'";
    }
    if (!empty($prod_Type)) {
        $fieldsToUpdate[] = "prodType = '" . mysqli_real_escape_string($conn, $prod_Type) . "'";
    }
    if (!empty($prod_Category)) {
        $fieldsToUpdate[] = "prodCategory = '" . mysqli_real_escape_string($conn, $prod_Category) . "'";
    }
    if (!empty($prod_Company)) {
        $fieldsToUpdate[] = "prodCompany = '" . mysqli_real_escape_string($conn, $prod_Company) . "'";
    }
    if (!empty($prod_Region)) {
        $fieldsToUpdate[] = "prodRegion = '" . mysqli_real_escape_string($conn, $prod_Region) . "'";
    }

    if (empty($fieldsToUpdate)) {
        throw new Exception("No fields to update");
    }

    $sql = "UPDATE products SET " . implode(", ", $fieldsToUpdate) . " WHERE prodId = '" . mysqli_real_escape_string($conn, $prod_id) . "'";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        echo json_encode(["success" => true, "message" => "Updated successfully"]);
    } else {
        throw new Exception("Update failed: " . mysqli_error($conn));
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
} finally {
    $conn->close();
}

?>
