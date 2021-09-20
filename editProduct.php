
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
else if(isset($_POST['id'])){

    $id=$_POST['id'];
    $pName=$_POST['pname'];
    $buy= intval ($_POST['buy']);
    $sell=intval (  $_POST['sell']);

    if($buy >= $sell){

        if(isset($_POST['Submit'])){
            $sql= "update  products set name='$pName',bought='$buy' , sold ='$sell'  where id='$id' ";

            if($conn->query($sql)===true){


                header('location:products.php');
            }
            else
            {
                $m="not query run";
                header ("location:editProduct.php?id=$id ");
            }

        }
        else{
            $m="wrong input  from  submit !!!!";
            header ("location:editProduct.php?id=$id ");
        }

    }
    else {
        $m="wrong input !!!!";
        header ("location:editProduct.php?id=$id ");

    }




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





<html>


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
        <!-- for Edit  Product - here started -->


        <div class="pt-20 pl-20">
            <div class="col-sm-12" style="background-color: #282828; ">
                <div class="text-center">
                    <h1 > Edit Product</h1>
                    <h2> <?php echo $m; ?> </h2>
                </div>
                <div class="row pt-20" >
                    <div class="col-sm-5 p-20" >
                        <img src="<?php echo  $res['image']; ?>" class="pull-right" height="300" width="300" style="border-radius: 10px;">
                    </div>

                    <div class="col-sm-7" >
                        <form method="POST" action="editProduct.php">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="pull-right"><h2> Name:</h2></label>
                                </div>
                                <div class="col-sm-6 form-input pt-10">
                                    <input type="text" class="login-input"  name="pname" value="<?php echo $res['name']; ?>" placeholder="Product Name">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="pull-right"><h2> Buy Quantity:</h2></label>
                                </div>
                                <div class="col-sm-6 form-input pt-10" >
                                    <input type="text" class="login-input" name="buy" value="<?php echo $res['bought']; ?>" placeholder="Buy Quantity">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="pull-right"><h2> Sell Quantity:</h2></label>
                                </div>
                                <div class="col-sm-6 form-input pt-10">
                                    <input type="text" class="login-input" name="sell" value="<?php echo $res['sold']; ?>" placeholder="Sell Quantity">
                                </div>
                            </div>
                            <input type="hidden" value="<?php echo $id; ?>" name="id">
                            <div class="row">
                                <div class="text-center">
                                    <input class="btn btn-success"  type="submit" name="Submit" value="Submit">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>











    </div>  <!-- edit  productd finished  -->






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