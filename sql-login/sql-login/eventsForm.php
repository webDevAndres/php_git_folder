<?php
session_start();
if($_SESSION['validUser'] =="yes") {
    $event_name = "";
    $event_description = "";
    $event_presenter = "";
    $event_date = "";
    $event_time = "";

    $event_name_error = "";
    $event_description_error = "";
    $event_presenter_error = "";
    $event_date_error = "";
    $event_time_error = "";
    $validForm = false;
    $message = "";
    function validateEventName($event_name) {
        global $validForm, $event_name_error;        //Use the GLOBAL Version of these variables instead of making them local
     
        if($event_name == "") {
            $validForm = false;
            $event_name_error = "Name is required";
        }
    }//end validateName()
    
    function validateDescription($event_description) {
        global $validForm, $event_description_error;

        if ($event_description == "") {
            $validForm = false;
            $event_description_error = "Description is required";
        } 
    }
    function validatePresenter($event_presenter) {
        global $validForm, $event_presenter_error;

      

        if($event_presenter == "") {
            $validForm = false;
            $event_presenter_error = "Presenter is required";
        }
    }

    function validateDate($event_date) {
        global $validForm, $event_date_error;

        $event_date_error = "";
        if ($event_date == "") {
             $validForm = false;
             $event_date_error = "Date is required";
         } 
    }

    function validateTime($event_time) {
        global $validForm, $event_time_error;

       
        if ($event_time == "") {
            $validForm = false;
            $event_time_error = "Time is required.";
        }
    }


    if (isset($_POST["submit"])) {

        $event_name = $_POST["event_name"];
        $event_description = $_POST["event_description"];
        $event_presenter = $_POST["event_presenter"];
        $event_date = $_POST["event_date"];
        $event_time = $_POST["event_time"];



            $validForm = true;      //switch for keeping track of any form validation errors

            validateEventName($event_name);
            validateDescription($event_description);
            validatePresenter($event_presenter);
            validateDate($event_date);
            validateTime($event_time);
 
    }

    if($validForm) {
        
                    try {
                        
                        require 'connectPDO.php';  //CONNECT to the database
                        
                        //begin the transaction
                        $conn->beginTransaction();

                        //SQL statements
                        $conn->exec("INSERT INTO wdv341_event (event_name, event_description, event_presenter, event_date, event_time) VALUES ('$event_name','$event_description','$event_presenter','$event_date','$event_time')");

                        //commit the transaction
                        $conn->commit();
                        $message = "New records created successfully <a href=login.php> RETURN TO LOGIN PAGE</a>";
                        
                      
                    }
                    
                    catch(PDOException $e)
                    {

                        $conn->rollback();
                        $message = "There has been a problem. The system administrator has been contacted. Please try again later.";
            
                        error_log($e->getMessage());            //Delivers a developer defined error message to the PHP log file at c:\xampp/php\logs\php_error_log
                        error_log(var_dump(debug_backtrace()));
                    
                        //Clean up any variables or connections that have been left hanging by this error.      
                    
                    }
                    $conn = null;
                    }

} //end valid user check
else {
    	//Invalid User attempting to access this page. Send person to Login Page
	header('Location: login.php');
}


  
?>

<!DOCTYPE html>
<html>
<head>
	<title>Event Form Add Event</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
   
   <style>
   body {
       background-color: black;
       color:white;
   }
   .addEvent {
       margin-top: 10%;
text-align: center;
border: 2px solid white;
   }

   </style>
   
</head>
<body>
<div class="container">

<section class="addEvent">
<div class="row">
<div class="col-sm-12">
<?php echo $message ?>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <fieldset>
  
        <legend>Add a new event</legend>
        <label>Event Name:</label> <br>
        <input type="text" name="event_name" maxlength="25"><span class="error" name="event_name_error"><?php echo $event_name_error; ?> </span><br>
        
        <label>Event Presenter:</label><br>
        <input type="text" name="event_presenter" maxlength="25"><span class="error" name="event_presenter_error"><?php echo $event_presenter_error; ?></span><br>
        
        <label>Event Date:</label> <br>
        <input type="text" name="event_date" id="datepicker"><span class="error" name="event_date_error"><?php echo $event_date_error; ?></span><br>
        
        <label>Event Time:</label> <br>
        <input type="timepicker" name="event_time"><span class="error" name="event_time_error"><?php echo $event_time_error; ?></span><br>
        
        <label>Event Description:</label><br>
        <textarea cols="50" rows="4" name="event_description" maxlength="500"></textarea><span class="error" name="event_description_error"><?php echo $event_description_error; ?></span><br>

        <input type="submit" name="submit" value="Submit">
        <input type="reset" name="reset" value="Reset">
    </fieldset>
       
	</form>

</div>

</div>


    </section>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>