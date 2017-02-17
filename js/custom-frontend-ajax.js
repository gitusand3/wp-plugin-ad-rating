jQuery(document).ready( function($) {

	/**
	* ajax
	* https://pippinsplugins.com/process-ajax-requests-correctly-in-wordpress-plugins/
	*/	
	$(document).on('click', ".rateit", function() {

		var postID = $(this).data('productid');
		var theRating = $(this).rateit('value');


		var data = {
			'action': 'ACTION_ad_ratings_response',
			'postID': postID,
			'theRating': theRating
		};
		// the_ajax_script.ajaxurl is a variable that will contain the url to the ajax processing file
	 	$.post(
	 		the_ajax_script.ajaxurl, 
	 		data, 
	 		function(response) {
	 			if ( postID > 0 ) {
	 				console.log("ajax says: " + response);
	 			} else {
	 				return false;
	 			}
	 		}
	 	);
	 	return false;
	});
});

