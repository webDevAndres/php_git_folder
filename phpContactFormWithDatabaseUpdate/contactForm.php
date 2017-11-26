<?php

date_default_timezone_set("America/New_York");
//define variables and set to empty values
 $inNameErr = "";
 $inEmailErr = "";
 $inContactOptionErr = "";
 $inMessageErr = "";

 
 $inName = "";
 $inEmail = "";
 $inContactOption = "";
 $inMessage = "";
 $inNewsletter = "No";
 $inMoreProducts = "No";
 $inContact_assigned_rep = "";
 $inContact_followup_date = "";
 $inContact_followup_result = "";
 $inRoboTest = "";
 $inDate = date("m/d/Y");
$inTime = date("h:ia");
$validForm =false;


//validation function

function validateName()
{
    global $inName, $validForm, $inNameErr;
    if (empty($_POST["contact_name"])) {
          $inNameErr = "Name is required";
          $validForm=false;
    } else {
          $inName = test_input($_POST["contact_name"]);
          //check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $inName)) {
            $inNameErr = "Only letters and white space allowed";
            $validForm = false;
            // cannot be all spaces
        } elseif (!preg_match("/^[^-\s][a-zA-Z \s-]*$/", $inName)) {
            $inNameErr = "Cannot be all spaces";
            $validForm = false;
        }
    }
}

function validateEmail()
{
    global $inEmail, $validForm, $inEmailErr;
    $inNameErr = "";
    if (empty($_POST["contact_email"])) {
        $inEmailErr = "Email is required";
        $validForm = false;
    } else {
        $inEmail = test_input($_POST["contact_email"]);
        //check to see if e-mail address is well formed
        if (!filter_var($inEmail, FILTER_VALIDATE_EMAIL)) {
            $inEmailErr = "Invalid email format";
            $validForm = false;
        }
    }
}

function validateContactOption()
{
    global $inContactOption, $validForm, $inContactOptionErr,$inMessageErr,$inMessage;
    $inContactOptionErr = "";
    if ($inContactOption == "") {
        $inContactOptionErr = "Please choose a reason";
        $validForm = false;
    } else {
        $inContactOption = test_input($_POST["contact_contactOption"]);
        if ($inContactOption == "Other") {
            if (empty($_POST["message"])) {
                $inMessageErr = "Please explain your reason for contacting us.";
                $validForm = false;
            }
        }
    }
}


function validateMessage()
{
    global $inMessage, $validForm, $inMessageErr;
    if (empty($_POST["contact_message"])) {
        //can be left empty
    } else {
          $inMessage = test_input($_POST["contact_message"]);
 
           // cannot be all spaces
        if (!preg_match("/^[^-\s][a-zA-Z 0-9\s-]*$/", $inMessage)) {
            $inMessageErr = "Cannot be all spaces";
            $validForm = false;
        }
        if (!preg_match("/^[a-zA-Z 0-9]*$/", $inMessage)) {
              $inMessageErr = "Only letters,numbers,and white space allowed";
              $validForm = false;
        }
    }
}
  

function roboTest()
{
    global $inRoboTest,$validForm;
    if (!empty($_POST["roboTest"])) {
        $roboTest = test_input($_POST["roboTest"]);
        $validForm= false;
    }
}



