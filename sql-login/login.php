<?php
//pevents chrome error when using the back button to return to this page
session_cache_limiter('none');
session_start();


$message = "";


//checks if user is valid

if ($_SESSION['validUser'] == "yes") {

    // if already signed in.
    $message = "Welcome back!";
  
} else {

    //checks if page was called fom a submitted form
    
    if (isset($_POST['submitLogin'])) {
        //pull username and password from form
        $inUsername = $_POST['loginUsername'];
        $inPassword = $_POST['loginPassword'];
//connect to database
        include 'connectPDO.php';

        $query = "SELECT event_user_name,event_user_password FROM event_user WHERE event_user_name = :event_user_name AND event_user_password = :event_user_password";

//prepare the query and bind parameters
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':event_user_name', $inUsername, PDO::PARAM_STR);
        $stmt->bindValue(':event_user_password', $inPassword, PDO::PARAM_STR);
        $stmt->execute();

    //If this is a valid user there should be ONE row only
        if ($stmt->rowCount() == 1) {
            global $username;
            //this is a valid user so set your SESSION variable
            $userName = $inUsername;
            $_SESSION['validUser'] = "yes";
            $message = "Welcome Back! $userName";
            //Valid User can do the following things:
        } else {
            //error in processing login.  Logon Not Found...
            
            $_SESSION['validUser'] = "no";
            $message = "Sorry, there was a problem with your username or password. Please try again.";
        }
        $conn = null;
    } //end if the form was submitted
}//end else valid user

?>








<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>wdv341 Events login</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
<style>
body {
    background-color: black;
    color:white;
}

.loginArea {
    margin-top: 5%;
text-align: center;
}

.loginForm {
    border: 1px solid white;
}


</style>


</head>
<body>
    <div class="container loginArea">

   
<section>
<div class="row">
    <div class="col-sm-12">
        <h1>wdv341 intro php</h1>
        <h2>Event admin system</h2>
        <h2><?php echo $message?></h2>
    </div>
</div>
</section>
<section class="loginForm">
<div class="row">
    <div class="col-sm-12">
            <?php
            if ($_SESSION['validUser'] == "yes") {
            ?>
            <h3>Event Administrator Options</h3>
                    <p><a href="eventsForm.php">Input new events</a></p>
                    <p><a href="selectEvents.php">List of events</a></p>
                    <p><a href="logout.php">Logout of Admin System</a></p>  
            <?php
            } else {
                ?>
                
                <h2>Please login to the Administrator System</h2>
                            <form method="post" name="loginForm" action="login.php" >
                              <p>Username: <input name="loginUsername" type="text" /></p>
                              <p>Password: <input name="loginPassword" type="password" /></p>
                              <p><input name="submitLogin" value="Login" type="submit" /> <input name="" type="reset" />&nbsp;</p>
                            </form>
            <?php
            }
            
            ?>
    </div>
</div>
</section>
</div>





<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>
