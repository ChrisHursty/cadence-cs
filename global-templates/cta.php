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
	$bg_img      = get_theme_mod( 'cta_img' );
    $heading     = get_theme_mod( 'cta_heading' );
    $text        = get_theme_mod( 'cta_text' );
    $button_text = get_theme_mod( 'cta_button_text' );
    $button_link = get_theme_mod( 'cta_button_link' );
    ?>
    
    <section class="cta" style="background-image: url(<?php echo esc_url( $bg_img ); ?>);">
        <div class="overlay-color" style="background-color: <?php echo get_theme_mod('cta_overlay_color'); ?>; 
								          opacity: <?php echo get_theme_mod('cta_overlay_opacity'); ?>;">
        </div>
        <!-- Add Customizer to change color of text -->
        <div id="cta-content" class="container">
            <?php if ( $heading ) : ?>
                <h2 class="cta-heading"><?php echo esc_html( $heading ); ?></h2>
            <?php endif; ?>

            <?php if ( $text ) : ?>
                <div class="text-area">
                    <p><?php echo esc_html( $text ); ?></p>
                </div>
            <?php endif; ?>

            <?php if ( $button_text && $button_link ) : ?>
                <a href="<?php echo esc_url( $button_link ); ?>" class="cta-button"><?php echo esc_html( $button_text ); ?></a>
            <?php endif; ?>
        </div>
    </section>
</div>
<?php 