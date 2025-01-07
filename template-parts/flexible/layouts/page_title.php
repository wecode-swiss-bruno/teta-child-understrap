<?php
/**
 * Template part for displaying Page Title
 *
 * @package Tetaz
 * 
 * @array   $layout      Layout settings (without values)
 * @array   $field       Flexible content field settings
 * @bool    $is_preview  True in Administration
 * @string  $col         Column size (auto, 1, 2, 3, 4 ...)
 */

$content = get_sub_field('content');
$col = get_sub_field('acfe_layout_col') ?: 'auto';

// If no custom content is provided, use the page title
if (empty($content)) {
    $content = get_the_title();
}
?>

<section class="page-title col-<?php echo esc_attr($col); ?>">
    <div class="container">
        <div class="page-title__inner">
            <h1 class="page-title__heading">
                asdf
                <?php echo esc_html($content); ?>
            </h1>
        </div>
    </div>
</section> 