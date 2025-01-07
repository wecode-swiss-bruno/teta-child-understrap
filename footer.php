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
                            width="125">
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
                        <form method="post" action="https://newsletter.infomaniak.com/v3/api/1/newsletters/webforms/19520/submit" class="inf-form newsletter-form"><input type="email" name="email" style="display:none" /><input type="hidden" name="key" value="eyJpdiI6IjBtZ3FcLzJiQUxkUURWODZtS2ZPbUtrQXRWd2RwMGpKYlNzTWhQTFwvaFwvVG89IiwibWFjIjoiOWI2ZTIyNmZjMzQ3ZTdkNmI3MzI0OTVhOGFmNzAyMjYyNTlmNDVkYTNlYTc1OTZiYmUzOThhNmVlNWE0MWQ5NiIsInZhbHVlIjoiZWdpd0xNQTJqcENUME4xckh2aFZheTFmbkx6UncxQ0NMc1l5Nms3TDhjND0ifQ=="><input type="hidden" name="webform_id" value="19520">
                            <style>
                            </style>
                            <div class="inf-main_db056ecf99d3fedd1f0c87aa2f39f2ee">
                                                           <div class="inf-success" style="display:none">
                                    <h4>Votre inscription a été enregistrée avec succès !</h4>
                                    <p> <a href="#" class="inf-btn">&laquo;</a> </p>
                                </div>
                                <div class="input-group">
                                    <input type="email" 
                                           class="newsletter-email-input" 
                                           name="inf[1]" 
                                           data-inf-meta="1" 
                                           data-inf-error="" 
                                           required="required" 
                                           placeholder="Email *">
                                    
                                    <div style="background-color: white; width: 100%; display: none;" class="captcha-group">
                                        <label data-mcaptcha_url="https://captcha.infomaniak.com/widget/?sitekey=wKJaAigS1e48fWgqtjvg5w7rKA6QIwmy" for="mcaptcha__token" id="mcaptcha__token-label">
                                            <input type="text" name="mcaptcha__token" id="mcaptcha__token" />
                                        </label>
                                        <div id="mcaptcha__widget-container"></div>
                                        <script src="https://unpkg.com/@mcaptcha/vanilla-glue@0.1.0-rc2/dist/index.js"></script>
                                    </div>

                                    <input type="submit" class="btn btn-newsletter" name="" value="Valider">
                                </div>

                                <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const emailInput = document.querySelector('.newsletter-email-input');
                                    const captchaGroup = document.querySelector('.captcha-group');
                                    
                                    emailInput.addEventListener('input', function() {
                                        if (this.value.trim() !== '') {
                                            captchaGroup.style.display = 'block';
                                        } else {
                                            captchaGroup.style.display = 'none';
                                        }
                                    });
                                });
                                </script>
                            </div>
                        </form>
                    </div>

                    <!-- Social Block -->
                    <div class="footer-social d-flex flex-row  gap-4">
                        <div class="social-icons d-flex flex-column gap-0">
                            <p class="social-title">Trouvez-nous</p>
                            <a href="https://www.instagram.com/tetamag.ch/" class="social-icon" target="_blank" rel="noopener">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                        <div class="social-title d-flex flex-column">
                            <p class="social-title">Des questions ?</p>
                            <a href="mailto:mrwolf@tetamag.ch" class="social-email text-white" target="_blank" rel="noopener">
                                mrwolf@tetamag.ch
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