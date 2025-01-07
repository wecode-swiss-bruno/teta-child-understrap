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
    
    // Enqueue your custom JavaScript with AJAX variables
    wp_enqueue_script('custom-js', get_stylesheet_directory_uri() . '/js/child-theme.min.js', array('jquery', 'bootstrap'), null, true);
    
    // Add AJAX variables to the main script
    wp_localize_script('custom-js', 'tetazAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('tetaz_load_more_nonce')
    ));
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

/**
 * AJAX handler for loading more posts
 */
function tetaz_load_more_posts() {
    // Debug information
    error_log('Load more posts request received: ' . print_r($_POST, true));

    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'tetaz_load_more_nonce')) {
        wp_send_json_error('Invalid nonce');
    }

    $page = intval($_POST['page']);
    $section = sanitize_text_field($_POST['section']);
    $posts_handling = json_decode(stripslashes($_POST['posts_handling']), true);
    
    // Debug decoded data
    error_log('Decoded posts handling: ' . print_r($posts_handling, true));
    
    // Calculate offset based on the original posts count
    $posts_per_page = $posts_handling['number_of_posts_to_display'] ?? 3;
    $offset = ($page - 1) * $posts_per_page;
    
    // Get posts with offset
    $posts = get_posts_by_settings($posts_handling, $posts_per_page, $offset);
    
    // Debug retrieved posts
    error_log('Retrieved posts: ' . print_r($posts, true));

    if (empty($posts)) {
        wp_send_json_success([
            'html' => '',
            'has_more' => false
        ]);
    }

    // Start output buffering to capture the HTML
    ob_start();
    
    // Determine which template to use based on the section
    if (strpos($section, 'fullscreen-articles') !== false) {
        foreach ($posts as $post) {
            setup_postdata($post);
            include(get_stylesheet_directory() . '/template-parts/flexible/partials/article-fullscreen.php');
        }
    } else if (strpos($section, 'grid-split-articles') !== false) {
        include(get_stylesheet_directory() . '/template-parts/flexible/partials/articles-grid-split-row.php');
    }
    
    wp_reset_postdata();
    
    $html = ob_get_clean();
    
    // Check if there are more posts
    $next_posts = get_posts_by_settings($posts_handling, $posts_per_page, $offset + $posts_per_page);
    $has_more = !empty($next_posts);
    
    wp_send_json_success([
        'html' => $html,
        'has_more' => $has_more
    ]);
}
add_action('wp_ajax_load_more_posts', 'tetaz_load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'tetaz_load_more_posts');

/**
 * AJAX handler for loading more related posts
 */
function tetaz_load_more_related_posts() {
    // Debug information
    error_log('Loading more related posts...');

    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'tetaz_load_more_nonce')) {
        wp_send_json_error('Invalid nonce');
    }

    $page = intval($_POST['page']);
    $current_post_id = intval($_POST['current_post_id']);
    $posts_per_page = 3;
    $offset = ($page - 1) * $posts_per_page;

    // Get related posts based on categories
    $categories = wp_get_post_categories($current_post_id);
    
    $args = array(
        'category__in' => $categories,
        'post__not_in' => array($current_post_id),
        'posts_per_page' => $posts_per_page,
        'offset' => $offset,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_status' => 'publish'  // Make sure we only get published posts
    );

    // Use WP_Query instead of get_posts to ensure all post data is available
    $query = new WP_Query($args);
    
    if (!$query->have_posts()) {
        wp_send_json_success([
            'html' => '',
            'has_more' => false
        ]);
    }

    // Start output buffering to capture the HTML
    ob_start();
    
    while ($query->have_posts()) {
        $query->the_post();
        global $post;
        
        // Debug post data
        error_log('Processing post: ' . print_r($post, true));
        
        include(get_stylesheet_directory() . '/template-parts/flexible/partials/related-post-card.php');
    }
    
    // Reset post data
    wp_reset_postdata();
    
    $html = ob_get_clean();
    
    // Check if there are more posts
    $next_query = new WP_Query(array_merge($args, ['offset' => $offset + $posts_per_page]));
    $has_more = $next_query->have_posts();
    wp_reset_postdata();  // Reset again after checking for more posts
    
    wp_send_json_success([
        'html' => $html,
        'has_more' => $has_more
    ]);
}
add_action('wp_ajax_load_more_related_posts', 'tetaz_load_more_related_posts');
add_action('wp_ajax_nopriv_load_more_related_posts', 'tetaz_load_more_related_posts');

/**
 * Hide parent theme page templates
 *
 * @param array $page_templates Array of page templates. Keys are filenames, values are translated names.
 * @param WP_Theme $theme Theme object
 * @param WP_Post $post The post being edited, provided for context, or null.
 * @param string $post_type Post type to get templates for.
 * @return array Modified array of page templates
 */
function tetaz_remove_parent_theme_templates($page_templates, $theme, $post, $post_type) {
    // Get the current theme directory
    $current_theme = get_stylesheet_directory();
    
    // Filter templates to only include those from the child theme
    foreach ($page_templates as $template_file => $template_name) {
        // Get the full path of the template
        $template_path = locate_template($template_file);
        
        // If template is not in current theme directory, remove it
        if (strpos($template_path, $current_theme) === false) {
            unset($page_templates[$template_file]);
        }
    }
    
    return $page_templates;
}
add_filter('theme_page_templates', 'tetaz_remove_parent_theme_templates', 10, 4);

/**
 * Newsletter form submission handler
 */
function tetaz_handle_newsletter_submission() {
    // Verify nonce for security
    if (!wp_verify_nonce($_POST['nonce'], 'tetaz_newsletter_nonce')) {
        wp_send_json_error('Invalid nonce');
    }

    // Get and sanitize the email
    $email = sanitize_email($_POST['email']);
    if (!is_email($email)) {
        wp_send_json_error('Invalid email address');
    }

    // Here you would typically:
    // 1. Save to your newsletter service (Mailchimp, SendinBlue, etc.)
    // 2. Or save to a custom table/post type
    // For now, we'll just return success
    
    // You can add your newsletter service integration here
    
    wp_send_json_success('Thank you for subscribing!');
}
add_action('wp_ajax_tetaz_newsletter_submit', 'tetaz_handle_newsletter_submission');
add_action('wp_ajax_nopriv_tetaz_newsletter_submit', 'tetaz_handle_newsletter_submission');

/**
 * Enqueue scripts and styles.
 */
function tetaz_scripts() {
    // Add AJAX URL and nonce to script
    wp_localize_script(
        'tetaz-newsletter',
        'tetazAjax',
        array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('tetaz_newsletter_nonce')
        )
    );
}
add_action('wp_enqueue_scripts', 'tetaz_scripts');

