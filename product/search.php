<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/product.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$product = new Product($db);



//URL localhost/API/product/search.php?{"name":"John"}
// URL http://localhost/API/product/search.php?{"name":"John"}
$base_url = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 'https' : 'http' ) . '://' .  $_SERVER['HTTP_HOST'];
$url = $base_url . $_SERVER["REQUEST_URI"];
$parse = parse_url(  $url, PHP_URL_QUERY );
$raw = rawurldecode( $parse );
$url_result = json_decode( $raw );


switch ( http_response_code(  ) ) {
    case 200:
        if ( isset( $url_result->name  ) )
        {
          echo json_encode(array("message" => "OK"));
          if (  ! empty( $product->search( $url_result  )  )  )
          {
            $product->search( $url_result  );
          }

        }
        else
        {
          echo json_encode(array("message" => "Check JSON payload"));
        }
        break;
    case 400:
        echo json_encode(array("message" => "There is no item. Bad Request."));
        break;
    case 404:
        echo json_encode(array("message" => "There is no item. Not Found."));
        break;
    case 503:
        echo json_encode(array("message" => "There is no item. Service Unavailable."));
        break;
    default:
        echo json_encode(array("message" => "Request Example -> /product/search.php?{'name':'John'}"));
}







?>
