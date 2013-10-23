<?php

// WP_Testimonial class

final class Testimonials_Widget extends WP_Widget {
	
	function __construct () {
	
		parent::__construct( false, 'Testimonial Widget' );
	
	}
	
	function widget ( $args, $instance ) {
	
		$args = array(
		
			'post_type' => 'testimonial',
			'numberposts' => 1
		
		);
		
		if( is_numeric( $instance['testimonial_id'] ) )
			$args['include'] = $instance['testimonial_id'];
		else
			$args['orderby'] = 'rand';
			
		if( $testimonials = get_posts( $args ) )
			foreach( $testimonials as $testimonial )
				$testimonial = new WP_Testimonial( $testimonial->ID );
				
		$testimonial->render();
	
	}
	
	function update ( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		
		if( !empty( $new_instance['testimonial_id'] ) )
			$instance['testimonial_id'] = $new_instance['testimonial_id'];
			
		return $instance;
	
	}
	
	function form ( $instance ) {

		$defaults = array(
		
			'testimonial_id' => 'random'
		
		);
		
		$instance = wp_parse_args( (array)$instance, $defaults );

		?>
		
		<p>Select a Testimonial to display</p>
		
		<select class="testimonial_widget_select" name="<?php echo $this->get_field_name( 'testimonial_id' ); ?>" style="width:100%;">
		
			<option value="random">Random</option>
		
			<?php if( $testimonials = get_posts( array( 'post_type' => 'testimonial', 'numberposts' => -1 ) ) ) :?>
			
			<?php foreach( $testimonials as $testimonial ): ?>
			<option value="<?php echo esc_attr( $testimonial->ID ); ?>"<?php echo ( $instance['testimonial_id'] == $testimonial->ID ? ' selected="selected"' : NULL ); ?>><?php echo $testimonial->post_title; ?></option>
			<?php endforeach; ?>
			
			<?php endif; ?>
			
		</select>
		
		<br /><br />
		
		<!--
		<div class="testimonial_random_category">
		
			<p>Get random testimonial from category</p>
			
			<?php if( $categories = get_terms( 'testimonial_category', array( 'hide_empty' => false ) ) ): ?>
			<select name="<?php echo $this->get_field_name( 'testimonial_random_category' ); ?>" style="width:100%;">
			
				<option value="any">Any</option>
				
				<?php foreach( $categories as $category ): ?>
				<option value="<?php echo $category->slug; ?>"><?php echo $category->name; ?></option>
				<?php endforeach; ?>
			
			</select>
			<?php endif; ?>
		
		</div>-->
		
		<?php
	
	}
	
}

?>