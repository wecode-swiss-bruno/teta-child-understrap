<?php

/**
 * Template part for displaying Button
 *
 * @package Tetaz
 * 
 * @array   $layout      Layout settings (without values)
 * @array   $field       Flexible content field settings
 * @bool    $is_preview  True in Administration
 * @string  $col         Column size (auto, 1, 2, 3, 4 ...)
 */

$text = get_sub_field('text');
$url = get_sub_field('url');
$align = get_sub_field('align') ?: 'center';

if ($text) : ?>
    <section class="wysiwyg-content">
        <div class="container d-flex justify-content-<?php echo esc_attr($align); ?>">
            <a
                href="<?php echo esc_attr($url); ?>"
                class="button-default"
            >
                <?php echo esc_html($text); ?>
            </a>
        </div>
    </section>
<?php endif; ?>