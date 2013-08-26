<?php

// WP_Testimonial class

final class Testimonials_Widget extends WP_Widget {
	
	function __construct () {
	
		parent::__construct( false, 'Testimonial Widget' );
	
	}
	
	function widget ( $args, $instance ) {
	
	
	}
	
	function update ( $new_instance, $old_instance ) {
		
		$instance = array( 'testimonial_id' => 'random' );
		
		if( !empty( $new_instance['testimonial_id'] ) )
			$instance['testimonial_id'] = $new_instance['testimonial_id'];
			
		return $instance;
	
	}
	
	function form ( $instance ) {

		?>
		
		<p>Select a Testimonial to display</p>
		
		<select name="testimonial_id" style="width:100%;">
		
			<option value="random">Random</option>	
		
			<?php if( $testimonials = get_posts( array( 'post_type' => 'testimonial', 'numberposts' => -1 ) ) ) :?>
			
			<?php foreach( $testimonials as $testimonial ): ?>
			<option value="<?php echo $testimonial->ID; ?>"<?php echo ( $instance['testimonial_id'] == $testimonial->ID ? ' selected="selected"' : NULL ); ?>><?php echo $testimonial->post_title; ?></option>
			<?php endforeach; ?>
			
			<?php endif; ?>
			
		</select>
		
		<?php
	
	}
	
}

?>