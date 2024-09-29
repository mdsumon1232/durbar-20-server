<?php
        
        require './connect.php';
        require './cros_policy.php';

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $admin_id = $_POST['id'];
            $file_name = $_FILES['cover']['name'];
            $file_tmp_name = $_FILES['cover']['tmp_name'];


          
           $fileDirectory = "./upload/" . $file_name;

           if(move_uploaded_file($file_tmp_name , $fileDirectory)){
            
            // upload data on database

            $blogData = $conn -> prepare("INSERT INTO blog (article,title,cover,admin_id) value (?,?,?,?)");

            $blogData -> bind_param('sssi' , $content , $title , $fileDirectory , $admin_id );

            if($blogData -> execute()){
              echo json_encode(["message" => "file upload done" , "success" => true]);
            }else{
              echo json_encode(["message" => "unknown error!" , "success0" => false]);
            }

           }
           else{
            echo json_encode(["message" => "photo not upload" , "success" => false]);
           }


          }

?>