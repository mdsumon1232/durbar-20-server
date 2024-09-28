<?php 
   session_start();
     
     require './connect.php';
     header('Access-Control-Allow-Origin: http://localhost:5173'); // Allow requests from your React app
    header('Access-Control-Allow-Methods: POST'); // Allow POST method (assuming you're sending a POST request)
    header('Access-Control-Allow-Headers: Content-Type');

     if($_SERVER["REQUEST_METHOD"] === "POST"){

        $json_data = file_get_contents('php://input');

        $loginData = json_decode($json_data , true);
        
         if($loginData){
            $email = $loginData['email'];
            $password = $loginData['password'];
            
            $adminLoginSystem = $conn -> prepare ("SELECT * FROM admin WHERE admin_email = ?");
            $adminLoginSystem -> bind_param('s' , $email);

            $adminLoginSystem -> execute();

            $result = $adminLoginSystem -> get_result();

            if($result -> num_rows > 0){
                    $row = $result -> fetch_array();
                    $password_check = $row['password'];
                    $status = $row['status'];
                    $user_id = $row['admin_id'];
                    if(password_verify($password , $password_check)){
                       if($status===1){
                           echo json_encode([ "user_id" => $user_id , "success" => true]);
                           $_SESSION["user"] = $user_id;
                       }
                       else{
                        echo json_encode(["message" => "your account is pending" , "success" => false]);
                       }
                    }else{
                        echo json_encode(["message" => "password not match" , "success" => false]);
                    }
            }else{
                echo json_encode(["message" => "email not found" , "success" => false]);
            } 
            

         }
     }


?>