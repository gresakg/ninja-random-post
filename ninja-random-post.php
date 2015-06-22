<?php
/*
Plugin Name: Ninja Mega Plugin
Plugin URI: http://naprimer-ninja-kamikaze.com/ninja-random-post
Description: This plugin is mega.
Author: Ninja Master
Version: 1.0
*/


add_action( 'widgets_init', function(){
     register_widget( 'Ninja_Random_Post_Widget' );
});

class Ninja_Random_Post_Widget extends WP_Widget {
    /**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
        parent::__construct(
            'ninja_random_post', // Base ID
            'Ninja Random Post', // Name
            array( 'description' => "Widget that displays a random post", ) // Args
		);
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		$random = $this->get_random_post();
        if($random->have_posts()) {
                echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ).$args['after_title'] ;
                $random->the_post();
                echo "<div class='ninja-random'>";
                if(has_post_thumbnail($random->ID))
                    the_post_thumbnail('thumbnail');
                echo "<h3>".get_the_title()."</h3>";
                echo "</div>";
            
        }
        wp_reset_postdata();
	}
    
    /**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : "";
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title );    ?>">
		</p>
		<?php 
	}

    private function get_random_post() {
        $args = array( 
                'post_type' => 'post',
                'numberposts' => 1,
                'orderby' => 'rand',
            );
        $the_query = new WP_Query($args);
        return $the_query;
    
    }

}