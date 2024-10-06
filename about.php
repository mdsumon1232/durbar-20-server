<?php 
        require './connect.php';
        require './cros_policy.php';

        
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $heading  = $_POST['heading'];
            $content = $_POST['content'];
            $cover_name = $_FILES['coverBg']['name'];
            $cover_tmpName = $_FILES['coverBg']['tmp_name'];
            $cover_file = './upload/'.$cover_name;


            if(strlen($heading) > 100){
                echo json_encode(["message" => "heading less than 100 character " , "success" => false] );
            }
            else{
                 if(move_uploaded_file($cover_tmpName , $cover_file)){

                    $insert_data = $conn -> prepare("INSERT INTO about (about_heading,about_content,bg) value(?,?,?)");
                    $insert_data -> bind_param('sss' , $heading , $content , $cover_file);

                    if($insert_data -> execute()){
                        echo json_encode(["message" => "about upload successfully" , "success" => true]);
                    }
                    else{
                        echo json_encode(["message" => "something wrong ! try again" , "success" => false]);
                    }

                 }else{
                    echo json_encode(["message" => "photo not uploaded" , "success" => false]);
                 }
            }
        }


?>