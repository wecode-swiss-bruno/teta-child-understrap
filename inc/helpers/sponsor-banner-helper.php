<?php

/**
 * Helper functions for sponsor banner
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Render sponsor banner
 *
 * @param array $args Banner parameters
 * @return string HTML output
 */
function render_sponsor_banner($args = array())
{
    // Default values
    $defaults = array(
        'title' => 'Sponsorisé par',
        'image' => '',
        'link' => '',
        'margin' => 'default'
    );

    $args = wp_parse_args($args, $defaults);

    // Handle image parameter - could be ID or URL
    $image_url = '';
    if (!empty($args['image'])) {
        if (is_numeric($args['image'])) {
            // It's an ID
            $image_array = wp_get_attachment_image_src($args['image'], 'full');
            $image_url = $image_array[0] ?? '';
        } else {
            // It's a URL
            $image_url = $args['image'];
        }
    }

    // If no valid image, return empty
    if (empty($image_url)) {
        return '';
    }

    // Get margin class
    $margin_class = 'sponsor-margin-' . $args['margin'];

    ob_start();
?>
    <div class="sponsor-banner <?php echo esc_attr($margin_class); ?>">
        <div class="container">
            <div class="sponsor-title"><?php echo esc_html($args['title']); ?></div>
            <?php if ($args['link']) : ?>
                <a href="<?php echo esc_url($args['link']); ?>" target="_blank" rel="noopener">
            <?php endif; ?>
                <div class="sponsor-image-wrapper">
                    <div class="sponsor-image" style="background-image: url('<?php echo esc_url($image_url); ?>');"></div>
                </div>
            <?php if ($args['link']) : ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
<?php
    return ob_get_clean();
}

/**
 * Shortcode handler for sponsor banner
 */
function sponsor_banner_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'title' => 'Sponsorisé par',
        'image' => '',
        'link' => '',
        'margin' => 'default'
    ), $atts, 'sponsor_banner');

    return render_sponsor_banner($atts);
}
add_shortcode('sponsor_banner', 'sponsor_banner_shortcode');
