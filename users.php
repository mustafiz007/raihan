<?php
session_start();



include ('navigation.php');

include ('auth/connection.php');
$m='';

$id = $_SESSION['userid'];

$conn= connect();



$sql="select * from users_info   ";

$res=   $conn->query($sql);


// for  test








$sql = "select count(*) as total_prod from products";

$total_products= $conn->query($sql);

$total_products=mysqli_fetch_assoc($total_products); // venge likhcii



$sql = "select sum(bought) as total_bought from products";

$total_bought=mysqli_fetch_assoc($conn->query($sql));

$sql = "select sum(sold)  total_sold from products";

$total_sold=mysqli_fetch_assoc($conn->query($sql));



$available_stock = $total_bought['total_bought']-$total_sold['total_sold'];



// for modals

// show old information

$sql= "select * from users_info where id=17";
$thisUser= mysqli_fetch_assoc($conn->query($sql));


if(isset($_POST['submit'])){  // modal update info

    $user_name = $_POST['uname'];

    $email = $_POST['email'];

    $ava = $_POST['uavtr'];

    $old_pass = $_POST['pass'];

    $new_pass = $_POST['npass'];

    $new_con_pass = $_POST['cpass'];

    $id = $_SESSION['userid'];

    $sql = "select * from users_info where u_name= '$abc'  ";  // where is the problem



     $res= $conn->query($sql);

     if(mysqli_num_rows($res)==1){

         header('location:login.php');

          if((strtoint($new_pass))== (strtoint($new_con_pass))){



          }

     }
     else{

        echo "the id is".$id;
     }



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

             <!-- users page - new item -->

            <div class="text-center">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addProduct">
                    Update Your Info
                </button>
                <h1><?php echo $m;?></h1>
                <div class="modal fade" id="addProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">

                                <button style="background-color: #ffce00;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h2 class="modal-title" id="exampleModalScrollableTitle">  <?php echo $thisUser['name']; ?>  </h2>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="users.php" enctype="multipart/form-data">
                                    <div class="form-group pt-20">
                                        <div class="col-sm-4">
                                            <label for="uname" class="pr-10"> User Name</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input name="uname" type="text" class="login-input" placeholder="User Name" id="uname" value="<?php echo  $thisUser['name']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group pt-20">
                                        <div class="col-sm-4">
                                            <label for="email" class="pr-10"> Email </label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input name="email" type="text" class="login-input" placeholder="Email Address" value="<?php echo $thisUser['email']; ?>" id="buy" required>
                                        </div>
                                    </div>
                                    <div class="form-group pt-20">
                                        <div class="col-sm-4">
                                            <label for="uavtr" class="pr-10"> User Avatar</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="pl-20">
                                                <input class="login-input" name="uavtr" type="file" id="uavtr" alt="Upload Image">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group pt-20">
                                        <div class="col-sm-4">
                                            <label for="pass" class="pr-10"> Password</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input name="pass" class="login-input" type="password" id="pass" required>
                                        </div>
                                    </div>
                                    <div class="form-group pt-20">
                                        <div class="col-sm-4">
                                            <label for="npass" class="pr-10">New Password</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input name="npass" class="login-input" type="text" id="npass" >
                                        </div>
                                    </div>
                                    <div class="form-group pt-20">
                                        <div class="col-sm-4">
                                            <label for="cpass" class="pr-10">Confirm New Password</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input name="cpass" class="login-input" type="text" id="cpass" >
                                        </div>
                                    </div>
                                    <div class="form-group" style="text-align: center;">
                                        <button type="submit" value="submit" name="submit" class="btn btn-success">Change</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>










            <div class="table_container">
                <h1 style="text-align: center;">Users Table</h1>
                <div class="table-responsive">
                    <table class="table table-dark" id="table" data-toggle="table" data-search="true" data-filter-control="true" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                        <thead class="thead-light">
                        <tr>
                            <th data-field="date" data-filter-control="select" data-sortable="true">User</th>
                            <th data-field="examen" data-filter-control="select" data-sortable="true"> Email</th>

                            <th data-field="note" data-sortable="true">Is Active</th>

                            <th data-field="note" data-sortable="true">Last Login Time</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(mysqli_num_rows($res)>0) {
                            while ($row = mysqli_fetch_assoc($res)) {

                                if($row['is_active']==1){

                                    $active = "Active";

                                }
                                else{

                                    $active="Inactive";
                                }

                                echo " <tr>";

                                echo "<td>".$row['name']."</td>";
                                echo "<td>".$row['email']."</td>";
                                echo "<td>".$active."</td>";

                                echo "<td>".date("Y-m-d    h:i:sa",strtotime($row['last_login_time']))."</td>td>";






                              echo "  </tr>";






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

