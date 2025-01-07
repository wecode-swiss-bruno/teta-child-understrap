<?php
/**
 * Template part for displaying WYSIWYG content
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

if ($content) : ?>
    <section class="wysiwyg-content col-<?php echo esc_attr($col); ?>">
        <div class="container">

            <div class="wysiwyg-content__inner">
                <?php echo $content; ?>
            </div>
        </div>
    </section>
<?php endif; ?>