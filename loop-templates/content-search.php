<?php
/**
 * Search results partial template
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;
?>

<article <?php post_class('mb-4'); ?> id="post-<?php the_ID(); ?>">
    <header class="entry-header">
        <?php
        the_title(
            sprintf('<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())),
            '</a></h2>'
        );
        ?>

        <?php if ('post' === get_post_type()) : ?>
            <div class="entry-meta">
                <small class="text-muted">
                    <?php understrap_posted_on(); ?>
                </small>
            </div>
        <?php endif; ?>
    </header>

    <div class="entry-summary">
        <?php the_excerpt(); ?>
    </div>

    <footer class="entry-footer">
        <a href="<?php echo esc_url(get_permalink()); ?>" class="btn btn-outline-primary btn-sm">
            <?php esc_html_e('Read More', 'tetaz-dev'); ?>
        </a>
    </footer>
</article> 