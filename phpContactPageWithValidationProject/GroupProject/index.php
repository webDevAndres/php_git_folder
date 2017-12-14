<?php
session_start();

$nameErrMsg = "";
$emailErrMsg = "";
$roboErrMsg = "";

$validForm = false;

$inName = "";
$inEmail = "";
$roboTest = $_POST['robotest'];

function validateName() {
	global $inName, $validForm, $nameErrMsg;
	$nameErrMsg = "";
	if($inName=="")
	{
		$validForm = false;
		$nameErrMsg = "Name is required";
	}
	elseif (!preg_match("/^[a-zA-Z]+(([\'\,\.\- ][a-zA-Z ])?[a-zA-Z]*)*$/",$inName)) {
		$validForm = false;
		$nameErrMsg = "That is an invalid name";
	}
	else {
		$inName = ltrim($inName);
	}
}

function validateEmail() {
	global $inEmail, $validForm, $emailErrMsg;
	$emailErrMsg = "";
	if($inEmail=="")
	{
		$validForm = false;
		$emailErrMsg = "E-mail is required";
	}
	elseif (!preg_match("/^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})$/",$inEmail)) {
		$validForm = false;
		$emailErrMsg = "That is an invalid E-mail";
	}
}

if( isset($_POST['submit']) ) {

  $inName = $_POST['inName'];
  $inEmail = $_POST['inEmail'];

  $validForm = true;

  validateName();
  validateEmail();

  if (!$roboTest == "") {
    $roboErrMsg = "You are a robot!";
    $validForm = false;
  }


}


?>




<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>

    <style media="screen">
      .error {
        color: red;
      }
    </style>

  </head>
  <body>

    <?php

    if ($validForm) {


    ?>

    	<h3>Thank You! Your Form Has Been Submitted!</h3>

    <?php
    }
    else {
    ?>

    <form class="form1" action="index.php" method="post">
      <p>
        <label for="inName">Your Name: </label>
        <input type="text" name="inName" value="<?php echo $inName; ?>" id="inName">
        <span class="error"><?php echo $nameErrMsg; //place error message on form  ?></span>
      </p>
      <p>
        <label for="inEmail">Your E-mail: </label>
        <input type="text" name="inEmail" value="<?php echo $inEmail; ?>" id="inEmail">
        <span class="error"><?php echo $emailErrMsg; //place error message on form  ?></span>
      </p>
      <!-- The following field is for robots only, invisible to humans: -->
      <p class="robotic" id="pot">
      <label>If you're human leave this blank:</label>
      <input name="robotest" type="text" id="robotest" class="robotest" />
      <span class="error"><?php echo $roboErrMsg; //place error message on form  ?></span>
      </p>
      <p>
        <input type="submit" name="submit" value="Submit">
        <input type="reset" name="" value="Reset" onclick="clearForm()">
      </p>
    </form>

  <?php } ?>


  </body>
</html>
