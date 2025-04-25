<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include('dbConnect.php');

try {

    $distId = $_GET['distributorId'] ?? null;
    /* $retailerId = intval($retailerId); */
    if(empty($distId)){

        throw new Exception("Field is empty");

    }

    $sql = "SELECT * FROM orders INNER JOIN products ON orders.prodId = products.prodId
    INNER JOIN distributors ON orders.distributorSL = distributors.distributorSL
    INNER JOIN retailers ON orders.retailerSL = retailers.retailerSL WHERE orders.distributorSL = '$distId'";

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

