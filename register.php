<?php
//this field is for PHP
include 'auth/connection.php'; // include 'auth/connection.php'

$m='';

$conn = connect();

$n='';



//closeConnect($conn);

if(isset($_POST['submit'])){

    $name= $_POST['name'];
    $uName= $_POST['uname'];
    $email= $_POST['email']?$_POST['email']:'';
    $pass= $_POST['pass'];
    $rPass= $_POST['r_pass'];
    if($pass===$rPass){

       // $sq="insert into users_info(name,u_name,email,password) values ('$name','$uName','$email','$pass')";
        $sq="insert into users_info(name,u_name,email,password) values ('$name','$uName','$email','$pass')";



        if($conn->query($sq) === true){

            header('location:login.php');

        }
        else{
            $m='connection not established';
        }

    }
    else
    {
        $m='Password is not matched';
    }

}





?>


<html>

    <head>

        <title>Registration form</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

        <link href="CSS/style.css" rel="stylesheet" type="text/css">
        <link href="CSS/register.css" rel="stylesheet" type="text/css">


    </head>

    <body>

    <form method="post" action="register.php" enctype="multipart/form-data">

        <div class="container">

            <span>
                <?php  if($m!='') echo $m;  ?>


            </span>





                <h1 style="text-align: center; color: black">Registration form</h1>
                <div>
                    <label for="name">Your name:<span>*</span></label>
                    <input type="text" id="name"  name="name" placeholder="Enter your name" required>

                </div>
                <div>
                    <label for="u_name">Username:<span>*</span></label>
                    <input type="text" id="uname"  name="uname" placeholder="enter User name" required>

                </div> <div>
                    <label for="email">Your Email:</label>
                    <input type="text" id="email"  name="email" placeholder="Enter your email" >

                </div> <div>
                    <label for="pass"> password:<span>*</span></label>
                    <input type="password" id="pass"  name="pass" placeholder="Enter password:" required>

                </div>
                <div>
                    <label for="rpass">Repeat password:<span>*</span></label>
                    <input type="password" id="rpass"  name="r_pass" placeholder="Confarm your password:" required>

                </div>
                <div>
                    <P style="text-align: center; color: black"><span>***</span>By creating an account you agree to our Terms & Privacy</P>
                </div>
                <div style="text-align: center;" >

                    <input type="submit"  value="Submit" class="btn btn-success" name="submit">
                </div>
                <div>

                    <P style="text-align: center; color: black">Already have an account <a href="login.php">Sign in</a></P>
                </div>

        </div>


    </form>





    </body>




</html>
