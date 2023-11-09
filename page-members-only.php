<?php
/**
 * Template Name:  Members Only
 *
 * Template to keep out the riff-raff
 * 
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
get_header();
?>

<div class="wrapper" id="members-only">
    
	<div class="container-fluid" id="content">
		<div class="row justify-content-md-center">
			<div class="col-md-8 text-center">
                <div class="mo-logo">

                <?php 
                $image = get_field('mo_logo');
                if( !empty( $image ) ): ?>
                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
                <?php endif; ?>
                </div>
                <a href="<?php echo the_field('mo_button_url'); ?>" class="mo-btn">
                    <span><?php echo the_field('mo_button_text'); ?></span>
                </a>
                
			</div>
		</div><!-- .row -->
	</div><!-- #content -->
</div><!-- #<?php echo $wrapper_id; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- ok. ?> -->

<?php
get_footer();
