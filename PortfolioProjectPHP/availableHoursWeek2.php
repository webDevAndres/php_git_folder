<?php
//controller
//gathers data from database table
//formats data into presentation format on browser




    include 'connectPDO.php';

//get event ID
if(!isset($avail_id)) {
    $avail_id = filter_input(INPUT_GET, 'avail_id',FILTER_VALIDATE_INT);
    if($avail_id == NULL || $avail_id ==FALSE) {
        $avail_id = 1;
    }
}



//get all available hours
$queryAllHours = 'SELECT avail_id,avail_days,slot_avail,slot_open FROM eny_avail_week2 WHERE slot_open="yes" ORDER BY avail_id ASC';
$stmt = $conn->prepare($queryAllHours);
$stmt->execute();
$availableHour = $stmt->fetchAll();
$stmt->closeCursor();




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
<div class="container">
      <section class="socialMedia">
        <div class="row justify-content-md-center">
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

    <section id='availableHours'>
    <nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item"><a class="page-link" href="availableHours.php">Availability for 1st week of the month</a></li>
    <li class="page-item"><a class="page-link" href="availableHoursWeek2.php">Availability for 2nd week of the month</a></li>
  </ul>
</nav>
    <table class='table table-striped table-dark'>
    <thead>
    <tr>
      <th scope="col">Available times for the week of Monday December 18th, 2017 </th>
    </tr>
  </thead>
    <?php foreach ($availableHour as $slot_avail) {?>
        <tbody>
<tr>
<td><?php echo $slot_avail['avail_days']; ?></td>
<td><?php echo $slot_avail['slot_avail']; ?></td>
<td><form class="bg-dark" action="confirmAppt.php" method="post">
<input type="hidden" name="avail_id" value="<?php echo $slot_avail['avail_id'];?>">
<input type="hidden" name="slot_avail" value="<?php echo $slot_avail['slot_avail'];?>">

<button type="submit" class="btn btn-primary btn-block">Select</button>
</form></td>
</tr>
</tbody>

    <?php } ?>
</table>
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