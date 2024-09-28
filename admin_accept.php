<?php
        require './connect.php';
        require './cros_policy.php';

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $json_data = file_get_contents('php://input');
            $id = json_decode($json_data , true);

            $status = 1;

            // update status

            $updateStatus = $conn -> prepare("UPDATE admin SET status = ? WHERE admin_id = ? LIMIT 1 ");
            $updateStatus -> bind_param('ii' , $status , $id);

           if($updateStatus -> execute()){
            echo json_encode(["message" => "admin accepted" , "success" => true]);
           }
           else{
            echo json_encode(["message" => "something wrong ? try again" , "success" => false]);
           }
        }



?>