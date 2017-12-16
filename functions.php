<?php
/**
 * Ohana functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Ohana
 */

if ( ! function_exists( 'ohana_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function ohana_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Ohana, use a find and replace
		 * to change 'ohana' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'ohana', get_template_directory() . '/languages' );

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
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'ohana' ),
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
		add_theme_support( 'custom-background', apply_filters( 'ohana_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		/**
		 * Add support for Gutenberg.
		 *
		 * @link https://wordpress.org/gutenberg/handbook/reference/theme-support/
		 */
		add_theme_support( 'gutenberg', array(
			'wide-images' => true,
			'colors' => array(
				'#dceab2',
				'#fc814a',
				'#89D2DC',
				'#88AB75',
			),
		) );

add_action( 'after_setup_theme', 'mytheme_setup_theme_supported_features' );

	}
endif;
add_action( 'after_setup_theme', 'ohana_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ohana_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'ohana_content_width', 1100 );
}
add_action( 'after_setup_theme', 'ohana_content_width', 0 );

/**
 * Enqueue editor styles for Gutenberg
 */
function ohana_editor_styles() {
	wp_enqueue_style( 'ohana-editor-style', get_template_directory_uri() . '/assets/stylesheets/editor-style.css' );
	wp_enqueue_style( 'ohana-block-editor-style', get_template_directory_uri() . '/assets/stylesheets/blocks.css' );
	wp_enqueue_style( 'ohana-fonts', ohana_fonts_url(), array(), null );

}
add_action( 'enqueue_block_editor_assets', 'ohana_editor_styles' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ohana_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'ohana' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'ohana' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'ohana_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ohana_scripts() {
	wp_enqueue_style( 'ohana-style', get_stylesheet_uri() );

	wp_enqueue_style( 'ohana-block-styles', get_template_directory_uri() . '/assets/stylesheets/blocks.css' );
	wp_enqueue_style( 'ohana-fonts', ohana_fonts_url(), array(), null );

	wp_enqueue_script( 'ohana-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'ohana-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ohana_scripts' );

/**
 * Enqueuing Google Fonts
 */
function ohana_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	* supported by Slabo 13px, translate this to 'off'. Do not translate
	* into your own language.
	*/
	$alegreya = esc_html_x( 'on', 'Alegreya font: on or off', 'ohana' );
	$lato = esc_html_x( 'on', 'Lato font: on or off', 'ohana' );

	if ( 'off' !== $alegreya || 'off' !== $lato ) {
		$font_families = array();

		if ( 'off' !== $alegreya ) {
			$font_families[] = 'Alegreya';
		}

		if ( 'off' !== $lato ) {
			$font_families[] = 'Lato';
		}

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
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
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * SVG Icons
 */
require get_template_directory() . '/inc/icon-functions.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

