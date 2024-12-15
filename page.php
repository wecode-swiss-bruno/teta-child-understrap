<?php
/**
 * The template for displaying all pages
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

// $container = get_theme_mod( 'understrap_container_type' );
?>

<div class="wrapper" id="page-wrapper">
    <div class="container-fluid" id="content">
        <div class="row">
            <main class="site-main" id="main">
                <?php
                while ( have_posts() ) {
                    the_post();
                    get_template_part( 'template-parts/flexible/page-builder' );
                }
                ?>
            </main>
        </div>
    </div>
</div>

<?php
get_footer(); 