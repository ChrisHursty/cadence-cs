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
    $heading     = get_theme_mod( 'cta_heading' );
    $text        = get_theme_mod( 'cta_text' );
    $button_text = get_theme_mod( 'cta_button_text' );
    $button_link = get_theme_mod( 'cta_button_link' );
    ?>
    
    <section class="cta" style="background-color: <?php echo get_theme_mod('cta_bg_color'); ?>;">
        
        <div id="cta-content" class="container">
            <div class="row justify-content-md-center">
                <div class="col-md-6">
                    <?php if ( $heading ) : ?>
                        <h2 class="cta-heading" style="color: <?php echo get_theme_mod('cta_text_color'); ?>"><?php echo esc_html( $heading ); ?></h2>
                    <?php endif; ?>

                    <?php if ( $text ) : ?>
                        <div class="text-area">
                            <p style="color: <?php echo get_theme_mod('cta_text_color'); ?>"><?php echo esc_html( $text ); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if ( $button_text && $button_link ) : ?>
                        <a href="<?php echo esc_url( $button_link ); ?>" class="cta-button" style="background-color: <?php echo get_theme_mod('cta_button_bg_color'); ?>"><span style="color: <?php echo get_theme_mod('cta_button_text_color'); ?>"><?php echo esc_html( $button_text ); ?></span></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>
<?php 