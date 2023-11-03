<?php
/**
 * Understrap Child Theme functions and definitions
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Removes the parent themes stylesheet and scripts from inc/enqueue.php
 */
function understrap_remove_scripts() {
	wp_dequeue_style( 'understrap-styles' );
	wp_deregister_style( 'understrap-styles' );

	wp_dequeue_script( 'understrap-scripts' );
	wp_deregister_script( 'understrap-scripts' );
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );

/**
 * Enqueue our stylesheet and javascript file
 */
function theme_enqueue_styles() {

	// Get the theme data.
	$the_theme     = wp_get_theme();
	$theme_version = $the_theme->get( 'Version' );

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	// Grab asset urls.
	$theme_styles  = "/css/child-theme{$suffix}.css";
	$theme_scripts = "/js/child-theme{$suffix}.js";
	
	$css_version = $theme_version . '.' . filemtime( get_stylesheet_directory() . $theme_styles );

	wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . $theme_styles, array(), $css_version );
	wp_enqueue_script( 'jquery' );
	
	$js_version = $theme_version . '.' . filemtime( get_stylesheet_directory() . $theme_scripts );
	
	wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . $theme_scripts, array(), $js_version, true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

/**
 * Load the child theme's text domain
 */
function add_child_theme_textdomain() {
	load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'add_child_theme_textdomain' );

/**
 * Overrides the theme_mod to default to Bootstrap 5
 *
 * This function uses the `theme_mod_{$name}` hook and
 * can be duplicated to override other theme settings.
 *
 * @return string
 */
function understrap_default_bootstrap_version() {
	return 'bootstrap5';
}
add_filter( 'theme_mod_understrap_bootstrap_version', 'understrap_default_bootstrap_version', 20 );



/**
 * Loads javascript for showing customizer warning dialog.
 */
function understrap_child_customize_controls_js() {
	wp_enqueue_script(
		'understrap_child_customizer',
		get_stylesheet_directory_uri() . '/js/customizer-controls.js',
		array( 'customize-preview' ),
		'20130508',
		true
	);
}
add_action( 'customize_controls_enqueue_scripts', 'understrap_child_customize_controls_js' );

// Allow SVG
add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {

    global $wp_version;
    if ( $wp_version !== '4.7.1' ) {
       return $data;
    }
  
    $filetype = wp_check_filetype( $filename, $mimes );
  
    return [
        'ext'             => $filetype['ext'],
        'type'            => $filetype['type'],
        'proper_filename' => $data['proper_filename']
    ];
  
}, 10, 4 );
  
function cc_mime_types( $mimes ){
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );

function fix_svg() {
    echo '<style type="text/css">
        .attachment-266x266, .thumbnail img {
            width: 100% !important;
            height: auto !important;
        }
        </style>';
}
add_action( 'admin_head', 'fix_svg' );

