<?php
add_action('wp_ajax_YGEditVideo','YGEditVideo');
add_action('wp_ajax_nopriv_YGEditVideo', 'YGEditVideo');

add_action('wp_ajax_YGDeleteVideo','YGDeleteVideo');
add_action('wp_ajax_nopriv_YGDeleteVideo', 'YGDeleteVideo');


add_action('wp_ajax_YGVideoSorting','YGVideoSorting');
add_action('wp_ajax_nopriv_YGVideoSorting', 'YGVideoSorting');

function YGVideoSorting()
{
$array	= $_POST['arrayorder'];
global $wpdb;
if ($_POST['update'] == "update"){
	
	$count = 1;
	foreach ($array as $idval) {
	//echo "idval======".$idval;
	//echo "count======".$count;
		update_post_meta( $idval, '_ygallery_video_position',$count);
		  /* $result=$wpdb->update( 
	'wp_home_slider', 
	array( 
		'position' => $count,	// string
		
	), 
	array( 'id' => $idval ), 
	array( 
		'%d'	// value1
		
	), 
	array( '%d' ) 
);
		*/
		
		
		
		
		$count ++;	
	}
	echo 'All saved! refresh the page to see the changes';
}
die();
}

function YGEditVideo()
{
global $wpdb;
$pid=$_REQUEST['vid'];
$videotitle=$_REQUEST['videotitle'];
$videodescription=$_REQUEST['videodescription'];
$my_post = array(
      'ID'           => $pid,
	  'post_title' => $videotitle,
      'post_content' => $videodescription
  );
// Update the post into the database
  $result=wp_update_post( $my_post );
  if($result)
  {
	  echo "success";
  }
exit;	
}

function YGDeleteVideo()
{
global $wpdb;
$pid=$_REQUEST['vid'];
if($pid)
{
$result=wp_delete_post($pid);

}

  if($result)
  {
	  echo "success";
  }
exit;	
}
?>