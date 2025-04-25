<?php
// Enable CORS
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true");
include 'dbConnect.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['contnum']) || !isset($data['pass'])) {
    echo json_encode(["success" => false, "message" => "Contact number and password are required."]);
    exit();
}
$contnum = $data['contnum'];
$pass = $data['pass'];
try {
    //searching retailer
    $queryRetailer = "SELECT * FROM retailers WHERE contactNumber = ?";
    $stmt = $conn->prepare($queryRetailer);
    $stmt->bind_param("s", $contnum);
    $stmt->execute();
    $resultRetailer = $stmt->get_result();
    if ($resultRetailer->num_rows > 0) {
        $user = $resultRetailer->fetch_assoc();
        if (password_verify($pass, $user['password'])) {
            echo json_encode(["success" => true, "message" => "Login successful as retailer.", "user_type"=>"retailer", "user_id"=>$user['retailerSL'],"user_region"=>$user['region']]);
            exit();
        }
    }

    // searching distributor
    $queryDistributor = "SELECT * FROM distributors WHERE disContactNumber = ?";
    $stmt = $conn->prepare($queryDistributor);
    $stmt->bind_param("s", $contnum);
    $stmt->execute();
    $resultDistributor = $stmt->get_result();
    if ($resultDistributor->num_rows > 0) {
        $user = $resultDistributor->fetch_assoc();
        if (password_verify($pass, $user['disPassword'])) {
            echo json_encode(["success" => true, "message" => "Login successful as distributor.", "user_type"=>"distributor","user_id"=>$user['distributorSL']]);
            exit();
        }
    }
    
    //No match Found
    echo json_encode(["success" => false, "message" => "Invalid contact number or password."]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
} finally {
    $stmt->close();
    $conn->close();
}
?>
