<?PHP

session_start();

include_once(__DIR__ . "/../header.html");
include_once(__DIR__ . "/../nav.php");

// Auth
include_once(__DIR__ . "/../../../auth.class.php");

$nav = new Nav("events");

echo $nav->bar();


if(!Auth::sessionCheck())
{
	Auth::drawAuthForm();

	include(__DIR__ . "/../footer.html");

	exit();
}

// Event Class
include_once(__DIR__ . "/../../Event.class.php");

$eventController = new EventController();


// Is there post data here?

// AUTH NEEDS TO HAPEN BEFORE ALL THIS

if(isset($_GET['del']))
{
	if(!$eventController->delete($_GET['del']))
	{
		echo "<div class='alert alert-danger'>Unable to delete, something went wrong: ".$eventController->db->error()."</div>";
	}
}
else if(isset($_POST['saveEvent']))
{
	if(!($eventController->saveEvent()))
	{
		echo "<div class='alert alert-danger'>Unable to save, something went wrong: ".$eventController->db->error()."</div>";
	}
}

$events = $eventController->getAll("DESC");

?>

<!-- Modal for events -->

<div id='eventModal' class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Event</h4>
      </div>
      <div class="modal-body">
        <?PHP $eventController->drawForm(); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id='saveEvent' class="btn btn-primary">Save Changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="col-md-10 col-md-offset-1">

<legend>Event Manager</legend>

	<div class="panel panel-default admin-panel">
	  <div class="panel-heading">
	    <h3 class="panel-title">Current Events</h3>
	  </div>
	  <div class="panel-body">
	    <button role="button" id='addEvent' class='btn btn-primary'>Add New Event</button>
	  </div>

	<div class='panelTable'>
		<table class='table table-striped'>
		<thead>
			<th>Date</th>
			<th>Title</th>
			<th>Description</th>
			<th>Price</th>
			<th>Actions</th>
		</thead>
		<tbody>
			<?PHP

		if($events->num_rows > 0)
		{

			while($event = $events->fetch_object())
			{

				?>

				<tr class='openEvent' data-eventImage='<?PHP echo $event->eventImage; ?>' id='event-<?PHP echo $event->eventID; ?>'>
					<td data-dbDate='<?PHP echo $event->eventDate; ?>' class='eventDateData'><?PHP echo $event->eDate; ?></td>
					<td class='eventTitle'><?PHP echo $event->eventTitle; ?></td>
					<td class='eventInfoData'><?PHP echo $event->eventInfo; ?></td>
					<td class='eventPriceData'><?PHP echo $event->eventPrice; ?></td>
					<td><button type="button" class="close deleteEvent" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></td>
				</tr>


				<?PHP

			}


		}
		else
		{
			?>
				<tr><td colspan="4">No Events found</td></tr>
			<?PHP
		}

		?>
		</tbody>
		</table>
	</div>
	</div>
</div>


<script>

	$("#addEvent").on("click", function()
	{
		clearModal();

		$("#eventModal").modal("show");
	});

	$("#eventDateTimePicker").datetimepicker();

	$(".deleteEvent").on("click", function(e)
	{
		e.stopPropagation();
		window.event.cancelBubble = true;

		// Delete this ID
		var id = $(this).closest("tr").attr("id").split("-")[1];

		var row = $(this).closest("tr");

		$.get("/server/events/admin/lib/admin.php",{del: id}, function(resp)
		{
			// Delete the row
			row.remove();
		});
	});

	$('#saveEvent').on("click", function()
	{
		$('#saveEventData').trigger("click");
	});

	$(".openEvent").on("click", function()
	{

		clearModal();


		// Open the Modal and load in all the information required using this table row
		var id = $(this).attr("id").split("-")[1];
		var eventImage = $(this).attr("data-eventImage");
		var eventTitle = $(this).find('.eventTitle').text();
		var eventDate = $(this).find(".eventDateData").attr("data-dbDate");
		var eventPrice = $(this).find('.eventPriceData').text();
		var eventInfo = $(this).find('.eventInfoData').text();

		// Update the Modal (with the eventID being valid, this should proc the update instead of create()

		$("#eventID").val(id);
		$("#eventTitle").val(eventTitle);
		$("#eventInfo").val(eventInfo);
		$("#eventDateTime").val(eventDate);
		$("#eventPrice").val(eventPrice);

		$("#existingImage img").remove();
		$("#existingImage").append("<img src='/assets/img/events/"+eventImage+"' />");
		$("#existingImage").removeClass("hidden");


		$("#eventModal").modal("show");
	});

	// Delete

	// Modal Functions

	function clearModal()
	{
		$("#eventID").val("");
		$("#eventTitle").val("");
		$("#eventInfo").val("");
		$("#eventDateTime").val("");
		$("#eventPrice").val("");

		$("#existingImage").addClass("hidden");
		$("#existingImage img").remove();
	}



</script>



<?PHP

include(__DIR__ . "/../footer.html");

?>
