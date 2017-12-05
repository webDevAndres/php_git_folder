<?php
//controller
//gathers data from database table
//formats data into presentation format on browser
class TableRows extends RecursiveIteratorIterator
{

    function __construct($it)
    {
        parent::__construct($it, self::LEAVES_ONLY);
    }

    function current()
    {
        return "<td>" . parent::current(). "</td>";
    }

    function beginChildren()
    {
        echo "<tr>";
    }

    function endChildren()
    {
        echo "</tr>" . "\n";
    }
}
//connects to database
include 'connectPDO.php';


$stmt = $conn->prepare("SELECT event_id,event_name,event_description,event_presenter,event_date, event_time FROM wdv341_event LIMIT 1");
$stmt->execute();


// set the resulting array to associative
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);







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
       border-right: .5px solid black;
       border-bottom: .5px solid black;
       width:150px;
       
    }
    
    </style>
</head>
<body>
<div class="container">
    <h1>The following information has been found:</h1>
    <section id="content">
    <?php
    echo "<table class='tableFormat'>";
    echo
    "<tr><th>event_id</th>
    <th>event_name</th>
    <th>event_description</th>
    <th>event_presenter</th>
    <th>event_date</th>
    <th>event_time</th>
   </tr>";
    foreach (new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k => $v) {
        echo $v;
    }
    $conn = null;
    echo "</table>";
?>

    </section>
    </div>
</body>
</html>
