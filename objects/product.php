<?php

class Product{

    // database connection and table name
    private $conn;
    private $table_name = "product";

    // object properties
    public $id;
    public $name;
    public $price;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
        //$this->read();
    }

    // read products
    function read(){

      try {
        //if ( ! empty( $json ) )
        //{

         $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $stmt = $this->conn->prepare("SELECT id, name, price FROM product");
         $stmt->execute();


         $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);


         echo json_encode( $stmt->fetchAll() );
       //}


      }
      catch(PDOException $e) {
         echo "Error: " . $e->getMessage();
      }
      $conn = null;


    }



    // create product
    function create( $json )
    {

        //if ( ! empty( $json ) )
        //{
          $values = '"'.$json->name .'","'. $json->price.'"';
        //}
        //print_r( $values );

        try{

          if ( ! empty( $values ) )
          {

            // sql to create table
            $sql = "INSERT INTO product ( name, price )
            VALUES ( $values )";

            // use exec() because no results are returned
            $this->conn->exec($sql);

          }

        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;

    }






    // delete the product
    function delete( $json ){


        try {

          if ( ! empty( $json ) )
          {
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // sql to delete a record
            $sql = "DELETE FROM $this->table_name WHERE id=$json->id ";

            // use exec() because no results are returned
            $this->conn->exec($sql);
            //echo "Record deleted successfully";
          }

        }

          catch(PDOException $e)

        {

          echo $sql . "<br>" . $e->getMessage();

        }


    }


    // search products
    function search( $keywords )
    {


      try
        {
          if ( ! empty( $keywords ) )
          {

            $this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->conn->prepare("SELECT * FROM product WHERE name LIKE ?");  //DELETE FROM MyGuests WHERE id=3
            $stmt->execute( (array)$keywords->name );

            if($stmt->execute()){
                echo json_encode( $stmt->fetchAll( PDO::FETCH_CLASS ) );
            }

            echo false;
          }

        } catch (Exception $ex) {
          die($ex->getMessage());
        }



    }





    // update the product
    function update( $json )
    {
      //print_r( $json );
      try {

            if (isset( $json->id )) {
              // set the PDO error mode to exception
              $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              //print_r( $json );

              if ( isset( $json->name ) )
              {
                $sql = "UPDATE $this->table_name SET name='$json->name' WHERE id=$json->id";
              } elseif ( isset( $json->price ) )
              {
                $sql = "UPDATE $this->table_name SET price='$json->price' WHERE id=$json->id";
              }

              // Prepare statement
              $stmt = $this->conn->prepare($sql);

              // execute the query
              $stmt->execute();
            }

          }
      catch(PDOException $e)
          {
          echo $sql . "<br>" . $e->getMessage();
          }

      $conn = null;

    }


}
