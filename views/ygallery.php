<h3>Add Videos to Seminar Gallery</h3>
<?php
$loader =  YG_ROOT_URL.'/images/loading.gif';
?>
<input type="hidden" name="plpath" id="plpath" value="<?php echo $loader; ?>"  />
<br />
<br />

<?php
if(isset($_POST['submit']))
{
	
if(isset($_POST['ygcat'])){
  if (is_array($_POST['ygcat'])) {
    foreach($_POST['ygcat'] as $value){
      echo $value;
    }
  } else {
    $value = $_POST['ygcat'];
    echo $value;
  }
}

print_r($_POST['ygcat']);	
	// Create post object
$my_post = array(
  'post_title'    => wp_strip_all_tags( $_POST['ytitle'] ),
  'post_content'  => $_POST['ydesc'],
  'post_status'   => 'publish',
  'post_author'   => 1,
  'post_type'     => 'ygallery',
  //'post_category' => $_POST['ygcat'],
  //'post_category' => $_POST['ygcat'],
  //'tax_input'=> array(80,83),
  

);

// Insert the post into the database
$post_id = wp_insert_post( $my_post );

if($post_id)
{
$cat_ids = $_POST['ygcat'];	

$cat_ids = array_map( 'intval', $cat_ids );
$cat_ids = array_unique( $cat_ids );
	
	$term_taxonomy_ids = wp_set_object_terms( $post_id, $cat_ids, 'ygallery_category' );

if ( is_wp_error( $term_taxonomy_ids ) ) {
	echo "There was an error somewhere and the terms couldn't be set.";
} else {
	echo "Success! The post's categories were set.";
}
	

	
	$smsg="Video Added Successfully";
	add_post_meta( $post_id, '_ygallery_video_url', $_POST['yurl'], true );
	add_post_meta( $post_id, '_ygallery_video_position', 0, true );
	add_post_meta( $post_id, '_ygallery_video_views', 0, true );
	
}
else
{
	$emsg="Sorry Try Again";
}
}
?>

<?php
if($smsg)
{
?>
<div  class="alert alert-success" style="width:50%;">
<?php echo $smsg; ?> 
</div>
<?php
}
?>
<?php
if($emsg)
{
?>
<div  class="alert alert-danger" style="width:50%;">
<?php echo $emsg; ?>
</div>
<?php
}
?>
<style>

ul {
	padding:0px;
	margin: 0px;
}
</style>
<form method="post" action="">
<table class="form-table">
<tr>
<td>
<strong>Video Title</strong>
</td>
<td>
<input type="text" name="ytitle" id="ytitle" placeholder="Video Title" style="width:50%"  />
</td>
</tr>
<tr>
<td>
<strong>Youtube Video Url</strong>
</td>
<td>
<input type="text" name="yurl" id="yurl" placeholder="Youtube Video Url" style="width:50%"  />
</td>
</tr>
<tr>
<td>
<strong>Video Description</strong>
</td>

<td>
<textarea name="ydesc" id="ydesc" rows="4" cols="60" ></textarea>

</td>
</tr>

<tr>
<td>

</td>

<td>
<button type="submit" name="submit" id="submit" value="Submit" class="button button-primary">Submit</button>
</td>
</tr>
</table>
</form>
<?php
$args = array(  'offset'=> 0, 'post_type'=> 'ygallery','order'=>'DESC','posts_per_page' => -1);
$myposts = get_posts( $args );
?>

<h4>Seminar Gallery(<?php echo count($myposts); ?>)</h4>
<div id="response" class="alert alert-success"> </div>

<div id="response1" class="alert alert-danger" style="width:50%;display:none"></div>
<div class="container container_fluid">

 	<div class="row">

    	<div class="col-sm-10" id="list">

            <ul >
<?php
                                    
//$args = array(  'offset'=> 0,'posts_per_page' => -1, 'post_type'=> 'ygallery','order'=>'ASC','orderby' => 'meta_value_num',
//'meta_key' => '_ygallery_video_position');

foreach ( $myposts as $post ) : setup_postdata( $post );     

  
  
   			 $youtubeurl = get_post_meta( $post->ID, '_ygallery_video_url', true );
				 
			 $video_url1=split('[&]',$youtubeurl);

	         $url_array=explode("=",$video_url1[0]);

		     $path=$url_array[1];		
  
   ?>       

                  <li id="arrayorder_<?php echo $post->ID; ?>">

                      <div style="float:left">

                      		<img src="http://img.youtube.com/vi/<?php echo $url_array[1]; ?>/1.jpg" width="110px" height="110px" />

                      </div>

                  <div style="float:left;margin:0px 15px;">

                    <h5 >
					<input type="text" name="ytitle<?php echo $post->ID; ?>" id="ytitle<?php echo $post->ID; ?>" placeholder="Video Title" style="width:50%" value="<?php echo $post->post_title; ?>"  />
					</h5>                    

                <p>
                <textarea name="ydesc<?php echo $post->ID; ?>" id="ydesc<?php echo $post->ID; ?>" rows="4" cols="60" ><?php echo $post->post_content; ?></textarea>
                
                </p>
                

                    <p id="Myactions">
 <button  class="btn btn-default btn-xs editvideo" id="<?php echo $post->ID; ?>" >Update</button > 

  

  <button id="<?php echo $post->ID; ?>" class="btn btn-default btn-xs deletevideo">Delete</button >


                    </p>
                    
   <p class="alert-success bg_none" id="pload<?php echo $post->ID; ?>"></p>

                    </div>

                  <div class="clear_fix0"></div>

                  </li>

<?php endforeach; 
wp_reset_postdata();?>                  

                

             </ul>        

        </div>

    </div>

</div>