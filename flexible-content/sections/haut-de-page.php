<?php

/**
 * Template pour la section Haut de page
 */

// Récupération des champs ACF
$badge = $args['badge'];
$titre = $args['titre'];
$texte = $args['texte'];
$bouton = $args['bouton'];
?>

<section class="haut-de-page">
    <div class="container py-4">
        <div class="row d-flex align-items-stretch justify-content-center gap-4 gap-md-0">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5 align-self-start">
                <?php if ($badge) : ?>
                    <div class="badge-container">
                        <div class="badge-button rounded-pill border border-primary text-primary d-inline-flex align-items-center justify-content-center px-3 py-1"><?php echo esc_html($badge); ?></div>
                    </div>
                <?php endif; ?>

                <?php if ($titre) : ?>
                    <h1 class="mt-3"><?php echo esc_html($titre); ?></h1>
                <?php endif; ?>
            </div>

            <div class="col-12 col-md-8 col-lg-6 col-xl-7 align-self-center">
                <?php if ($texte) : ?>
                    <div class="lead">
                        <p><?php echo esc_html($texte); ?></p>
                    </div>
                <?php endif; ?>

                <?php if ($bouton && $bouton['texte'] && $bouton['lien']) : ?>
                    <div class="bouton-container">
                        <a href="<?php echo esc_url($bouton['lien']['url']); ?>"
                            class="text-decoration-none text-secondary d-flex align-items-center gap-2 justify-content-between"
                            <?php echo ($bouton['lien']['target']) ? 'target="' . esc_attr($bouton['lien']['target']) . '"' : ''; ?>>
                            <?php echo esc_html($bouton['texte']); ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>