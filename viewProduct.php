
<?php
        session_start();
        include ('navigation.php');


        $m='';

        $conn= connect();





        if(isset($_GET['id'])){

            $id = $_GET['id'];


            $sql="select * from products  where id ='$id' limit 1";

            $res = $conn->query($sql);

            $res= mysqli_fetch_assoc($res);


        }




        $sql = "select count(*) as total_prod from products";

        $total_products= $conn->query($sql);

        $total_products=mysqli_fetch_assoc($total_products); // venge likhcii



        $sql = "select sum(bought) as total_bought from products";

        $total_bought=mysqli_fetch_assoc($conn->query($sql));

        $sql = "select sum(sold)  total_sold from products";

        $total_sold=mysqli_fetch_assoc($conn->query($sql));



        $available_stock = $total_bought['total_bought']-$total_sold['total_sold'];




?>








<head>
    <title>View Product</title>
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
        <!-- for view Product - here started -->

        <div class="pt-20 pl-20">
            <div class="col-sm-12" style="background-color: #282828; ">
                <div class="text-center">
                    <h2 > Product Details</h2>
                </div>
                <div class="row pt-20" >
                    <div class="col-sm-5 p-20" >
                        <img src=" <?php  echo $res['image'];   ?>" class="pull-right" height="300" width="300" style="border-radius: 10px;">
                    </div>

                    <div class="col-sm-7" >
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="pull-right"><h2> Name:</h2></label>
                            </div>
                            <div class="col-sm-6">
                                <h2 style="color: whitesmoke;"><?php echo  ucwords($res['name']); ?></h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="pull-right"><h2> Buy Quantity:</h2></label>
                            </div>
                            <div class="col-sm-6">
                                <h2 style="color: whitesmoke;"><?php echo $res['bought'] ?></h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="pull-right"><h2> Sell Quantity:</h2></label>
                            </div>
                            <div class="col-sm-6">
                                <h2 style="color: whitesmoke;"><?php echo $res['sold'] ?></h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="pull-right"><h2> Created at:</h2></label>
                            </div>
                            <div class="col-sm-6">
                                <h2 style="color: whitesmoke;"><?php echo  date('F j,Y',strtotime( str_replace('-','/',$res['created_at']) ) )    ;          ?></h2>
                            </div>
                        </div>

                        <div class="row text-center">
                            <a href=" editProduct.php?id=<?php   echo $res['id'] ; ?>"><button class="btn btn-warning">Editttt</button></a>
                            <a href="deleteProduct.php?id=<?php echo $res['id']; ?>"><button class="btn btn-danger">Delete</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>




    </div>  <!-- view productd finished  -->






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