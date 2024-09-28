<?php
    require './connect.php';

    // CORS headers
    header('Access-Control-Allow-Origin: http://localhost:5173'); // Allow requests from your React app
    header('Access-Control-Allow-Methods: POST'); // Allow POST method (assuming you're sending a POST request)
    header('Access-Control-Allow-Headers: Content-Type'); // Allow Content-Type header (common for sending JSON)
   
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
          http_response_code(200); 
        exit;
    }

    // Handle actual POST request
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the input JSON data
        $json_data = file_get_contents('php://input');
        $admin_data = json_decode($json_data, true);

        if ($admin_data) {
            // Extract data from the request
            $full_name = $admin_data['full_name'];
            $email = $admin_data['email'];
            $mobile = $admin_data['mobile'];
            $password = $admin_data['password'];
            $encrypt_password = password_hash($password , PASSWORD_DEFAULT);

            // Check if the donor exists in the donor list
            $DonarListCheck = $conn->prepare("SELECT * FROM donar_list WHERE full_name = ? AND phone_number = ? AND email = ?");
            $DonarListCheck->bind_param('sss', $full_name, $mobile, $email);
            $DonarListCheck->execute();
            $result = $DonarListCheck->get_result();

            if ($result->num_rows > 0) {


                // email already exit

                $email_exit = $conn -> prepare("SELECT * FROM admin WHERE admin_email = ?");
                $email_exit -> bind_param('s' , $email);

                $email_exit -> execute();

                $is_email_exit = $email_exit -> get_result();

                if($is_email_exit -> num_rows > 0){

                    echo json_encode(["message" => "email already used" , "success" => false] );

                } else{

                    $admin_register = $conn->prepare("INSERT INTO admin (full_name, admin_email, admin_mobile, password, status) VALUES (?,?,?,?,?)");
                $status = 0; // Pending status
                $admin_register->bind_param('ssssi', $full_name, $email, $mobile, $encrypt_password, $status);

                if ($admin_register->execute()) {
                    echo json_encode(["message" => "Pending, waiting for approval", "success" => true]);
                } else {
                    echo json_encode(["message" => "Something went wrong! Please try again", "success" => false]);
                }
                }

             
                
            } else {
                // Donor not found, return error
                echo json_encode(["message" => "Please register as a donor first", "success" => false]);
            }
        }
    }
?>
