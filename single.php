<?php

/**
 * The template for displaying single posts
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();

while (have_posts()) :
    the_post();

    // Get post data
    $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
    $categories = get_the_category();
    $post_date = get_the_date('j F Y');

    // Setup overlay (matching articles_full_screen style)
    $overlay_rgba = 'rgba(0, 0, 0, 0.6)';
?>

    <article <?php post_class('single-post'); ?> id="post-<?php the_ID(); ?>">
        <!-- Hero Section -->
        <div class="article-full-screen hero-section" <?php if ($thumbnail_url) : ?>style="background-image: url('<?php echo esc_url($thumbnail_url); ?>');" <?php endif; ?>>
            <div class="overlay" style="background-color: <?php echo esc_attr($overlay_rgba); ?>;"></div>
            <div class="container mx-auto">
                <div class="row">
                    <div class="col-12">
                        <div class="content-wrapper">
                            <div class="content-wrapper-aligner">
                                <!-- Categories -->
                                <?php if ($categories) : ?>
                                    <div class="categories">
                                        <?php foreach ($categories as $category) : ?>
                                            <span class="category-badge"><?php echo esc_html($category->name); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Title -->
                                <h1 class="entry-title"><?php the_title(); ?></h1>

                                <!-- Excerpt -->
                                <div class="excerpt">
                                    <?php the_excerpt(); ?>
                                </div>

                                <!-- Date -->
                                <div class="post-meta">
                                    <span class="post-date"><?php echo esc_html($post_date); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="entry-content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Posts Section -->
        <?php
        // Get current post categories
        $categories = wp_get_post_categories(get_the_ID());

        // Query related posts
        $related_args = array(
            'post_type' => 'post',
            'posts_per_page' => 4,
            'post__not_in' => array(get_the_ID()),
            'category__in' => $categories,
            'orderby' => 'date',
            'order' => 'DESC'
        );

        $related_posts = new WP_Query($related_args);

        if ($related_posts->have_posts()) :
        ?>
            <div class="related-posts-section">
                <div class="container mx-auto">
                    <h2 class="related-posts-title">À lire aussi</h2>
                </div>
                <div class="container mx-auto">

                    <div class="row  flex-lg-nowrap">
                        <?php while ($related_posts->have_posts()) : $related_posts->the_post(); ?>
                            <div class="col-xl-3 col-lg-4 col-md-6 g-0 related-post-column">
                                <div class="related-post-card">
                                    <a href="<?php the_permalink(); ?>" class="image-link">
                                        <div class="image-wrapper">
                                            <?php if (has_post_thumbnail()) : ?>
                                                <div class="post-thumbnail" style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>');">
                                                    <div class="overlay"></div>
                                                    <div class="content">
                                                        <h3><?php the_title(); ?></h3>
                                                        <span class="post-date"><?php echo get_the_date('j F Y'); ?></span>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </a>
                                    <div class="excerpt">
                                        <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>

                    <div class="load-more-wrapper">
                        <button class="load-more-button" data-post-id="<?php echo get_the_ID(); ?>">
                            Voir plus d'articles
                        </button>
                    </div>
                </div>
            </div>
        <?php
        endif;
        wp_reset_postdata();
        ?>
    </article>

<?php
endwhile;
get_footer();
?>