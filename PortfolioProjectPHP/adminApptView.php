<?php
//controller
//gathers data from database table
//formats data into presentation format on browser
session_start();

if($_SESSION['validUser'] =="yes") {
    include 'connectPDO.php';

//get event ID
if(!isset($cust_id)) {
    $cust_id = filter_input(INPUT_GET, 'cust_id',FILTER_VALIDATE_INT);
    if($cust_id == NULL || $cust_id ==FALSE) {
        $cust_id = 1;
    }
}


try {
//get all events
$queryAllAppts = 'SELECT cust_id,cust_name,cust_email,cust_address,cust_city,cust_state,cust_zip,cust_service,cust_option1,cust_option2,cust_option3,appt_time,DATE_FORMAT(appt_day, "%m-%d-%Y") AS appt_day FROM customers WHERE appt_time="8am" OR appt_time="9am" OR appt_time="10am" OR appt_time="11am" OR appt_time="12pm" ORDER BY appt_day ASC, appt_time DESC';
$stmt = $conn->prepare($queryAllAppts);
$stmt->execute();
$todaysAppts = $stmt->fetchAll();
$stmt->closeCursor();
}
catch(PDOExcception $e) {
  {
      echo "<h1>Failed to connect to database: </h1>" . $e-getMessage();
  }
  $conn = null;
}
}
else {
  	//Invalid User attempting to access this page. Send person to login Page
	header('Location: index.php');
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

      <br>
     
<div class="container-fluid">
<section id='availableHours'>
    <table class='table table-responsive-sm table-lg table-striped table-secondary table-hover table-bordered'>
    <thead>
    <tr>
      <th scope="col">Customer Name</th>
      <th scope="col">Email</th>
      <th scope="col">Address</th>
      <th scope="col">City</th>
      <th scope="col">State</th>
      <th scope="col">Zip</th>
      <th scope="col">Appointment Details</th>
      <th scope="col">Additional Services 1</th>
      <th scope="col">Additional Services 2</th>
      <th scope="col">Additional Services 3</th>
      <th scope="col">Appt Date</th>
      <th scope="col">Appt Time</th>
    </tr>
  </thead>
        <tbody>
        <?php foreach ($todaysAppts as $custInfo) {?>
<tr>
<th><?php echo $custInfo['cust_name']; ?></th>
<td><?php echo $custInfo['cust_email']; ?></td>
<td><?php echo $custInfo['cust_address']; ?></td>
<td><?php echo $custInfo['cust_city']; ?></td>
<td><?php echo $custInfo['cust_state']; ?></td>
<td><?php echo $custInfo['cust_zip']; ?></td>
<td><?php echo $custInfo['cust_service']; ?></td>
<td><?php echo $custInfo['cust_option1']; ?></td>
<td><?php echo $custInfo['cust_option2']; ?></td>
<td><?php echo $custInfo['cust_option3']; ?></td>
<td><?php echo $custInfo['appt_day']; ?></td>
<td><?php echo $custInfo['appt_time']; ?></td>
<td><form class="bg-dark" action="update.php" method="post">
<input type="hidden" name="cust_id" value="<?php echo $custInfo['cust_id'];?>">
<button type="submit" class="btn btn-dark btn-block">Select</button>
</form></td>
</tr>
</tbody>

    <?php } ?>
</table>
    </section>

</div>


      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
        crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ"
        crossorigin="anonymous"></script>
</body>
</html>