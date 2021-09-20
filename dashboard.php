<?php
    session_start();
    include ('navigation.php');





    $conn= connect();

    $date = date('y-m-d', strtotime('-5 days'));

    $sql="select * from products where updated_at > '$date'";

    $prod = $conn->query($sql);



    $sql = "select count(*) as total_prod from products";

    $total_products= $conn->query($sql);

    $total_products=mysqli_fetch_assoc($total_products); // venge likhcii



     $sql = "select sum(bought) as total_bought from products";

     $total_bought=mysqli_fetch_assoc($conn->query($sql));

     $sql = "select sum(sold)  total_sold from products";

     $total_sold=mysqli_fetch_assoc($conn->query($sql));



     $available_stock = $total_bought['total_bought']-$total_sold['total_sold'];









?>

<html>

        <head>
            <title>Dashboard</title>
            <link rel="stylesheet" type="text/css" href="CSS/dashboard.css">
        </head>

        <body>
                <div class="row" style="padding-top: 40px;">
                    <div class="leftcolumn">

                        <div class="row">

                            <section style="padding-left: 20px; padding-right: 20px;">
                                <div class="col-sm-3">
                                    <div class="card card-green">
                                        <h3>Total Products </h3>
                                        <h2 style="color: #282828; text-align: center;"><?php echo$total_products['total_prod'] ?></h2>
                                    </div>

                                </div>
                                <div class="col-sm-3">
                                    <div class="card card-yellow" >
                                        <h3>Products Bought </h3>
                                        <h2 style="color: #282828; text-align: center;"><?php echo $total_bought['total_bought'] ?></h2>
                                    </div>
                                </div>
                                <div class="col-sm-3 " >
                                    <div class="card card-blue" >
                                        <h3>Products Sold </h3>
                                        <h2 style="color: #282828; text-align: center;"><?php echo $total_sold['total_sold'] ?></h2>
                                    </div>
                                </div>
                                <div class="col-sm-3" >
                                    <div class="card card-red" >
                                        <h3>Available Stock </h3>
                                        <h2 style="color: #282828; text-align: center;"><?php echo   $available_stock ?></h2>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <div class="card">
                            <div class="table_container">
                                <h1 style="text-align: center;">Products Table</h1>
                                <div class="table-responsive">
                                    <table class="table table-dark" id="table" data-toggle="table" data-search="true" data-filter-control="true" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                                        <thead class="thead-light">
                                        <tr>
                                            <th data-field="date" data-filter-control="select" data-sortable="true">Product Name</th>
                                            <th data-field="examen" data-filter-control="select" data-sortable="true"> Bought</th>
                                            <th data-field="note" data-sortable="true">Sold</th>
                                            <th data-field="note" data-sortable="true">Available in Stock</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                           <?php

                                                if(mysqli_num_rows($prod)>0){

                                                    while($res=mysqli_fetch_assoc($prod)){
                                                        $stock = $res['bought']-$res['sold'];

                                                        echo "<tr>";

                                                         echo "<td>".$res['name']."</td>>" ;

                                                        echo "<td>".$res['bought']."</td>>" ;

                                                        echo "<td>".$res['sold']."</td>>" ;

                                                        echo "<td>".  $stock."</td>>" ;

                                                        echo "</tr>";


                                                    }


                                                }

                                           ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="rightcolumn">
                        <div class="card  text-center" >
                            <h2>About User</h2>
                            <div style="height:100px;"><img src="<?php echo $thisUser['avatar']; ?>" height="100px;" width="100px;" class="img-circle" alt="Please Select your avatar"></div>
                            <p><h4><?php echo $thisUser['name'];  ?></h4> is working here since <h4><?php echo date('F j, Y', strtotime($thisUser['created_at'])); ?></h4></p>
                        </div>


                        <div class="card text-center">
                            <h2>Owners Info</h2>
                            <p>Some text..</p>
                        </div>
                    </div>
                </div>

                <?php include('footer.php')?>

        </body>
</html>

