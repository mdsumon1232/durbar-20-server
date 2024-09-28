<?php
        require './connect.php';
        require './cros_policy.php';

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $json_data = file_get_contents('php://input');
            $id = json_decode($json_data , true);

       

            // update status

            $delete_request = $conn -> prepare("DELETE FROM admin WHERE admin_id = ? LIMIT 1 ");
            $delete_request -> bind_param('i' , $id);

           if($delete_request -> execute()){
            echo json_encode(["message" => "admin request cancel" , "success" => true]);
           }
           else{
            echo json_encode(["message" => "something wrong ? try again" , "success" => false]);
           }
        }



?>