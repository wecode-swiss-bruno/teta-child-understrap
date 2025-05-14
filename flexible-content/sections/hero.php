<?php
$background = $args['background'];
$sur_titre = $args['sur-titre'];
$titre = $args['titre'];
$sous_titre = $args['sous-titre'];
$boutons = $args['boutons'];
$blanc_arrondi_en_bas = $args['blanc_arrondi_en_bas'] ?? true;
?>

<section class="hero position-relative overflow-hidden justify-content-center align-items-center d-flex" <?php if ($background): ?>style="background: url('<?php echo esc_url($background['url']); ?>') no-repeat center center; background-size: cover; height: 80vh" <?php endif; ?>>
    <div class="overlay position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50 z-0"></div>
    <div class="container py-5 position-relative">
        <div class="row min-vh-75 align-items-center justify-content-center">
            <div class="col-md-12 col-lg-11 col-xl-10 text-white text-center">
                <?php if ($sur_titre): ?>
                    <div class="badge bg-primary mb-3"><?php echo esc_html($sur_titre); ?></div>
                <?php endif; ?>

                <?php if ($titre): ?>
                    <h1 class="display-5 mb-4"><?php echo esc_html($titre); ?></h1>
                <?php endif; ?>

                <?php if ($sous_titre): ?>
                    <div class="mb-4 px-5">
                        <?php echo $sous_titre; ?>
                    </div>
                <?php endif; ?>

                <?php if ($boutons): ?>
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        <?php foreach ($boutons as $index => $bouton): ?>
                            <?php if ($bouton['lien'] && $bouton['texte']): ?>
                                <?php
                                $style = '';
                                switch ($bouton['style']) {
                                    case 'primary':
                                        $style = 'btn-primary';
                                        break;
                                    case 'secondary':
                                        $style = 'btn-secondary';
                                        break;
                                    case 'outline':
                                        $style = 'btn-outline-light';
                                        break;
                                }
                                ?>
                                <a href="<?php echo esc_url($bouton['lien']['url']); ?>" class="btn <?= $style ?>" <?php echo ($bouton['lien']['target']) ? 'target="' . $bouton['lien']['target'] . '"' : ''; ?>>
                                    <?php echo esc_html($bouton['texte']); ?>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php if ($blanc_arrondi_en_bas): ?>
        <div class="blanc-arrondi-en-bas position-absolute bottom-0 start-0 w-100 py-4 bg-white" style="border-radius: 999px 999px 0 0;"></div>
    <?php endif; ?>
</section>