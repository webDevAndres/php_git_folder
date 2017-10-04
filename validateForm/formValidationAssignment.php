<?php
//define variables and set to empty values
$inNameErr = $inSocialSecurityErr = $inRadioGroup1Err = "";
$inName = $inSocialSecurity = $inRadioGroup1 = "";

$validForm = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
          $inNameErr = "Name is required";
    } else {
          $inName = test_input($_POST["name"]);
          $inNameErr = "";
        //check if name only contains lettes and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $inName)) {
            $nameErr = "Only letters and white space allowed";
        }
    }

    if (empty($_POST["socialSecurity"])) {
      $inSocialSecurityErr = "SSN is required";
} else {
      $inSocialSecurity = test_input($_POST["socialSecurity"]);
      $inSocialSecurityErr = "";
       //check if name only contains lettes and whitespace
       if (filter_var($inSocialSecurity, FILTER_VALIDATE_INT) === false) {
        $inSocialSecurityErr = "Only Numbers are allowed";
    }
    }


    if (empty($_POST["radioGroup1"])) {
          $inRadioGroup1Err = "Please Choose a response";
    } else {
          $inRadioGroup1 = test_input($_POST["radioGroup1"]);
          $inRadioGroup1Err = "";
    }
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
  <title>WDV341 Intro PHP - Form Validation</title>

  <style>
#orderArea	{
    width:600px;
    background-color:#CF9;
}

.error	{
    color:red;
    font-style:italic;  
}
</style>

</head>

<body>
<h1>WDV341 Intro PHP</h1>
<h2>Form Validation Assignment</h2>

<div id="orderArea">
  <form id="form1" name="form1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <h3>Customer Registration Form</h3>
  <table width="587" border="0">
    <tr>
      <td width="117">Name:</td>
     
      <td width="246"><input type="text" name="name" id="name" size="40" value=""/> <span class="error"> <?php echo $inNameErr;?></span></td>
      <td width="210" class="error"></td>
    </tr>
    <tr>
      <td>Social Security</td>
      
      <td><input type="text" name="socialSecurity" id="socialSecurity"  minlength="9" maxlength="9" size="40" value="" /><span class="error"> <?php echo $inSocialSecurityErr;?></span></td>
      <td class="error"></td>
    </tr>
    <tr>
    
      <td>Choose a Response</td>
      
      <td><p>
     
        <label>
          
          <input type="radio" name="radioGroup1" id="radioGroup1_0" <?php if (isset($inRadioGroup1) && $inRadioGroup1=="Phone") echo "checked";?> value="Phone">
          Phone</label><span class="error"> <?php echo $inRadioGroup1Err;?></span>
        <br>
        <label>
          <input type="radio" name="radioGroup1" id="radioGroup1_1" <?php if (isset($inRadioGroup1) && $inRadioGroup1=="Email") echo "checked";?> value="Email">
          Email</label>
        <br>
        <label>
          <input type="radio" name="radioGroup1" id="radioGroup1_2" <?php if (isset($inRadioGroup1) && $inRadioGroup1=="US Mail") echo "checked";?> value="US Mail">
          US Mail</label>
          
        <br>
      </p></td>
      <td class="error"></td>
    </tr>
  </table>
  <p>
    <input type="submit" name="submit" id="button" value="Register" >
    <input type="reset" name="reset" id="button2" value="Clear Form" >
  </p>
</form>
</div>



</body>
</html>
