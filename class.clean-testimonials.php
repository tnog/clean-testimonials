<?php

// Core class for plugin functionality

final class Plugify_Clean_Testimonials {

	public function __construct () {

		// Register actions
		add_action( 'init', array( __CLASS__, 'init' ) );
		add_action( 'admin_init', array( __CLASS__, 'admin_init' ) );
		add_action( 'widgets_init', array( __CLASS__, 'widgets_init' ) );
		add_action( 'wp_insert_post', array( __CLASS__, 'insert_testimonial' ), 10, 1 );
		add_action( 'manage_posts_custom_column', array( __CLASS__, 'testimonial_column' ), 10, 2 );

		// Filters for testimonial post type columns
		add_filter( 'manage_edit-testimonial_columns', array( __CLASS__, 'testimonial_columns' ), 5 );
		add_filter( 'manage_edit-testimonial_sortable_columns', array( __CLASS__, 'testimonial_sortable_columns' ), 5 );

		// Filter for testimonial category taxonomy columns
		add_filter( 'manage_edit-testimonial_category_columns', array( __CLASS__, 'testimonial_taxonomy_columns' ) );
		add_filter( 'manage_testimonial_category_custom_column', array( __CLASS__, 'testimonial_taxonomy_column' ), 10, 3 );

		// Install tasks
		register_activation_hook( trailingslashit( dirname( __FILE__ ) ) . 'init.php', array( &$this, 'install' ) );

	}

	public static function install () {

		// Store timestamp of when activation occured
		update_option( 'ct_activated', time() );

	}

	public static function init () {

		/*≈=====≈=====≈=====≈=====≈=====≈=====≈=====
		Testimonial Post Type
		≈=====≈=====≈=====≈=====≈=====≈=====≈=====*/
		// Setup core dependencies
		$post_type_labels = array(
			'name' => _x( 'Testimonials', 'post type general name' ),
			'singular_name' => _x( 'Testimonial', 'post type singular name' ),
			'add_new' => _x( 'Add New', 'testimonial item' ),
			'add_new_item' => __( 'Add New Testimonial' ),
			'edit_item' => __( 'Edit Testimonial' ),
			'new_item' => __( 'New Testimonial' ),
			'view_item' => __( 'View Testimonial' ),
			'search_items' => __( 'Search Testimonials' ),
			'not_found' =>  __( 'No Testimonials found' ),
			'not_found_in_trash' => __( 'No Testimonials found in the trash' ),
			'parent_item_colon' => ''
		);

		// Register the post type
		register_post_type( 'testimonial',
			array(
				 'labels' => $post_type_labels,
				 'singular_label' => _x( 'Testimonial', 'post type singular label' ),
				 'public' => true,
				 'show_ui' => true,
				 '_builtin' => false,
				 '_edit_link' => 'post.php?post=%d',
				 'capability_type' => 'post',
				 'hierarchical' => false,
				 'rewrite' => array( 'slug' => 'testimonial' ),
				 'query_var' => 'testimonial',
				 'supports' => array( 'title', 'editor', 'thumbnail' ),
				 'menu_position' => 5
			)
		);

		/*≈=====≈=====≈=====≈=====≈=====≈=====≈=====
		Testimonial Taxonomy
		≈=====≈=====≈=====≈=====≈=====≈=====≈=====*/
		// Register and configure Testimonial Category taxonomy
		$taxonomy_labels = array(
			'name' => _x( 'Testimonial Categories', 'taxonomy general name' ),
			'singular_name' => _x( 'Testimonial Category', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search Testimonial Categories' ),
			'all_items' => __( 'All Testimonial Categories' ),
			'parent_item' => __( 'Parent Testimonial Categories' ),
			'parent_item_colon' => __( 'Parent Testimonial Category' ),
			'edit_item' => __( 'Edit Testimonial Category' ),
			'update_item' => __( 'Update Testimonial Category' ),
			'add_new_item' => __( 'Add New Testimonial Category' ),
			'new_item_name' => __( 'New Testimonial Category' ),
			'menu_name' => __( 'Categories' )
	  );

		register_taxonomy( 'testimonial_category', 'testimonial', array(
				'hierarchical' => true,
				'labels' => $taxonomy_labels,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'testimonials' )
			)
		);

		// Ensure jQuery is enqueued
		wp_enqueue_script( 'jquery' );

		// Enqueue admin scripts
		if( is_admin() )
			wp_enqueue_script( 'ct_scripts', plugins_url( 'assets/js/scripts.js', __FILE__ ), array( 'jquery' ) );

	}

