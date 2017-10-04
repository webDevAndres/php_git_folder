<?php
include 'Email.php';

//define variables and set to empty values
$inNameErr = $inEmailErr = $inContactOptionErr = $inComplimentaryUpgrade = $inRequestValet = $inMessageErr = "";
$inName = $inEmail = $inContactOption = $inComplimentaryUpgrade = $inRequestValet = $inMessage = "";



//set form to false
$validForm = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty($_POST["name"])) {
    $inNameErr = "Name is required";
    $validForm = false;
  }
  else {
    $inName = test_input($_POST["name"]);
    //check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$inName)) {
      $inNameErr = "Only lettes and white space allowed";
    }
  }

  if (empty($_POST["email"])) {
    $inEmailErr = "Email is required";
    $validForm = false;
  }
  else {
    $inEmail = test_input($_POST["email"]);
    //check to see if e-mail address is well formed
    if (!filter_var($inEmail, FILTER_VALIDATE_EMAIL)) {
      $inEmailErr = "Invalid email format";
     
    }
  }

  if ($_POST["contactOption"] == "Please Select an Option"){
    $inContactOptionErr = "Please choose one option from the drop down";
    $validForm = false;

  }
  else {
    $inContactOption = $_POST["contactOption"];
    
  }

  if (empty($_POST["message"])) {
    $inMessageErr = "Must be filled";
    $validForm = false;
  }
  else {
    $inMessage = test_input($_POST["message"]);
  }

  if (isset($_POST["complimentaryUpgrade"])) {
    $inComplimentaryUpgrade = $_POST["complimentaryUpgrade"];
}

if (isset($_POST["requestValet"])) {
  $inRequestValet = $_POST["requestValet"];
}


}
 
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  $validForm = true;

if ($validForm) {

//put in an if statement after form has been validated
$contactEmail = new Email(""); //instantiate
$contactEmail->setRecipient($inEmail);                            //person filling out the form
$contactEmail->setSender("contact@andresmonline.com");           //the email that is sending the form
$contactEmail->setSubject("We have received your message.");
  $contactEmail->setMessage("Thank you for your form submission one of our representatives will get back to you. Below is a copy of your message.\nName: " . $inName . "\nEmail: " . $inEmail . "\nReason for contact: " . $inContactOption . "\nComplimentary upgrade: " . $inComplimentaryUpgrade . "\nRequest valet: " . $inRequestValet . "\nMessage: " . $inMessage);
$emailStatus = $contactEmail->sendCustomerMail();                     //create and send email to customer



$clientEmail = new Email(""); //instantiate
$clientEmail->setRecipient("amacias@dmacc.edu");                            //person filling out the form
$clientEmail->setSender($inEmail);           //the email that is sending the form
$clientEmail->setSubject("New form Submission");
$clientEmail->setMessage("Customer inquiry.\nName: " . $inName . "\nEmail: " . $inEmail . "\nReason for contact: " . $inContactOption . "\nComplimentary upgrade: " . $inComplimentaryUpgrade . "\nRequest valet: " . $inRequestValet . "\nMessage: " . $inMessage);
$clientEmail->sendClientMail();                     //create and send email to client

}
else {
 $validForm = false;
}



?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Intro PHP Form Processing</title>

  <!-- Custom Css -->
  <link rel="stylesheet" href="../css/responsive-grid.css">
  <link rel="stylesheet" href="../css/styles.css">

  <!-- JavaScript -->

  <script src="../js/buttons.js"></script>
</head>

<body>

    <div class="container">
  <div class="row">
    <div class="topNav" id="myTopNav">
      <a href="#">Home</a>
      <a href="#">Rooms</a>
      <a href="#">Features</a>
      <a href="#">Dining</a>
      <a href="#">Events</a>
      <a href="#">Contact Us</a>
      <a href="javascript:void(0);" class="icon" onclick="openClose()">&#9776;</a>
    </div>
  </div>
<div class="row socialBanner">

</div>
  <header class="wdv341">
    <div class="row">
      <div class="col-12">
          <h4>WDV341 Intro PHP</h4>
          <h5>Programming Project - Contact Form</h5>
      </div>
    </div>
  </header>

  <header class="hotelName">
      <div class="row">
        <div class="col-12">
            <h1>Andres' Fictional Hotel and Suites</h1>
        </div>
      </div>
    </header>
  
     
<div class="row">
  <div class="col-m-5 col-4">
  <h3>
    
<?php  if ($emailStatus) {
        echo "<h3 class='successMessage'>Thank you for your submission</h3>";
    }
    else {
        echo "<h3 class='messageFailed'>Sorry Error try again later</h3>";
    }
    
 ?>
 </h3>
  
 
      
  </div> <!-- end form column-->

  <div class=" col-m-7 col-8">
    <aside class="missionStatement">
      <h2>Our Mission Statement</h2>
      <h3 class="principlesFormat">Our guiding principles</h3>
      <h5>Delighting our guests</h5>
      <p>We are committed to exceeding guest expectations by surprising them with our ability to anticipate and fulfill their wishes.</p>
      <h5 class="principlesFormat">Delighting our colleagues</h5>
      <p>We value each colleague and provide a caring, motivating and rewarding environment for all. We bring out the best in our people through effective training and personal development, enabling a fulfilling career with the Group.</p>
      <h5 class="principlesFormat">Becoming the best</h5>
      <p>We intend to be an innovative leader in the luxury hospitality industry. We will continually improve our service delivery, as well as the quality of our products and facilities, ensuring we appeal to a multi-generational audience.</p>
      <h5 class="principlesFormat">Working together</h5>
      <p>We emphasize the importance of teamwork and treat each other with mutual respect and trust. By working together cooperatively, we all contribute to the Group’s success.</p>
      <h5 class="principlesFormat">Acting with responsibility</h5>
      <p>We maintain integrity, fairness and honesty in all our internal and external relationships. We support initiatives that improve the environment and are responsible members of our communities.</p>
    </aside>
  </div>
  

</div> <!--end form row-->
    
  </div> <!-- end container-->
 <footer>
   <div class="row">
     <div class="col-2">
        <h4>Andres' Hotel Inn and Suites</h4>
        <p>Check In: 3PM</p>
        <p>Check Out: 12PM</p>
        <p>Check-in Age: 18</p>
     </div>

     <div class="col-3">
       <h4>Located at:</h4>
        <address>
            6111 Flower Dive, Des Moines, Iowa
            50321
            United States
        </address>
    </div>
   </div>
  
  
 </footer>
  
</body>

</html>



</body>
</html>
