<?php
// Creating the widget 
class yggallery_youtube_related_video_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'yggallery_youtube_related_video_widget', 

// Widget name will appear in UI
__('Youtube related_video Widget', 'yggallery_youtube_related_video_widget_domain'), 

// Widget description
array( 'description' => __( 'Youtube related_video Widget', 'yggallery_youtube_related_video_widget_domain' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
$youtubeurl = apply_filters( 'widget_catno', $instance['catno'] );
$viewmore = apply_filters( 'widget_spantext', $instance['viewmore'] );
$sviewmore = apply_filters( 'widget_spantext', $instance['sviewmore'] );

			 $video_url1=split('[&]',$youtubeurl);
	         $url_array=explode("=",$video_url1[0]);
		     $path=$url_array[1];

// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] ."<h5>". $title ."</h5>". $args['after_title'];

$postid= get_the_ID();

if ( is_page_template( 'template-video-gallery.php' ) ) {
	// Returns true when 'about.php' is being used.
	
	$args = array(  'offset'=> 1, 'post_type'=> 'ygallery','order'=>'DESC','posts_per_page' => 8);
} else {
	$args = array(  'offset'=> 0, 'post_type'=> 'ygallery','order'=>'DESC','posts_per_page' => 8,'exclude' => $postid,);
}




$myposts = get_posts( $args );
?>
<div class="wpb_text_column wpb_content_element  ">
		<div class="wpb_wrapper">
			<ul class="image-arrow list-divider">
<?php
foreach ( $myposts as $post ) : setup_postdata( $post );  
	 $youtubeurl = get_post_meta( $post->ID, '_ygallery_video_url', true );

	  $views1 = get_post_meta( $post->ID, '_ygallery_video_views', true );		

			 

			 $video_url1=split('[&]',$youtubeurl);

	         $url_array=explode("=",$video_url1[0]);

		     $path=$url_array[1];
			 
			 $author_id=$post->post_author;
			 
			 
?>

<li><div class="wf-table">
<div style="margin-right:10px;"><img src="http://img.youtube.com/vi/<?php echo $url_array[1]; ?>/1.jpg" width="90px" height="90px" style="position:relative;" /></div>
&nbsp;&nbsp;&nbsp;
<div style="margin-top:0;margin-left:4px;"><a style="font-size:14px;text-decoration:none;"  href="<?php echo get_permalink( $post->ID ); ?>"> <?php echo $post->post_title; ?></a>
<p style="font-size:12px;e;"> Views: <?php echo $views1; ?></p>
<!--<p style="font-size:12px;">by: <?php //echo the_author_meta( 'user_nicename' , $author_id ); ?></p>-->
</div>
</div>
</li>




<?php
 endforeach; 
 
 ?>
 </ul>
</div> 
</div>
 <?php
wp_reset_postdata();

if($viewmore&&$sviewmore)
{
?>
<a href="<?php echo get_site_url(); ?>/seminar-list/" class="related_video_video" style="float:right;" >
<?php 
echo $viewmore; 
?>
</a>
<?php
}
// This is where you run the code and display the output
//echo __( 'Hello, World!', 'yggallery_kalamela_widget_domain' );
echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
//$title = __( 'New title', 'yggallery_kalamela_widget_domain' );
}
//$num_items = isset($instance['num_items']) ? absint($instance['num_items']) : 5;
$catno = isset($instance['catno']) ? esc_attr($instance['catno']) :'';

$viewmore = isset($instance['viewmore']) ? esc_attr($instance['viewmore']) :'';
$sviewmore = isset($instance['sviewmore']) ? esc_attr($instance['sviewmore']) :'';


// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<p>
<label for="<?php echo $this->get_field_id( 'catno' ); ?>"><?php _e( 'Number of Videos:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'catno' ); ?>" name="<?php echo $this->get_field_name( 'catno' ); ?>" type="text" value="<?php echo esc_attr( $catno); ?>" value="5" />
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
$instance['catno'] = ( ! empty( $new_instance['catno'] ) ) ? strip_tags( $new_instance['catno'] ) : '';
$instance['viewmore'] = ( ! empty( $new_instance['viewmore'] ) ) ? strip_tags( $new_instance['viewmore'] ) : '';
$instance['sviewmore'] = ( ! empty( $new_instance['sviewmore'] ) ) ? strip_tags( $new_instance['sviewmore'] ) : '';

return $instance;
}
} // Class wpb_widget ends here

// Register and load the widget
function yggallery_youtube_related_video_load_widget() {
	register_widget( 'yggallery_youtube_related_video_widget' );
}
add_action( 'widgets_init', 'yggallery_youtube_related_video_load_widget' );
?>