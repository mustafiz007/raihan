<?php
        session_start();
        include ('navigation.php');


        $m='';

        $conn= connect();



        $sql="select * from products ";

        $prod = $conn->query($sql);




        $sql = "select count(*) as total_prod from products";

        $total_products= $conn->query($sql);

        $total_products=mysqli_fetch_assoc($total_products); // venge likhcii



        $sql = "select sum(bought) as total_bought from products";

        $total_bought=mysqli_fetch_assoc($conn->query($sql));

        $sql = "select sum(sold)  total_sold from products";

        $total_sold=mysqli_fetch_assoc($conn->query($sql));



        $available_stock = $total_bought['total_bought']-$total_sold['total_sold'];



        if(isset($_POST['submit'])){

            $pName = $_POST['pname'];

            $buy = $_POST['buy'];

            $img = $_FILES['pimage'];

            $iName = $img['name'];

            $temporary_name = $img['tmp_name'];

            $format = explode ('.',$iName);

            $actualName = strtolower($format[0]);

            $actualFormat = strtolower($format[1]);

            $allowedFormat = ['jpg','png','jpeg','gif'];



            if(in_array($actualFormat,$allowedFormat)){

                $location = 'Uploads/'.$actualName.'.'.$actualFormat;

                $sql ="insert into products(name,bought,image,created_at)values('$pName','$buy','$location',current_timestamp ())";

                if($conn->query($sql)===true){

                    move_uploaded_file($temporary_name,$location);
                    $m="upload successfully";
                    header('location:products.php');
                }
            }

           //  print_r($_FILES);
        }

?>

<html>

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="CSS/products.css">
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


            <div class="text-center">   <!-- modals   -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addProduct">
                    Add New Product
                </button>
                <h2><?php echo $m; ?></h2>
                <div class="modal fade" id="addProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">

                                <button style="background-color: #ffce00;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h2 class="modal-title" id="exampleModalScrollableTitle">Add New Product</h2>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="products.php" enctype="multipart/form-data">
                                    <div class="form-group pt-20">
                                        <div class="col-sm-4">
                                            <label for="name" class="pr-10"> Product Name</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input name="pname" type="text" class="login-input" placeholder="Product Name" id="name" required>
                                        </div>
                                    </div>
                                    <div class="form-group pt-20">
                                        <div class="col-sm-4">
                                            <label for="buy" class="pr-10"> Buying Amount</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input name="buy" type="text" class="login-input" placeholder="Buying Amount" id="buy" required>
                                        </div>
                                    </div>
                                    <div class="form-group pt-20">
                                        <div class="col-sm-4">
                                            <label for="pimage" class="pr-10"> Product Image</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input name="pimage" class="pl-20" type="file" id="pimage" required>
                                        </div>
                                    </div>
                                    <div class="form-group" style="text-align: center;">
                                        <button type="submit" value="submit" name="submit" class="btn btn-success">Add</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>






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
                            <th data-field="actions" data-sortable="true"> Actions</th>
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

                                echo "<td><a href='viewProduct.php?id=".$res['id']."' class='btn btn-success btn-sm'>".
                                    "<span class='glyphicon glyphicon-eye-open'></span> </a>";

                                echo "<a href='editProduct.php?id=".$res['id']."' class='btn btn-warning btn-sm'>".
                                    "<span class='glyphicon glyphicon-pencil'></span> </a>";

                                echo "<a href='deleteProduct.php?id=" . $res['id'] . "' class='btn btn-danger btn-sm'>" .
                                    "<span class='glyphicon glyphicon-trash'></span> </a></td>";

                                echo "</tr>";


                            }


                        }
                        else{

                            echo "no products found";
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

