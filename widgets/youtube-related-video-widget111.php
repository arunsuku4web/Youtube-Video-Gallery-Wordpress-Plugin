<?php
// Creating the widget 
class yggallery_related_video_sidebar_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'yggallery_related_video_sidebar_widget', 

// Widget name will appear in UI
__('Youtube Sidebar Widget', 'yggallery_related_video_sidebar_widget_domain'), 

// Widget description
array( 'description' => __( 'Youtube Sidebar Widget', 'yggallery_related_video_sidebar_widget_domain' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
$youtubeurl = apply_filters( 'widget_videonum', $instance['videonum'] );
$viewmore = apply_filters( 'widget_spantext', $instance['viewmore'] );
$sviewmore = apply_filters( 'widget_spantext', $instance['sviewmore'] );

			 $video_url1=split('[&]',$youtubeurl);
	         $url_array=explode("=",$video_url1[0]);
		     $path=$url_array[1];

// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];
$args = array(  'offset'=> 0, 'post_type'=> 'ygallery','order'=>'DESC','posts_per_page' => -1);
$myposts = get_posts( $args );
foreach ( $myposts as $post ) : setup_postdata( $post );  
	 $youtubeurl = get_post_meta( $post->ID, '_ygallery_video_url', true );

			

			 

			 $video_url1=split('[&]',$youtubeurl);

	         $url_array=explode("=",$video_url1[0]);

		     $path=$url_array[1];
?>
<li>
 <div style="float:left">
<img src="http://img.youtube.com/vi/<?php echo $url_array[1]; ?>/1.jpg" width="110px" height="110px" />
 </div>
 <b style="float:left"><?php echo $post->post_title; ?></b>
 <p><?php echo $post->post_expert; ?></p>
</li>

<?php
 endforeach; 
wp_reset_postdata();
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
$videonum = isset($instance['videonum']) ? esc_attr($instance['videonum']) :'';

$viewmore = isset($instance['viewmore']) ? esc_attr($instance['viewmore']) :'';
$sviewmore = isset($instance['sviewmore']) ? esc_attr($instance['sviewmore']) :'';


// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<p>
<label for="<?php echo $this->get_field_id( 'videonum' ); ?>"><?php _e( 'Number Of Videos:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'videonum' ); ?>" name="<?php echo $this->get_field_name( 'videonum' ); ?>" type="text" value="<?php echo esc_attr( $videonum); ?>" />
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
$instance['videonum'] = ( ! empty( $new_instance['videonum'] ) ) ? strip_tags( $new_instance['videonum'] ) : '';
$instance['viewmore'] = ( ! empty( $new_instance['viewmore'] ) ) ? strip_tags( $new_instance['viewmore'] ) : '';
$instance['sviewmore'] = ( ! empty( $new_instance['sviewmore'] ) ) ? strip_tags( $new_instance['sviewmore'] ) : '';

return $instance;
}
} // Class wpb_widget ends here

// Register and load the widget
function yggallery_related_video_sidebar_load_widget() {
	register_widget( 'yggallery_related_video_sidebar_widget' );
}
add_action( 'widgets_init', 'yggallery_related_video_sidebar_load_widget' );
?>