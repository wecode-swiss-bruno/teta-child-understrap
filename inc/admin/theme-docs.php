<?php
/**
 * Theme Documentation Page
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Add documentation menu item
 */
function add_theme_docs_page() {
    add_menu_page(
        'Theme Documentation',
        'Theme Docs',
        'edit_posts',
        'theme-documentation',
        'render_theme_docs_page',
        'dashicons-book-alt',
        99
    );
}
add_action('admin_menu', 'add_theme_docs_page');

/**
 * Render the documentation page
 */
function render_theme_docs_page() {
    // Get the current page from the URL
    $current_page = isset($_GET['doc']) ? sanitize_text_field($_GET['doc']) : 'index';
    $current_page = str_replace('.', '', $current_page); // Prevent directory traversal
    
    // Get documentation content
    $docs_dir = get_stylesheet_directory() . '/inc/admin/docs/';
    $file_path = $docs_dir . $current_page . '.md';
    
    // Default to index if file doesn't exist
    if (!file_exists($file_path)) {
        $file_path = $docs_dir . 'index.md';
    }
    
    $content = file_get_contents($file_path);
    
    // Process internal links
    $content = preg_replace_callback(
        '/\[([^\]]+)\]\(([^)]+)\)/',
        function($matches) {
            $url = $matches[2];
            // Only process internal links (no http/https)
            if (!preg_match('/^https?:\/\//', $url)) {
                return '[' . $matches[1] . '](admin.php?page=theme-documentation&doc=' . $url . ')';
            }
            return $matches[0];
        },
        $content
    );
    
    // Include Parsedown library for Markdown parsing
    require_once get_stylesheet_directory() . '/inc/admin/Parsedown.php';
    $parsedown = new Parsedown();
    ?>
    <div class="wrap theme-documentation">
        <h1>Theme Documentation</h1>
        
        <div class="theme-docs-navigation">
            <a href="<?php echo admin_url('admin.php?page=theme-documentation'); ?>" class="button">
                Back to Index
            </a>
        </div>

        <div class="theme-docs-content">
            <?php echo wp_kses_post($parsedown->text($content)); ?>
        </div>
    </div>
    <?php
}

/**
 * Add styles for the documentation page
 */
function theme_docs_admin_styles() {
    $screen = get_current_screen();
    if ($screen->id !== 'toplevel_page_theme-documentation') {
        return;
    }
    ?>
    <style>
        .theme-documentation {
            max-width: 1000px;
            margin: 20px;
            padding: 20px;
            background: #fff;
            box-shadow: 0 1px 1px rgba(0,0,0,0.04);
        }
        
        .theme-docs-navigation {
            margin: 20px 0;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        
        .theme-docs-content {
            margin-top: 20px;
        }
        
        .theme-docs-content pre {
            background: #f5f5f5;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow-x: auto;
        }
        
        .theme-docs-content code {
            background: #f5f5f5;
            padding: 2px 5px;
            border-radius: 3px;
        }
        
        .theme-docs-content h1 {
            margin-bottom: 1.5em;
        }
        
        .theme-docs-content h2 {
            margin: 1.5em 0 1em;
            padding-bottom: 0.5em;
            border-bottom: 1px solid #eee;
        }
        
        .theme-docs-content ul {
            list-style: disc;
            margin-left: 20px;
        }
        
        .theme-docs-content a {
            color: #0073aa;
            text-decoration: none;
        }
        
        .theme-docs-content a:hover {
            color: #00a0d2;
        }
    </style>
    <?php
}
add_action('admin_head', 'theme_docs_admin_styles'); 