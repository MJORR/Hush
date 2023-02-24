<?php

/**
 * hush functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package hush
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function hush_setup()
{
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on hush, use a find and replace
		* to change 'hush' to the name of your theme in all the template files.
		*/
	load_theme_textdomain('hush', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support('title-tag');

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support('post-thumbnails');

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	add_post_type_support('page', 'excerpt');

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'hush_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action('after_setup_theme', 'hush_setup');

/**
 * Enqueue scripts and styles.
 */
function hush_scripts()
{
	$theme_styles  = "/css/theme.min.css";
	wp_enqueue_style('hush-style', get_stylesheet_directory_uri() . $theme_styles, null, _S_VERSION);

	//wp_enqueue_script('hush-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

}
add_action('wp_enqueue_scripts', 'hush_scripts');


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function hush_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'hush'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'hush'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'hush_widgets_init');

/**
 * Register menu areas.
 *
 */

if (!function_exists('hush_register_nav_menu')) {

	function hush_register_nav_menu()
	{
		register_nav_menus(array(
			'primary_menu' => __('Primary Menu', 'text_domain'),
			'footer_menu'  => __('Footer Menu', 'text_domain'),
		));
	}
	add_action('after_setup_theme', 'hush_register_nav_menu', 0);
}

/**
 * Save ACF json
 *
 */

add_filter('acf/settings/save_json', 'my_acf_json_save_point');

function my_acf_json_save_point($path)
{

	// update path
	$path = get_stylesheet_directory() . '/src/acf';

	// return
	return $path;
}
