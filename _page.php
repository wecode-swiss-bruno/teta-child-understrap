<?php
/**
 * The template for displaying all pages
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();
?>

<div class="wrapper" id="page-wrapper">
    <div class="container mt-80">
        <div class="row">
            <main class="site-main" id="main">
                <?php
                while (have_posts()) {
                    the_post();
                    get_template_part('loop-templates/content', 'page');
                }
                ?>
            </main>
        </div>
    </div>
</div>

<?php
get_footer(); 