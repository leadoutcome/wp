
function trackLeadEvent(eventName, eventActivity, eventDetails, incScore) {
 
   data = {
		      "action":'leadajaxtracking', // this is the function in your functions.php that will be triggered
		      "activity":eventActivity, 
		      "details": eventDetails,
		      "incScore": incScore
		   };

  jQuery.ajax({
    url: ajax_object.ajaxurl, // this is the object instantiated in wp_localize_script function
    type: 'POST',
    data: data,
    success: function( data ){
      //Do something with the result from server
      //console.log( data );
    }
  });
}