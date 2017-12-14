<?php
  require 'connectPDO.php';
//set the timeZone
date_default_timezone_set("America/New_York");

// define variables and set to empty values
$nameError = "";
$emailError = "";
$addressError = "";
$cityError = "";
$stateError = "";
$zipError = "";
$hairCareServiceError = "";


$name = "";
$email = "";
$address = "";
$city = "";
$state = "";
$zip = "";
$hairCareService = "";
$option1 = "";
$option2 = "";
$option3 = "";
$slot_open="";
$honeyPot = "";

// set form flag to false
$validForm=false;
$avail_id = filter_input(INPUT_POST, 'avail_id',FILTER_VALIDATE_INT);
$slot_avail = filter_input(INPUT_POST, 'slot_avail',FILTER_SANITIZE_SPECIAL_CHARS);


try {
  if ($avail_id < 27) {
    $updateSlotAvailability = "UPDATE eny_avail SET slot_open='$slot_open' WHERE avail_id='$avail_id'";
    
        $stmt = $conn->prepare($updateSlotAvailability);
        $stmt->execute();
        
            if ( $stmt->execute() )
            {
              $message = "<h1>Your record has been successfully UPDATED to the database.</h1>";
             
            }
            else
            {
              $message = "<h1>You have encountered a problem.</h1>";
              $message .= "<h2 style='color:red'>" . mysqli_error($link) . "</h2>";
            }
  }
 else {
  $updateSlotAvailabilityWeek2 = "UPDATE eny_avail_week2 SET slot_open='$slot_open' WHERE avail_id='$avail_id'";
  
      $stmt = $conn->prepare($updateSlotAvailabilityWeek2);
      $stmt->execute();
      
          if ( $stmt->execute() )
          {
            $message = "<h1>Your record has been successfully UPDATED to the database.</h1>";
           
          }
          else
          {
            $message = "<h1>You have encountered a problem.</h1>";
            $message .= "<h2 style='color:red'>" . mysqli_error($link) . "</h2>";
          }
 }

}

catch(PDOException $e) {
  $message = "There has been a problem. Please try again later.";
  error_log($e->getMessage());
  error_log(var_dump(debug_backtrace()));
}
$conn = null;



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
   
     
      <section class="desktopNav">
 <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="index.php">Eny Hair Salon</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link" href="index.php">Home
              <span class="sr-only">(current)</span>
            </a>
          <li class="nav-item">
          <a class="nav-link" href="login.php">LOGIN</a>
        </li>
          <li class="nav-item">
            <a class="nav-link" href="adminApptView.php">View appointments</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="addAvailTimes.php">Update available times</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">logout</a>
          </li>
        </ul>
      </div>
    </nav>
 </section>
      <section class="mobileNav">
      <nav class="navbar fixed-bottom navbar-expand-lg navbar-light bg-light">
           <a class="navbar-brand" href="index.php">Eny Hair Salon</a>
           <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
             aria-label="Toggle navigation">
             <span class="navbar-toggler-icon"></span>
           </button>
           <div class="collapse navbar-collapse" id="navbarNav">
             <ul class="navbar-nav">
               <li class="nav-item active">
                 <a class="nav-link" href="index.php">Home
                   <span class="sr-only">(current)</span>
                 </a>
               <li class="nav-item">
               <a class="nav-link" href="login.php">LOGIN</a>
             </li>
               <li class="nav-item">
                 <a class="nav-link" href="adminApptView.php">View appointments</a>
               </li>
               <li class="nav-item">
                 <a class="nav-link" href="addAvailTimes.php">Update available times</a>
               </li>
               <li class="nav-item">
                 <a class="nav-link" href="logout.php">logout</a>
               </li>
             </ul>
           </div>
         </nav>
      </section>
      
      <div class="container">
      <form id="customerInfo">
        <?php echo "<h1>$message</h1>";?>
        <?php echo "<h2>Time slot $slot_avail  updated to available</h2>";?>
       

      </form>

</div>

      

      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
        crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ"
        crossorigin="anonymous"></script>
  </body>

  </html>