	public static function admin_init () {

		add_meta_box( 'testimonial-details', 'Client Details', array( __CLASS__, 'testimonial_metabox' ), 'testimonial', 'normal', 'core' );

	}

	public static function widgets_init () {

		register_widget( 'Testimonials_Widget' );

	}

	public static function testimonial_columns ( $columns ) {

		unset( $columns['date'] );
		$columns['testimonial_client_name'] = 'Client';
		$columns['testimonial_client_company_name'] = 'Company';
		$columns['testimonial_category'] = 'Category';
		$columns['testimonial_shortcode'] = 'Shortcode';
		$columns['testimonial_thumbnail'] = 'Thumbnail';

		$columns['date'] = 'Date';

		return $columns;

	}

	public static function testimonial_sortable_columns ( $columns ) {

		$columns['testimonial_client_name'] = 'testimonial_client';
		$columns['testimonial_client_company_name'] = 'testimonial_client_company_name';

		return $columns;

	}

	public static function testimonial_column ( $column, $post_id ) {

		global $post;

		if( $post->post_type != 'testimonial' )
			return;

		switch( $column ) {

			case 'testimonial_category':

				$list = get_the_term_list( $post->ID, 'testimonial_category', null, ', ', null );
				echo $list == '' ? '<em>N/A</em>' : $list;

				break;

			case 'testimonial_shortcode':
				echo sprintf( '[testimonial id="%s"]', $post->ID );
				break;

			case 'testimonial_thumbnail':

				if( has_post_thumbnail( $post->ID ) )
					echo wp_get_attachment_image( get_post_thumbnail_id( $post->ID ), array( 64, 64 ) );
				else
					echo 'No thumbnail supplied';

				break;

			default:

				$value = get_post_meta( $post->ID, $column, true );
				echo $value == '' ? '<em>N/A</em>' : $value;

		}

	}

	public static function testimonial_taxonomy_columns ( $columns ) {

		return array(

			'cb' => '<input type="checkbox" />"',
			'name' => 'Name',
			'shortcode' => 'Shortcode',
			'slug' => 'Slug',
			'posts' => 'Testimonials'

		);

	}

	public static function testimonial_taxonomy_column ( $out, $column_name, $id ) {

		if( $column_name == 'shortcode' )
			return sprintf( '[testimonials category="%s"]', $id );

	}

	public static function testimonial_metabox ( $post ) {

		global $post;

		// Display Client Details form
		?>

		<table class="testimonial-client-details">

			<tr>
				<td valign="middle" align="left" width="125"><label for="testimonial_client_name">Client Name</label></td>
				<td valign="middle" align="left" width="150"><input type="text" name="testimonial_client_name" value="<?php echo esc_attr( get_post_meta( $post->ID, 'testimonial_client_name', true ) ); ?>" />
				<td valign="middle" align="left"><em>The name of the client giving this testimonial</em></td>
			</tr>
			<tr>
				<td valign="middle" align="left"><label for="testimonial_client_company_name">Company Name</label></td>
				<td valign="middle" align="left"><input type="text" name="testimonial_client_company_name" value="<?php echo esc_attr( get_post_meta( $post->ID, 'testimonial_client_company_name', true ) ); ?>" />
				<td valign="middle" align="left"><em>The company which this client represents</em></td>
			</tr>
			<tr>
				<td valign="middle" align="left"><label for="testimonial_client_email">Email</label></td>
				<td valign="middle" align="left"><input type="text" name="testimonial_client_email" value="<?php echo esc_attr( get_post_meta( $post->ID, 'testimonial_client_email', true ) ); ?>" />
				<td valign="middle" align="left"><em>Contact email address of whom is giving the testimonial</em></td>
			</tr>
			<tr>
				<td valign="middle" align="left"><label for="testimonial_client_website">Website</label></td>
				<td valign="middle" align="left"><input type="text" name="testimonial_client_company_website" value="<?php echo esc_attr( get_post_meta( $post->ID, 'testimonial_client_company_website', true ) ); ?>" />
				<td valign="middle" align="left"><em>Website of whom is giving the testimonial</em></td>
			</tr>

		</table>

		<?php

	}

	public static function insert_testimonial ( $post_id ) {

		global $post;

		if( ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || ( isset( $_GET['action'] ) && $_GET['action'] == 'trash' ) )
			return;

		if( @$post->post_type != 'testimonial' )
			return;

		foreach( $_POST as $key => $value )
			if( strpos( $key, 'testimonial_' ) === 0 )
				update_post_meta( $post_id, $key, sanitize_text_field( $value ) );

	}

}

?>
