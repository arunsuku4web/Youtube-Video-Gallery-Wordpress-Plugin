<?php
// Creating the widget 
class yggallery_youtube_video_category_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'yggallery_youtube_video_category_widget', 

// Widget name will appear in UI
__('Youtube video_category Widget', 'yggallery_youtube_video_category_widget_domain'), 

// Widget description
array( 'description' => __( 'Youtube video_category Widget', 'yggallery_youtube_video_category_widget_domain' ), ) 
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
echo $args['before_title'] . $title . $args['after_title'];

$taxonomy     = 'ygallery_category';
//$taxonomy     = 'category';
$orderby      = 'name';
$show_count   = 0;      // 1 for yes, 0 for no
$pad_counts   = 0;      // 1 for yes, 0 for no
$hierarchical = 1;      // 1 for yes, 0 for no
$title        = '';
$empty        = 0;

$args = array(
  'taxonomy'     => $taxonomy,
  'orderby'      => $orderby,
  'show_count'   => $show_count,
  'pad_counts'   => $pad_counts,
  'hierarchical' => $hierarchical,
  'title_li'     => $title,
  'hide_empty'   => $empty
);


 $categories = get_categories($args); 
  foreach ($categories as $category) {
				
				
				echo '<li><a href="' .get_site_url() . '/video-categories/?category='.$category->slug.'">' . $category->cat_name . '('.$category->category_count.')</a></li>';
				
				//echo $term->name.","; 
			}
		echo '</ul>';


if($viewmore&&$sviewmore)
{
?>
<a href="http://chicagomalayaleeassociation.org/video-gallery/" class="video_category_video" >
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
<label for="<?php echo $this->get_field_id( 'catno' ); ?>"><?php _e( 'Number of Categories:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'catno' ); ?>" name="<?php echo $this->get_field_name( 'catno' ); ?>" type="text" value="<?php echo esc_attr( $catno); ?>" />
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
function yggallery_youtube_video_category_load_widget() {
	register_widget( 'yggallery_youtube_video_category_widget' );
}
add_action( 'widgets_init', 'yggallery_youtube_video_category_load_widget' );
?>