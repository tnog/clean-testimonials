<?php
/*
Plugin Name: Modified Clean Testimonials
Plugin URI: http://noguchi.at
Description: Allows you to easily and quickly add Testimonials to your WordPress website
Author: Takahiro Noguchi modified from Luke Rollan's original code
Version: 9.9.9
Author URI: http://noguchi.at
*/

// Ensure WordPress has been bootstrapped
if( !defined( 'ABSPATH' ) )
	exit;

$path = trailingslashit( dirname( __FILE__ ) );

// Ensure our class dependencies class has been defined
if( !class_exists( 'Testimonials_Widget' ) )
require_once( $path . 'class.testimonials-widget.php' );

if( !class_exists( 'Plugify_Clean_Testimonials' ) )
require_once( $path . 'class.clean-testimonials.php' );

if( !class_exists( 'WP_Testimonial' ) )
require_once( $path . 'class.wp-testimonial.php' );

require_once( $path . 'lib/functions.php' );
require_once( $path . 'lib/shortcodes.php' );

// Boot Clean Testimonials
new Plugify_Clean_Testimonials();

?>
