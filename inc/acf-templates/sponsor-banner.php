<?php
/**
 * ACF Template for Sponsor Banner
 */

acf_add_local_field_group(array(
    'key' => 'group_sponsor_banner',
    'title' => 'Sponsor Banner',
    'fields' => array(
        array(
            'key' => 'field_sponsor_title',
            'label' => 'Title',
            'name' => 'sponsor_title',
            'type' => 'text',
            'default_value' => 'Sponsorisé par',
            'placeholder' => 'Sponsorisé par',
        ),
        array(
            'key' => 'field_sponsor_image',
            'label' => 'Banner Image',
            'name' => 'sponsor_image',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
            'instructions' => 'Recommended ratio: 10:3',
        ),
        array(
            'key' => 'field_sponsor_link',
            'label' => 'Banner Link',
            'name' => 'sponsor_link',
            'type' => 'url',
            'placeholder' => 'https://',
        ),
        array(
            'key' => 'field_sponsor_margin',
            'label' => 'Margin Size',
            'name' => 'sponsor_margin',
            'type' => 'select',
            'choices' => array(
                'none' => 'None (0)',
                'xs' => 'Extra Small (x0.33)',
                'sm' => 'Small (x0.66)',
                'default' => 'Default (x1)',
                'lg' => 'Large (x1.5)',
                'xl' => 'Extra Large (x2)',
                'huge' => 'Huge (x3)'
            ),
            'default_value' => 'default',
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'post',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
)); 