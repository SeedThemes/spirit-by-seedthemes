<?php
/**
 * Spirit functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Spirit
 */

if ( ! function_exists( 'spirit_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function spirit_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Spirit, use a find and replace
	 * to change 'spirit' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'spirit', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	add_theme_support( 'custom-logo', array(
		'width'       => 200,
		'height'      => 100,
		'flex-width' => true,
		) );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'spirit' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'spirit_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif;
add_action( 'after_setup_theme', 'spirit_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function spirit_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'spirit_content_width', 640 );
}
add_action( 'after_setup_theme', 'spirit_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function spirit_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'spirit' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'spirit' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'spirit_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function spirit_scripts() {

	wp_enqueue_style( 'spirit-bootstrap3', get_template_directory_uri() . '/vendor/bootstrap3/css/bootstrap.min.css' );

	wp_enqueue_style( 'spirit-style', get_stylesheet_uri() );

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'spirit-bootstrap3', get_stylesheet_directory_uri() . '/vendor/bootstrap3/js/bootstrap.min.js', array( 'jquery' ), array(), true );

	wp_enqueue_script( 'spirit-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script( 'spirit-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'spirit_scripts' );




/**
 * WooCommerce
 */
add_theme_support( 'woocommerce' );
/* Display 12 products per page */
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 12;' ), 20 );
/* Change Thumbnails Columns in Single Product Page */
add_filter ( 'woocommerce_product_thumbnails_columns', 'seed_thumb_cols' );
function seed_thumb_cols() {
	return 5;
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

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
