<?php
/**
 * Helper functions for article display layouts
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Get posts based on settings
 *
 * @param array $posts_handling ACF posts_handling field
 * @param int $posts_count Number of posts to retrieve
 * @return array
 */
function get_posts_by_settings($posts_handling, $posts_count) {
    if (empty($posts_handling['posts_selection'])) {
        return [];
    }

    switch ($posts_handling['posts_selection']) {
        case 'manual':
            return $posts_handling['posts'] ?? [];
            
        case 'categories':
            $args = [
                'post_type' => 'post',
                'posts_per_page' => $posts_count,
            ];
            
            if (!empty($posts_handling['categories_to_display'])) {
                $args['category__in'] = $posts_handling['categories_to_display'];
            }
            
            $query = new WP_Query($args);
            return $query->posts;
            
        case 'featured':
            $args = [
                'post_type' => 'post',
                'posts_per_page' => $posts_count,
                'meta_query' => [
                    [
                        'key' => '_is_featured',
                        'value' => '1',
                        'compare' => '='
                    ]
                ]
            ];
            $query = new WP_Query($args);
            return $query->posts;
            
        case 'lasts':
            $args = [
                'post_type' => 'post',
                'posts_per_page' => $posts_count,
            ];
            $query = new WP_Query($args);
            return $query->posts;
            
        default:
            return [];
    }
}

/**
 * Get overlay style attributes
 *
 * @param array $posts_handling ACF posts_handling field
 * @return array
 */
function get_overlay_attributes($posts_handling) {
    $overlay = $posts_handling['overlay'] ?? [];
    $overlay_color = $overlay['overlay_color'] ?? '#000000';
    $overlay_opacity = $overlay['overlay_opacity'] ?? 50;
    $opacity_decimal = $overlay_opacity / 100;

    $overlay_rgb = sscanf($overlay_color, "#%02x%02x%02x");
    $overlay_rgba = sprintf('rgba(%d, %d, %d, %s)', 
        $overlay_rgb[0], 
        $overlay_rgb[1], 
        $overlay_rgb[2], 
        $opacity_decimal
    );

    return [
        'color' => $overlay_color,
        'opacity' => $overlay_opacity,
        'rgba' => $overlay_rgba
    ];
}

/**
 * Render post meta information
 *
 * @param array $posts_handling Display settings
 * @param WP_Post $post Post object
 * @return void
 */
function render_post_meta($posts_handling, $post) {
    $display_date = $posts_handling['display_date'] ?? true;
    $display_categories = $posts_handling['display_categories'] ?? true;
    
    if (!$display_date && !$display_categories) {
        return;
    }
    ?>
    <div class="post-meta">
        <?php if ($display_date) : ?>
            <span class="post-date"><?php echo esc_html(get_the_date('j F Y', $post)); ?></span>
        <?php endif; ?>

        <?php if ($display_categories) : 
            $categories = get_the_category($post); ?>
            <?php if ($categories) : ?>
                <div class="categories">
                    <?php foreach ($categories as $category) : ?>
                        <span class="category-badge"><?php echo esc_html($category->name); ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * Get section title from ACF field
 *
 * @param array $section_title ACF section_title field
 * @return string|null
 */
function get_section_title($section_title) {
    if (empty($section_title) || empty($section_title['section_title_value'])) {
        return null;
    }
    return $section_title['section_title_value'];
}

/**
 * Generate unique section ID
 *
 * @param string $base_name Base name for the section
 * @param string $title Section title (optional)
 * @return string
 */
function generate_section_id($base_name, $title = '') {
    static $counters = [];
    
    // Create a clean base for the ID
    $clean_base = sanitize_title($base_name);
    
    // Add title to make it more specific if provided
    if ($title) {
        $clean_base .= '-' . sanitize_title($title);
    }
    
    // Initialize counter for this base if not exists
    if (!isset($counters[$clean_base])) {
        $counters[$clean_base] = 0;
    }
    
    // Increment counter
    $counters[$clean_base]++;
    
    // Add counter if it's greater than 1
    $section_id = $clean_base;
    if ($counters[$clean_base] > 1) {
        $section_id .= '-' . $counters[$clean_base];
    }
    
    return $section_id;
}

/**
 * Render section title
 *
 * @param string $title Section title
 * @param string $section_id Section ID
 * @param string $classes Additional CSS classes (optional)
 * @return void
 */
function render_section_title($title, $section_id, $classes = '') {
    if (empty($title)) {
        return;
    }
    
    $title_classes = 'section-title';
    if ($classes) {
        $title_classes .= ' ' . $classes;
    }
    ?>
    <h2 id="<?php echo esc_attr($section_id); ?>" class="<?php echo esc_attr($title_classes); ?>">
        <?php echo esc_html($title); ?>
    </h2>
    <?php
}

/**
 * Render display more button
 *
 * @param array $posts_handling Posts handling settings
 * @param string $section_id Section ID for targeting
 * @return void
 */
function render_display_more($posts_handling, $section_id) {
    $show_display_more = $posts_handling['show_display_more'] ?? false;
    $display_more_text = $posts_handling['display_more_text'] ?? 'Load more';
    
    if (!$show_display_more) {
        return;
    }
    ?>
    <div class="display-more-wrapper">
        <button 
            class="display-more-button" 
            data-section="<?php echo esc_attr($section_id); ?>"
            data-posts-handling='<?php echo esc_attr(json_encode($posts_handling)); ?>'
        >
            <?php echo esc_html($display_more_text); ?>
        </button>
    </div>
    <?php
} 