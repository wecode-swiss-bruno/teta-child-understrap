<?php

/**
 * Header Navbar (bootstrap5)
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

$container = get_theme_mod('understrap_container_type');
$container = "container";
?>

<nav id="main-nav" class="navbar navbar-expand-lg" aria-labelledby="main-nav-label">

	<div class="<?php echo esc_attr($container); ?>">
		<!-- Left Menu -->
		<div class="navbar-left">
			<!-- Burger Menu Button -->
			<button class="navbar-toggler-custom me-2 me-md-5" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarOffcanvas" aria-controls="navbarOffcanvas" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'understrap'); ?>">
				<span class="navbar-toggler-icon">
					<?php include get_stylesheet_directory() . '/img/menu-toggler.svg'; ?>
				</span>
			</button>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'left_menu',
					'container'      => false,
					'menu_class'    => 'navbar-nav d-none d-lg-flex',
					'fallback_cb'   => '',
					'menu_id'       => 'left-menu',
					'depth'         => 1,
					'walker'        => new Understrap_WP_Bootstrap_Navwalker(),
				)
			);
			?>
		</div>

		<!-- Logo -->
		<div class="navbar-brand-wrapper">
			<?php if (! has_custom_logo()) { ?>
				<a class="navbar-brand" rel="home" href="<?php echo esc_url(home_url('/')); ?>" itemprop="url">
					<?php bloginfo('name'); ?>
				</a>
			<?php } else {
				the_custom_logo();
			} ?>
		</div>

		<!-- Right Menu -->
		<div class="navbar-right">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'right_menu',
					'container'      => false,
					'menu_class'    => 'navbar-nav d-none d-lg-flex',
					'fallback_cb'   => '',
					'menu_id'       => 'right-menu',
					'depth'         => 1,
					'walker'        => new Understrap_WP_Bootstrap_Navwalker(),
				)
			);
			?>

			<!-- Search Icon and Form -->
			<div class="search-wrapper">
				<button class="search-toggle" aria-label="Toggle search">
					<i class="fa fa-search"></i>
				</button>
				<div class="search-form-wrapper mx-auto">
					<form rol="search" method="get" class="search-form container mx-auto justify-content-between" action="<?php echo esc_url(home_url('/')); ?>">
						<input type="search" class="search-field" placeholder="Rechercher..." value="<?php echo get_search_query(); ?>" name="s">
						<button type="button" class="search-close" aria-label="Fermer la recherche">
							<i class="fa fa-times"></i>
						</button>
					</form>
				</div>
			</div>
		</div>

	</div><!-- .container(-fluid) -->

	<!-- Offcanvas Menu -->
	<div class="offcanvas offcanvas-start" tabindex="-1" id="navbarOffcanvas">
		<div class="container mx-auto position-relative">
			<div class="offcanvas-header">
				<button type="button" class="btn-close" aria-label="Close"></button>
			</div>

			<div class="offcanvas-body">
				<div class="offcanvas-logo">
					<?php the_custom_logo(); ?>
				</div>

				<div class="offcanvas-nav">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'container'      => false,
							'menu_class'    => 'navbar-nav',
							'fallback_cb'   => '',
							'menu_id'       => 'offcanvas-menu',
							'depth'         => 1,
							'walker'        => new Understrap_WP_Bootstrap_Navwalker(),
						)
					);
					?>
				</div>

				<div class="offcanvas-social">
					<a href="#" class="social-icon" target="_blank" rel="noopener noreferrer">
						<i class="fab fa-linkedin-in"></i>
					</a>
					<a href="https://www.instagram.com/tetamag.ch/" class="social-icon" target="_blank" rel="noopener noreferrer">
						<i class="fab fa-instagram"></i>
					</a>
				</div>
			</div>
		</div>
	</div>
</nav>