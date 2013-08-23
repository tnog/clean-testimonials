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
			$this->website = $meta['testimonial_client_website'][0];
			
		}
	
	}
	
	public function render () { ?>
	
		<div class="single-testimonial">
	
			<h3><?php echo $this->post_title; ?></h3>
			
			<?php echo $this->post_content; ?>
			
			<h5><?php echo $this->client; ?>,</h5>
			<h6><?php echo $this->company; ?></h6>
		
		</div>
		
		<?php
	
	}
	
	public static function get_instance ( $post_id ) {
	
		return WP_Post::get_instance( $post_id );
	
	}
	
}

?>