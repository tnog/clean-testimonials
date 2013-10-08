<?php
/*
Shortcode handlers
*/

// Handler for "testimonial" shortcode.
// This shortcode is used to output a single testimonial
function shortcode_testimonial ( $atts ) {
	
	if( !isset( $atts['id'] ) )
		return;
	
	$args = array(
	
		'post_type' => 'testimonial',
		'numberposts' => 1
	
	);
	
	if( is_numeric( $atts['id'] ) )
		$args['include'] = $atts['id'];
	elseif( $atts['id'] == 'random' )
		$args['orderby'] = 'rand';
		
	if( $testimonials = get_posts( $args ) ) {
	
		$output = '';
		ob_start();
		
		foreach( $testimonials as $testimonial ) {
		
			$testimonial = new WP_Testimonial( $testimonial->ID );
			$testimonial->render();
		
		}
		
		$data = ob_get_contents();
		ob_end_clean();
		
		return $data;
		
	}

}
add_shortcode( 'testimonial', 'shortcode_testimonial' );

// Handler for "testimonials" shortcode.
// This shortcode is used to output multiple testimonials from a testimonial_category term
function shortcode_testimonials ( $atts ) {

	$args = array(
	
		'posts_per_page' => 2,
		'paged' => get_query_var( 'paged' ),
		'post_type' => 'testimonial',
	);
	
	if( isset( $atts['category'] ) ) {
		
		$category = get_term_by( 'id', $atts['category'], 'testimonial_category' );	
		$args['testimonial_category'] = $category->slug;
	
	}
	
	if( query_posts( $args ) ) {

		if( have_posts() ) {
		
			echo '<div class="testimonial-category">';
			
			while( have_posts( ) ) {
			
				the_post();
				
				$testimonial = new WP_Testimonial( get_the_ID() );
				$testimonial->render();
			
			}
			
			if( function_exists( 'wp_paginate' ) ) {
			
				wp_paginate();
				
			}
			else {
			
				global $wp_query;
				
				echo paginate_links( array(
					'base' => str_replace( 99999999, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format' => '?paged=%#%',
					'current' => max( 1, get_query_var('paged') ),
					'total' => $wp_query->max_num_pages
				) );
			
			}
		
			echo '</div>';
		
		}
		
		wp_reset_query();
		
	}

}
add_shortcode( 'testimonials', 'shortcode_testimonials' );

// Handler for "testimonial-submission-form" shortcode
// This shortcode outputs a form which visitors can use to submit a testimonial
function shortcode_testimonial_submission ( $atts ) {

	if( isset( $_POST['testimonial-postback'] ) && wp_verify_nonce( $_POST['testimonial_nonce'], 'add-testimonial' ) ):
	
		// Require WordPress core functions we require for file upload
		if( !function_exists( 'media_handle_upload' ) ) {
		
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			require_once( ABSPATH . 'wp-admin/includes/media.php' );
			
		}
		
		// Build post array object
		$post = array(
			
			'ID' => NULL,
			'post_content' => apply_filters( 'the_content', esc_textarea( $_POST['testimonial_description'] ) ),
			'post_name' => '',
			'post_type' => 'testimonial',
			'post_status' => 'draft',
			'post_title' => $_POST['testimonial_title']
		
		);
		
		// Insert new testimonial, if successful, update meta data
		if( $post_id = wp_insert_post( $post, false ) ) {
		
			update_post_meta( $post_id, 'testimonial_client_name', sanitize_text_field( $_POST['testimonial_client_name'] ) );
			update_post_meta( $post_id, 'testimonial_client_company_name', sanitize_text_field( $_POST['testimonial_client_company_name'] ) );
			update_post_meta( $post_id, 'testimonial_client_email', sanitize_email( $_POST['testimonial_client_email'] ) );
			update_post_meta( $post_id, 'testimonial_client_company_website', esc_url( $_POST['testimonial_client_company_website'] ) );
			update_post_meta( $post_id, 'testimonial_client_permission', $_POST['permission'] == '' ? 'no' : sanitize_text_field( $_POST['permission'] ) );
			
			// If thumbnail has been uploaded, assign as thumbnail
			if( !empty( $_FILES['thumbnail']['tmp_name'] ) )
				if( $attachment_id = media_handle_upload( 'thumbnail', $post_id ) )
					update_post_meta( $post_id, '_thumbnail_id', $attachment_id );
			
			// If a category has been selected, update the object term
			if( '' != $_POST['testimonial_category_group'] )
				wp_set_object_terms( $post_id, $_POST['testimonial_category_group'], 'testimonial_category' );
			
			echo '<p>We successfully received your testimonial. If approved, it will appear on our website. Thank you!</p>';						
		
		}
		else {
		
			echo '<p class="error">Sorry, but there was a problem with submitting your testimonial. Please try again.</p>';
		
		}
	
	else:
	?>
	
	<script src="<?php echo plugins_url( 'assets/js/validation.js', dirname( __FILE__ ) ); ?>"></script>
	
	<form id="add-testimonial" enctype="multipart/form-data" name="add-testimonial" method="POST" action="<?php the_permalink(); ?>">
	
		<label for="testimonial_title">Testimonial Title (eg, &quot;I'm so super happy!&quot;)</label><br />
		<input type="text" name="testimonial_title" required="required"/><br />
		
		<label for="testimonial_description">Your Testimonial (be as descriptive as you like here!)</label><br />
		<textarea name="testimonial_description" rows="10" cols="20" required="required"></textarea><br />
		
		<label for="testimonial_category_group">Category (optional)</label><br />
		<select name="testimonial_category_group">
		
			<option value="">None</option>
			
			<?php if( $terms = get_terms( 'testimonial_category', array( 'hide_empty' => false ) ) ): ?>
			
				<?php foreach( $terms as $term ): ?>
				<option value="<?php echo $term->slug; ?>"><?php echo $term->name; ?></option>
				<?php endforeach; ?>
			
			<?php endif; ?>
		
		</select><br />
		
		<label for="testimonial_client_name">Your Name</label><br />
		<input type="text" name="testimonial_client_name" id="testimonial_client_name" required="required"/><br />
		
		<label for="testimonial_client_company_name">Company Name <em>(optional)</em></label><br />
		<input type="text" name="testimonial_client_company_name" id="testimonial_client_company_name" /><br />
		
		<label for="testimonial_client_email">Your Email <em>(optional)</em></label><br />
		<input type="text" name="testimonial_client_email" id="testimonial_client_email" /><br />
		
		<label for="testimonial_client_company_website">Your Website <em>(optional)</em></label><br />
		<input type="text" name="testimonial_client_company_website" id="testimonial_client_company_website" /><br />
		
		<label for="thumbnail">Thumbnail <em>(optional)</em></label><br />
		<input type="file" name="thumbnail" id="thumbnail" /><br />
		
		<label for="permission">Can we display your contact details? (EG, email and website)?</label><br />
		<input type="radio" name="permission" value="no" required="required" />&nbsp;No<br />
		<input type="radio" name="permission" value="yes" required="required" />&nbsp;Yes<br />
		
		<!-- hidden postback test field and nonce -->
		<input type="hidden" name="testimonial-postback" value="true" />
		<input type="hidden" name="testimonial_nonce" value="<?php echo wp_create_nonce( 'add-testimonial' ); ?>" />
		
		<input type="submit" id="submit-testimonial" value="Submit Testimonial" />
	
	</form>
	
	<?php
	
	endif;
	
}
add_shortcode( 'testimonial-submission-form', 'shortcode_testimonial_submission' );

?>