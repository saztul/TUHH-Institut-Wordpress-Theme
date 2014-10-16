<?php
/**
 * TUHH Institute functions and definitions
 *
 * @package TUHH Institute
 */

require get_template_directory() . '/classes/TUHH_Nav_Item.php';
require get_template_directory() . '/classes/TUHH_Nav_Root.php';
require get_template_directory() . '/classes/TUHH_Navigation.php';
require get_template_directory() . '/classes/TUHH_Nav_WP_Data_Wrapper.php';

require get_template_directory() . '/classes/TUHH_Settings.php';
require get_template_directory() . '/classes/TUHH_Settings_Provider.php';
$tuhh_conf = TUHH_Settings::get_instance(); 

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'tuhh_institute_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function tuhh_institute_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on TUHH Institute, use a find and replace
	 * to change 'tuhh-institute' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'tuhh-institute', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'tuhh-institute' ),
	) );
	
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link'
	) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'tuhh_institute_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // tuhh_institute_setup
add_action( 'after_setup_theme', 'tuhh_institute_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function tuhh_institute_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'tuhh-institute' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="box widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h1 class="widget-title box-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'tuhh_institute_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function tuhh_institute_scripts() {
	wp_enqueue_style( 'tuhh-institute-style', get_stylesheet_uri() );
	wp_enqueue_style( 'tuhh-institute-imported-style', get_template_directory_uri() . '/static/application-da92feeab726f7664b36f44894a37c53.css' );
    

    wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/static/assets/modernizr.js', array(), '20140815', true );
    wp_enqueue_script( 'tuhh-jquery-next-or-first', get_template_directory_uri() . '/js/jQuery_next_or_first.js', array('jquery'), '20140815', true );
    wp_enqueue_script( 'tuhh-institute-navigation-loader', get_template_directory_uri() . '/js/navigation-loader.js', array('jquery'), '20140815', true );
    wp_enqueue_script( 'tuhh-institute-mobile-navigation', get_template_directory_uri() . '/js/mobile-navigation.js', array('jquery', 'tuhh-institute-navigation-loader'), '20140815', true );
    wp_enqueue_script( 'tuhh-institute-search-panel', get_template_directory_uri() . '/js/search-panel.js', array('jquery'), '20140815', true );
    wp_enqueue_script( 'tuhh-institute-svg-fallback', get_template_directory_uri() . '/js/svg-fallback.js', array('jquery'), '20140815', true );
    wp_enqueue_script( 'tuhh-institute-teaser', get_template_directory_uri() . '/js/teaser.js', array('jquery', 'modernizr'), '20140815', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'tuhh_institute_scripts' );

function tuhh_top_menu(){
    echo TUHH_Navigation::get_instance()->top_navigation();
}

function tuhh_side_menu(){
    echo TUHH_Navigation::get_instance()->sidebar_navigation();
}

function tuhh_breadcrumbs(){
    echo TUHH_Navigation::get_instance()->breadcrumbs();
}



/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
