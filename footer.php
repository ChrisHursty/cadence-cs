<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );
?>

<?php get_template_part( 'sidebar-templates/sidebar', 'footerfull' ); ?>
<div class="wrapper" id="wrapper-footer" style="background-color: <?php echo get_theme_mod('footer_bg_color'); ?>;">
	<div class="<?php echo esc_attr( $container ); ?>">
		<div class="row">
			<div class="col-md-12">
                <?php
                // Get the customizer settings
                $footer_image_url   = get_theme_mod('ccs_footer_image');
                $footer_text        = get_theme_mod('ccs_footer_text');
                $social_media_icons = get_theme_mod('ccs_social_media_icons');
                // Decode the JSON string into an array of icon data
                $social_media_icons = $social_media_icons ? json_decode($social_media_icons, true) : array();
                ?>

                <footer class="container mt-5">
                    <!-- Footer Image -->
                    <?php if ($footer_image_url): ?>
                        <div class="mb-4 text-center">
                            <img src="<?php echo esc_url($footer_image_url); ?>" alt="Footer Logo" class="img-fluid">
                        </div>
                    <?php endif; ?>

                    <!-- Footer Text -->
                    <?php if ($footer_text): ?>
                        <div class="byline mb-4 text-center">
                            <h5 style="color: <?php echo get_theme_mod('footer_text_color'); ?>;"><?php echo esc_html($footer_text); ?></h5>
                        </div>
                    <?php endif; ?>

                    <!-- Social Media Icons -->
                    <?php if ($social_media_icons): ?>
                        <ul class="list-inline text-center">
                            <?php foreach ($social_media_icons as $icon): ?>
                                <li class="list-inline-item me-3">
                                    <a href="<?php echo esc_url($icon['url']); ?>" target="_blank">
                                        <img src="<?php echo esc_url($icon['imageUrl']); ?>" alt="Social Media Icon" class="img-fluid">
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </footer>       
			</div><!-- col -->
		</div><!-- .row -->
	</div><!-- .container(-fluid) -->
</div><!-- #wrapper-footer -->
<?php // Closing div#page from header.php. ?>
</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html>
