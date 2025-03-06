<?php
header("Content-type: application/json");
require("connection.php");
$method = $_SERVER["REQUEST_METHOD"];


switch ($method){ 
    case "POST": 
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        
        if ($name && $price && $description) { 
            $stmt = $connection->prepare("INSERT INTO `products`(`name`, `price`, `description`) VALUES (?, ?, ?)");
            $stmt->bind_param("sds", $name, $price, $description);
            $stmt->execute();
            http_response_code(200); 
            echo json_encode(["status" => "success", "message" => "Posted"]);
        } else {
            http_response_code(404); 
            echo json_encode(["status" => "error",  "message" => "Invalid"]);
        }
        
    case "GET":
        echo json_encode($connection->query("SELECT * FROM products")->fetch_all(MYSQLI_ASSOC));
        break;
    case "PUT":
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $data = json_decode(file_get_contents("php://input"), true);
        $name = filter_var($data["name"], FILTER_SANITIZE_STRING);
        $price = filter_var($data["price"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $description = filter_var($data["description"], FILTER_SANITIZE_STRING);
        
        if ($id && $name && $price && $description) {
            $stmt = $connection->prepare("UPDATE `products` SET `name` = ?, `price` = ?, `description` = ? WHERE `id` = ?");
            $stmt->bind_param("sdsi", $name, $price, $description, $id);
            $stmt->execute();
            
            if ($stmt->affected_rows > 0) {
                echo json_encode(["status" => "success", "message" => "Updated"]);
            } else {
                http_response_code(404);
                echo json_encode(["status" => "error", "message" => "This id does not exist"]);
            }
        } else {
            http_response_code(404);
            echo json_encode(["status" => "error", "message" => "Invalid input"]);
        }
        
    case "DELETE": 
        if(isset($_GET["id"])) {
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            
            if($id) {
                $stmt = $connection->prepare("DELETE FROM products WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
        
                if($stmt->affected_rows == 1) {
                    echo json_encode(["status" => "success", "message" => "DELETED"]);
                } else {
                    http_response_code(404); 
                    echo json_encode(["status" => "error", "message" => "This id does not exist"]);
                }
            } else {
                http_response_code(404); 
                echo json_encode(["status" => "error", "message" => "Invalid id"]);
            }
        } else {
            http_response_code(404); 
            echo json_encode(["status" => "error", "message" => "There's no id provided"]);
        }
        
    default:
        http_response_code(400); 
        echo json_encode(["message" => "undefined request method"]);
}


?>