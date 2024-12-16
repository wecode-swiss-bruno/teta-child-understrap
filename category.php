<?php

/**
 * The template for displaying category pages
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();

// Get current category - Updated to handle both category and archive pages
$category = get_queried_object();

// Verify we have a valid category
if (!$category || !is_category()) {
    // Redirect to home if not a valid category page
    wp_redirect(home_url());
    exit;
}

$posts_per_page = 10;
$paged = get_query_var('paged') ? get_query_var('paged') : 1;

// Setup query
$args = array(
    'post_type' => 'post',
    'posts_per_page' => $posts_per_page,
    'cat' => $category->term_id,
    'paged' => $paged
);

$query = new WP_Query($args);

// Setup posts handling array to match articles_full_screen expectations
$posts_handling = array(
    'posts_selection' => 'categories',
    'categories_to_display' => array($category->term_id),
    'number_of_posts_to_display' => $posts_per_page,
    'display_date' => true,
    'display_categories' => true,
    'overlay' => array(
        'overlay_color' => '#000000',
        'overlay_opacity' => 60
    )
);

// Generate section ID
$section_title = $category->name;
$section_id = generate_section_id('category-articles', $section_title);
?>

<div class="wrapper" id="category-wrapper">
    <div id="content" tabindex="-1">
        <?php if ($query->have_posts()) : ?>
            <div class="fullscreen-posts-wrapper">
                <div class="container mx-auto">
                <h1 id="<?php echo esc_attr($section_id); ?>" class="section-title">
                        <?php echo esc_html($category->name); ?>.
                    </h1>
                </div>

                <?php
                while ($query->have_posts()) :
                    $query->the_post();
                    $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                ?>
                    <section class="article-full-screen" <?php if ($thumbnail_url) : ?>style="background-image: url('<?php echo esc_url($thumbnail_url); ?>');" <?php endif; ?>>
                        <div class="overlay" style="background-color: <?php echo esc_attr(sprintf('rgba(0, 0, 0, %s)', 0.6)); ?>;"></div>
                        <div class="container mx-auto">
                            <div class="row">
                                <div class="col-12">
                                    <div class="content-wrapper">
                                        <div class="content-wrapper-aligner">
                                            <a href="<?php the_permalink(); ?>" class="post-link">
                                                <h2><?php the_title(); ?></h2>
                                                <div class="excerpt">
                                                    <?php the_excerpt(); ?>
                                                </div>
                                                <?php render_post_meta($posts_handling, $post); ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                <?php endwhile; ?>

                <?php if ($query->max_num_pages > 1) : ?>
                    <div class="pagination-wrapper">
                        <?php
                        echo paginate_links(array(
                            'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                            'format' => '?paged=%#%',
                            'current' => max(1, $paged),
                            'total' => $query->max_num_pages,
                            'prev_text' => '<i class="fas fa-chevron-left"></i>',
                            'next_text' => '<i class="fas fa-chevron-right"></i>',
                            'type' => 'list'
                        ));
                        ?>
                    </div>
                <?php endif; ?>
                <?php
                $sponsor_data = array(
                    'title' => 'Sponsorisé par',
                    'image' => 150,  // Image ID or URL
                    'link' => 'https://google.com',
                    'margin' => 'xl'
                );
                echo render_sponsor_banner($sponsor_data);
                ?>
            </div>
        <?php else : ?>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <p class="no-posts-message">
                            <?php _e('Aucun article trouvé dans cette catégorie.', 'tetaz-dev'); ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
wp_reset_postdata();
get_footer();
?>