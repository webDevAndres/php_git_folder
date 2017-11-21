<?php
//controller
//gathers data from database table
//formats data into presentation format on browser


    include 'connectPDO.php';

//get the customer prefererences and display them in descending order for each preference.
$queryPref1 = 'SELECT cust_email, cust_pref1 FROM time_preferences ORDER BY cust_pref1 DESC';
$stmt1 = $conn->prepare($queryPref1);
$stmt1->execute();
$cust_pref1 = $stmt1->fetchAll();
$stmt1->closeCursor();

// gets the average rating for the first preference
$queryPref1Average = 'SELECT AVG(cust_pref1) AS averageRating FROM time_preferences';
$stmt1Average = $conn->prepare($queryPref1Average);
$stmt1Average->execute();
$cust_pref1Average = $stmt1Average->fetchAll();
$stmt1Average->closeCursor();

//TABLE 2
$queryPref2 = 'SELECT cust_email,cust_pref2 FROM time_preferences ORDER BY cust_pref2 DESC';
$stmt2 = $conn->prepare($queryPref2);
$stmt2->execute();
$cust_pref2 = $stmt2->fetchAll();
$stmt2->closeCursor();

// gets the average rating for the 2nd preference
$queryPref2Average = 'SELECT AVG(cust_pref2) AS averageRating FROM time_preferences';
$stmt2Average = $conn->prepare($queryPref2Average);
$stmt2Average->execute();
$cust_pref2Average = $stmt2Average->fetchAll();
$stmt2Average->closeCursor();

//TABLE 3
$queryPref3 = 'SELECT cust_email,cust_pref3 FROM time_preferences ORDER BY cust_pref3 DESC';
$stmt3 = $conn->prepare($queryPref3);
$stmt3->execute();
$cust_pref3 = $stmt3->fetchAll();
$stmt3->closeCursor();

// gets the average rating for the 3rd preference
$queryPref3Average = 'SELECT AVG(cust_pref3) AS averageRating FROM time_preferences';
$stmt3Average = $conn->prepare($queryPref3Average);
$stmt3Average->execute();
$cust_pref3Average = $stmt3Average->fetchAll();
$stmt3Average->closeCursor();


//TABLE 4
$queryPref4 = 'SELECT cust_email,cust_pref4 FROM time_preferences ORDER BY cust_pref4 DESC';
$stmt4 = $conn->prepare($queryPref4);
$stmt4->execute();
$cust_pref4 = $stmt4->fetchAll();
$stmt4->closeCursor();

// gets the average rating for the 4th preference
$queryPref4Average = 'SELECT AVG(cust_pref4) AS averageRating FROM time_preferences';
$stmt4Average = $conn->prepare($queryPref4Average);
$stmt4Average->execute();
$cust_pref4Average = $stmt4Average->fetchAll();
$stmt4Average->closeCursor();
$message = "<h1>The following has been found: " .$stmt2->RowCount() . " " . "rows</h1>";



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>wdv341 intro php Select events</title>

    <style>
.container {
width: 100%;
text-align: center;
}
    .tableFormat {
       float:left;
    }
    th {
        background-color: lightblue;
        width: 150px;
        height: 50px;
       
    }

    td {
       text-align: center;
       border-bottom: 1px solid black;
       width:30px;
       height: 30px;
       border:1px solid black;
       
    }

    tr:nth-child(even){
        background-color: #dad6d6;
    }
    
    </style>

</head>
<body>
<div class='container'>
    <section id='content'>
    <?php echo $message  ?>
    <!-- table 1 -->
    <table class='tableFormat'>
    <th>Customer Email</th><th>Monday/Wednesday 10:10 - 12</th>

    <?php foreach ($cust_pref1 as $pref) {?>
<tr>
<td ><?php echo $pref['cust_email']; ?></td>
<td><?php echo $pref['cust_pref1']; ?></td>
</tr>
    <?php } ?>
    <?php foreach ($cust_pref1Average as $pref) {?>
<td><?php echo 'Average Rating' ?></td>
<td><?php echo round($pref['averageRating'],2); ?></td>

    <?php } ?>
    </table>
    
    <!-- table 2 -->
    <table class='tableFormat'>
    <th>Customer Email</th><th> Tuesday 6pm - 9pm</th>

    <?php foreach ($cust_pref2 as $pref) {?>
<tr>
<td ><?php echo $pref['cust_email']; ?></td>
<td><?php echo $pref['cust_pref2']; ?></td>
</tr>
    <?php } ?>
    <?php foreach ($cust_pref2Average as $pref) {?>
<td><?php echo 'Average Rating' ?></td>
<td><?php echo round($pref['averageRating'],2); ?></td>

    <?php } ?>
    </table>

    <!-- table 3 -->
    <table class='tableFormat'>
    <th>Customer Email</th><th> Wednesday 6pm - 9pm</th>

    <?php foreach ($cust_pref3 as $pref) {?>
<tr>
<td ><?php echo $pref['cust_email']; ?></td>
<td><?php echo $pref['cust_pref3']; ?></td>
</tr>
    <?php } ?>
    <?php foreach ($cust_pref3Average as $pref) {?>
<td><?php echo 'Average Rating' ?></td>
<td><?php echo round($pref['averageRating'],2); ?></td>

    <?php } ?>
    </table>

<!-- table 4 -->
    <table class='tableFormat'>
    <th>Customer Email</th><th> Tuesday/Thursday 10:10-Noon</th>

    <?php foreach ($cust_pref4 as $pref) {?>
<tr>
<td ><?php echo $pref['cust_email']; ?></td>
<td><?php echo round($pref['cust_pref4'],2); ?></td>
</tr>
    <?php } ?>
    <?php foreach ($cust_pref4Average as $pref) {?>
<td><?php echo 'Average Rating' ?></td>
<td><?php echo round($pref['averageRating'],2); ?></td>

    <?php } ?>
</table>
    </section>
    </div>
</body>
</html>