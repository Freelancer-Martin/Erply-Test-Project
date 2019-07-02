<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object file
include_once '../config/database.php';
include_once '../objects/product.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare product object
$product = new Product($db);

// get product id
// URL localhost/API/product/delete.php?{"id":10}
$base_url = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 'https' : 'http' ) . '://' .  $_SERVER['HTTP_HOST'];
$url = $base_url . $_SERVER["REQUEST_URI"];
$parse = parse_url(  $url, PHP_URL_QUERY );
$raw = rawurldecode( $parse );
$url_result = json_decode( $raw );


switch ( http_response_code(  ) ) {
    case 200:
        if ( isset( $url_result->id  ) )
        {
          echo json_encode(array("message" => "Product deleted. OK !"));
          if (  ! empty( $product->delete( $url_result  )  )  )
          {

            $product->delete( $url_result );

          }

        }
        else
        {
          echo json_encode(array("message" => "Check JSON payload"));
        }
        break;
    case 400:
        echo json_encode(array("message" => "Unavailable delete product. Bad Request !"));
        break;
    case 404:
        echo json_encode(array("message" => "Unavailable delete product. Not Found !"));
        break;
    case 503:
        echo json_encode(array("message" => "Unavailable delete product. Service Unavailable !"));
        break;
    default:
        echo json_encode(array("message" => "Request Example -> /product/delete.php?{'id':'1'}"));

}


?>
