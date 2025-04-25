<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Content-Type: application/json");

    include('dbConnect.php');

    try {

        $retailerRegion = $_GET['region'] ?? null;

        if (empty($retailerRegion)) {

            throw new Exception("No User Region provided");
    
        }

        $sqlShowProduct = "SELECT * FROM products WHERE prodRegion = '$retailerRegion'";

        $sqlShowProductQuery = mysqli_query($conn, $sqlShowProduct);

        $result = [];

        while($row = mysqli_fetch_assoc($sqlShowProductQuery)){

            $result[] = $row;

        }

        if(!empty($result)){

            echo json_encode(["success" => true, "data" => $result]);

        } else{

            throw new Exception("No data Found");
        }


    
    }

    catch(Exception $e){

        echo json_encode(["success" => false, "message" => $e->getMessage()]);

    }

    finally{

        $conn->close();

    }

?>