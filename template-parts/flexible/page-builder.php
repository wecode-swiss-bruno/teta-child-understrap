<?php
/**
 * Template part for displaying the page builder flexible content
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( is_page_template('page-templates/static_page.php') || is_page_template('page-templates/static-page-no-title.php') ) {
    // Use page_builder_static for pages with "Page statique" template
    if ( have_rows('page_builder_static') ):
        while ( have_rows('page_builder_static') ) : the_row();
            $layout = get_row_layout();
            $template_path = 'template-parts/flexible/layouts/' . $layout . '.php';
            
            if( locate_template( $template_path ) ) {
                get_template_part( 'template-parts/flexible/layouts/' . $layout );
            }
        endwhile;
    endif;
} else {
    // Use regular page_builder for other pages
    if ( have_rows('page_builder') ):
        while ( have_rows('page_builder') ) : the_row();
            $layout = get_row_layout();
            $template_path = 'template-parts/flexible/layouts/' . $layout . '.php';
            
            if( locate_template( $template_path ) ) {
                get_template_part( 'template-parts/flexible/layouts/' . $layout );
            }
        endwhile;
    endif;
} 
