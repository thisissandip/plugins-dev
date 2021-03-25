<?php

namespace Inc\Base;

use \Inc\Base\BaseController;

class TestimonialController extends BaseController {

    public $isActivated;
    
    public function register(){

        $this->isActivated = get_option( "testimonial_manager");

        if($this->isActivated == 1){
            /* register a cpt testimonial */
            add_action( "init", array($this, "Register_Testimonial_CPT") );
            /* Add meta box for this CPT Testimonial */
            add_action( "add_meta_boxes",array($this, "add_meta_boxes")  );
            /* Add save action hook to save the Meta Box changes */
            add_action( "save_post", array($this, "save_details"));
            /* Create Custom Columns For the CPT Testimonial */
            add_action( 'manage_testimonial_posts_columns', array( $this, 'set_custom_columns' ) );
            /* After creating Custom Columns Fill the data for the columns */
            add_action( 'manage_testimonial_posts_custom_column', array( $this, 'set_custom_columns_data' ), 10, 2 );
            /* Sort the Columns As Preffered with Custom Columns */
            add_filter( 'manage_edit-testimonial_sortable_columns', array( $this, 'set_custom_columns_sortable' ) );
            
            /* Add ShortCode For Form */
            add_shortcode( "sandip-my-form", array($this, "GetmyForm") );

            /* Add ShortCode For Slider */
            add_shortcode( "sandip-my-slider", array($this, "showMySlider") );

            /* Ajax Requests */
            add_action( "wp_ajax_testimonial_form", array($this, "submitTestimonialForm") );
            add_action( "wp_ajax_nopriv_testimonial_form", array($this, "submitTestimonialForm") );
        }

    }

    public function Register_Testimonial_CPT(){
		$labels = array(
			'name' => 'Testimonials',
			'singular_name' => 'Testimonial'
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'has_archive' => false,
			'menu_icon' => 'dashicons-testimonial',
			'exclude_from_search' => true,
			'publicly_queryable' => false,
			'supports' => array( 'title', 'editor' )
		);

        register_post_type( "testimonial", $args );
    }

    public function add_meta_boxes(){
        add_meta_box( "testimonial_author", $title= "Testimonial Options", 
        $callback = array($this, "render_author_meta_box") , $screen = "testimonial", 
        $context = "side", $priority = "default" );
    }

   /*  Create the display / Form of the Meta Box Set all the nonce field and Keys of Meta Post Type */
    public function render_author_meta_box($post){
        wp_nonce_field( "sandip_testimonial", "sandip_testimonial_nonce" );

        $data = get_post_meta( $post->ID, "_sandip_testimonial_key", true );
        $name = isset($data["name"]) ? $data["name"] : "";
        $email = isset($data["email"]) ? $data["email"] : "";

        ?>
        <p>
            <label class="meta-label" for="sandip_testimonial_author">Author Name</label>
            <input type="text" id="sandip_testimonial_author" name="sandip_testimonial_author" class="widefat" value="<?php echo esc_attr( $name ); ?>">
        </p>
        <p>
            <label class="meta-label" for="sandip_testimonial_email">Author Email</label>
            <input type="email" id="sandip_testimonial_email" name="sandip_testimonial_email" class="widefat" value="<?php echo esc_attr( $email ); ?>">
        </p>
    <?php
    }

    /* Method for Saving The Posts */
    public function save_details($post_id){
        // check if the nonce field is set
		if (! isset($_POST['sandip_testimonial_nonce'])) {
			return $post_id;
		}

        // If it is set, Verify the Nonce
		$nonce = $_POST['sandip_testimonial_nonce'];
		if (! wp_verify_nonce( $nonce, 'sandip_testimonial' )) {
			return $post_id;
		}

        /* The save_post hook is triggered while doing autosave too, So to avoid
            unnecessary saves. Check if it is an autosave action
        */
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

        // Check if the current user can edit post for the particular Post ID
		if (! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

        // Update
		$data = array(
			'name' => sanitize_text_field( $_POST['sandip_testimonial_author'] ),
			'email' => sanitize_text_field( $_POST['sandip_testimonial_email'] ),
		);

		update_post_meta( $post_id, '_sandip_testimonial_key', $data );

    }

    /* Set the Custom Columns */
    public function set_custom_columns($columns){
        $title = $columns['title'];
		$date = $columns['date'];
		unset( $columns['title'], $columns['date'] );

		$columns['name'] = 'Author Name';
        $columns['author_email'] = 'Author Email';
		$columns['title'] = $title;
		$columns['date'] = $date;

		return $columns;
    }

    /* Fill the data for the Custom Columns, It will loop through each postID and Column Names */
    public function set_custom_columns_data($column, $post_id)
	{
		$data = get_post_meta( $post_id, '_sandip_testimonial_key', true );
		$name = isset($data['name']) ? $data['name'] : '';
		$email = isset($data['email']) ? $data['email'] : '';

		switch($column) {
			case 'name':
				echo '<strong>' . $name . '</strong><br/>';
				break;

			case 'author_email':
                echo '<a href="mailto:' . $email . '">' . $email . '</a>';
                break;
		}
	}

    // Make columns Sortable
	public function set_custom_columns_sortable($columns)
	{
		$columns['name'] = 'name';
		return $columns;
	}

    // Get the Form, Scripts and Styles
    public function GetmyForm(){
        ob_start();
        echo "<link rel=\"stylesheet\" href=\"$this->pluginURL/src/adminstyles.css\" type=\"text/css\" media=\"all\" />";
        require_once ("$this->pluginPATH/templates/MyForm.php");
        echo "<script src=\"$this->pluginURL/src/form.js\"></script>";
		return ob_get_clean();
    }

    public function submitTestimonialForm(){

        // check and Verify the nonce and check if it is an actual Ajax Request
		if (! DOING_AJAX || ! check_ajax_referer('testimonial-nonce', 'nonce') ) {
			return $this->return_json('error');
		}
        
        $name = sanitize_text_field( $_POST["name"] );
        $email = sanitize_email($_POST['email']);
		$message = sanitize_textarea_field($_POST['message']);

        $metadata = array(
            "name" => $name,
            "email" => $email,
        );

        // fill a new array ($args) for creating a new post
        $args = array(
			'post_title' => 'Testimonial from ' . $name,
			'post_content' => $message,
			'post_status' => 'publish',
			'post_type' => 'testimonial',
			'meta_input' => array(
				'_sandip_testimonial_key' => $metadata
			)
		);

        // Insert the Post, It will Return a Post ID
		$postID = wp_insert_post($args);

        if ($postID) {
			return $this->return_json('success');
		}

        return $this->return_json('error');
    }

    public function return_json($msg){
        $return = array(
            "status"=>$msg
        );
        wp_send_json( $return );
        wp_die();
    }

    public function showMySlider(){
        ob_start();
            echo "<link rel=\"stylesheet\" href=\"$this->pluginURL/src/adminstyles.css\" type=\"text/css\" media=\"all\" />";
            require_once ("$this->pluginPATH/templates/Slider.php");
            echo "<script src=\"$this->pluginURL/src/slider.js\"></script>";
        return ob_get_clean();
    }
}