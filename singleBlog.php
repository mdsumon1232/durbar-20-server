<?php
        require './connect.php';
        require './cros_policy.php';

        $id = $_GET['id'];

        $loadSingleData = $conn -> prepare("SELECT blog.* , admin.full_name , admin.profile FROM admin INNER JOIN blog ON admin.admin_id = blog.admin_id WHERE blog_id = ?");

        $loadSingleData -> bind_param('i' , $id);

        $loadSingleData -> execute();

        $blogData = $loadSingleData -> get_result();

        if($blogData -> num_rows > 0){
            
            $singleBlog = [];
            while($content = $blogData -> fetch_assoc()){
                $singleBlog[] = $content;
            }
            
            echo json_encode(["data" => $singleBlog , "success" => true]);

        }
        else{
            echo json_encode(["message" => "data not found" , "success" => false]);
        }



?>