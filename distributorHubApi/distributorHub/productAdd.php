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
        $prodName = $_POST['productName'];
        $prodType = $_POST['productType'];
        $prodCtg = $_POST['productCategory'];
        $prodMinQtn = $_POST['productMinQtn'];
        $prodPricePerPiece = $_POST['productPricePerPiece'];
        $prodRegion = $_POST['productRegion'];
        $prodComp = $_POST['productCompany'];
        $distid = $_POST['distributorSL'];
        $prodPic = null;
        if(empty($prodName)){
            throw new Exception("Enter Product Name!");
        }
        if(empty($prodType)){
            throw new Exception("Enter Product Type!");
        }
        if(empty($prodCtg)){
            throw new Exception("Enter Product Category!");
        }
        if(empty($prodMinQtn)){
            throw new Exception("Enter product Minimum Quantity!");
        }
        if(empty($prodPricePerPiece )){
            throw new Exception("Enter Per Piece Price!");
        }
        if(empty($prodRegion)){
            throw new  Exception("Enter Distributor Region!");
        }
        if(empty($prodComp)){
            throw new Exception("Enter Product Company Name!");
        }

        if (isset($_FILES['productPicture'])) {
            $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/productImages/"; 
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            $targetFile = $targetDir . basename($_FILES['productPicture']['name']);
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif','image/webp'];
            if (!in_array($_FILES['productPicture']['type'], $allowedTypes)) {
                throw new Exception("Only JPG, PNG, and GIF files are allowed.");
            }
            $maxFileSize = 2 * 1024 * 1024;
            if ($_FILES['productPicture']['size'] > $maxFileSize) {
                throw new Exception("File size should not exceed 2MB.");
            }
            if (!move_uploaded_file($_FILES['productPicture']['tmp_name'], $targetFile)) {
                throw new Exception("Failed to upload profile picture.");
            }
            $prodPic = "/productImages/" . basename($_FILES['productPicture']['name']);
        }  


        $sqlAddProduct = "INSERT INTO products (prodName, prodImage, prodType, prodCategory, prodMinQtn, prodPerPiecePrice, prodRegion, prodCompany,distributorSL)
        VALUES ('$prodName', '$prodPic', '$prodType', '$prodCtg', '$prodMinQtn', '$prodPricePerPiece', '$prodRegion', '$prodComp','$distid')";
        $sqlAddProductResult = mysqli_query($conn, $sqlAddProduct);
        if($sqlAddProductResult){
            echo json_encode(["success" => true, "message" => "Data saved successfully."]);
        } else{
            throw new Exception("Failed to save data.");
        }

    }
    
    catch(Exception $e) {

        echo json_encode(["success" => false, "message" => $e->getMessage()]);

    }
    
    finally {

        $conn->close();

    }

?>