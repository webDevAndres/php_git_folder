<?php
session_start();
if($_SESSION['validUser'] =="yes") {
	
	
	include 'connectPDO.php';		//connects to the database
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
	$message = "";
	$validForm = false;

	//get event ID
	$event_id = filter_input(INPUT_POST, 'event_id',FILTER_VALIDATE_INT);
	
	//get the event that matches the event ID
			$queryEvent = 'SELECT * FROM wdv341_event WHERE event_id = :event_id';
			$stmt1 = $conn->prepare($queryEvent);
			$stmt1->bindValue(':event_id', $event_id);
			$stmt1->execute();
			$event = $stmt1->fetch();
			$event_name = $event['event_name'];
			$stmt1->closeCursor();
			
	function validateEventName($event_name) {
        global $validForm, $event_name_error;        //Use the GLOBAL Version of these variables instead of making them local
     
        if (empty($_POST["event_name"])) {
			$event_name_error = "event name is required";
			$validForm=false;
	  } else {
			$event_name_error = "";
			//check if name only contains letters and whitespace
		  if (!preg_match("/^[a-zA-Z0-9 ]*$/", $event_name)) {
			  $event_name_error = "Only letters and white space allowed";
			  $validForm = false;
			  // cannot be all spaces
		  } elseif (!preg_match("/^[^-\s][a-zA-Z0-9 \s-]*$/", $event_name)) {
			  $event_name_error = "Cannot be all spaces";
			  $validForm = false;
		  }
	  }
    }//end validateName()
    
    function validateDescription($event_description) {
        global $validForm, $event_description_error;

        if (empty($_POST["event_description"])) {
			$event_description_error = "event description is required";
			$validForm=false;
	  } else {
			$event_description_error = "";
			//check if name only contains letters and whitespace
		  if (!preg_match("/^[a-zA-Z0-9 ]*$/", $event_description)) {
			  $event_description_error = "Only letters and white space allowed";
			  $validForm = false;
			  // cannot be all spaces
		  } elseif (!preg_match("/^[^-\s][a-zA-Z0-9 \s-]*$/", $event_description)) {
			  $event_description_error = "Cannot be all spaces";
			  $validForm = false;
		  }
	  }
    } //end validateDescription()

    function validatePresenter($event_presenter) {
        global $validForm, $event_presenter_error;
        if (empty($_POST["event_presenter"])) {
			$event_presenter_error = "event presenter is required";
			$validForm=false;
	  } else {
			$event_presenter_error = "";
			//check if name only contains letters and whitespace
		  if (!preg_match("/^[a-zA-Z0-9 ]*$/", $event_presenter)) {
			  $event_presenter_error = "Only letters and white space allowed";
			  $validForm = false;
			  // cannot be all spaces
		  } elseif (!preg_match("/^[^-\s][a-zA-Z0-9 \s-]*$/", $event_presenter)) {
			  $event_presenter_error = "Cannot be all spaces";
			  $validForm = false;
		  }
	  }
    } //end validatePresenter()

    function validateDate($event_date) {
        global $validForm, $event_date_error;

        if (empty($_POST["event_date"])) {
			$event_date_error = "event date is required";
			$validForm=false;
	  } else {
			$event_date_error = "";
			
	  }
    } //end validateDate()

    function validateTime($event_time) {
        global $validForm, $event_time_error;

       
		if (empty($_POST["event_time"])) {
			$event_time_error = "event time is required";
			$validForm=false;
	  } else {
			$event_time_error = "";
			//check if name only contains letters and whitespace
	  }
    }//end validateTime()
	if(isset($_POST["submit"])) {
		$event_name = $_POST['event_name'];
		$event_description = $_POST['event_description'];
		$event_presenter = $_POST['event_presenter'];
		$event_date = $_POST['event_date'];
		$event_time = $_POST['event_time'];
		$event_id = $_POST['event_id'];	//from the hidden field of the update form


		$validForm = true;      //switch for keeping track of any form validation errors
		
					validateEventName($event_name);
					validateDescription($event_description);
					validatePresenter($event_presenter);
					validateDate($event_date);
					validateTime($event_time);
	}
if($validForm) {
	try {
		$updateEvent = "UPDATE wdv341_event SET event_name ='$event_name', event_description='$event_description', event_presenter='$event_presenter', event_date='$event_date', event_time='$event_time' WHERE event_id='$event_id'";
		
				$stmt = $conn->prepare($updateEvent);
				$stmt->execute();
				
						if ( $stmt->execute() )
						{
							$message = "<h1>Your record has been successfully UPDATED to the database.</h1>";
							$message .= "<p>Please <a href='selectEvents.php'>view</a> your records.</p>";
						}
						else
						{
							$message = "<h1>You have encountered a problem.</h1>";
							$message .= "<h2 style='color:red'>" . mysqli_error($link) . "</h2>";
						}
	}
	catch(PDOException $e) {
		$conn->rollback();
		$message = "There has been a problem. The system administrator has been contacted. Please try again later.";
	}
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Event</title>
<style>
.errormsg {
		color:red;
	}
</style>
	

</head>

<body>

<h1>WDV341 Intro PHP</h1>
<h1>Presenters Admin System Example</h1>
<h3>UPDATE Form for Changing information on a Presenter</h3>
<p>This page is called from the presentersSelectView.php page when you click on the Update link of a presenter. That page attaches the presenter_id to the URL of this page making it a GET parameter.</p>
<p>This page uses that information to SELECT the requested record from the database. Then PHP is used to pull the various column values for the record and place them in the form fields as their default values. </p>
<p>The user/customer can make changes as needed or leave the information as is. When the form is submitted and validated it will update the record in the database.</p>
<p>Notice that this form uses a hidden field. The value of this hidden field contains the presenter_id. It is passed as one of the form name-value pairs. The submitted page will use that value to determine which record to update on the database.</p>

<?php
//If the user submitted the form the changes have been made
if($validForm)
{
	echo $message;	//contains a Success or Failure output content

	
}//end if submitted

else
{	//The page needs to display the form and associated data to the user for changes
?>
<form id="event_Form" name="event_Form" method="post" action="updateEvent.php">
  <p>Update the following event Information.  Place the new information in the appropriate field(s)</p>
  <p>Event Name: 
    <input type="text" name="event_name" id="event_name" 
    	value="<?php echo $event['event_name']; ?>"/>	
		<span class="errormsg"><?php echo $event_name_error; ?> </span>
  </p>
  <p>Event Description:  
    <input type="text" name="event_description" id="event_description" 
    	value="<?php echo $event['event_description']; ?>" />
		<span class="errormsg"><?php echo $event_description_error; ?></span>
		
  </p>
  <p>Event Presenter:  
    <input type="text" name="event_presenter" id="event_presenter" 
       	value="<?php echo $event['event_presenter']; ?>" />
		   <span class="errormsg"><?php echo $event_presenter_error; ?></span>
  </p>
  <p>Event Date: 
    <input type="date" name="event_date" id="event_date" 
        value="<?php echo $event['event_date']; ?>" />
		<span class="errormsg"><?php echo $event_date_error; ?></span>
  </p>
  <p>Event Time: 
    <input type="time" name="event_time" id="event_time" 
    	value="<?php echo $event['event_time']; ?>" />
		<span class="errormsg"><?php echo $event_time_error; ?></span>
  </p>
  
  	<!--The hidden form contains the record if for this record. 
    	You can use this hidden field to pass the value of record id 
        to the update page.  It will go as one of the name value
        pairs from the form.
    -->
  	<input type="hidden" name="event_id" id="event_id"
    	value="<?php echo $event_id ?>" />
  
  <p>
    <input type="submit" name="submit" id="submit" value="Update" />
    <input type="reset" name="button2" id="button2" value="Clear Form" />
  </p>
</form>

<?php
}//end else submitted
?>

</body>
</html>

