<?php
session_start();
if($_SESSION['validUser'] =="yes") {

  require 'connectPDO.php';
//set the timeZone
date_default_timezone_set("America/New_York");

// define variables and set to empty values
$apptTimeError = "";
$nameError = "";
$emailError = "";
$addressError = "";
$cityError = "";
$stateError = "";
$zipError = "";

$appt_day = "";
$appt_time = "";
$name = "";
$email = "";
$address = "";
$city = "";
$state = "";
$zip = "";

$honeyPot = "";

// set form flag to false
$validForm=false;

$custInfo = filter_input(INPUT_POST, 'cust_id',FILTER_VALIDATE_INT);

	//fill in the form with the customers information
    $queryCustInfo = 'SELECT * FROM customers WHERE cust_id = :cust_id';
    $stmt1 = $conn->prepare($queryCustInfo);
    $stmt1->bindValue(':cust_id', $custInfo);
    $stmt1->execute();
    $cust_info = $stmt1->fetch();
    $cust_name = $cust_info['cust_name'];
    $stmt1->closeCursor();

// validation functions
function validateApptTime() {
  global $appt_time,$validForm,$apptTimeError;
  if (!preg_match("/^[^-\s][a-zA-Z0-9 \s-]*$/", $appt_time)) {
    $apptTimeError = "Special characters not allowed";
    $validForm = false;
}
else {
  $name = test_input($_POST['appt_time']);
}
}

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
      $EmailError = "Invalid email";
      $validForm = false;
  } else {
        $email = test_input($_POST["email"]);
    }
}

function validateAddress() {
  global $address,$validForm,$addressError;
  if (!preg_match("/^[^-\s][a-zA-Z0-9 \s-]*$/", $address)) {
    $addressError = "Special characters not allowed";
    $validForm = false;
}
else {
  $name = test_input($_POST['address']);
}
}

function validateCity() {
  global $city,$validForm,$cityError;
  if (!preg_match("/^[^-\s][a-zA-Z0-9' \s-]*$/", $city)) {
    $cityError = "Special characters not allowed";
    $validForm = false;
}
else {
  $name = test_input($_POST['city']);
}
}

function validateState() {
  global $state,$validForm,$stateError;
  if (!preg_match("/^[^-\s][a-zA-Z0-9 \s-]*$/", $state)) {
    $stateError = "Special characters not allowed";
    $validForm = false;
}
else {
  $name = test_input($_POST['state']);
  if ($state == "") {
    $stateError = "Please choose a state";
    $validForm = false;
}
}
}

function validateZip() {
  global $zip,$validForm,$zipError;
  if (!preg_match("/^[^-\s][0-9\s-]*$/", $zip)) {
    $zipError = "Special characters not allowed";
    $validForm = false;
}
else {
  $name = test_input($_POST['zip']);
}
}


function validateHoneyPot() {
  global $honeyPot,$validForm;
  if (!empty($_POST["honeyPot"])) {
      $honeyPot = test_input($_POST["honeyPot"]);
      $validForm= false;
  }
}

