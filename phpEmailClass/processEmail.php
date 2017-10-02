<?php
include 'Email.php';

$contactEmail = new Email(""); //instantiate

$contactEmail->setRecipient("amacias@dmacc.edu");

$contactEmail->setSender("andres_blue-101@hotmail.com");

$contactEmail->setSubject("Hello World whats up");

$contactEmail->setMessage("did this send?");

$emailStatus = $contactEmail->sendMail(); //create and send email
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>WDV 341 Intro PHP</h1>
    <h2>OOP Email Class</h2>

<p>Recipient Email Address: <?php echo $contactEmail->getRecipient(); ?> </p>
<p>Sender Email Address: <?php echo $contactEmail->getSender(); ?> </p>
<p>Subject:  <?php echo $contactEmail->getSubject(); ?></p>
<p>Message:  <?php echo $contactEmail->getMessage(); ?>  </p>




<h3>
<?php  if ($emailStatus) {
        echo "<h3>Thank you for your submission</h3>";
    }
    else {
        echo "<h3>Sorry Error try again later</h3>";
    }
 ?>

</h3>

</body>
</html>