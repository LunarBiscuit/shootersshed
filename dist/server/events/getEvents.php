<?PHP
include_once("./Event.class.php");
// Return json for the events list in order

$eventController = new EventController();

$events = $eventController->getUpcoming();

$payload = [];

while($event = $events->fetch_object())
{
    array_push($payload, $event);
}



echo json_encode($payload);
?>