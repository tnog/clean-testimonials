<?php
/*
Shortcode handlers
*/

// Handler for "testimonial" shortcode.
// This shortcode is used to output a single testimonial
function shortcode_testimonial ( $atts ) {
	
	if( !isset( $atts['id'] ) )
		return;
		
	$testimonial = new WP_Testimonial( $atts['id'] );
	$testimonial->render();

}
add_shortcode( 'testimonial', 'shortcode_testimonial' );

// Handler for "testimonials" shortcode.
// This shortcode is used to output multiple testimonials from a testimonial_category term
function shortcode_testimonials ( $atts ) {

	if( !isset( $atts['category'] ) )
		return;
		
	$category = get_term_by( 'id', $atts['category'], 'testimonial_category' );
	
	$args = array(
	
		'numberposts' => -1,
		'post_type' => 'testimonial',
		'testimonial_category' => $category->slug
	
	);
	
	if( $testimonials = get_posts( $args ) ) {
	
		foreach( $testimonials as &$testimonial ) {
		
			$testimonial = new WP_Testimonial( $testimonial->ID );
			$testimonial->render();
		
		}	
		
	}

}
add_shortcode( 'testimonials', 'shortcode_testimonials' );

// Handler for "testimonial-submission-form" shortcode
// This shortcode outputs a form which visitors can use to submit a testimonial
function shortcode_testimonial_submission ( $atts ) {

	

}
add_shortcode( 'testimonial-submission-form', 'shortcode_testimonial_submission' );

?>