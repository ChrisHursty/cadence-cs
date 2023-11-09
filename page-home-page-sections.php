<?php
/**
 * Template Name:  Home Page
 *
 * Template for displaying the home page and its sections
 *
 * @package Understrap
 */
?>
<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
get_header();
?>

<!-- Hero Area -->
<div class="wrapper home-page-hero">

    <?php
    $hero_heading     = get_theme_mod( 'hero_area_heading' );
    $hero_text        = get_theme_mod( 'hero_area_text' );
    $hero_button_text = get_theme_mod( 'hero_area_button_text' );
    $hero_button_link = get_theme_mod( 'hero_area_button_link' );
    ?>
    
    <section id="hero">
        <div class="video-overlay" style="background-color: <?php echo get_theme_mod('overlay_color'); ?>; opacity: <?php echo get_theme_mod('overlay_opacity'); ?>;">
        </div>
        <video playsinline autoplay muted loop id="bgvid">
            <source src="<?php echo wp_get_attachment_url(get_theme_mod('hero_video')); ?>" type="video/mp4">
        </video>

        <div id="hero-content" class="container">
            <?php if ( $hero_heading ) : ?>
                <h1><?php echo esc_html( $hero_heading ); ?></h1>
            <?php endif; ?>

            <?php if ( $hero_text ) : ?>
                <div class="text-area">
                    <p><?php echo esc_html( $hero_text ); ?></p>
                </div>
            <?php endif; ?>

            <?php if ( $hero_button_text && $hero_button_link ) : ?>
                <a href="<?php echo esc_url( $hero_button_link ); ?>" class="hero-button"><span><?php echo esc_html( $hero_button_text ); ?></span></a>
            <?php endif; ?>
        </div>
    </section>
</div>
<div class="container-fluid">
    <div class="row centered-text">
        <h2 class=""><?php the_field('centered_text'); ?></h2>
    </div>
</div>
<div class="container" id="content" tabindex="-1">
    <div class="row">
        <?php
            // Check value exists.
            if( have_rows('flexible_content') ): ?>
            <div class="container hp-grid">
                <?php // Loop through rows.
                while ( have_rows('flexible_content') ) : the_row(); ?>
                    <div class="row bottom-border">
                        <?php // Case: Download layout.
                        if( get_row_layout() == 'image_text' ):
                            $image = get_sub_field( 'image' );
                            $text  = get_sub_field('text'); ?>
                            <div class="col-md-6 col-sm-12 hp-image-left">
                                <img src="<?php echo $image;?>" alt="">
                            </div>
                            <div class="col-md-6 col-sm-12 align-self-center hp-text-right">
                                <div class="text-holder">
                                    <?php echo $text; ?>
                                </div>
                            </div>
                        <?php // Case: Download layout.
                        elseif( get_row_layout() == 'text_image' ):
                            $image = get_sub_field( 'image' );
                            $text = get_sub_field('text'); ?>
                            <div class="reverse-cols">
                                <div class="col-md-6 col-sm-12 align-self-center hp-text-left">
                                    <div class="text-holder">
                                        <?php echo $text; ?>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 hp-image-right">
                                    <img src="<?php echo $image;?>" alt="">
                                </div>
                            </div>
                            <?php
                            
                        endif; ?>
                    </div>
                <?php // End loop.
                endwhile; ?>
                
            </div>
            <?php  // No value.
            else :
                // Do something...
            endif; ?>

    </div><!-- .row -->
</div><!-- #content -->
<?php 
    get_template_part( 'global-templates/cta' );
?>

<?php
get_footer();
