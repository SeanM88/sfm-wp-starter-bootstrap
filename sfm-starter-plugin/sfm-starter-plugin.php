<?php

/*
Plugin Name: SFM Starter Plugin
Description: Accompanying functional plugin to SFM Starter theme which provides site-wide functions like custom post types, taxonomies, admin UI, and shortcodes.  This plugin is a merely base for future development and should be renamed to match accompanying theme built with the SFM Starter theme. All functions should be uniquely prefixed to prevent any potential compatibility errors with other plugins.  <strong>WARNING! - Deactivating this plugin could result in breaking important site-functionality.</strong>

Version: 1.0
Author: Sean Megan
Author URI: http://www.seanmegan.com

*/

/* =================================================================================== *
* Custom Taxonomies
* ==================================================================================== */

/* Example of a Genre taxonomy maybe used for a music site. Uncomment this section to use as model

function sfm_genre_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Genres ', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Genre', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Genres', 'text_domain' ),
		'all_items'                  => __( 'All Genres', 'text_domain' ),
		'parent_item'                => __( 'Parent Genre', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Genre:', 'text_domain' ),
		'new_item_name'              => __( 'New Genre Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Genre', 'text_domain' ),
		'edit_item'                  => __( 'Edit Genre', 'text_domain' ),
		'update_item'                => __( 'Update Genre', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate genre with commas', 'text_domain' ),
		'search_items'               => __( 'Search Genres', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove genres', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used genres', 'text_domain' ),
		'not_found'                  => __( 'Genre Not Found', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'genre', array( 'post' ), $args );

}
add_action( 'init', 'sfm_genre_taxonomy', 0 ); // Hook into the 'init' action

*/

/* =================================================================================== *
* Custom Post Types
* ==================================================================================== */

/* Example of a custom Video post type which supports the custom taxonomy genre.
function sfm_video_post_type() {

	$labels = array(
		'name'                => _x( 'Videos', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Video', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Videos', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Video:', 'text_domain' ),
		'all_items'           => __( 'All Videos', 'text_domain' ),
		'view_item'           => __( 'View Video', 'text_domain' ),
		'add_new_item'        => __( 'Add New Video', 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'edit_item'           => __( 'Edit Video', 'text_domain' ),
		'update_item'         => __( 'Update Video', 'text_domain' ),
		'search_items'        => __( 'Search Video', 'text_domain' ),
		'not_found'           => __( 'Video not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Video not found in Trash', 'text_domain' ),
	);
	$args = array(
		'label'               => __( 'video', 'text_domain' ),
		'description'         => __( 'Video post type', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', ),
		'taxonomies'          => array( 'category', 'post_tag', 'genre' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-video-alt2',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'video', $args );

}
add_action( 'init', 'sfm_video_post_type', 0 ); // Hook into the 'init' action

*/

/* =================================================================================== *
* Custom Meta Boxes for Posts
* ==================================================================================== */

// Initialize the metabox class
add_action( 'init', 'sfm_initialize_cmb_meta_boxes', 9999 );
function sfm_initialize_cmb_meta_boxes() {
    if ( !class_exists( 'cmb_Meta_Box' ) ) {
        require_once( plugin_dir_path( __FILE__ ) . 'library/metabox/init.php' );
    }
}

/*
// Example metabox function for showing/hiding posts on the home page. Uncomment & edit this funtion to create metaboxes for posts.

function sfm_toggle_post_on_home_metabox( $meta_boxes ) {
    $prefix = '_otw_'; // Prefix for all fields
    $meta_boxes['toggle_post_on_home'] = array(
        'id' => 'toggle_post_on_home',
        'title' => "Show On Home",
        'pages' => array('post'), // post type
        'context' => 'side',
        'priority' => 'high',
        'show_names' => false, // Show field names on the left
        'fields' => array(
            array(
                'name' => 'Show Post on Home',
                'desc' => "By default posts will not show up on the home page blog.  Check this box to display this post on the home page.",
                'id' => $prefix . 'post_on_home_toggle',
                'type' => 'checkbox'
            ),
        ),
    );

    return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'sfm_toggle_post_on_home_metabox' );
*/

/* =================================================================================== *
* WordPress Dashboard and Admin UI Functions
* ==================================================================================== */

/* Function to add custom taxonomy Genre to default post type.  To add taxnomies to custom post type: copy, rename, and update this function and
   change $typenow to custom post type name.

function sfm_add_taxonomy_filters_to_post() {
	global $typenow;
 
	// an array of all the taxonomyies you want to display. Use the taxonomy name or slug
	$taxonomies = array('genres');
 
	// must set this to the post type you want the filter(s) displayed on
	if( $typenow == 'post' ){
 
		foreach ($taxonomies as $tax_slug) {
			$tax_obj = get_taxonomy($tax_slug);
			$tax_name = $tax_obj->labels->name;
			$terms = get_terms($tax_slug);
			if(count($terms) >= 0) {
				echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
				echo "<option value=''>View all $tax_name</option>";
				foreach ($terms as $term) { 
					echo '<option value='. $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name .'</option>'; 
				}
				echo "</select>";
			}
		}
	}
}
add_action( 'restrict_manage_posts', 'sfm_add_taxonomy_filters_to_post' );

*/


/* =================================================================================== *
* Import includes files and load/enque scripts & styles below here
* ==================================================================================== */

foreach ( glob( plugin_dir_path( __FILE__ )."includes/*.php" ) as $file )
    include_once $file;

?>