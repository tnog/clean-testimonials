<?php

// WP_Testimonial class

final class WP_Testimonial {
	
	/* Members */
	public $client;
	public $company;
	public $email;
	public $website;
	
	// Constructor
	public function __construct ( $post_id = null ) {
	
		if( !is_null( $post_id ) ) {
			
			$testimonial 	= self::get_instance( $post_id );
			$meta 				= get_post_meta( $testimonial->ID, '' );
		
			// Copy WP_Post public members
			foreach( $testimonial as $key => $value )
				$this->$key = $value;
			
			// Assign WP_Testimonial specific members	
			$this->client = $meta['testimonial_client_name'][0];
			$this->company = $meta['testimonial_client_company_name'][0];
			$this->email = $meta['testimonial_client_email'][0];
			$this->website = $meta['testimonial_client_company_website'][0];
			
		}
	
	}
	
	public function render () { ?>
	
		<div class="single-testimonial">
	
			<h3><?php echo $this->post_title; ?></h3>
			
			<blockquote>
				
				<?php if( has_post_thumbnail( $this->ID ) ): $image = wp_get_attachment_image_src( get_post_thumbnail_id( $this->ID ), array( 200, 200 ) ); ?>
				<img style="float: left; padding: 10px;" src="<?php echo $image[0]; ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>" />
				<?php endif; ?>
				
				<?php echo $this->post_content; ?>
				
				
			</blockquote>
			
			<h5>
				
				<?php echo $this->client; ?>,<br /><?php echo $this->company; ?>
				
				<?php if( testimonial_has_permission( $this->ID ) ): ?>
				<?php echo sprintf( '<br />Web: <a href="%s">%s</a>,<br />Email: <a href="mailto:%s">%s</a>', $this->website, $this->website, $this->email, $this->email ); ?>
				<?php endif; ?>
				
			</h5>
			
			<br clear="all" />
		
		</div>
		
		<?php
	
	}
	
	public static function get_instance ( $post_id ) {
	
		return WP_Post::get_instance( $post_id );
	
	}
	
}

?>