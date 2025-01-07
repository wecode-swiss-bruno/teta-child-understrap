<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Debug variables
error_log('Loading article-fullscreen.php template');
error_log('Post data: ' . print_r($post, true));
error_log('Posts handling: ' . print_r($posts_handling, true));

// Get the thumbnail URL and overlay
$thumbnail_url = get_the_post_thumbnail_url($post->ID, 'full');
$overlay = get_overlay_attributes($posts_handling);
?>
<a href="<?php echo get_permalink($post); ?>" class="post-link">
    <section class="article-full-screen" <?php if ($thumbnail_url) : ?>style="background-image: url('<?php echo esc_url($thumbnail_url); ?>');" <?php endif; ?>>
        <div class="overlay" style="background-color: <?php echo esc_attr($overlay['rgba']); ?>;"></div>
        <div class="container mx-auto px-3 px-md-0">
            <div class="row">
                <div class="col-12">
                    <div class="content-wrapper">
                        <div class="content-wrapper-aligner">
                            <h2><?php echo esc_html(get_the_title($post)); ?></h2>
                            <div class="excerpt">
                                <?php echo wp_kses_post(get_the_excerpt($post)); ?>
                            </div>
                            <?php render_post_meta($posts_handling, $post); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</a> 