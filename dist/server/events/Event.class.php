<?php


include_once("../db.class.php");

/* 
 * TODO
 * 
 * Get Events
 * Display Events
 * A 'Tweet this Event' feature?
 * ADMIN FEATURES: 
 * Edit Event
 * Delete Event
 * Add Events
 * (CRUD)
 * Authentications
 */

class EventController
{
	public $db;
	
	public function __construct()
	{
		$this->db = new DB("nmos_sb", "Warabimochi1");
	}
	
	public function getUpcoming()
	{
		return $this->db->query("SELECT *, DATE_FORMAT(eventDate, '%M %e, %Y, %l:%i%p') as eDate from events WHERE eventDate >= now() ORDER BY eventDate ASC");
	}
	
	public function getPrevious()
	{
		return $this->db->query("SELECT *, DATE_FORMAT(eventDate, '%M %e, %Y, %l:%i%p') as eDate from events WHERE eventDate < now() ORDER BY eventDate ASC");
	}
	
	public function getAll($order = "ASC")
	{
		return $this->db->query("SELECT *, DATE_FORMAT(eventDate, '%M %e, %Y, %l:%i%p') as eDate from events ORDER BY eventDate " . $order);
	}
	
	public function get($id)
	{
		return $this->db->query("SELECT *, DATE_FORMAT(eventDate, '%M %e, %Y, %l:%i%p') as eDate from events WHERE eventID ='".$this->db->res($id)."'");
	}
	
	public function saveEvent()
	{
		// Decide here to create a new event or update an existing event
		
		// If eventID is not blank or less than 1 then run create() else update
		if(!isset($_POST['eventID']) || $_POST['eventID'] < 1 || $_POST['eventID'] === "")
		{
			return $this->create();
		}
		else
		{
			return $this->update();
		}

	}
	
	public function update()
	{
		// If Image has been set, then upload it first, then update the filename
		
		$imageUpdate = "";
		
		if(isset($_FILES['eventImage']['name']) && $_FILES['eventImage']['name'] !=="")
		{
			if($this->saveImage())
			{
				$imageUpdate = ", eventImage ='".$_FILES['eventImage']['name']."'"; 
			}
		}
		 

        //prepare post for db
        foreach($_POST as $key => $val)
        {

            $_POST[$key] = $this->db->res($val);
            
        }
		
		// Query events table for the list of events
            $query = "UPDATE events SET eventTitle='".$_POST['eventTitle']."', eventInfo='".nl2br($_POST['eventInfo'])."', eventPrice='".$_POST['eventPrice']."' ".$imageUpdate." WHERE eventID='".$_POST['eventID']."'"; // TODO remove the FB link field

            
            $result = $this->db->query($query);
            
            return $result;
		
	}
	
	
	public function saveImage()
	{
		
		if(!isset($_FILES['eventImage']['name']) || $_FILES['eventImage']['name'] ==="")
		{
			return false;
		}
	
		$uploaddir = __DIR__ . '../../assets/img/events/';
        $uploadfile = $uploaddir . basename($_FILES['eventImage']['name']);
        $uploaded_size = $_FILES['eventImage']['size'];
        $uploaded_type = $_FILES['eventImage']['type'];
    
        $pos = strpos($uploaded_type,'image');  
                                  
        if($pos === false) 
        {
         	echo "<div class='alert alert-danger'>File is invalid. Only images can be uploaded.</div>";
         	return false;
        }
        else 
        {
            if (move_uploaded_file($_FILES['eventImage']['tmp_name'], $uploadfile)) {
                echo "<div class='alert alert-success'>File is valid, and was successfully uploaded.</div>";
                return true;
            } else {
                echo "<div class='alert alert-danger'>Possible file upload attack! Upload was aborted.</div>";
                return false;
            }

        }

	}
	
	public function create()
	{
		if($_POST)
        {
            $this->saveImage(); // Allow no image?

            //prepare post for db
            foreach($_POST as $key => $val)
            {

                $_POST[$key] = $this->db->res($val);
                
            }

            // Query events table for the list of events
            $query = "INSERT into events VALUES ('','".
                    $_POST['eventTitle']."','".
                    $this->db->res($_FILES['eventImage']['name'])."','".
                    $_POST['eventDateTime']."','".
                    $_POST['eventPrice']."','".
                    nl2br($_POST['eventInfo'])."','')"; // TODO remove the FB link field

            
            $result = $this->db->query($query);
            
            return $result;
          
        }
	}
	
	
	public function delete($id)
	{ 
                            
        return $this->db->query("DELETE FROM events WHERE eventID ='".$this->db->res($id)."'");
       
	}
	
	public function drawForm()
	{
		?>
		<form method="post" id="createEvent" enctype="multipart/form-data" action="" onsubmit="">
                      		
			<p>
				<input  id="eventID" name="eventID" type='hidden' value='' /> 
				
		        <label class='form-label' for="eventTitle">Event Title</label><br />
		  		<input class='form-control' id="eventTitle" name="eventTitle" required value="" title="eventTitle" tabindex="1" type="text" />                     		
	        </p>
	
	        
	        <p>
	            Please specify an image file:<br>
	            <input type="file" class='form-control' name="eventImage" tabindex="2" size="40">
	        </p>
	        
	        <p id='existingImage' class='hidden'>
	        	
	        </p>
	
	        <p>
	        	<label for="eventDateTime">Event Date and Time</label><br />
	        	<div class="form-group">
	                <div class='input-group date' id='eventDateTimePicker'>
	                    <input class='form-control' id="eventDateTime" name="eventDateTime" required value="" title="eventDateTime" tabindex="3" data-date-format="YYYY-MM-DD HH:mm" type="text" />
	                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
	                    </span>
	                </div>
	            </div>
	          
	        </p>
	
	        <p>
	            <label for="eventInfo">Event Information</label><br />
	            <textarea class='form-control' id="eventInfo" name="eventInfo" required tabindex="4" type="eventInfo"></textarea>
	        </p>
	
	        <p>
	            <label for="eventPrice">Event Price</label><br />
	            <input class='form-control' id="eventPrice" name="eventPrice" placeholder="No need for &pound; signs" required value="" title="eventPrice" tabindex="5" type="text" />
	      
	        <input type='submit' name='saveEvent' class='hidden' id='saveEventData' value='Save' />                        
	        
	  </form>
      <?PHP
	}

}