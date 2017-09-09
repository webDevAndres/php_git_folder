<!DOCTYPE html>
<html lang="en">
    <head>
        <title>PHP Basics</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
       
    </head>
    <body>
       <h1>PHP Basics</h1>
        
        <p>Create a variable called yourName. Assign it a value of your name.</p>
            <?php $yourName = "Andres Macias"; ?>

        <p>Display the assignment name in an h1 element on the page. Include the elments in your output.</p>
        <?php echo "<h1>PHP Basics</h1>";?>

        <p>Use HTML to put an h2 element on the page. Use PHP to display your name inside the element using the variable.</h2>
        <h2><?php echo $yourName; ?></h2>
        
        <p>Create the following variables: number1, number2 and total. Assign a value to them.</p2>
        <?php $number1 = 1;
              $number2 = 2;
              $total   = $number1 + $number2;
        ?>

        <p>Display the value of each variable and the total variable when you add them together.</p>
        <p><?php echo $number1. " " . "+" . " " .$number2 . " " . "=" . " " . $total; ?> </p>
       

        <p>Use PHP to create a Javascript array with the following values: PHP,HTML,Javascript.  Output this array using PHP.  Create a script that will display the values of this array on your page.  NOTE:  Remember PHP is building the array not running it.  Javascript will use the array once the page is processed and returned to the client's browser where HTML and Javascript will do their thing.</p>
        <p id="displayCodeValues"></p>
     
        <?php 
        
        echo                                                //Use PHP to create a Javascript array with the following values: PHP,HTML,Javascript. Output this array using PHP.
        "<script>
        var codeLang = ['PHP',' HTML',' Javascript'];
        </script>"; 
    
        ?>
     <script>
         document.getElementById("displayCodeValues").innerHTML = codeLang;          // Create a script that will display the values of this array on your page.
     </script>

    </body>
</html>
