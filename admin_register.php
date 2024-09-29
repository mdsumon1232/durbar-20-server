<?php
    require './connect.php';
    require './cros_policy.php';
   
   

    // Handle actual POST request
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the input JSON data
        

        
            // Extract data from the request
            $full_name = $_POST['full_name'];
            $email = $_POST['email'];
            $mobile = $_POST['mobile'];
            $password = $_POST['password'];
            $fileName = $_FILES["profile"]["name"];
            $fileTmpName = $_FILES['profile']['tmp_name'];
            

            $file_directory = 'upload/'.$fileName;
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

                    if(move_uploaded_file($fileTmpName , $file_directory)){

                  $admin_register = $conn->prepare("INSERT INTO admin (full_name, admin_email, admin_mobile, password, status ,profile) VALUES (?,?,?,?,?,?)");
                $status = 0; // Pending status
                $admin_register->bind_param('ssssis', $full_name, $email, $mobile, $encrypt_password, $status,$file_directory);

                if ($admin_register->execute()) {
                    echo json_encode(["message" => "Pending, waiting for approval", "success" => true]);
                } else {
                    echo json_encode(["message" => "Something went wrong! Please try again", "success" => false]);
                }

                    }else{
                        echo json_encode(["message" => "photo not upload" , "success" => false]);
                    }
                }

             
                
            } else {
                // Donor not found, return error
                echo json_encode(["message" => "Please register as a donor first", "success" => false]);
            }
        
    }
?>
