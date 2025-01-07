<?php

/**
 * Template Name: Page statique
 *
 * Template for displaying a page without sidebar even if a sidebar widget is published.
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();
$container = get_theme_mod('understrap_container_type');

if (is_front_page()) {
	get_template_part('global-templates/hero');
}

$wrapper_id = !defined('STATIC_PAGE_NO_TITLE') ? 'full-width-page-wrapper' : 'no-title-page-wrapper';
?>

<div class="wrapper static-page" id="<?php echo $wrapper_id; ?>">
	<?php if (!defined('STATIC_PAGE_NO_TITLE')) : ?>
		<div class="<?php echo esc_attr($container); ?>" id="title-container">
			<div class="row">
				<div class="col-12">
					<h1 class="entry-title text-uppercase"><?php the_title(); ?>.</h1>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<div class="container-sm" id="content">
		<div class="row">
			<div class="col-md-12 content-area" id="primary">
				<main class="site-main" id="main" role="main">
					<?php
					while (have_posts()) {
						the_post();
					?>
						<div class="content">
							<?php get_template_part('template-parts/flexible/page-builder'); ?>
						</div>
					<?php
						// If comments are open or we have at least one comment, load up the comment template.
						if (comments_open() || get_comments_number()) {
							comments_template();
						}
					}
					?>
				</main>
			</div><!-- #primary -->
		</div><!-- .row -->
	</div><!-- #content -->
</div><!-- #<?php echo $wrapper_id; ?> -->

<?php
get_footer();
