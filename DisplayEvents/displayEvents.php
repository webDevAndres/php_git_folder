<?php
	//Get the Event data from the server.
		include 'connectPDO.php';
	
	//get all events
	$queryAllEvents = 'SELECT *,DATE_FORMAT(event_day,"%m-%d-%Y") AS formattedDate FROM wdv341_events';
	$stmt = $conn->prepare($queryAllEvents);
	$stmt->execute();
	$events = $stmt->fetchAll();
	$stmt->closeCursor();
	$message = "<h1>The following has been found: " .$stmt->RowCount() . " " . "rows</h1>";

	
	

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>WDV341 Intro PHP  - Display Events Example</title>
    <style>
		.header {
			text-align:center;
		}
		.eventBlock{
			width:90%;
			margin-left:auto;
			margin-right:auto;
			background-color:#CCC;	
		}
		
		.displayEvent{
			text_align:left;
			font-size:18px;	
		}
		
		.displayDescription {
			margin-left:100px;
		}
	</style>
</head>

<body>
<div class="header">
<h1>WDV341 Intro PHP</h1>
    <h2>Example Code - Display Events as formatted output blocks</h2>   
    <h3> <?php echo $message; ?> Events are available today.</h3>
</div>
    

<?php
	//Display each row as formatted output
	foreach ($events as $events)	
	//Turn each row of the result into an associative array 
  	{		
		//For each row you have in the array create a block of formatted text
?>
	<p>
        <div class="eventBlock">	
            <div>
            	<span class="displayEvent">Event:</span>
				<?php echo $events['event_name']; ?>

            	<span class="displayDescription">Description:</span>
				<?php echo $events['event_description']; ?> 
            </div>
            <div>
            	Presenter: <?php echo $events['event_presenter']; ?>
            </div>
            <div>
            	<span class="displayTime">Time:</span>
				<?php echo $events['event_time']; ?>
            </div>
            <div>
            	<span class="displayDate">Date:</span>
				<?php echo $events['formattedDate']; ?>
            </div>
        </div>
    </p>

<?php
  	}//close foreach

?>
</div>	
</body>
</html>