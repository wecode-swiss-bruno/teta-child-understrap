<?php
/**
 * Template part for displaying the page builder flexible content
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if( have_rows('page_builder') ):
    while ( have_rows('page_builder') ) : the_row();
        
        $layout = get_row_layout();
        $template_path = 'template-parts/flexible/layouts/' . $layout . '.php';
        
        if( locate_template( $template_path ) ) {
            get_template_part( 'template-parts/flexible/layouts/' . $layout );
        }
        
    endwhile;
endif; 