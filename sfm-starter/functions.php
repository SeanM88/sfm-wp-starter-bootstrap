<?php
/**
 * sfm-starter functions and definitions
 *
 * @package sfm-starter
 */

// Set the content width based on the theme's design and stylesheet.
/*if ( ! isset( $content_width ) ) {
	$content_width = 640; // <-- in pixels
}
*/

//===========================================================================================================
// WP HEAD CLEANUP + MISCELLANEOUS CLEANUP
//===========================================================================================================

function sfm_starter_wp_head_cleanup() {
	
	// remove_action( 'wp_head', 'feed_links_extra', 3 ); // category feeds
	// remove_action( 'wp_head', 'feed_links', 2 ); // post and comment feeds
	
	remove_action( 'wp_head', 'rsd_link' ); // remove Really Simple Discovery link
	remove_action( 'wp_head', 'wp_generator' ); // remove WP version
	
	remove_action( 'wp_head', 'index_rel_link' ); // remove index link
	remove_action( 'wp_head', 'wlwmanifest_link' ); // remove windows live writer link
	
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // remove random post link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // remove parent post link
	remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0); // remove links for next and previous post links
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 ); 
	
	add_filter( 'style_loader_src', 'sfm_starter_remove_wp_ver_css_js', 9999 ); // remove WP version from css
	add_filter( 'script_loader_src', 'sfm_starter_remove_wp_ver_css_js', 9999 ); // remove Wp version from scripts

} // end sfm-starter wp head cleanup

add_action( 'init', 'sfm_starter_wp_head_cleanup' );

// remove WP version from scripts
function sfm_starter_remove_wp_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}

// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function sfm_starter_filter_ptags_on_images($content){
	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}
add_filter( 'the_content', 'sfm_starter_filter_ptags_on_images' );

//===========================================================================================================
// ADD THEME SUPPORT
//
// http://codex.wordpress.org/Function_Reference/add_theme_support
//===========================================================================================================

if ( ! function_exists( 'sfm_starter_theme_support_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function sfm_starter_theme_support_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on sfm-starter, use a find and replace
	 * to change 'sfm-starter' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'sfm-starter', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'link', 'quote', 'image', 'gallery', 'video', 'audio', 'chat',
	) );
	
	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	// set_post_thumbnail_size( 300, 200 ); // set default thumbnail size to 300 pixels wide by 200 pixels tall, resize mode

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'sfm_starter_custom_background_args', array(
		'default-color' => 'ffffff', // background color default (dont add the #)
		'default-image' => '', 
	) ) );
}
endif; // sfm_starter_theme_support_setup
add_action( 'after_setup_theme', 'sfm_starter_theme_support_setup' );

//===========================================================================================================
// NAVIGATION & MENUS
//
// http://codex.wordpress.org/Navigation_Menus 
//===========================================================================================================

// Register nav menus for theme.
register_nav_menus( array(
	'primary' => __( 'Primary Menu', 'sfm-starter' ),
	//'extra' => __( 'Extra Menu', 'sfm-starter' ),
) );

// Primary Menu function
function sfm_navbar() {
	wp_nav_menu(array(
		'theme_location' => 'primary',
		'container'      => false,
		'menu_class'     => 'nav navbar-nav',
		'menu_id'	 => '',
		'fallback_cb'    => 'wp_bootstrap_navwalker::fallback',
		'walker'	 => new wp_bootstrap_navwalker(),
	));
}

class SFM_Bootstrap_Walker_Navbar extends Walker_Nav_Menu {
	
}

/*function sfm_extra_menu() {
	wp_nav_menu(array(
		'theme_location' => 'extra',
	));
}*/


//===========================================================================================================
// ACTIVE SIDEBARS & WIDGETS
//
// http://codex.wordpress.org/Function_Reference/register_sidebar
//===========================================================================================================

function sfm_starter_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'sfm-starter' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'sfm_starter_widgets_init' );

//===========================================================================================================
// THUMBNAILS & FEATURED IMAGES
//
// http://codex.wordpress.org/Post_Thumbnails
//===========================================================================================================



//===========================================================================================================
// REGISTER + ENQUEUE SCRIPTS & STYLES
//
// http://codex.wordpress.org/Function_Reference/wp_register_script
// http://codex.wordpress.org/Function_Reference/wp_enqueue_script
// http://codex.wordpress.org/Function_Reference/wp_enqueue_style
//===========================================================================================================

function sfm_starter_enqueue_scripts() {
	
	// Register styles
	//wp_register_style( 'sfm-normalize', get_template_directory_uri() . '/library/css/normalize.css', '3.0.2' ); // Normalize.css - uncomment out this line if needed
	wp_register_style( 'sfm-starter-theme-info', get_stylesheet_uri() );
	wp_register_style( 'sfm-bootstrap-styles', get_template_directory_uri() . '/library/css/styles.css');
	wp_register_style( 'sfm-font-awesome', "//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css");
	
	// Register scripts
	wp_register_script( 'sfm-bootstrap-js-cdn', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js', array('jquery'), '3.3', true ); // Max CDN Bootstrap javascript
	// wp_register_script( 'sfm-bootstrap-js-dev', get_template_directory_uri() . '/library/js/bootstrap.min.js', array(), '3.3', true ); // Uncomment to use development version
	//wp_register_script( 'sfm-starter-navigation', get_template_directory_uri() . '/library/js/navigation.js', array(), '20120206', true );
	//wp_register_script( 'sfm-starter-skip-link-focus-fix', get_template_directory_uri() . '/library/js/skip-link-focus-fix.js', array(), '20130115', true );
	
	
	// Enqueue Scripts & Styles
	//wp_enqueue_style( 'sfm-normalize' ); // Normalize.css - uncomment out this line if needed
	wp_enqueue_style( 'sfm-starter-theme-info' );
	wp_enqueue_style( 'sfm-bootstrap-styles' );
	wp_enqueue_style( 'sfm-font-awesome' );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'sfm-bootstrap-js-cdn' ); // CDN delivered Bootstrap javascript
	// wp_enqueue_script( 'sfm-bootstrap-js-dev' ); // Uncomment to use development version of bootstrap javascript
	// wp_enqueue_script( 'sfm-starter-navigation' );
	// wp_enqueue_script( 'sfm-starter-skip-link-focus-fix' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'sfm_starter_enqueue_scripts' );

//===========================================================================================================
// REQUIRED & INCLUDED FILES
//===========================================================================================================

// Implement the Custom Header feature.
//require get_template_directory() . '/inc/custom-header.php';

// Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';

// Custom functions that act independently of the theme templates.
require get_template_directory() . '/inc/extras.php';

// Bootstrap Walker class to add dropdown menu support.
require get_template_directory() . '/inc/wp-bootstrap-navwalker.php';

// Customizer additions.
require get_template_directory() . '/inc/customizer.php';

// Load Jetpack compatibility file.
require get_template_directory() . '/inc/jetpack.php';
