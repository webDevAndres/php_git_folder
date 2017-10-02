<?php

$inMonth = $_POST["month"];
$inDay = $_POST["day"];
$inYear = $_POST["year"];
$inSecurityPhrase = $_POST["securityPhrase"];
$informattedQuantity = $_POST["formattedQuantity"];
$inBidFormatted = $_POST["bid"];


function formatBirthday($month, $day, $year)
{
   $UsFormat = date("m/d/Y", mktime(0, 0, 0, $month, $day, $year));
    
    return $UsFormat;
}

function formatBirthdayInternational($month, $day, $year)
{
    $InternationalFormat = date("d/m/Y", mktime(0, 0, 0, $month, $day, $year));

    return $InternationalFormat;
}

function formatSecurityPhrase($phrase)
{
    $targetWord = "dmacc";
    $phrase = trim($phrase);
    $foundTargetWord = strtolower(stristr($phrase, $targetWord));
     
    if ($foundTargetWord === "dmacc") {
       $containsDmacc = "<strong>target word found</strong>";
       
    } else {
       $containsDmacc = "<strong>does not contain target Word</strong>";
        
    }
    return strlen($phrase) ." ". strtolower($phrase)." ". $containsDmacc;
}

function formatQuantity($inQuantity){
    $formattedNumber = number_format($inQuantity);
    return $formattedNumber;
}
function formatBidCurrency($bid){
    $formattedBidNumber = "$ ". number_format($bid, 2);
    return $formattedBidNumber;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Wdv341 Intro PHP</title>
    <link rel="stylesheet" href="css/responsive-grid.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<div class="container">
        <div class="row">
            <div class="col-12">
                <h1>PHP Functions</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <p>Create a function that will accept a date input and format it into mm/dd/yyyy format.</p>
                <p>Create a function that will accept a date input and format it into dd/mm/yyyy format to use when working
                    with international dates.</p>


                <p>Create a function that will accept a string input. It will do the following things to the string:</p>
                <ul>
                    <li>Display the number of characters in the string</li>
                    <li>Trim any leading or trailing whitespace</li>
                    <li>Display the string as all lowercase characters</li>
                    <li>Will display whether or not the string contains "DMACC" either upper or lowercase</li>
                </ul>



                <p>Create a function that will accept a number and display it as a formatted number. Use 1234567890 for your
                    testing.
                </p>



                <p>Create a function that will accept a number and display it as US currency. Use 123456 for your testing.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <form method="post" action="phpFunctions.php">

                    <fieldset>
                    <legend>Your input:</legend>
                       
                        <p class="dateFormatter">
                           Birthday: <?php  echo formatBirthday($inMonth, $inDay, $inYear); ?>
                           Birthday international: <?php echo formatBirthdayInternational($inMonth, $inDay, $inYear);    ?>
                        </p>
                  
                        <p>
                        Security answer: <?php echo  formatSecurityPhrase($inSecurityPhrase);    ?>
                        </p>
                       
                        <p>
                        Quantity: <?php  echo formatQuantity($informattedQuantity);     ?>
                        </p>

                        <p>
                       Bid: <?php  echo formatBidCurrency($inBidFormatted);    ?>

                       </p>

                    </fieldset>
            </div>
        </div>
    </div>




</body>
</html>
