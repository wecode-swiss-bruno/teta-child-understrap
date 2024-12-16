<?php
/**
 * The template for displaying the footer
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;
?>

<div class="wrapper" id="wrapper-footer">
    <footer class="site-footer">
        <div class="container footer-container">
            <!-- Logo Row -->
            <div class="row footer-logo-row">
                <div class="col-12 text-center">
                    <?php if (has_custom_logo()) : ?>
                        <?php
                        $custom_logo_id = get_theme_mod('custom_logo');
                        $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                        ?>
                        <img src="<?php echo esc_url($logo[0]); ?>" 
                             alt="<?php echo get_bloginfo('name'); ?>" 
                             class="footer-logo"
                             width="125"
                        >
                    <?php endif; ?>
                </div>
            </div>

            <!-- Content Row -->
            <div class="row footer-content-row">
                <!-- Footer Menu -->
                <div class="col-md-6">
                    <nav class="footer-navigation">
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'footer_menu',
                                'container'      => false,
                                'menu_class'     => 'footer-menu',
                                'fallback_cb'    => '',
                                'depth'          => 1,
                            )
                        );
                        ?>
                    </nav>
                </div>

                <!-- Newsletter and Social -->
                <div class="col-md-6">
                    <!-- Newsletter Block -->
                    <div class="footer-newsletter">
                        <p class="newsletter-title">
                            Inscrivez-vous à notre newsletter pour suivre toutes les actualités :
                        </p>
                        <form class="newsletter-form" action="#" method="POST">
                            <div class="input-group">
                                <input type="email" 
                                       class="form-control" 
                                       placeholder="Votre email" 
                                       required
                                >
                                <button type="submit" class="btn btn-newsletter">
                                    Je m'inscris
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Social Block -->
                    <div class="footer-social">
                        <p class="social-title">Trouvez-nous</p>
                        <div class="social-icons">
                            <a href="#" class="social-icon" target="_blank" rel="noopener">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="social-icon" target="_blank" rel="noopener">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
	<div class="footer-bottom">
		<div class="container">
			<p class="footer-bottom-text">
				&copy; <?php echo date('Y'); ?> teta. Tous droits réservés. Design by PAW! Development by Wecode.
			</p>
		</div>
	</div>
</div>

<?php wp_footer(); ?>

</body>
</html>

