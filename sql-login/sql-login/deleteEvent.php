<?php
session_start();

if($_SESSION['validUser'] == "yes") {
	include 'connectPDO.php';

	$event_id = filter_input(INPUT_POST, 'event_id',FILTER_VALIDATE_INT);

	//delete the product from the database
	if($event_id != false){
		$query = 'DELETE FROM wdv341_event WHERE event_id = :event_id';
		$stmt = $conn->prepare($query);
		$stmt->bindValue(':event_id',$event_id);
		$success = $stmt->execute();
		$stmt->closeCursor();
		
	}
	//display the events page
	include('selectEvents.php');


	

	

} // end valid user check
else {
	//Invalid User attempting to access this page. Send person to Login Page
	header('Location: login.php');
}

	


?>
