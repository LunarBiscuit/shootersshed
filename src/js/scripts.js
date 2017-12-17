(function ($, window, document, undefined) {

  'use strict';


  //  Helpers

  const eventRenderer = function(key, event) {
    return "<div class='event-container' id='event-" + key + "'>" + 
    "<div class='visualContainer'>" +
      "<div class='eventImage' style='background-image: url(\"/assets/img/events/"+event.eventImage +"\")'></div>" +
    "</div>" +
    "<div class='detailContainer'>" +
        "<div class='eventTitle'><h1>" + event.eventTitle + "</h1></div>" +
        "<div class='eventDate'>" + event.eDate + "</div>" + 
        "<div class='eventInfo'>" + event.eventInfo + "</div>" +  
      "</div>" +
      "<div class='eventFooter'>" +
        "<div class='eventPrice'>ENTRY: " + event.eventPrice + "</div>" +
      "</div>" +
    "</div>";
  }

  // End Helpers

  $(function () {
    // Load in events from the API
    if($('#event-list').is(":visible")) {
      // Loading message
      $('#event-list').html('Loading events...');

      // AJAX to grab the events JSON from server
      $.getJSON('/server/events/getEvents.php', function(events) {
        $('#event-list').html('');
        var items = [];

        if(!events.length) {
          $('#event-list').html("<div class='eventContainer noEvents col-xs-12'>There are currently no upcoming events.</div>");
          return false;
        }

        var items = [];
        $.each( events, function( key, val ) {
          items.push( eventRenderer(key, val) );
        });
       
        $( "<div/>", {
          "class": "event-items",
          html: items.join( "" )
        }).appendTo( "#event-list" );

      })
    }
  });

  $(function () {
    // Future ASYNC - Load in gallery from the API
  });

})(jQuery, window, document);
