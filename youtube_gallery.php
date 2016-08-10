<?php
/*
Plugin Name: GY Video Gallery
Plugin URI: http://greenfrog.in
Description: Simple Video Gallery With Youtube Urls.
Version: 1.0.0
Author: Green Frog IT Solutions
Author URI: http://greenfrog.in
Text Domain: ygallery
*/
if(defined('YG_PLUGIN_VERSION') || isset($GLOBALS['lsPluginPath'])) {
	die('ERROR: It looks like you already have one instance of Youtube Video Gallery installed. WordPress cannot activate and handle two instanced at the same time, you need to remove the old version first.');
}

if(!defined('ABSPATH')) { 
	header('HTTP/1.0 403 Forbidden');
	exit;
}
	// Constants
	define('YG_ROOT_FILE', __FILE__);
	define('YG_ROOT_PATH', dirname(__FILE__));
	define('YG_ROOT_URL', plugins_url('', __FILE__));
	define('YG_PLUGIN_VERSION', '1.0.0');
	define('YG_PLUGIN_SLUG', basename(dirname(__FILE__)));
	define('YG_PLUGIN_BASE', plugin_basename(__FILE__));
	
	
include(YG_ROOT_PATH.'/includes/ajax.php');	

add_action('admin_menu', 'youtube_gallery_settings_menu');

add_action('init', 'register_ygallery' );

//register the custom post type for the logos myteam
function register_ygallery() {


$name="ygallery";
    $labels = array( 
    'name'               => 'Seminar Gallery',
    'singular_name'      => 'ygallery',
   // 'add_new'            => 'Add New Template',
   // 'add_new_item'       => 'Add New Template',
    'edit_item'          => 'Edit Seminar Gallery',
    'new_item'           => 'New',
    'all_items'          => 'All Seminar Gallery',
    'view_item'          => 'View Seminar Gallery',
    'search_items'       => 'Search weeklydesign Templates',
    'not_found'          => 'No Data found',
    'not_found_in_trash' => 'No Data found in Trash',
    'parent_item_colon'  => '',
    'menu_name'          => 'Seminar Gallery',
    );
	
	$singletrue = true;
	if($singlepage=="false") { $singletrue = false; }
	
    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,        
        'supports' => array( 'title', 'thumbnail', 'custom-fields', 'editor','page-attributes'),
        'public' => $singletrue,
        'show_ui' => true,
        'show_in_menu' => false,       
        'show_in_nav_menus' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => true,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post',
		'rewrite' => array( 'slug' => 'ygallery' )

    );

    register_post_type( 'ygallery', $args );
	
	
		$ygallery_category_labels = array(
		'name' => _x( 'Categories', 'taxonomy general name' ),
		'singular_name' => _x( 'Category', 'taxonomy singular name' ),
		'search_items' => __( 'Search Categories', 'yg' ),
		'all_items' => __( 'All Categories', 'yg' ),
		'parent_item' => __( 'Parent Category', 'yg' ),
		'parent_item_colon' => __( 'Parent Category:', 'yg' ),
		'edit_item' => __( 'Edit Category', 'yg' ), 
		'update_item' => __( 'Update Category', 'yg' ),
		'add_new_item' => __( 'Add New Category', 'yg' ),
		'new_item_name' => __( 'New Category Name', 'yg' ),
		'menu_name' => __( 'ygallery Categories', 'yg' ),
	);  


	register_taxonomy( 'ygallery_category', array( 'ygallery' ), array(
			'hierarchical'  => true,
			'labels'        => $ygallery_category_labels,
			'show_ui'       => true,
			'query_var'     => true,
			'rewrite'       => array( 
				'slug'          => $ygallery_category_rewrite,
				'with_front'    => false,
			),
	) );
}


//$icon = version_compare(get_bloginfo('version'), '3.8', '>=') ? 'dashicons-images-alt2' : YG_ROOT_URL.'/static/img/Film.png'; 

$icon =YG_ROOT_URL.'/static/img/Film.png'; 


function youtube_gallery_settings_menu()
 {
	// $icon = version_compare(get_bloginfo('version'), '3.8', '>=') ? 'dashicons-images-alt2' : YG_ROOT_URL.'/static/img/Film.png';
	 
	  $icon =  YG_ROOT_URL.'/static/img/Film.png';
		$layerslider_hook = add_menu_page(
		'Seminar Gallery', 'Seminar Gallery',
	'administrator', 'ygallery', 'ygallery_router',
		$icon
	); 
	
	//add_submenu_page( 'ygallery', 'Gallery Categories', 'Gallery Categories', 'administrator', 'gallery-category', 'ygcategory_router' );
	
	
 }
  function ygcategory_router() 
 {
 global $pagenow;
 $page = (isset($_REQUEST['page']) ? $_REQUEST['page'] : false);
 

  if($pagenow=='admin.php' && $page=='gallery-category'){
      
		wp_redirect( 'edit-tags.php?taxonomy=ygallery_category&post_type=ygallery', 301 );
        exit;
    }		 
	 

 }
 add_action('admin_init', 'ygcategory_router');
 
 function ygallery_router() 
 {
	 	// Get current screen details
	$screen = get_current_screen();
	if(strpos($screen->base, 'ygallery') !== false) {
		
		wp_enqueue_style( 'yg-bootstrap', YG_ROOT_URL."/assets/css/bootstrap.css" );
		
		
		//wp_enqueue_script('jquery');
		
		//wp_register_script('jquery-js', YG_ROOT_URL.'/assets/js/jquery.js', array('jquery'));
		//wp_register_script('yg-jquery-ui', YG_ROOT_URL.'/assets/js/jquery-ui.js', array('jquery'));
		
		wp_register_script('yg-script', YG_ROOT_URL.'/assets/js/ygscript.js', array('jquery'));
		
		//wp_register_script('yg-sorting', YG_ROOT_URL.'/assets/js/sorting.js', array('jquery'));
		
		
		//wp_enqueue_script('jquery-js');
		//wp_enqueue_script('yg-jquery-ui');
		wp_enqueue_script('yg-script');
		//wp_enqueue_script('yg-sorting');
		
		 
		include(YG_ROOT_PATH.'/views/ygallery.php');

	}
 }

 
include(YG_ROOT_PATH.'/widgets/youtube-video-category-widget.php');
include(YG_ROOT_PATH.'/widgets/youtube-related-video-widget.php');
?>
