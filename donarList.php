 <?php

require './connect.php';

header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');


$donarList = $conn->prepare("SELECT donar_id , full_name, phone_number, email, blood_group,last_donate , division , distric 
                        ,sub_distric FROM donar_list");


$donarList->execute();

$result = $donarList->get_result();


if ($result->num_rows > 0) {

    $donors = [];

    // Fetch data row by row and store it in the array
    while ($row = $result->fetch_assoc()) {
        $donors[] = $row;
    }

 
    echo json_encode(["data" => $donors , "success" => true]);
} else {

    echo json_encode(["message" => "No data available" , "success"=>false]);
}




// Close the connection
$conn->close();



?>