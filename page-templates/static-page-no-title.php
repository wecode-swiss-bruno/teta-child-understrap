<?php
/**
 * Template Name: Page statique sans titre
 *
 * Template for displaying a static page without title and without sidebar.
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Set flag for no title
define('STATIC_PAGE_NO_TITLE', true);

// Include the main static page template
include(get_stylesheet_directory() . '/page-templates/static_page.php');  