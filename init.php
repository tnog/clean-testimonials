<?php
/*
Plugin Name: Clean Testimonials
Plugin URI: http://www.plugify.com.au/plugin/simple-testimonials
Description: Allows you to easily and quickly add Testimonials to your WordPress website
Author: Luke Rollans
Version: 1.0
Author URI: http://www.lukerollans.me
*/

$path = trailingslashit( dirname( __FILE__ ) );

// Ensure the Post Navigator class has been defined
if( !class_exists( 'Plugify_Clean_Testimonials' ) )
require_once( $path . 'class.clean-testimonials.php' );

if( !class_exists( 'WP_Testimonial' ) )
require_once( $path . 'class.wp-testimonial.php' );

require_once( $path . 'lib/functions.php' );
require_once( $path . 'lib/shortcodes.php' );

new Plugify_Clean_Testimonials();

?>