<?php
    require './connect.php';
    require './cros_policy.php';

    // load data from database

    $dataLoad  = $conn -> prepare ("SELECT blog.* , admin.full_name  FROM admin INNER JOIN blog WHERE admin.admin_id = blog.admin_id");

    $dataLoad -> execute();

    $result = $dataLoad -> get_result();

    if($result -> num_rows > 0){

        $blogs = [];
        while($blog = $result -> fetch_assoc()){
            $blogs[] = $blog;
        }

        echo json_encode(["data" => $blogs , "success" => true]);

    }else{
        echo json_encode(["message" => "no data found" , "success" => false] );
    }

?>