// Form validation
if(isset($_POST['submit'])) {  
  $name = $_POST["name"]; 
  $email = $_POST["email"];
  $address = $_POST["address"];
  $city = $_POST["city"];
  $state = $_POST["state"];
  $zip = $_POST["zip"];
  $appt_day = $_POST["datepicker"];
  $appt_time = $_POST["appt_time"];
  $honeyPot = $_POST["honeyPot"];

  // set form flag to true
  $validForm = true;
  validateApptTime();
  validateName();
  validateEmail();
  validateAddress();
  validateCity();
  validateState();
  validateZip();


  validateHoneyPot();

  // if the form is true connect to database

  if($validForm) {
    try {
        $updateCustInfo = "UPDATE customers SET cust_name ='$name', cust_email='$email',cust_address='$address', cust_city='$city', cust_state='$state',cust_zip='$zip',appt_time='$appt_time',appt_day='$appt_day' WHERE cust_id='$custInfo'";
		
				$stmt = $conn->prepare($updateCustInfo);
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

    catch(PDOException $e) {
      $message = "There has been a problem. Please try again later.";
      error_log($e->getMessage());
      error_log(var_dump(debug_backtrace()));
    }
    $conn = null;

  }

}
}
else {
  	//Invalid User attempting to access this page. Send person to login Page
	header('Location: login.php');
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
   
      </section>
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
    
    <?php
if ($validForm){
?>
      <form id="customerInfo">
        <?php echo "<h1>$message</h1>";?>
        <p>Name:
          <?php echo $appt_time;?>
        </p>
        <p>Name:
          <?php 
           
           $date=date_create($appt_day);
           echo date_format($date,"m/d/Y");?>
        </p>
        <p>Name:
          <?php echo $name;?>
        </p>
        <p>Email:
          <?php echo $email;?>
        </p>
        <p>Address:
          <?php echo $address;?>
        </p>
        <p>City:
          <?php echo $city;?>
        </p>
        <p>State:
          <?php echo $state;?>
        </p>
        <p>Zip:
          <?php echo $zip;?>
        </p>

      </form>
      </div>
      <?php  
}
else {
 ?>
      <div class="formContainer">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="needs-validation" novalidate>
      
<?php echo "<h2>Customer id: $custInfo</h2>";?>
<div class="form-group">
            <label for="appt_time">Reschedule appt time</label>
            <input type="text" class="form-control" name="appt_time" id="appt_time"  value="<?php echo $cust_info['appt_time'];?>">
            <span class="error">
              <?php echo $apptTimeError; ?>
            </span>
            <span class="invalid-feedback" id="apptTimeError"></span>
          </div>
<div class="form-group">
            <label for="datepicker">Please choose a day</label>
            <input type="date" name="datepicker" id="datepicker"   min="2017-12-11" max="2017-12-22" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" value="<?php echo $appt_day;?> ">
            <span class="invalid-feedback" id="nameError"></span>
          </div>
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="name@example.com"  value="<?php echo $cust_info['cust_name'];?>">
            <span class="error">
              <?php echo $nameError; ?>
            </span>
            <span class="invalid-feedback" id="nameError"></span>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com"  value="<?php echo $cust_info['cust_email'];?>">
            <span class="error">
              <?php echo $emailError;?>
            </span>
            <span class="invalid-feedback" id="emailError"></span>
          </div>
          <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" name="address" id="address" placeholder="1234 Main St"  value="<?php echo $cust_info['cust_address'];?>">
            <span class="error">
              <?php echo $addressError;?>
            </span>
            <span class="invalid-feedback" id="addressError"></span>
          </div>
          <div class="form-row">
            <div class="form-group col col-md-6">
              <label for="city">City</label>
              <input type="text" class="form-control" name="city" id="city"  value="<?php echo $cust_info['cust_city'];?>">
              <span class="error">
                <?php echo $cityError;?>
              </span>
              <span class="invalid-feedback" id="cityError"></span>
            </div>
            <div class="form-group col-md-4">
              <label for="state">State</label>
              <span class="invalid-feedback">
                <?php echo "$stateError";?>
              </span>
              <select id="state" name="state" class="form-control" >
                <option value="<?php echo $cust_info['cust_state']; ?>"><?php echo $cust_info['cust_state']; ?></option>
                <option value="AL" <?php if($state=="AL" ){echo "selected='selected'";} ?>>Alabama</option>
                <option value="AK" <?php if($state=="AK" ){echo "selected='selected'";} ?>>Alaska</option>
                <option value="AZ" <?php if($state=="AZ" ){echo "selected='selected'";} ?>>Arizona</option>
                <option value="AR" <?php if($state=="AR" ){echo "selected='selected'";} ?>>Arkansas</option>
                <option value="CA" <?php if($state=="CA" ){echo "selected='selected'";} ?>>California</option>
                <option value="CO" <?php if($state=="CO" ){echo "selected='selected'";} ?>>Colorado</option>
                <option value="CT" <?php if($state=="CT" ){echo "selected='selected'";} ?>>Connecticut</option>
                <option value="DE" <?php if($state=="DE" ){echo "selected='selected'";} ?>>Delaware</option>
                <option value="DC" <?php if($state=="CD" ){echo "selected='selected'";} ?>>District Of Columbia</option>
                <option value="FL" <?php if($state=="FL" ){echo "selected='selected'";} ?>>Florida</option>
                <option value="GA" <?php if($state=="GA" ){echo "selected='selected'";} ?>>Georgia</option>
                <option value="HI" <?php if($state=="HI" ){echo "selected='selected'";} ?>>Hawaii</option>
                <option value="ID" <?php if($state=="ID" ){echo "selected='selected'";} ?>>Idaho</option>
                <option value="IL" <?php if($state=="IL" ){echo "selected='selected'";} ?>>Illinois</option>
                <option value="IN" <?php if($state=="IN" ){echo "selected='selected'";} ?>>Indiana</option>
                <option value="IA" <?php if($state=="IA" ){echo "selected='selected'";} ?>>Iowa</option>
                <option value="KS" <?php if($state=="KS" ){echo "selected='selected'";} ?>>Kansas</option>
                <option value="KY" <?php if($state=="KY" ){echo "selected='selected'";} ?>>Kentucky</option>
                <option value="LA" <?php if($state=="LA" ){echo "selected='selected'";} ?>>Louisiana</option>
                <option value="ME" <?php if($state=="ME" ){echo "selected='selected'";} ?>>Maine</option>
                <option value="MD" <?php if($state=="MD" ){echo "selected='selected'";} ?>>Maryland</option>
                <option value="MA" <?php if($state=="MA" ){echo "selected='selected'";} ?>>Massachusetts</option>
                <option value="MI" <?php if($state=="MI" ){echo "selected='selected'";} ?>>Michigan</option>
                <option value="MN" <?php if($state=="MN" ){echo "selected='selected'";} ?>>Minnesota</option>
                <option value="MS" <?php if($state=="MS" ){echo "selected='selected'";} ?>>Mississippi</option>
                <option value="MO" <?php if($state=="MO" ){echo "selected='selected'";} ?>>Missouri</option>
                <option value="MT" <?php if($state=="MT" ){echo "selected='selected'";} ?>>Montana</option>
                <option value="NE" <?php if($state=="NE" ){echo "selected='selected'";} ?>>Nebraska</option>
                <option value="NV" <?php if($state=="NV" ){echo "selected='selected'";} ?>>Nevada</option>
                <option value="NH" <?php if($state=="NH" ){echo "selected='selected'";} ?>>New Hampshire</option>
                <option value="NJ" <?php if($state=="NJ" ){echo "selected='selected'";} ?>>New Jersey</option>
                <option value="NM" <?php if($state=="NM" ){echo "selected='selected'";} ?>>New Mexico</option>
                <option value="NY" <?php if($state=="NY" ){echo "selected='selected'";} ?>>New York</option>
                <option value="NC" <?php if($state=="NC" ){echo "selected='selected'";} ?>>North Carolina</option>
                <option value="ND" <?php if($state=="ND" ){echo "selected='selected'";} ?>>North Dakota</option>
                <option value="OH" <?php if($state=="OH" ){echo "selected='selected'";} ?>>Ohio</option>
                <option value="OK" <?php if($state=="OK" ){echo "selected='selected'";} ?>>Oklahoma</option>
                <option value="OR" <?php if($state=="OR" ){echo "selected='selected'";} ?>>Oregon</option>
                <option value="PA" <?php if($state=="PA" ){echo "selected='selected'";} ?>>Pennsylvania</option>
                <option value="RI" <?php if($state=="RI" ){echo "selected='selected'";} ?>>Rhode Island</option>
                <option value="SC" <?php if($state=="SC" ){echo "selected='selected'";} ?>>South Carolina</option>
                <option value="SD" <?php if($state=="SD" ){echo "selected='selected'";} ?>>South Dakota</option>
                <option value="TN" <?php if($state=="TN" ){echo "selected='selected'";} ?>>Tennessee</option>
                <option value="TX" <?php if($state=="TX" ){echo "selected='selected'";} ?>>Texas</option>
                <option value="UT" <?php if($state=="UT" ){echo "selected='selected'";} ?>>Utah</option>
                <option value="VT" <?php if($state=="VT" ){echo "selected='selected'";} ?>>Vermont</option>
                <option value="VA" <?php if($state=="VA" ){echo "selected='selected'";} ?>>Virginia</option>
                <option value="WA" <?php if($state=="WA" ){echo "selected='selected'";} ?>>Washington</option>
                <option value="WV" <?php if($state=="WV" ){echo "selected='selected'";} ?>>West Virginia</option>
                <option value="WI" <?php if($state=="WI" ){echo "selected='selected'";} ?>>Wisconsin</option>
                <option value="WY" <?php if($state=="WY" ){echo "selected='selected'";} ?>>Wyoming</option>

              </select>
              <span class="error">
                <?php echo $stateError;?>
              </span>
            </div>
            <div class="form-group col-md-2">
              <label for="zip">Zip</label>
              <span class="invalid-feedback">
                <?php echo "$zipError";?>
              </span>
              <span class="invalid-feedback" id="zipError"></span>
              <input type="text" class="form-control" name="zip" id="inputZip"  value="<?php echo $cust_info['cust_zip'];?>">
              <span class="error">
                <?php echo $zipError;?>
              </span>
            </div>
          </div>

          <div class="form-group">   
              <input type="hidden" name="cust_id" value="<?php echo $custInfo;?>">
          </div>
          
          <!-- do not fill -->
          <input class="hideRoboTest" type="hidden" name="honeyPot">
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


      <?php 
}
?>


      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
        crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ"
        crossorigin="anonymous"></script>
  </body>

  </html>