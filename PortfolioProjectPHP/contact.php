<?php
  require 'connectPDO.php';
//set the timeZone
date_default_timezone_set("America/New_York");

// define variables and set to empty values
$nameError = "";
$emailError = "";
$messageError = "";



$name = "";
$email = "";
$message = "";

$honeyPot = "";

// set form flag to false
$validForm=false;

// validation functions

function validateName() {
  global $name,$validForm,$nameError;
  if (!preg_match("/^[^-\s][a-zA-Z \s-]*$/", $name)) {
    $nameError = "Special characters not allowed";
    $validForm = false;
}
else {
  $name = test_input($_POST['name']);
}
}

function validateEmail()
{
    global $email, $validForm, $emailError;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailError = "Invalid email";
      $validForm = false;
  } else {
        $email = test_input($_POST["email"]);
    }
}

function validateMessage() {
  global $message,$validForm,$messageError;
  if (!preg_match("/^[^-\s][a-zA-Z0-9.!? \s-]*$/", $message)) {
    $messageError = "Special characters not allowed";
    $validForm = false;
}
else {
  $name = test_input($_POST['message']);
}
}




function validateHoneyPot() {
  global $honeyPot,$validForm;
  if (!empty($_POST["honeyPot"])) {
      $honeyPot = test_input($_POST["honeyPot"]);
      $validForm= false;
  }
}

// Form validaiton
if(isset($_POST['submit'])) {
  $name = $_POST["name"]; 
  $email = $_POST["email"];
  $message = $_POST["message"];
  $honeyPot = $_POST["honeyPot"];


  // set form flag to true
  $validForm = true;

  validateName();
  validateEmail();
  validateMessage();

  validateHoneyPot();

}

if ($validForm) {
  //send email
    include 'php/Email.php';
    $contactEmail = new Email(""); //instantiate
    $contactEmail->setRecipient($email);                            //person receiving the email
    $contactEmail->setSender("contact@andresmonline.com");           //the email that is sending the form
    $contactEmail->setSubject("We have received your message.");
    $contactEmail->setMessage("Thank you for your form submission. Below is a copy of your message.\nName: " . $name . "\nEmail: " . $email . "\nmessage: " . $message);
    $emailStatus = $contactEmail->sendCustomerMail();                     //create and send email to customer

    $clientEmail = new Email(""); //instantiate
    $clientEmail->setRecipient("amacias@dmacc.edu");           //person receiving email
    $clientEmail->setSender($email);                        //the email that is sending the form
    $clientEmail->setSubject("New form Submission");
    $clientEmail->setMessage("Customer Appointment info.\nName: " . $name . "\nEmail: " . $email . "\nMessage: " . $message);
    $clientEmail->sendClientMail();                     //create and send email to client
}



function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb"
      crossorigin="anonymous">

    <link rel="stylesheet" href="css/style.css">
    <script src="formValidation.js"></script>
    <title>Eny Hair Salon</title>

  </head>

  <body>
    <div class="container">
    <section class="socialMedia">
      <div class="row">
          <div class="col">
          <a target="_blank" title="find us on Facebook" href="http://www.facebook.com/"><img alt="follow me on facebook" src="//login.create.net/images/icons/user/facebook_30x30.png" border=0></a>
          <a target="_blank" title="follow me on twitter" href="http://www.twitter.com/"><img alt="follow me on twitter" src="//login.create.net/images/icons/user/twitter-b_30x30.png" border=0></a> 
          <a target="_blank" title="follow me on instagram" href="http://www.instagram.com/"><img alt="follow me on instagram" src="https://c866088.ssl.cf3.rackcdn.com/assets/instagram30x30.png" border=0></a>
            </div>
      </div>
  </section>
      <section class="desktopNav">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="index.php">Eny Hair Salon</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="about.html">About us</a>
          </li>
          <li class="nav-item">
          <a class="nav-link" href="services.html">Haircare Services</a>
        </li>
          <li class="nav-item">
            <a class="nav-link" href="availableHours.php">Schedule an appointment</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contact.php">Contact Us</a>
          </li>
        </ul>
      </div>
    </nav>
      </section>
      
   
    <?php
if ($validForm){
?>
      <form id="contactInfo">
     <h1>Your email has been sent.</h1>
        <p>Name:
          <?php echo $name;?>
        </p>
        <p>Email:
          <?php echo $email;?>
        </p>
        <p>Message:
          <?php echo $message;?>
        </p>

      </form>

      <?php  
}
else {
 ?>
      <div class="formContainer">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="needs-validation" novalidate>

          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="name@example.com" required value="<?php echo $name;?>">
            <span class="error">
              <?php echo $nameError; ?>
            </span>
            <span class="invalid-feedback" id="nameError"></span>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required value="<?php echo $email;?>">
            <span class="error">
              <?php echo $emailError;?>
            </span>
            <span class="invalid-feedback" id="emailError"></span>
          </div>
          <div class="form-group">
            <label for="message">Message</label>
            <textarea class="form-control" name="message" id="message" placeholder="message here..." required value="<?php echo $message;?>"><?php echo $message;?></textarea>
            <span class="error">
              <?php echo $messageError;?>
            </span>
            <span class="invalid-feedback" id="messageError"></span>
          </div>
          
          <!-- do not fill -->
          <input type="hidden" name="honeyPot">
          <div class="form-group row">
            <div class="col">
              <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </div>
            <div class="col">
              <button type="reset" name="reset" class="btn btn-primary">reset</button>
            </div>
          </div>

        </form>
        </section>
      </div>
      </div>

      <?php 
}
?>
<div class="container">
    <section id="footer">
    <footer class="footer">
    <div class="container">
      <span>&copy;2017 Eny Salon </span>
    </div>
  </footer>
  </section>
  </div>
<section class="mobileNav">
<nav class="navbar fixed-bottom navbar-expand-lg navbar-light bg-light">
<a class="navbar-brand" href="index.php">Eny Hair Salon</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarNav">
  <ul class="navbar-nav">
    <li class="nav-item active">
      <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="about.html">About us</a>
    </li>
    <li class="nav-item">
    <a class="nav-link" href="services.html">Haircare Services</a>
  </li>
    <li class="nav-item">
      <a class="nav-link" href="availableHours.php">Schedule an appointment</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="contact.php">Contact Us</a>
    </li>
  </ul>
</div>
</nav>
</section>


      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
        crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ"
        crossorigin="anonymous"></script>
  </body>

  </html>