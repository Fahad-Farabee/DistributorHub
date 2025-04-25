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
    $region = $input['region'] ?? null;

    if (!$id) {
        throw new Exception("Retailer ID is required");
    }

    // Build the update query dynamically based on provided fields
    $fieldsToUpdate = [];
    if (!empty($name)) {
        $fieldsToUpdate[] = "userName = '" . mysqli_real_escape_string($conn, $name) . "'";
    }
    if (!empty($contnum)) {
        $fieldsToUpdate[] = "contactNumber = '" . mysqli_real_escape_string($conn, $contnum) . "'";
    }
    if (!empty($strname)) {
        $fieldsToUpdate[] = "storeName = '" . mysqli_real_escape_string($conn, $strname) . "'";
    }
    if (!empty($straddr)) {
        $fieldsToUpdate[] = "storeAddress = '" . mysqli_real_escape_string($conn, $straddr) . "'";
    }
    if (!empty($division)) {
        $fieldsToUpdate[] = "division = '" . mysqli_real_escape_string($conn, $division) . "'";
    }
    if (!empty($district)) {
        $fieldsToUpdate[] = "district = '" . mysqli_real_escape_string($conn, $district) . "'";
    }
    if (!empty($city)) {
        $fieldsToUpdate[] = "city = '" . mysqli_real_escape_string($conn, $city) . "'";
    }
    if (!empty($region)) {
        $fieldsToUpdate[] = "region = '" . mysqli_real_escape_string($conn, $region) . "'";
    }

    if (empty($fieldsToUpdate)) {
        throw new Exception("No fields to update");
    }

    $sql = "UPDATE retailers SET " . implode(", ", $fieldsToUpdate) . " WHERE retailerSL = '" . mysqli_real_escape_string($conn, $id) . "'";
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
