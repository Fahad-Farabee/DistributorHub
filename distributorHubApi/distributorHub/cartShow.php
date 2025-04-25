<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Content-Type: application/json");

    include('dbConnect.php');

    try{

    /* $cartid = $_GET['cartid'] ?? null; */
    $userId = $_GET['retailerId'] ?? null;

        if(empty($userId)){

            throw new Exception("Field is empty");

        }

        /* $sql = "SELECT * FROM products INNER JOIN mycart ON products.prodId = mycart.prodId Where cartId = '$cartid'"; */
        $sql = "SELECT * FROM mycart
                INNER JOIN products ON mycart.prodId = products.prodId
                WHERE retailerSL = $userId";

        $query = mysqli_query($conn, $sql);

        $result = [];

        while($row = mysqli_fetch_assoc($query)){

            $result[] = $row;

        }

        if(!empty($result)){

            echo json_encode(["success" => true, "data" => $result]);

        }

        
        else{

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