// Home Page Video BG
function theme_customizer_register( $wp_customize ) {
    // Add a new section for the hero area
    $wp_customize->add_section( 'hero_area_section', array(
        'title'       => __( 'Home Page Hero', 'understrap-child' ),
        'description' => __( 'Here is where you add the video and text elements for the home page hero area', 'understrap-child' ),
        'priority'    => 30,
    ) );

    // Add setting and control for video background
    $wp_customize->add_setting( 'hero_video', array(
        'default'     => '',
        'transport'   => 'refresh',
    ));
    $wp_customize->add_control(
        new WP_Customize_Media_Control(
            $wp_customize,
            'hero_video',
            array(
                'label'       => __( 'Video Background', 'understrap-child' ),
                'section'     => 'hero_area_section',
                'mime_type'   => 'video',
            )
        )
    );

    // Add settings for the editable content
    $wp_customize->add_setting( 'hero_area_heading', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_setting( 'hero_area_text', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );

    $wp_customize->add_setting( 'hero_area_button_text', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_setting( 'hero_area_button_link', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    // Add controls for the editable content
    $wp_customize->add_control( 'hero_area_heading', array(
        'label' => __( 'Heading', 'understrap-child' ),
        'section' => 'hero_area_section',
        'type' => 'text',
    ) );

    $wp_customize->add_control( 'hero_area_text', array(
        'label' => __( 'Text', 'understrap-child' ),
        'section' => 'hero_area_section',
        'type' => 'textarea',
    ) );

    $wp_customize->add_control( 'hero_area_button_text', array(
        'label' => __( 'Button Text', 'understrap-child' ),
        'section' => 'hero_area_section',
        'type' => 'text',
    ) );

    $wp_customize->add_control( 'hero_area_button_link', array(
        'label' => __( 'Button Link', 'understrap-child' ),
        'section' => 'hero_area_section',
        'type' => 'url',
    ) );

    // Add setting and control for overlay color
    $wp_customize->add_setting( 'overlay_color', array(
        'default'           => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'overlay_color',
            array(
                'label'       => __( 'Overlay Color', 'understrap-child' ),
                'section'     => 'hero_area_section',
            )
        )
    );

    // Add setting and control for overlay opacity
    $wp_customize->add_setting( 'overlay_opacity', array(
        'default'           => '0.5',
        'sanitize_callback' => 'understrap_child_sanitize_float',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control( 'overlay_opacity', array(
        'type'        => 'range',
        'priority'    => 10,
        'section'     => 'hero_area_section',
        'label'       => __( 'Overlay Opacity', 'understrap-child' ),
        'input_attrs' => array(
            'min'   => 0,
            'max'   => 1,
            'step'  => 0.1,
        ),
    ));

    // Add a new section for global CTA
    $wp_customize->add_section( 'cta_section', array(
        'title'       => __( 'Call To Acton', 'understrap-child' ),
        'description' => __( 'Global CTA Section', 'understrap-child' ),
        'priority'    => 35,
    ) );

    // Add setting and control for (optional) BG Image
    $wp_customize->add_setting( 'cta_img' , array(
        'title'       => __( 'CTA BG Image', 'understrap-child' ),
        'description' => __( '(Optional) Background Image for the Call To Action', 'understrap-child' ),
        'priority'    => 1,
        'default'     => '', 
    ) );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'cta_img',
            array(
                'label'      => __( 'CTA BG Image', 'understrap-child' ),
                'section'    => 'cta_section',
                'settings'   => 'cta_img' 
            )
        )
    );


    // Add settings for the editable content
    $wp_customize->add_setting( 'cta_heading', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_setting( 'cta_text', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );

    $wp_customize->add_setting( 'cta_button_text', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_setting( 'cta_button_link', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    // Add controls for the editable content
    $wp_customize->add_control( 'cta_heading', array(
        'label' => __( 'Heading', 'understrap-child' ),
        'section' => 'cta_section',
        'type' => 'text',
    ) );

    $wp_customize->add_control( 'cta_text', array(
        'label' => __( 'Text', 'understrap-child' ),
        'section' => 'cta_section',
        'type' => 'textarea',
    ) );

    $wp_customize->add_control( 'cta_button_text', array(
        'label' => __( 'Button Text', 'understrap-child' ),
        'section' => 'cta_section',
        'type' => 'text',
    ) );

    $wp_customize->add_control( 'cta_button_link', array(
        'label' => __( 'Button Link', 'understrap-child' ),
        'section' => 'cta_section',
        'type' => 'url',
    ) );

    // Add setting and control for overlay color
    $wp_customize->add_setting( 'cta_overlay_color', array(
        'default'           => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'cta_overlay_color',
            array(
                'label'       => __( 'Overlay Color', 'understrap-child' ),
                'section'     => 'cta_section',
            )
        )
    );

    // Add setting and control for overlay opacity
    $wp_customize->add_setting( 'cta_overlay_opacity', array(
        'default'           => '0.5',
        'sanitize_callback' => 'understrap_child_sanitize_float',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control( 'cta_overlay_opacity', array(
        'type'        => 'range',
        'priority'    => 10,
        'section'     => 'cta_section',
        'label'       => __( 'Overlay Opacity', 'understrap-child' ),
        'input_attrs' => array(
            'min'   => 0,
            'max'   => 1,
            'step'  => 0.1,
        ),
    ));
}
add_action( 'customize_register', 'theme_customizer_register' );

// Sanitize float value
function understrap_child_sanitize_float( $input ) {
    return filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
}

// Custom H2 Gutenberg Block

function custom_page_h2_enqueue_scripts() {
    wp_enqueue_script(
        'custom-page-h2-editor-script',
        get_stylesheet_directory_uri() . '/custom-page-h2.js',
        array( 'wp-blocks', 'wp-element' )
    );
}

add_action( 'enqueue_block_editor_assets', 'custom_page_h2_enqueue_scripts' );