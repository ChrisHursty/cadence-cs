<?php
/**
 * Page Hero
 *
 * @package Understrap
 */

// Get the featured image URL
$featured_image_url = get_the_post_thumbnail_url(); ?>

<section class="hero" style="background-image: url(<?php echo esc_url( $featured_image_url ); ?>);">
    <div class="container">
        <div class="bg-shade row justify-content-md-center">
            <h1 class="page-title"><?php echo get_the_title(); ?></h1>
        </div>
    </div>
</section>

<?php
