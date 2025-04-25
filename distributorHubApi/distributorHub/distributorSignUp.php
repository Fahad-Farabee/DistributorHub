<?php
//headers for json
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
//connecting to database.
include('dbConnect.php');

try{
    //Checking the request method.
    if($_SERVER['REQUEST_METHOD']!=='POST'){
        throw new Exception("Invalid Request Mehtod");
    }
    //handling the form data
    $name = $_POST['name'] ?? '';
    $contnum = $_POST['contnum'] ?? '';
    $nidnum = $_POST['nidnum'] ?? '';
    $strname = $_POST['strname'] ?? '';
    $straddr = $_POST['straddr'] ?? '';
    $tradelicnum = $_POST['tradelicnum'] ?? '';
    $division = $_POST['division'] ?? '';
    $district = $_POST['district'] ?? '';
    $city = $_POST['city'] ?? '';
    $pass = password_hash($_POST['pass'] ?? '', PASSWORD_BCRYPT);
    //handling the file upload
    $profilePicture = null;
    if (isset($_FILES['profilePicture'])) {
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/distributorImage/"; 
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $targetFile = $targetDir . basename($_FILES['profilePicture']['name']);
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['profilePicture']['type'], $allowedTypes)) {
            throw new Exception("Only JPG, PNG, and GIF files are allowed.");
        }
        $maxFileSize = 2 * 1024 * 1024;
        if ($_FILES['profilePicture']['size'] > $maxFileSize) {
            throw new Exception("File size should not exceed 2MB.");
        }
        if (!move_uploaded_file($_FILES['profilePicture']['tmp_name'], $targetFile)) {
            throw new Exception("Failed to upload profile picture.");
        }
        $profilePicture = "/distributorImage/" . basename($_FILES['profilePicture']['name']);
    }
    //validating the input fields
    if (empty($name) || empty($contnum) || empty($nidnum) || empty($strname) || empty($straddr) || empty($tradelicnum) || empty($division) || empty($district) || empty($city) || empty($pass)) {
        throw new Exception("All fields are required.");
    }
    //inserting into the database.
    //preparing the query.
    $stmt = $conn->prepare("INSERT INTO distributors (disUserName, disContactNumber, disNidNumber, disStoreName, disStoreAddress, disTradeLicenseNumber, disDivision, disDistrict, disCity,  disPassword, disProfilePic) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $name, $contnum, $nidnum, $strname, $straddr, $tradelicnum, $division, $district, $city, $pass, $profilePicture);
    //executing the query.
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Data saved successfully."]);
    } else {
        throw new Exception("Failed to save data.");
    }
}catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
} finally {
    $conn->close();
}
?>