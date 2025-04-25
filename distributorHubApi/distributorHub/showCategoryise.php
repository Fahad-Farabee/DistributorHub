<?php

/*     header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Content-Type: application/json");

    include('dbConnect.php');

    try{

        $category = $_GET['category'] ?? null;

        if(empty($category)){

            throw new Exception("Field is empty");

        }

        $sql = "SELECT * FROM products WHERE prodCategory = '$category'";

        $query = mysqli_query($conn, $sql);

        $result = [];

        while($row = mysqli_fetch_assoc($query)){

            $result[] = $row;

        }

        if(!empty($result)){

            echo json_encode(["success" => true, "data" => $result]);

        } else{

            throw new Exception("No Product Found");
            
        }

    }

    catch(Exception $e){

        echo json_encode(["success" => false, "message" => $e->getMessage()]);

    }

    finally{

        $conn->close();

    } */


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include('dbConnect.php');

try {
    $category = $_GET['category'] ?? null;

    if (empty($category)) {
        throw new Exception("Category is required");
    }

    $stmt = $conn->prepare("SELECT * FROM products WHERE prodCategory = ?");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    if (!empty($products)) {
        echo json_encode(["success" => true, "data" => $products]);
    } else {
        echo json_encode(["success" => true, "data" => []]);
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
} finally {
    $conn->close();
}




?>