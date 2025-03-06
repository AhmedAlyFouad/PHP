<?php
try{
$connection = mysqli_connect("localhost", "root", "", "online_shopping_system");
} catch(Exception $e){
   echo "Database Error: " . $e->getMessage();
}

?>

