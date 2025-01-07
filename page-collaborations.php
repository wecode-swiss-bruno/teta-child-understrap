<?php
/**
 * Template Name: Collaborations Page
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();

$args = array(
    'post_type' => 'collaboration',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'DESC'
);

$collaborations = new WP_Query($args);
?>

<div class="wrapper" id="collaborations-wrapper">
    <div id="content" tabindex="-1">
        <div class="container mx-auto bg-white">
            <h1 class="section-title">
                <?php echo get_the_title(); ?>.
            </h1>
        </div>


        <div class="container-fluid mx-auto g-0 bg-black">
            <div class="row gap-0 g-0">
                <?php if ($collaborations->have_posts()) : ?>
                    <?php while ($collaborations->have_posts()) : $collaborations->the_post(); 
                        $pdf_url = get_field('article_pdf'); // Assuming you have an ACF field for the PDF
                        if (!$pdf_url) {
                            $pdf_url = get_permalink(); // Fallback to permalink if no PDF
                        }
                        $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                    ?>
                        <div class="col-md-6 col-xl-4 g-0">
                            <a href="<?php echo esc_url($pdf_url); ?>" target="_blank" rel="noopener noreferrer" class="collaboration-item">
                                <div class="collaboration-image-wrapper">
                                    <?php if ($thumbnail_url) : ?>
                                        <div class="collaboration-image" style="background-image: url('<?php echo esc_url($thumbnail_url); ?>');"></div>
                                    <?php endif; ?>
                                    <div class="collaboration-overlay">
                                        <!-- <h2><?php the_title(); ?></h2> -->
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <div class="col-12">
                        <p class="no-posts-message">
                            <?php _e('Aucune collaboration trouvée.', 'tetaz-dev'); ?>
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
wp_reset_postdata();
get_footer();
?> 