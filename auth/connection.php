

 <?php

    function connect(){

        $dbhost="localhost";
        $user="root";
        $password="";
        $dbname="inventory_project";

        $conn = new mysqli($dbhost,$user,$password,$dbname);

        return $conn;
    }

    function closeConnect($cn){

        $cn->close();

    }





 ?>