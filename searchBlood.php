<?php
    
    require './connect.php';

    header('Access-Control-Allow-Origin: http://localhost:5173');
    header('Access-Control-Allow-Methods: POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
    
   
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200); 
        exit;
    }

    // Handle POST request
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = file_get_contents('php://input');
        $request_info = json_decode($data, true); 
      
        if ($request_info) {
            $group = $request_info['group'];
            $division = $request_info['division'];
            $district = $request_info['district'];
            $sub_district = $request_info['sub_district'];

        $searchData =  $conn -> prepare("SELECT donar_id,blood_group,full_name,phone_number,email,last_donate,division,distric,
                    sub_distric FROM  donar_list WHERE blood_group = ? AND division = ? AND  distric = ? AND sub_distric = ?");


        $searchData -> bind_param('ssss' , $group , $division , $district , $sub_district);

        $searchData -> execute();
        $result = $searchData -> get_result();

        if($result -> num_rows > 0){
                $searchDonarData = [];

                while ($row = $result->fetch_assoc()) {
                    $searchDonarData[] = $row;
                }

                echo json_encode (["data" => $searchDonarData , "success" => true ]);
        }
        else{
            echo json_encode(["message" => "data not found" , "success" => false]);
        }

        }
    }
?>
