<?php
header("Content-type: application/json");
require("connection.php");
$method = $_SERVER["REQUEST_METHOD"];


switch ($method){ 
    case "POST":
        $name = $_POST["name"] ?? '';
        $price = $_POST["price"] ?? '';
        $description = $_POST["description"] ?? '';

        if (!empty($name) && is_numeric($price) && !empty($description)) {
            $sql = "INSERT INTO `products`(`name`, `price`, `description`) VALUES (?, ?, ?)";
            $stmt = $connection->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("sds", $name, $price, $description); 
                if ($stmt->execute()) {
                    http_response_code(200);
                    echo json_encode(["status" => "success", "message" => "Posted"]);
                } else {
                    http_response_code(500);
                    echo json_encode(["status" => "error", "message" => "Database error"]);
                }
                $stmt->close();
            } else {
                http_response_code(500);
                echo json_encode(["status" => "error", "message" => "Failed to prepare statement"]);
            }
        } else {
            http_response_code(404);
            echo json_encode(["status" => "error", "message" => "Invalid"]);
        }
    case "GET":
        echo json_encode($connection->query("SELECT * FROM products")->fetch_all(MYSQLI_ASSOC));
        break;
    case "PUT":
        $id = $_GET["id"] ?? ''; 
        $data = json_decode(file_get_contents("php://input"), true);

        $name = $data["name"] ?? '';
        $price = $data["price"] ?? '';
        $description = $data["description"] ?? '';

        
        if (!empty($id) && is_numeric($id) && !empty($name) && is_numeric($price) && !empty($description)) {
            $sql = "UPDATE `products` SET `name` = ?, `price` = ?, `description` = ? WHERE `id` = ?";
            $stmt = $connection->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("sdsi", $name, $price, $description, $id); // s = string, d = double, s = string, i = integer
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    echo json_encode(["status" => "success", "message" => "Updated"]);
                } else {
                    http_response_code(404);
                    echo json_encode(["status" => "error", "message" => "This id does not exist or no changes made"]);
                }
                $stmt->close();
            } else {
                http_response_code(500);
                echo json_encode(["status" => "error", "message" => "Database error"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Invalid input"]);
        }
        break;
    case "DELETE": 
        if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
            $id = $_GET["id"];
    
            $sql = "DELETE FROM `products` WHERE `id` = ?";
            $stmt = $connection->prepare($sql);
    
            if ($stmt) {
                $stmt->bind_param("i", $id); // "i" = integer
                $stmt->execute();
    
                if ($stmt->affected_rows > 0) {
                    echo json_encode(["status" => "success", "message" => "DELETED"]);
                } else {
                    http_response_code(404);
                    echo json_encode(["status" => "error", "message" => "This id does not exist"]);
                }
                $stmt->close();
            } else {
                http_response_code(500);
                echo json_encode(["status" => "error", "message" => "Database error"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Invalid or missing id"]);
        }
        break;
    default:
        http_response_code(400); 
        echo json_encode(["message" => "undefined request method"]);
}


?>