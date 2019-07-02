<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/product.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare product object
$product = new Product($db);

// URL NAME   localhost/API/product/update.php?{"id":7,"name":"pizza"}
// URL PRICE   localhost/API/product/update.php?{"id":7,"price":459}
$base_url = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 'https' : 'http' ) . '://' .  $_SERVER['HTTP_HOST'];
$url = $base_url . $_SERVER["REQUEST_URI"];
$parse = parse_url(  $url, PHP_URL_QUERY );
$raw = rawurldecode( $parse );
$url_result = json_decode( $raw );
//print_r( $raw );

switch ( http_response_code(  ) ) {
    case 200:
        if ( isset( $url_result->name  ) xor isset( $url_result->price  ) and isset( $url_result->id  ) )
        {
          echo json_encode(array("message" => "Product was updated . OK !"));
          if (  ! empty( $product->update( $url_result  )  )  )
          {
            $product->update( $url_result );
          }

        }
        else
        {
          echo json_encode(array("message" => "Check JSON payload"));
        }

        break;
    case 400:
        echo json_encode(array("message" => "Unable to updated product. Bad Request."));
        break;
    case 404:
        echo json_encode(array("message" => "Unable to updated product. Not Found."));
        break;
    case 503:
        echo json_encode(array("message" => "Unable to updated product. Service Unavailable."));
        break;
    default:
        echo json_encode(array("message" => "Request Example -> /product/update.php?{'id':'1','name':'sucky'}"));
}
?>
