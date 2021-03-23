<?php

namespace Inc\Api;

use WP_Widget;

class EmbedWidgetAPI extends WP_Widget{

    public $widget_ID;

	public $widget_name;

	public $widget_options = array();

	public $control_options = array();


    public function __construct(){
        $this->widget_ID = 'sandip_embed_widget';
		$this->widget_name = 'Sandip Embed Widget';

		$this->widget_options = array(
			'classname' => $this->widget_ID,
			'description' => $this->widget_name,
			'customize_selective_refresh' => true,
		);
/* 
		$this->control_options = array(
			'width' => 400,
			'height' => 350,
		); */
    }

    public function register(){
        parent::__construct( $this->widget_ID, $this->widget_name, $this->widget_options, $this->control_options );
		add_action( 'widgets_init', array( $this, 'widgetsInit' ) );
    }

    public function widgetsInit(){
        register_widget( $this );
    }

    public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
        if ( ! empty( $instance['video_id'] ) ) {
			echo '<iframe width="520" height="415"
            src="https://www.youtube.com/embed/' .$instance['video_id']. '">
            </iframe> ';
		}
		echo $args['after_widget'];
	}

    public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : "";
        $video_id = ! empty( $instance['video_id'] ) ? $instance['video_id'] : "";
		
        ?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'sandip-plugin' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

        <p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'video_id' ) ); ?>"><?php esc_attr_e( 'Youtube Video Id:', 'sandip-plugin' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'video_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'video_id' ) ); ?>" type="text" value="<?php echo esc_attr( $video_id ); ?>">
		</p>

		<?php 
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
        $instance['video_id'] = sanitize_text_field( $new_instance['video_id'] );

		return $instance;
	}
}