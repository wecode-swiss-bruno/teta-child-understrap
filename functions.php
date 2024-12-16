<?php
/**
 * Understrap Child Theme functions and definitions
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Add this line to include the helper file
require_once get_stylesheet_directory() . '/inc/helpers/articles-display-helper.php';

// Add these lines to include the new files
require_once get_stylesheet_directory() . '/inc/helpers/sponsor-banner-helper.php';
require_once get_stylesheet_directory() . '/inc/acf-templates/sponsor-banner.php';

// Add this line with your other requires
require_once get_stylesheet_directory() . '/inc/admin/theme-docs.php';



/**
 * Removes the parent themes stylesheet and scripts from inc/enqueue.php
 */
function understrap_remove_scripts() {
	wp_dequeue_style( 'understrap-styles' );
	wp_deregister_style( 'understrap-styles' );

	wp_dequeue_script( 'understrap-scripts' );
	wp_deregister_script( 'understrap-scripts' );
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );



/**
 * Enqueue our stylesheet and javascript file
 */
function theme_enqueue_styles() {

	// Get the theme data.
	$the_theme     = wp_get_theme();
	$theme_version = $the_theme->get( 'Version' );

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	// Grab asset urls.
	$theme_styles  = "/css/child-theme{$suffix}.css";
	$theme_scripts = "/js/child-theme{$suffix}.js";
	
	$css_version = $theme_version . '.' . filemtime( get_stylesheet_directory() . $theme_styles );

	wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . $theme_styles, array(), $css_version );
	wp_enqueue_script( 'jquery' );
	
	$js_version = $theme_version . '.' . filemtime( get_stylesheet_directory() . $theme_scripts );
	
	wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . $theme_scripts, array(), $js_version, true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );



/**
 * Load the child theme's text domain
 */
function add_child_theme_textdomain() {
	load_child_theme_textdomain( 'tetaz-dev', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'add_child_theme_textdomain' );



/**
 * Overrides the theme_mod to default to Bootstrap 5
 *
 * This function uses the `theme_mod_{$name}` hook and
 * can be duplicated to override other theme settings.
 *
 * @return string
 */
function understrap_default_bootstrap_version() {
	return 'bootstrap5';
}
add_filter( 'theme_mod_understrap_bootstrap_version', 'understrap_default_bootstrap_version', 20 );



/**
 * Loads javascript for showing customizer warning dialog.
 */
function understrap_child_customize_controls_js() {
	wp_enqueue_script(
		'understrap_child_customizer',
		get_stylesheet_directory_uri() . '/js/customizer-controls.js',
		array( 'customize-preview' ),
		'20130508',
		true
	);
}
add_action( 'customize_controls_enqueue_scripts', 'understrap_child_customize_controls_js' );



/**
 * Check if ACF is active
 */
function check_acf_activation() {
    if ( ! class_exists('ACF') ) {
        add_action( 'admin_notices', function() {
            ?>
            <div class="notice notice-error">
                <p><?php _e( 'This theme requires Advanced Custom Fields PRO to be installed and activated.', 'tetaz-dev' ); ?></p>
            </div>
            <?php
        });
    }
}
add_action( 'admin_init', 'check_acf_activation' );

function translate_date_to_french($date) {
    $months_en = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    $months_fr = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
    return str_replace($months_en, $months_fr, $date);
}

add_filter('get_the_date', 'translate_date_to_french');

remove_filter('get_the_excerpt', 'wp_trim_excerpt');

/**
 * Add Typekit fonts
 */
function add_typekit_fonts() {
    ?>
    <link rel="stylesheet" href="https://use.typekit.net/upr7qks.css">
    <?php
}
add_action('wp_head', 'add_typekit_fonts');

/**
 * Register custom menu locations
 */
function register_custom_menus() {
    register_nav_menus(
        array(
            'left_menu' => __('Left Menu', 'tetaz-dev'),
            'right_menu' => __('Right Menu', 'tetaz-dev'),
            'footer_menu' => __('Footer Menu', 'tetaz-dev'),
        )
    );
}
add_action('after_setup_theme', 'register_custom_menus');

function understrap_child_enqueue_scripts() {
    // Enqueue Bootstrap JS from CDN as fallback
    wp_enqueue_script(
        'bootstrap',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js',
        array('jquery'),
        '5.3.2',
        true
    );
    
    // Enqueue your custom JavaScript
    wp_enqueue_script('custom-js', get_stylesheet_directory_uri() . '/src/js/custom-javascript.js', array('jquery', 'bootstrap'), null, true);
}
add_action('wp_enqueue_scripts', 'understrap_child_enqueue_scripts');

// Add custom favicon
function add_custom_favicon() {
    echo '<link rel="icon" type="image/x-icon" href="' . get_stylesheet_directory_uri() . '/favicon.ico">';
}
add_action('wp_head', 'add_custom_favicon');

function add_font_awesome() {
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
}
add_action('wp_enqueue_scripts', 'add_font_awesome');

// Remove category base from URLs
function remove_category_url_base() {
    global $wp_rewrite;
    $wp_rewrite->category_base = '.';
    $wp_rewrite->flush_rules();
}
add_action('init', 'remove_category_url_base');

function tetaz_dev_load_theme_textdomain() {
    load_theme_textdomain('tetaz-dev', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'tetaz_dev_load_theme_textdomain');

