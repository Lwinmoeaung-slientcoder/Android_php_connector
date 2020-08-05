<?php
require_once "db_connection.php";

// array for JSON response
$response = array();

$qr_code=$_POST['code'];//Data fROM Android

$query="SELECT * FROM products";// get all products from products table
$result=mysqli_query($conn,$query);

if (mysqli_num_rows($result) > 0) {
    // looping through all results
    // products node
    $response["products"] = array();
    while ($row = mysqli_fetch_array($result)) {
        // temp user array
        $db_id=$row["id"];
        $db_name=$row["name"];
        $db_code=$row["code"];

        if ($db_code==$qr_code) {
          // code...
          $product = array();
          $product["id"] = $db_id;
          $product["name"] = $db_name;
          $product["code"] = $db_code;
          array_push($response["products"], $product);
        // push single product into final response array
        $response["success"] = 1;
        echo json_encode($response);
    }else {
      $response["success"] = 0;
      $response["message"] = "There is no code number in database";
      echo json_encode($response["message"]);
    }
  }
} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = "No products found";

    // echo no users JSON
    echo json_encode($response);
}
?>
