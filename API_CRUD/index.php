<?php
header("Content-type: application/json");
require("connection.php");
$method = $_SERVER["REQUEST_METHOD"];


switch ($method){ 
    case "POST": 
        $name = $_POST["name"];
        $price = $_POST["price"];
        $description = $_POST["description"];
        if(!empty($name) && !empty($price) && !empty($description)){ // validation
            $sql = "INSERT INTO `products`(`name`, `price`, `description`) VALUES ('$name','$price','$description')";
            $connection->query($sql);
            http_response_code(200); 
            echo json_encode(["status"=>"success", "message" => "Posted"]);
        }else{
            http_response_code(404); 
            echo json_encode(["status"=>"error",  "message" => "Invalid"]);
        }
        break;
    case "GET":
        echo json_encode($connection->query("SELECT * FROM products")->fetch_all(MYSQLI_ASSOC));
        break;
    case "PUT":
        $id = $_GET["id"];
        $data = json_decode(file_get_contents("php://input"), true);
        $name = $data["name"];
        $price = $data["price"];
        $description = $data["description"];
        $sql = "UPDATE `products` SET `name`='$name',`price`='$price',`description`='$description' WHERE 'id' = '$id'";
        $connection->query($sql);
        if($connection->affected_rows > 0){
            echo json_encode(["status"=>"success", "message" => "Updated"]);
        }else{
            http_response_code(404); 
            echo json_encode(["status"=>"error", "message" => "This id does not exists"]);
        }
        break;
    case "DELETE": 
        if(isset($_GET["id"])){
            $id = $_GET["id"];
            $sql = "DELETE FROM products WHERE id = $id";
            $connection->query($sql);
            if($connection->affected_rows == 1){
                echo json_encode(["status"=>"success", "message" => "DELETED"]);
            }else{
                http_response_code(404); 
                echo json_encode(["status"=>"error", "message" => "This id does not exists"]);
            }
        }else{
            http_response_code(404); 
            echo json_encode(["status"=>"error", "message" => "There's no id provided"]);
            }
        break;
    default:
        http_response_code(400); 
        echo json_encode(["message" => "undefined request method"]);
}


?>