<?php

/**
 * Template part for displaying the article grid split layout
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Get settings and posts
$posts_handling = get_sub_field('posts_handling');
$posts = get_posts_by_settings($posts_handling, 4);
$overlay = get_overlay_attributes($posts_handling);

// Get and process section title
$section_title = get_section_title(get_sub_field('section_title'));
$section_id = generate_section_id('grid-split-articles', $section_title);

if ($posts && count($posts) >= 4) : ?>
    <div class="grid-split-posts-wrapper">
        <?php render_section_title($section_title, $section_id); ?>
        <div class="container-fluid p-0">
            <div class="row g-0">
                <!-- Left Column -->
                <div class="col-md-6">
                    <div class="row g-0">
                        <!-- Top Article -->
                        <?php
                        $post = $posts[0];
                        setup_postdata($post);
                        $thumbnail_url = get_the_post_thumbnail_url($post->ID, 'full');
                        ?>
                        <div class="col-12">
                            <article class="grid-article grid-article-large" <?php if ($thumbnail_url) : ?>style="background-image: url('<?php echo esc_url($thumbnail_url); ?>');" <?php endif; ?>>
                                <div class="overlay" style="background-color: <?php echo esc_attr($overlay['rgba']); ?>;"></div>
                                <div class="content-wrapper">
                                    <a href="<?php echo get_permalink($post); ?>" class="post-link">
                                        <h2><?php echo esc_html(get_the_title($post)); ?></h2>
                                        <div class="excerpt">
                                            <?php echo wp_kses_post(get_the_excerpt($post)); ?>
                                        </div>
                                        <?php render_post_meta($posts_handling, $post); ?>
                                    </a>
                                </div>
                            </article>
                        </div>

                        <!-- Bottom Two Articles -->
                        <?php for ($i = 1; $i <= 2; $i++) :
                            $post = $posts[$i];
                            setup_postdata($post);
                            $thumbnail_url = get_the_post_thumbnail_url($post->ID, 'full');
                        ?>
                            <div class="col-md-6">
                                <article class="grid-article grid-article-medium" <?php if ($thumbnail_url) : ?>style="background-image: url('<?php echo esc_url($thumbnail_url); ?>');" <?php endif; ?>>
                                    <div class="overlay" style="background-color: <?php echo esc_attr($overlay['rgba']); ?>;"></div>
                                    <div class="content-wrapper">
                                        <a href="<?php echo get_permalink($post); ?>" class="post-link">
                                            <h2><?php echo esc_html(get_the_title($post)); ?></h2>
                                            <div class="excerpt">
                                                <?php echo wp_kses_post(get_the_excerpt($post)); ?>
                                            </div>
                                            <?php render_post_meta($posts_handling, $post); ?>
                                        </a>
                                    </div>
                                </article>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-6">
                    <?php
                    $post = $posts[3];
                    setup_postdata($post);
                    $thumbnail_url = get_the_post_thumbnail_url($post->ID, 'full');
                    ?>
                    <article class="grid-article grid-article-full" <?php if ($thumbnail_url) : ?>style="background-image: url('<?php echo esc_url($thumbnail_url); ?>');" <?php endif; ?>>
                        <div class="overlay" style="background-color: <?php echo esc_attr($overlay['rgba']); ?>;"></div>
                        <div class="content-wrapper">
                            <a href="<?php echo get_permalink($post); ?>" class="post-link">
                                <h2><?php echo esc_html(get_the_title($post)); ?></h2>
                                <div class="excerpt">
                                    <?php echo wp_kses_post(get_the_excerpt($post)); ?>
                                </div>
                                <?php render_post_meta($posts_handling, $post); ?>
                            </a>
                        </div>
                    </article>
                </div>
            </div>
        </div>
        <?php render_display_more($posts_handling, $section_id); ?>
    </div>
<?php
    wp_reset_postdata();
endif; ?>