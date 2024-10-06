<?php
        require './connect.php';
        require './cros_policy.php';

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $id = file_get_contents('php://input');

            if($id){
               $deleteBlog = $conn -> prepare("DELETE from blog WHERE blog_id = ?");
               $deleteBlog -> bind_param('i' , $id);
               if($deleteBlog -> execute()){
                echo json_encode(["message" => "Blog delete" , "success" => true]);
               }
               else{
                echo json_encode(["message" => "blog not delete" , "success" => false]);
               }
            }
            else{
                echo json_encode(["message" => "something wrong , try again" , "success" => false]);
            }
        }


?>