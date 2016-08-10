<?php
// Creating the widget 
class cma_youtube_sidebar_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'cma_youtube_sidebar_widget', 

// Widget name will appear in UI
__('Youtube Sidebar Widget', 'cma_youtube_sidebar_widget_domain'), 

// Widget description
array( 'description' => __( 'Youtube Sidebar Widget', 'cma_youtube_sidebar_widget_domain' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
$youtubeurl = apply_filters( 'widget_videourl', $instance['videourl'] );
$viewmore = apply_filters( 'widget_spantext', $instance['viewmore'] );
$sviewmore = apply_filters( 'widget_spantext', $instance['sviewmore'] );

			 $video_url1=split('[&]',$youtubeurl);
	         $url_array=explode("=",$video_url1[0]);
		     $path=$url_array[1];

// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];
?>
<iframe type="text/html" width="100%"  src="http://www.youtube.com/embed/<?php echo $path; ?>?wmode=opaque" frameborder="0" ></iframe>
<?php
if($viewmore&&$sviewmore)
{
?>
<a href="http://chicagomalayaleeassociation.org/video-gallery/" class="sidebar_video" >
<?php 
echo $viewmore; 
?>
</a>
<?php
}
// This is where you run the code and display the output
//echo __( 'Hello, World!', 'cma_kalamela_widget_domain' );
echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
//$title = __( 'New title', 'cma_kalamela_widget_domain' );
}
//$num_items = isset($instance['num_items']) ? absint($instance['num_items']) : 5;
$videourl = isset($instance['videourl']) ? esc_attr($instance['videourl']) :'';

$viewmore = isset($instance['viewmore']) ? esc_attr($instance['viewmore']) :'';
$sviewmore = isset($instance['sviewmore']) ? esc_attr($instance['sviewmore']) :'';


// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<p>
<label for="<?php echo $this->get_field_id( 'videourl' ); ?>"><?php _e( 'Youtube Video Url:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'videourl' ); ?>" name="<?php echo $this->get_field_name( 'videourl' ); ?>" type="text" value="<?php echo esc_attr( $videourl); ?>" />
</p>
<p>
<label for="<?php echo $this->get_field_id( 'viewmore' ); ?>"><?php _e( 'View More:' ); ?></label> 
<input type="checkbox" id="<?php echo $this->get_field_id('sviewmore'); ?>" name="<?php echo $this->get_field_name( 'sviewmore' ); ?>" value="1"
<?php
if($sviewmore)
{
?>
checked="checked"
<?php
}
?>
 /><input class="widefat" id="<?php echo $this->get_field_id( 'viewmore' ); ?>" name="<?php echo $this->get_field_name( 'viewmore' ); ?>" type="text" value="<?php echo esc_attr( $viewmore ); ?>" />
</p>
<?php 
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
$instance['videourl'] = ( ! empty( $new_instance['videourl'] ) ) ? strip_tags( $new_instance['videourl'] ) : '';
$instance['viewmore'] = ( ! empty( $new_instance['viewmore'] ) ) ? strip_tags( $new_instance['viewmore'] ) : '';
$instance['sviewmore'] = ( ! empty( $new_instance['sviewmore'] ) ) ? strip_tags( $new_instance['sviewmore'] ) : '';

return $instance;
}
} // Class wpb_widget ends here

// Register and load the widget
function cma_youtube_sidebar_load_widget() {
	register_widget( 'cma_youtube_sidebar_widget' );
}
add_action( 'widgets_init', 'cma_youtube_sidebar_load_widget' );
?>