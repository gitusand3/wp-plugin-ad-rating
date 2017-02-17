<?php
/*
Plugin Name: AD Ratings
Plugin URI:  https://developer.wordpress.org/plugins/the-basics/
Description: Basic WordPress Plugin Header Comment
Version:     1.0
Author:      WordPress.org
Author URI:  https://developer.wordpress.org/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wporg
Domain Path: /languages
*/

/**
 * Security
 * prevent direct access to file
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


/**
 * Translations
 */
load_plugin_textdomain('your-unique-name', false, basename( dirname( __FILE__ ) ) . '/languages' );











// http://localhost/sites/wordpress/wp-make-plugin-ad-ratings/wp-content/plugins/ad-ratings/
define('AD_RATINGS_ROOT_URI', plugin_dir_url( __FILE__ ) );


/**
 * https://github.com/gjunge/rateit.js
 * http://gjunge.github.io/rateit.js/examples/
 */


// Register Style
function ad_ratings_custom_styles() {

	wp_register_style( 
		'ad-ratings-rateit', 
		AD_RATINGS_ROOT_URI . 'scripts/rateit-js/rateit.css', 
		false, // deps
		null // version
		);
	wp_enqueue_style( 'ad-ratings-rateit' );

	wp_register_style( 
		'ad-ratings-custom-frontend', 
		AD_RATINGS_ROOT_URI . 'css/custom-frontend.css', 
		array('ad-ratings-rateit'), // deps
		null // version
		);
	wp_enqueue_style( 'ad-ratings-custom-frontend' );

}
add_action( 'wp_enqueue_scripts', 'ad_ratings_custom_styles' );




// Register Script
function ad_ratings_custom_scripts() {

	wp_register_script( 
		'ad-ratings-rateit', 
		AD_RATINGS_ROOT_URI . 'scripts/rateit-js/jquery.rateit.min.js', 
		array('jquery'), // deps 
		false, // ver
		false // in_footer
		);

	wp_enqueue_script( 
		'ad-ratings-rateit'
		);

	wp_register_script( 
		'ad-ratings-custom-frontend', 
		AD_RATINGS_ROOT_URI . 'js/custom-frontend.js', 
		array('jquery','ad-ratings-rateit'), // deps 
		false, // ver
		false // in_footer
		);

	wp_enqueue_script( 
		'ad-ratings-custom-frontend'
		);


}
add_action( 'wp_enqueue_scripts', 'ad_ratings_custom_scripts' );







/**
 * Register a custom menu page.
 */
function ad_ratings_add_menu_pages() {
    add_menu_page(
        __( 'AD Ratings', 'textdomain' ), // page_title
        'Ratings', // menu_title
        'manage_options',
        'ad-ratings', // menu_slug
        'ad_ratings_add_menu_pages_cb', // function
        plugins_url( 'ad-ratings/images/star-16 16.png' ),
        6 // position
    );


    add_submenu_page( 
				'ad-ratings',  // parent_slug
				'AD Ratings Settings', // page_title
				'Settings', // menu_title
				'manage_options', // capability
				'ad-ratings-settings', // menu_slug
				'ad_ratings_add_submenu_page_settings_cb'
    );


}
add_action( 'admin_menu', 'ad_ratings_add_menu_pages' );

/**
 * Plugin index page
 * callback
 */
function ad_ratings_add_menu_pages_cb(){
	require_once('first-page.php');
}


/**
 * settings page
 * callback
 */
function ad_ratings_add_submenu_page_settings_cb(){
	require_once('settings.php');
}




add_filter( 'the_content', 'ad_ratings_display' );
function ad_ratings_display( $content ){
	$rating = '
<div class="rateit readonly" data-productid="7" data-rateit-value="2.5" data-rateit-min="0" data-rateit-max="5"></div>

<div class="hover-output">2.5 stars out of 5</div>


	';

	$content = $rating . $content;

	return $content;
}






	//	AD_RATINGS_ROOT_URI . 'js/custom-ajax-frontend.js', 

/**
 * ajax
 * https://pippinsplugins.com/process-ajax-requests-correctly-in-wordpress-plugins/
 * https://premium.wpmudev.org/blog/using-ajax-with-wordpress/
 * https://www.sitepoint.com/adding-ajax-to-your-wordpress-plugin/
 * http://www.makeuseof.com/tag/tutorial-ajax-wordpress/
 */

/**
 * pass data to JS file
 */
function ad_ratings_ajax_load_scripts() {
    // load our jquery file that sends the $.post request
    wp_enqueue_script( 
    	"ad-ratings-ajax-handle", // handle
    	AD_RATINGS_ROOT_URI . 'js/custom-frontend-ajax.js', 
    	array( 'jquery' ) 
    );
 
    // make the ajaxurl var available to the above script
    wp_localize_script( 
        'ad-ratings-ajax-handle', // handle
        'the_ajax_script', // The name of the variable which will contain the data
        array( 
        	'ajaxurl' => admin_url( 'admin-ajax.php' ) 
        ) // The data itself
    );  
}
add_action('wp_print_scripts', 'ad_ratings_ajax_load_scripts');



/**
 * receive data to JS file and echo/send back the db response to ajax dile, for display
 */
function ad_ratings_ajax_process_request() {
    global $wpdb; // this is how you get access to the database

    $postID = $_POST["postID"];
    $theRating = $_POST["theRating"];

    // send the response back to the front end
    $response = $postID . " - " . $theRating;
    echo $response;

    // send the response back to the front end
    // $response = $like_user_id . " - " . $like_post_id;
    // echo $response;
    die();
}
add_action('wp_ajax_ACTION_ad_ratings_response', 'ad_ratings_ajax_process_request');
add_action('wp_ajax_nopriv_ACTION_ad_ratings_response', 'ad_ratings_ajax_process_request');



