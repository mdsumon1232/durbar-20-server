<?php

require './connect.php';

header('Access-Control-Allow-Origin: http://localhost:5173'); 
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');


if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    
    $json_data = file_get_contents('php://input'); 
    
    $donor_info = json_decode($json_data, true); 
 
    if ($donor_info) {
       
        $full_name = $donor_info['full_name'] ;
        $mobile = $donor_info['mobile'] ;
        $email = $donor_info['email'] ;
        $last_donate = $donor_info['last_donate'] ;
        $blood_group = $donor_info['blood_group'] ;
        $division = $donor_info['division'] ;
        $district = $donor_info['district'] ;
        $sub_district = $donor_info['sub_district'] ;
        $password = $donor_info['password'] ;

        $encrypt_password = password_hash($password ,  PASSWORD_DEFAULT );
       
   

          $donar_data_insert = $conn -> prepare("INSERT INTO donar_list (	full_name , phone_number ,email	,last_donate,blood_group,
                        division , distric	,sub_distric,password) VALUES(?,?,?,?,?,?,?,?,?)");

             $donar_data_insert -> bind_param("sssssssss" , $full_name, $mobile , $email , $last_donate , $blood_group, $division , $district,
                                       $sub_district , $encrypt_password  );
    
             $donar_data_insert -> execute();
            
      
    } 
    else {
        echo json_encode([
            "error" => "Failed to decode JSON data",
        ]);
    }
} 
else {
    
    echo json_encode([
        "error" => "Only POST requests are allowed"
    ]);
}
?>
