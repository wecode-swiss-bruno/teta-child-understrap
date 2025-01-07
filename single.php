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
    $overlay_rgba = 'rgba(0, 0, 0, 1)';
    $overlay_opacity = get_field('overlay_opacity') ?? 45;
    if(is_numeric($overlay_opacity)){
        $overlay_opacity = $overlay_opacity/100;
    }
    else{
        $overlay_opacity = 0.45;
    }?>

    <article <?php post_class('single-post'); ?> id="post-<?php the_ID(); ?>">
        <!-- Hero Section -->
        <div class="article-full-screen hero-section" <?php if ($thumbnail_url) : ?>style="background-image: url('<?php echo esc_url($thumbnail_url); ?>');" <?php endif; ?>>
            <div class="overlay" style="background-color: <?php echo esc_attr($overlay_rgba); ?>; opacity: <?php echo esc_attr($overlay_opacity/100); ?>;"></div>
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
        <section class="related-posts-section">
            <div class="container mx-auto">
                <h2 class="related-posts-title"><?php _e('Articles similaires', 'tetaz-dev'); ?></h2>
                
                <div class="row related-posts-row">
                    <?php
                    $related_posts = get_posts(array(
                        'category__in' => wp_get_post_categories($post->ID),
                        'post__not_in' => array($post->ID),
                        'posts_per_page' => 3,
                        'orderby' => 'date',
                        'order' => 'DESC'
                    ));

                    foreach ($related_posts as $post) {
                        setup_postdata($post);
                        include(get_stylesheet_directory() . '/template-parts/flexible/partials/related-post-card.php');
                    }
                    wp_reset_postdata();
                    ?>

                    
                </div>

                

                <?php if (count($related_posts) >= 3) : ?>
                    <div class="load-more-wrapper">
                        <button 
                            class="load-more-button" 
                            data-current-post-id="<?php echo get_the_ID(); ?>"
                        >
                            <?php _e('Voir plus d\'articles', 'tetaz-dev'); ?>
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </article>

<?php
endwhile;
get_footer();
?>