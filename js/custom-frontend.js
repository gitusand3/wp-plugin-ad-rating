jQuery(document).ready(function($){




$(".rateit").bind(
							'over', 
							function (event, value) { 
								if ( value !== null ) {
									$('.hover-output').css("display","inline-block").text(value + " stars out of 5");
								} else {
									$('.hover-output').text(" ");
								}
							}
						);

$(".rateit").bind(
							'rated', 
							function (event, value) { 
								if ( value !== null ) {
									$('.hover-output').text('You\'ve rated it: ' + value);
								} else {
								}
							}
						);





	// $('.rateit').on('click', $(this), function(){

	// 	var ratings = $(this).rateit('value');

	// 	console.log( "xxx " + ratings );

	// });
	


	// $('.rateit').bind('rated reset', function (e) {
	//          var ri = $(this);
	 
	//          //if the use pressed reset, it will get value: 0 (to be compatible with the HTML range control), we could check if e.type == 'reset', and then set the value to  null .
	//          var value = ri.rateit('value');


	//          console.log( "yyy " + value );

	//        });



}); 