//form Validation
if (isset($_POST['submit'])) {
    $inName = $_POST["contact_name"];
    $inEmail = $_POST["contact_email"];
    $inContactOption = $_POST["contact_contactOption"];
    $inMessage = $_POST["contact_message"];
    $inNewsletter = isset($_POST["contact_newsletter"]);
    $inMoreProducts = isset($_POST["contact_more_products"]);
    $inContact_assigned_rep = $_POST["contact_assigned_rep"];
    $inContact_followup_date = $_POST["contact_followup_date"];
    $inContact_followup_result = $_POST["contact_followup_result"];
    $inRoboTest = $_POST["roboTest"];





    if (!isset($_POST["contact_newsletter"])) {
        $inNewsletter = "No";
    } else {
        $inNewsletter = "Yes";
    }

    if (!isset($_POST["contact_more_products"])) {
        $inMoreProducts = "No";
    } else {
        $inMoreProducts = "Yes";
    }
    
    $validForm = true; //form flag is set to true

    validateName();
    validateEmail();
    validateContactOption();
    validateMessage();
    roboTest();

    if ($validForm) {
        try {
            //connect to the database
            require 'connectPDO.php';
            $conn->beginTransaction();
            $conn->exec("INSERT INTO wdv_341_customer_contacts(contact_name,contact_email,contact_reason,contact_message,contact_newsletter,contact_more_products,contact_date,contact_time,contact_assigned_rep,contact_followup_date,contact_followup_result) VALUES ('$inName','$inEmail', '$inContactOption', '$inMessage','$inNewsletter', '$inMoreProducts','$inDate','$inTime','$inContact_assigned_rep','$inContact_followup_date','$inContact_followup_result')");
               $conn->commit();
        
            $message = "Success.";
        
        } catch (PDOException $e) {
            $message = "There has been a problem. The system administrator has been contacted. Please try again later.";
        
                    error_log($e->getMessage());            //Delivers a developer defined error message to the PHP log file at c:\xampp/php\logs\php_error_log
                    error_log(var_dump(debug_backtrace()));
                
                    //Clean up any variables or connections that have been left hanging by this error.
        }
                
                $conn = null;
    } else {
        echo "<script>alert('Failed to insert to database.')</script>";
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


if ($validForm) {
  //send email
    include 'php/Email.php';
    $contactEmail = new Email(""); //instantiate
    $contactEmail->setRecipient($inEmail);                            //person receiving the email
    $contactEmail->setSender("contact@andresmonline.com");           //the email that is sending the form
    $contactEmail->setSubject("We have received your message.");
    $contactEmail->setMessage("Thank you for your form submission one of our representatives will get back to you. Below is a copy of your message.\nName: " . $inName . "\nEmail: " . $inEmail . "\nReason for contact: " . $inContactOption . "\nComplimentary upgrade: " . $inNewsletter . "\nRequest valet: " . $inMoreProducts . "\nMessage: " . $inMessage ."\nSubmitted: " . $inDate);
    $emailStatus = $contactEmail->sendCustomerMail();                     //create and send email to customer

    $clientEmail = new Email(""); //instantiate
    $clientEmail->setRecipient("amacias@dmacc.edu");           //person receiving email
    $clientEmail->setSender($inEmail);                        //the email that is sending the form
    $clientEmail->setSubject("New form Submission");
    $clientEmail->setMessage("Customer inquiry.\nName: " . $inName . "\nEmail: " . $inEmail . "\nReason for contact: " . $inContactOption . "\nComplimentary upgrade: " . $inNewsletter . "\nRequest valet: " . $inMoreProducts . "\nMessage: " . $inMessage . "\nAssigned Rep: " . $inContact_assigned_rep . "\nFollow Up date: " . $inContact_followup_date . "\nFollow Up Result: " . $inContact_followup_result . "\nSubmitted: " . $inDate);
    $clientEmail->sendClientMail();                     //create and send email to client
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
  <link rel="stylesheet" href="css/responsive-grid.css">
  <link rel="stylesheet" href="css/styles.css">

  <!-- JavaScript -->

  <script src="js/buttons.js"></script>

  <style>
  .error {
    color: red;
    font-weight: bold;
    text-shadow: -1px 1px 1px black;
  }
    .hideRoboTest {
      display: none;
    }

  </style>
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
 
<?php
if ($validForm) {
?>
       <?php echo "<h3 class='successMessage'>$message</h3>";?>
        <h3 class='successMessage'>Thank you for your submission</h3>
        <form name="form1">
        <fieldset>
<p>Name: <?php echo $inName;?></p>
<p>Email: <?php echo $inEmail;?></p>
<p>Reason for contact: <?php echo $inContactOption;?></p>
<p>  <textarea name="message" id="message" cols="45" rows="5" <?php echo "disabled";?>><?php echo $inMessage;?></textarea></p>

<p>Request Complimentary room upgrade: <?php echo $inNewsletter;?></p>
<p>Request Valet: <?php echo $inMoreProducts;?></p>
<p>Submitted: <?php echo $inDate ." ". $inTime;?></p>
        </fieldset>
        </form>

<?php
} else {
?>
   <form name="form1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <fieldset>
          <p>
            <label for="name">Name:</label>
          <input type="text" name="contact_name" id="name" value="<?php echo $inName;?>">
          <span class="error"><?php echo "$inNameErr" ?></span>
          </p>

          <p>
            <label for="email">Email:</label>
            <input type="text" name="contact_email" id="email" value="<?php echo $inEmail;?>">
            <span class="error"><?php echo "$inEmailErr" ?></span>
           
          </p>


          <p>
      
            <label for="contact_contactOption">Reason for contacting:</label>
            <span class="error"><?php echo "$inContactOptionErr" ?></span>
          <select name="contact_contactOption" id="contactOption">
            <option value="" <?php if ($inContactOption=="") {
                echo "selected='selected'";
}?>>Please Select a Reason</option>

            <option value="Booking" <?php if ($inContactOption=="Booking") {
                echo "selected='selected'";
}?>>Booking</option>

            <option value="Events Problem" <?php if ($inContactOption=="Events Problem") {
                echo "selected='selected'";
}?>>Events Problem</option>

            <option value="Billing Question" <?php if ($inContactOption=="Billing Question") {
                echo "selected='selected'";
}?>>Billing Question</option>

            <option value="Request Service" <?php if ($inContactOption=="Request Service") {
                echo "selected='selected'";
}?>>Request service</option>

            <option value="Other" <?php if ($inContactOption=="Other") {
                echo "selected='selected'";
}?>>Other</option>
          </select>

</p>
          <p>
          <label for="contact_message" class="messageAlign">Message:</label>
          <span class="error"><?php echo "$inMessageErr" ?></span>
          <textarea name="contact_message" id="message" cols="45" rows="5"><?php echo $inMessage;?></textarea>
          </p>

          <p class="checkboxFormat">
             Sign up for newsletter
             
          <input type="checkbox" name="contact_newsletter" id="checkbox1" value="Yes"<?php if (isset($inNewsletter) && $inNewsletter =="Yes") {
                echo "checked = 'checked'";
}?>></p>

          <p class="checkboxFormat">
              Would you like to be reached for offers or our products?
              
          <input type="checkbox" name="contact_more_products" id="checkbox2" value="Yes" <?php if (isset($inMoreProducts) && $inMoreProducts =="Yes") {
                echo "checked = 'checked'";
} ?>></p>

    <input type="hidden" name="contact_date" value="TBD">
    <input type="hidden" name="contact_time" value="TBD">
    <input type="hidden" name="contact_assigned_rep" value="TBD">
    <input type="hidden" name="contact_followup_date" value="TBD">
    <input type="hidden" name="contact_followup_result" value="TBD">
            <!-- do not fill -->
          <input class="hideRoboTest" type="text" name="roboTest">

          <p>
            <input type="submit" name="submit" id="sendForm" value="Submit">
            <input type="reset" name="reset" id="resetForm" value="Reset">
          </p>
        </fieldset>
        </form>

  


<?php
}
?>
    
 
      
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
