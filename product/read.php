<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/product.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$product = new Product($db);


switch ( http_response_code(  ) ) {
    case 200:
        if ( $product->read() )
        {
          echo json_encode(array("message" => "Prduct List. OK !"));
          $product->read();
        }
        break;
    case 400:
        echo json_encode(array("message" => "No Items. Bad Request !"));
        break;
    case 404:
        echo json_encode(array("message" => "No Items. Not Found !"));
        break;
    case 503:
        echo json_encode(array("message" => "No Items. Service Unavailable !"));
        break;
    default:
        echo json_encode(array("message" => "Request Example -> /product/read.php"));
}
