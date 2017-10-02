<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WDV101 Form Emailer Example</title>

<!-- Custom Style sheet -->
<link rel="stylesheet" href="../css/responsive-grid.css">
<link rel="stylesheet" href="../css/styles.css">
</head>

<body>
<div class="row">
		<div class="topNav" id="myTopNav">
			<a href="#home">Home</a>
			<a href="#food">Food</a>
            <a href="#drinks">Drinks</a>
            <a href="#reservations">Reservations</a>
            <a href="#Catering">Catering</a>
			<a href="#contactUs">Contact Us</a>
			<a href="javascript:void(0);" class="icon" onclick="openClose()">&#9776;</a>
		</div>
    </div>
    
 <div class="container">
<div class="row">
    <div class="col-m-12 col-12">
      <header>
            <h1>Contact Us</h1>
      </header>
    </div>
</div>
<section class="contactForm">
    <div class="row">
        <div class="col-m-12 col-4">
            <p>For questions regarding catering services or you would like to tell us about your dining experience please use the contact form below. </p>
        </div>
    </div>
<div class="row">
    <div class="col-m-6 col-6">
	<?php
echo "<p class='colorRed'>This page was created by PHP on the server and sent back to your browser. </p>";

//It will create a table and display one set of name value pairs per row
	echo "<table border='1'>";
	echo "<tr><th>Field Name</th><th>Value of field</th></tr>";
	foreach($_POST as $key => $value)
	{
		echo '<tr class=colorRow>';
		echo '<td>',$key,'</td>';
		echo '<td>',$value,'</td>';
		echo "</tr>";
	} 
	echo "</table>";
	echo "<p>&nbsp;</p>";

//This code pulls the field name and value attributes from the Post file
//The Post file was created by the form page when it gathered all the name value pairs from the form.
//It is building a string of data that will become the body of the email

//          CHANGE THE FOLLOWING INFORMATION TO SEND EMAIL FOR YOU //  

	$toEmail = "amacias@dmacc.edu";		//CHANGE within the quotes. Place email address where you wish to send the form data. 
										//Use your DMACC email address for testing. 
										//Example: $toEmail = "jhgullion@dmacc.edu";		
	
	$subject = "ContactForm";	//CHANGE within the quotes. Place your own message.  For the assignment use "WDV101 Email Example" 

	$fromEmail = "contact@andresmonline.com";		//CHANGE within the quotes.  Use your DMACC email address for testing OR
										//use your domain email address if you have Heartland-Webhosting as your provider.
										//Example:  $fromEmail = "contact@jhgullion.org";  
// Receive and sanitize input
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['comment'];

// set up email
$msg = "Your submission has been recieved, we will get back to you soon.\nName: " . $name . "\nEmail: " . $email . "\ncomments: " . $comments;
$msg = wordwrap($msg,70);
mail($email,"Thank you for your form submission",$msg);

//   DO NOT CHANGE THE FOLLOWING LINES  //

	$emailBody = "Form Data\n\n ";			//stores the content of the email
	foreach($_POST as $key => $value)		//Reads through all the name-value pairs. 	$key: field name   $value: value from the form									
	{
		$emailBody.= $key."=".$value."\n";	//Adds the name value pairs to the body of the email, each one on their own line
	} 
	
	$headers = "From: $fromEmail" . "\r\n";				//Creates the From header with the appropriate address

 	if (mail($toEmail,$subject,$emailBody,$headers)) 	//puts pieces together and sends the email to your hosting account's smtp (email) server
	{
		   echo("<p>Message successfully sent!</p>");

  	} 
	else 
	{
   		echo("<p>Message delivery failed...</p>");
  	}

?>

    </div>
    <div class=" col-m-6 col-6">
        <aside>
       <h2>Artisan</h2>
       <p>A person or company that makes a high-quality, distinctive product in small quantities, usually by hand and using traditional methods.</p>
        <img src="../images/pizza-image.jpg" alt="Pizza in oven">
        </aside>
    </div>
</div>
</section>


<footer>
    <p>Brick Oven Pizza,</p>
    <p>2451 N Randolf St,</p>
    <p>Chicago, IL 60607</p>
    <p><a href="http://www.freepik.com/free-vector/brick-texture-background_854395.htm">background image Designed by Freepik</a></p>
</footer>
</div>



</body>
</html>
