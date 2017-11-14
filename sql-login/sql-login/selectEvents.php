<?php
//controller
//gathers data from database table
//formats data into presentation format on browser
session_start(); 
if ($_SESSION['validUser'] == "yes") {


    include 'connectPDO.php';

//get event ID
if(!isset($event_id)) {
    $event_id = filter_input(INPUT_GET, 'event_id',FILTER_VALIDATE_INT);
    if($event_id == NULL || $event_id ==FALSE) {
        $event_id = 1;
    }
}



//get all events
$queryAllEvents = 'SELECT * FROM wdv341_event ORDER BY event_id';
$stmt2 = $conn->prepare($queryAllEvents);
$stmt2->execute();
$events = $stmt2->fetchAll();
$stmt2->closeCursor();

$message = "<h1>The following has been found: " .$stmt2->RowCount() . " " . "rows</h1>";
  $message .= "<p>Return to <a href='login.php'>Login</a>.</p>";
} //end valid user check

else {
    //redirect invalid user to login page
    header('Location: login.php');
}

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
text-align: center;


}
    .tableFormat {
        border: 2px solid black;
        margin-right: auto;
        margin-left: auto;

    }
    th {
        background-color: lightblue;
       
    }

    td {
       text-align: center;
       border-bottom: 1px solid black;
       width:150px;
       height: 30px;
       border:1px solid black;
       
    }

    
    </style>
</head>
<body>
<div class='container'>
    <section id='content'>
    <?php echo $message  ?>
    <table class='tableFormat'>
    <th>Event Id</th><th>Event Name</th><th>Event Description</th><th>Event Presenter</th><th>Event Date</th><th>Event Time</th><th>Update</th><th>Delete</th>

    <?php foreach ($events as $event) {?>
<tr>
<td><?php echo $event['event_id']; ?></td>
<td><?php echo $event['event_name']; ?></td>
<td><?php echo $event['event_description']; ?></td>
<td><?php echo $event['event_presenter']; ?></td>
<td><?php echo $event['event_date']; ?></td>
<td><?php echo $event['event_time']; ?></td>
<td><form action="updateEvent.php" method="post">
<input type="hidden" name="event_id" value="<?php echo $event['event_id'];?>">
<input type="submit" value="UPDATE">
</form></td>
<td><form action="deleteEvent.php" method="post">
<input type="hidden" name="event_id" value="<?php echo $event['event_id'];?>">
<input type="submit" value="DELETE">
</form></td>
</tr>


    <?php } ?>
</table>
    </section>
    </div>




    

    
   
   

</body>
</html>