<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Content-Type: application/json");
    include('dbConnect.php');
    try{
        if($_SERVER['REQUEST_METHOD']!== 'POST'){

            throw new Exception("Invalid Request Method");

        }
        
        $inputData = json_decode(file_get_contents("php://input"), true);
        $retailerId = $inputData['userId'] ?? null;
        $productid = $inputData['productid'] ?? null;
        $qtncount = $inputData['qtncount'] ?? null;
        $totalPrice = $inputData['totalPrice'] ?? null;
        if(empty($productid)){
            throw new Exception("No product id!");
        }
        if(empty($qtncount)){
             throw new Exception("No qtn count");
        }
        $sqlDistributorId = "SELECT distributorSL FROM products WHERE prodId = $productid";
        $sqlDistributorIdQuery = mysqli_query($conn, $sqlDistributorId);
        $distributorData = mysqli_fetch_assoc($sqlDistributorIdQuery);
        $distributorId = $distributorData['distributorSL'];
        $sqlCartAdd = "INSERT  INTO orders (prodId, quantity, totalPrice, retailerSL,distributorSL) VALUES ('$productid', '$qtncount','$totalPrice', '$retailerId','$distributorId')";
        $sqlCartAddQuery = mysqli_query($conn, $sqlCartAdd);
        if($sqlCartAddQuery){
            echo json_encode(["success" => true, "message" => "Data saved successfully."]);
        } else{
            throw new Exception("Failed to save data.");         
        }
    }
    catch(Exception $e){
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
    finally{
        $conn->close();
    }

?>