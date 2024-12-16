    <?php
    /**
     * The template for displaying search results
     *
     * @package Understrap
     */

    // Exit if accessed directly.
    defined('ABSPATH') || exit;

    get_header();
    ?>

    <div class="wrapper" id="search-wrapper">
        <div class="container mx-auto mt-80 py-5">
            <header class="page-header">
                <h1 class="page-title">
                    <?php
                    printf(
                        /* translators: %s: query term */
                        esc_html__('Search Results for: %s', 'tetaz-dev'),
                        '<span>' . get_search_query() . '</span>'
                    );
                    ?>
                </h1>
            </header>

            <div class="row">
                <main class="site-main" id="main">
                    <?php
                    if (have_posts()) {
                        while (have_posts()) {
                            the_post();
                            get_template_part('loop-templates/content', 'search');
                        }
                    } else {
                        get_template_part('loop-templates/content', 'none');
                    }
                    ?>

                    <?php
                    // Display pagination if needed
                    understrap_pagination();
                    ?>
                </main>
            </div>
        </div>
    </div>

    <?php
    get_footer(); 