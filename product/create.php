<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate product object
include_once '../objects/product.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

// get posted data
// URL http://localhost/API/product/create.php?{"name":"sucky","price":250}
$base_url = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 'https' : 'http' ) . '://' .  $_SERVER['HTTP_HOST'];
$url = $base_url . $_SERVER["REQUEST_URI"];
$parse = parse_url( $url, PHP_URL_QUERY );
$raw = rawurldecode( $parse );
//$encode = json_encode( $raw );
$url_result = json_decode( $raw );
//print_r( $url_result );

switch ( http_response_code(  ) ) {
    case 200:
        if ( isset( $url_result->name  ) && isset( $url_result->price  ) )
        {
          echo json_encode(array("message" => "Product was created . OK !"));
          if (  ! empty( $product->create( $url_result  )  )  )
          {

            $product->create( $url_result );

          }

        }
        else
        {
          echo json_encode(array("message" => "Check your json input Example -> product/create.php?{name:John,price:250}"));
        }


        break;
    case 400:
        echo json_encode(array("message" => "Unable to create product. Bad Request."));
        break;
    case 404:
        echo json_encode(array("message" => "Unable to create product. Not Found."));
        break;
    case 503:
        echo json_encode(array("message" => "Unable to create product. Service Unavailable."));
        break;
    default:
        echo json_encode(array("message" => "Request Example -> /product/create.php?{name:John,price:250}"));
}
?>
