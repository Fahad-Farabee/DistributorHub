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

    $id = $input['id'] ?? null;
    $name = $input['name'] ?? null;
    $strname = $input['strname'] ?? null;
    $straddr = $input['straddr'] ?? null;
    $division = $input['division'] ?? null;
    $district = $input['district'] ?? null;
    $city = $input['city'] ?? null;

    if (!$id) {
        throw new Exception("Retailer ID is required");
    }

    // Build the update query dynamically based on provided fields
    $fieldsToUpdate = [];
    if (!empty($name)) {
        $fieldsToUpdate[] = "disUserName = '" . mysqli_real_escape_string($conn, $name) . "'";
    }
    if (!empty($strname)) {
        $fieldsToUpdate[] = "disStoreName = '" . mysqli_real_escape_string($conn, $strname) . "'";
    }
    if (!empty($straddr)) {
        $fieldsToUpdate[] = "disStoreAddress = '" . mysqli_real_escape_string($conn, $straddr) . "'";
    }
    if (!empty($division)) {
        $fieldsToUpdate[] = "disDivision = '" . mysqli_real_escape_string($conn, $division) . "'";
    }
    if (!empty($district)) {
        $fieldsToUpdate[] = "disDistrict = '" . mysqli_real_escape_string($conn, $district) . "'";
    }
    if (!empty($city)) {
        $fieldsToUpdate[] = "disCity = '" . mysqli_real_escape_string($conn, $city) . "'";
    }

    if (empty($fieldsToUpdate)) {
        throw new Exception("No fields to update");
    }

    $sql = "UPDATE distributors SET " . implode(", ", $fieldsToUpdate) . " WHERE distributorSL = '" . mysqli_real_escape_string($conn, $id) . "'";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        echo json_encode(["success" => true, "message" => "Updated"]);
    } else {
        throw new Exception("Update failed: " . mysqli_error($conn));
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
} finally {
    $conn->close();
}

?>
