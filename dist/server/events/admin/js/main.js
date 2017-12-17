$(document).ready(function(){

      
    // Modal
    $(".openModal").on("click", function(e) 
    {
    	e.preventDefault();
    
    	$(".modal").modal("show");
	    
    });
    
    
    $( "#eventDateTime, #promoStartDateTime, #promoEndDateTime " ).datetimepicker(
		{
			showOn: "button",
			buttonImage: "img/calendar.gif",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd",
			timeFormat: "hh:mm:ss"
		});
  
  
});

