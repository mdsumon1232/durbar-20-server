<?php
    require './connect.php';


     // CORS headers
     header('Access-Control-Allow-Origin: http://localhost:5173');
     header('Access-Control-Allow-Methods: POST, GET , OPTIONS');
     header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
     header('Access-Control-Allow-Credentials: true');
     header('Content-Type: application/json');

     $status  = 0;

     $pending_admin =  $conn -> prepare("SELECT * FROM admin WHERE status = ?");
      
     $pending_admin -> bind_param('i' , $status);

     $pending_admin -> execute();
    
     $result  = $pending_admin -> get_result();

     if($result -> num_rows > 0){
        $pending_all_array = [];
        while ($row = $result->fetch_assoc()) {
            
            $pending_admin_array[] = $row;
        }
        echo json_encode(["data" => $pending_admin_array , "success" => true] );

     }
     else{
        echo json_encode(["message" => "no pending data" , "success" => false]);
     }


?>