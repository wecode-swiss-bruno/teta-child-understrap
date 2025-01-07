<?php
if (!defined('ABSPATH')) exit;

global $post;
$thumbnail_url = get_the_post_thumbnail_url($post->ID, 'full');
$permalink = get_permalink();
$title = get_the_title();
$date = get_the_date('j F Y');
$excerpt = wp_trim_words(get_the_excerpt(), 20);

// Debug information
error_log('Related post card data: ' . print_r([
    'ID' => $post->ID,
    'title' => $title,
    'permalink' => $permalink,
    'date' => $date,
    'excerpt' => $excerpt,
    'thumbnail' => $thumbnail_url
], true));
?>
<div class="col-md-4">
    <article class="related-post-card">
        <a href="<?php echo esc_url($permalink); ?>" class="image-link">
            <div class="image-wrapper">
                <div class="post-thumbnail" <?php if ($thumbnail_url) : ?>style="background-image: url('<?php echo esc_url($thumbnail_url); ?>');"<?php endif; ?>>
                    <div class="overlay"></div>
                    <div class="content">
                        <h3><?php echo esc_html($title); ?></h3>
                        <div class="post-date"><?php echo esc_html($date); ?></div>
                    </div>
                </div>
            </div>
        </a>
        <div class="excerpt">
            <?php echo esc_html($excerpt); ?>
        </div>
    </article>
</div> 