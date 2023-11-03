<?php
/**
 * Template Name:  Services Page
 *
 * Template for displaying services offered
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
get_header();
?>

<div class="wrapper" id="ccs-full-width">
    <?php 
    get_template_part( 'global-templates/page-hero' );
    ?>
    <div class="services-sub-heading container-fluid">
        <h2 class="ccs-h2"><?php the_field('sub_heading'); ?></h2>
    </div>
	<div class="container" id="content">
		<div class="row">
			<div class="col-md-12 content-area" id="primary">
                <div class="container services">
                    <div class="row">
                        <?php
                            // Check rows exists.
                            if( have_rows('services_repeater') ):
                                // Loop through rows.
                                while( have_rows('services_repeater') ) : the_row();
                                    // Load sub field value.
                                    $service_icon        = get_sub_field('service_icon');
                                    $service_title       = get_sub_field('service_title');
                                    $service_description = get_sub_field('service_description'); ?>
                                    <div class="icon-column col-md-4 col-sm-6">
                                        <div class="icon">
                                            <img src="<?php echo esc_url($service_icon['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />    
                                        </div>
                                        
                                        <h4><?php echo $service_title; ?></h4>
                                        <p><?php echo $service_description; ?></p>
                                    </div>
                                <?php // End loop.
                                endwhile;
                            // No value.
                            else :
                                // Do something...
                            endif; ?>
                    </div>
                </div>
			</div><!-- #primary -->
		</div><!-- .row -->
	</div><!-- #content -->
</div><!-- #<?php echo $wrapper_id; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- ok. ?> -->

<?php
get_footer();
