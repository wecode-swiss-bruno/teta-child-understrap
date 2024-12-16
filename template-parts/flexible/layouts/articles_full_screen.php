<?php

/**
 * Template part for displaying the article full screen layout
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Get settings and posts
$posts_handling = get_sub_field('posts_handling');
$posts_count = $posts_handling['number_of_posts_to_display'] ?? 3;
$posts = get_posts_by_settings($posts_handling, $posts_count);
$overlay = get_overlay_attributes($posts_handling);

// Get and process section title
$section_title = get_section_title(get_sub_field('section_title'));
$section_id = generate_section_id('fullscreen-articles', $section_title);

if ($posts) : ?>
    <div class="fullscreen-posts-wrapper">
        <?php render_section_title($section_title, $section_id); ?>
        <?php foreach ($posts as $post):
            setup_postdata($post);
            $thumbnail_url = get_the_post_thumbnail_url($post->ID, 'full');
        ?>
            <section class="article-full-screen" <?php if ($thumbnail_url) : ?>style="background-image: url('<?php echo esc_url($thumbnail_url); ?>');" <?php endif; ?>>
                <div class="overlay" style="background-color: <?php echo esc_attr($overlay['rgba']); ?>;"></div>
                <div class="container mx-auto px-3 px-md-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="content-wrapper">
                                <div class="content-wrapper-aligner">
                                    <a href="<?php echo get_permalink($post); ?>" class="post-link">
                                        <h2><?php echo esc_html(get_the_title($post)); ?></h2>
                                        <div class="excerpt">
                                            <?php echo wp_kses_post(get_the_excerpt($post)); ?>
                                        </div>
                                        <?php render_post_meta($posts_handling, $post); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endforeach; ?>
        <?php render_display_more($posts_handling, $section_id); ?>
    </div>
<?php
    wp_reset_postdata();
endif; ?>