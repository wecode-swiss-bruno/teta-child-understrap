<?php

/**
 * Header Navbar (bootstrap5)
 *
 * @package Understrap
 * @since 1.1.0
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

$container = get_theme_mod('understrap_container_type');
$container = 'container';
?>

<nav id="main-nav" class="navbar navbar-dark sticky-top bg-transparent" aria-labelledby="main-nav-label">

	<h2 id="main-nav-label" class="screen-reader-text">
		<?php esc_html_e('Main Navigation', 'understrap'); ?>
	</h2>


	<div class="<?php echo esc_attr($container); ?>">

		<div class="navbar-left d-flex col-4">
			<button
				class="navbar-toggler me-3"
				type="button"
				data-bs-toggle="offcanvas"
				data-bs-target="#navbarNavOffcanvas"
				aria-controls="navbarNavOffcanvas"
				aria-expanded="false"
				aria-label="<?php esc_attr_e('Open menu', 'understrap'); ?>">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="offcanvas offcanvas-start bg-primary-dark w-100 container" tabindex="-1" id="navbarNavOffcanvas">

				<div class="offcanvas-header justify-content-start">
					<button
						class="btn-close btn-close-white text-reset"
						type="button"
						data-bs-dismiss="offcanvas"
						aria-label="<?php esc_attr_e('Close menu', 'understrap'); ?>"></button>
				</div><!-- .offcancas-header -->

				<!-- The WordPress Menu goes here -->
				<?php
				wp_nav_menu(
					array(
						'theme_location'  => 'primary',
						'container_class' => 'offcanvas-body d-flex justify-content-center align-items-center',
						'container_id'    => '',
						'menu_class'      => 'navbar-nav justify-content-center align-items-center pb-5 display-6 font-weight-regular font-family-primary',
						'fallback_cb'     => '',
						'menu_id'         => 'main-menu',
						'depth'           => 2,
						'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
					)
				);
				?>
			</div><!-- .offcanvas -->
			<div class="navbar-left-menu">
				<?php wp_nav_menu(array(
					'theme_location'  => 'header-left',
					'menu_class'      => 'navbar-nav justify-content-end',
					'fallback_cb'     => '',
					'menu_id'         => 'header-left-menu',
					'depth'           => 2,
					'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
				)); ?>
			</div>
		</div> <!-- .navbar-left -->
		<div class="navbar-center mx-auto text-center col-4">
			<?php get_template_part('global-templates/navbar-branding'); ?>
		</div> <!-- .navbar-center -->
		<div class="navbar-right  col-4">
			<div class="navbar-right-menu">
				<?php wp_nav_menu(array(
					'theme_location'  => 'header-right',
					'menu_class'      => 'navbar-nav justify-content-end align-items-end',
					'fallback_cb'     => '',
					'menu_id'         => 'header-right-menu',
					'depth'           => 2,
					'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
				)); ?>
			</div>
		</div> <!-- .navbar-right -->
	</div><!-- .container(-fluid) -->

</nav><!-- #main-nav -->