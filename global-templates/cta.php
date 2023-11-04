<?php
/**
 * CTA
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit; ?>

<!-- Hero Area -->
<div class="wrapper cta">

    <?php
    $cta_heading     = get_theme_mod( 'cta_heading' );
    $cta_text        = get_theme_mod( 'cta_text' );
    $cta_button_text = get_theme_mod( 'cta_button_text' );
    $cta_button_link = get_theme_mod( 'cta_button_link' );
    ?>
    
    <section class="cta" style="background-color: <?php echo get_theme_mod('cta_bg_color'); ?>;">
        
        <div id="cta-content" class="container">
            <div class="row justify-content-md-center">
                <div class="col-md-6">
                    <?php if ( $cta_heading ) : ?>
                        <h2 class="cta-heading" style="color: <?php echo get_theme_mod('cta_text_color'); ?>"><?php echo esc_html( $cta_heading ); ?></h2>
                    <?php endif; ?>

                    <?php if ( $cta_text ) : ?>
                        <div class="text-area">
                            <p style="color: <?php echo get_theme_mod('cta_text_color'); ?>"><?php echo esc_html( $cta_text ); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if ( $cta_button_text && $cta_button_link ) : ?>
                        <a href="<?php echo esc_url( $cta_button_link ); ?>" class="cta-button" style="background-color: <?php echo get_theme_mod('cta_button_bg_color'); ?>"><span style="color: <?php echo get_theme_mod('cta_button_text_color'); ?>"><?php echo esc_html( $cta_button_text ); ?></span></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>
<?php 