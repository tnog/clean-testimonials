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

	if( isset( $_POST['testimonial-postback'] ) ):
	
	
	
	else:
	?>
	
	<form id="add-testimonial" name="add-testimonial" method="POST" action="<?php the_permalink(); ?>">
	
		<label for="title">Testimonial Title (eg, &quot;I'm so super happy!&quot;)</label><br />
		<input type="text" name="testimonial_title" required="required"/><br />
		
		<label for="testimonial">Your Testimonial (be as descriptive as you like here!)</label><br />
		<textarea name="testimonial_description" rows="10" cols="20" required="required"></textarea><br />
		
		<label for="name">Your Name</label><br />
		<input type="text" name="testimonial_client_name" required="required"/><br />
		
		<label for="name">Company Name <em>(optional)</em></label><br />
		<input type="text" name="testimonial_client_company_name" /><br />
		
		<label for="name">Your Email <em>(optional)</em></label><br />
		<input type="text" name="testimonial_client_email" /><br />
		
		<label for="name">Your Website <em>(optional)</em></label><br />
		<input type="text" name="testimonial_client_company_website" /><br />
		
		<!-- hidden postback test field -->
		<input type="hidden" name="testimonial-postback" value="true" />
		
		<input type="submit" id="submit-testimonial" value="Submit Testimonial" />
	
	</form>
	
	<?php
	
	endif;
	
}
add_shortcode( 'testimonial-submission-form', 'shortcode_testimonial_submission' );

?>