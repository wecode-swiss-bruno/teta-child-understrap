<?php

/**
 * Template part for displaying the article full screen layout
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Get posts
$posts = get_sub_field('posts');

if ($posts) : ?>
    <div class="fullscreen-posts-wrapper">
        <?php foreach ($posts as $post):
            setup_postdata($post);

            // Get post data
            $post_title = get_the_title();
            $categories = get_the_category();
            $excerpt = get_the_excerpt();
            $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
            
            // Get formatted date
            $post_date = get_the_date('j F Y');

            // Get overlay settings
            $overlay_color = get_sub_field('overlay_color') ?: '#000000';
            $overlay_opacity = get_sub_field('overlay_opacity') ?: 50;
            $opacity_decimal = $overlay_opacity / 100;

            // Generate rgba color for overlay
            $overlay_rgb = sscanf($overlay_color, "#%02x%02x%02x");
            $overlay_rgba = sprintf('rgba(%d, %d, %d, %s)', $overlay_rgb[0], $overlay_rgb[1], $overlay_rgb[2], $opacity_decimal);
        ?>

            <section class="article-full-screen" <?php if ($thumbnail_url) : ?>style="background-image: url('<?php echo esc_url($thumbnail_url); ?>');" <?php endif; ?>>
                <div class="overlay" style="background-color: <?php echo esc_attr($overlay_rgba); ?>;"></div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="content-wrapper">
                                <div class="content-wrapper-aligner">
                                    <a href="<?php the_permalink(); ?>" class="post-link">
                                        <?php if ($post_title) : ?>
                                            <h2><?php echo esc_html($post_title); ?></h2>
                                        <?php endif; ?>

                                      

                                        <?php if ($excerpt) : ?>
                                            <div class="excerpt">
                                                <?php echo wp_kses_post($excerpt); ?>
                                            </div>
                                        <?php endif; ?>

                                        <div class="post-meta">
                                            <?php if ($post_date) : ?>
                                                <span class="post-date"><?php echo esc_html($post_date); ?></span>
                                            <?php endif; ?>

                                            <?php if ($categories) : ?>
                                                <div class="categories">
                                                    <?php foreach ($categories as $category) : ?>
                                                        <span class="category-badge"><?php echo esc_html($category->name); ?></span>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        <?php endforeach; ?>
    </div>
<?php
    wp_reset_postdata();
endif; ?>