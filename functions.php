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

    // Font Awesome
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css' );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );


function ccs_enqueue_customizer_scripts() {
    wp_enqueue_script(
        'ccs-customizer-script',
        get_stylesheet_directory_uri() . '/js/ccs-customizer.js',
        array( 'jquery', 'customize-controls' ),
        false,
        true
    );
}
add_action( 'customize_controls_enqueue_scripts', 'ccs_enqueue_customizer_scripts' );


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

    // Add setting and control for hero button bg color
    $wp_customize->add_setting( 'hero_button_bg_color', array(
        'default'           => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'hero_button_bg_color',
            array(
                'label'       => __( 'Button BG Color', 'understrap-child' ),
                'section'     => 'hero_area_section',
            )
        )
    );

    // Add setting and control for button text color
    $wp_customize->add_setting( 'hero_button_text_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'hero_button_text_color',
            array(
                'label'       => __( 'Button Text Color', 'understrap-child' ),
                'section'     => 'hero_area_section',
            )
        )
    );

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
        'title'       => __( 'Call To Action', 'understrap-child' ),
        'description' => __( 'Global CTA Section', 'understrap-child' ),
        'priority'    => 35,
    ) );

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

    // Add setting and control for BG color
    $wp_customize->add_setting( 'cta_bg_color', array(
        'default'           => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'cta_bg_color',
            array(
                'label'       => __( 'Background Color', 'understrap-child' ),
                'section'     => 'cta_section',
            )
        )
    );

    // Add setting and control for text color
    $wp_customize->add_setting( 'cta_text_color', array(
        'default'           => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'cta_text_color',
            array(
                'label'       => __( 'Text Color', 'understrap-child' ),
                'section'     => 'cta_section',
            )
        )
    );

    // Add setting and control for button bg color
    $wp_customize->add_setting( 'cta_button_bg_color', array(
        'default'           => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'cta_button_bg_color',
            array(
                'label'       => __( 'Button BG Color', 'understrap-child' ),
                'section'     => 'cta_section',
            )
        )
    );

    // Add setting and control for button text color
    $wp_customize->add_setting( 'cta_button_text_color', array(
        'default'           => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'cta_button_text_color',
            array(
                'label'       => __( 'Button Text Color', 'understrap-child' ),
                'section'     => 'cta_section',
            )
        )
    );

    // Custom Footer
    // Add CCS Footer Section
    $wp_customize->add_section( 'ccs_footer', array(
        'title'    => __( 'CCS Footer', 'understrap-child' ),
        'priority' => 40, // After Additional CSS
    ));

    // Footer BG Color
    $wp_customize->add_setting( 'footer_bg_color', array(
        'default'           => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'footer_bg_color',
            array(
                'label'       => __( 'Footer BG Color', 'understrap-child' ),
                'section'     => 'ccs_footer',
            )
        )
    );

    // Image Upload Setting
    $wp_customize->add_setting( 'ccs_footer_image' );
    $wp_customize->add_control( new WP_Customize_Image_Control(
        $wp_customize,
        'ccs_footer_image',
        array(
            'label'    => __( 'Footer Image', 'understrap-child' ),
            'section'  => 'ccs_footer',
            'settings' => 'ccs_footer_image',
        )
    ));

    // Text Field Setting
    $wp_customize->add_setting( 'ccs_footer_text', array(
        'default' => '',
    ));
    $wp_customize->add_control( 'ccs_footer_text', array(
        'label'    => __( 'Footer Text', 'understrap-child' ),
        'section'  => 'ccs_footer',
        'type'     => 'text',
    ));

    // Text Color
    $wp_customize->add_setting( 'footer_text_color', array(
        'default'           => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'footer_text_color',
            array(
                'label'       => __( 'Footer Text Color', 'understrap-child' ),
                'section'     => 'ccs_footer',
            )
        )
    );

    class CCS_Social_Media_Control extends WP_Customize_Control {
        public function render_content() {
            $icons = json_decode($this->value(), true);
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            </label>
            <div class="ccs-social-media-icons">
                <ul id="ccs-icons-list">
                    <?php
                    if ($icons) {
                        foreach ($icons as $icon) {
                            ?>
                            <li>
                                <img src="<?php echo esc_url($icon['imageUrl']); ?>" class="icon-image" />
                                <input type="hidden" value="<?php echo esc_url($icon['imageUrl']); ?>" class="icon-image-url" />
                                <input type="url" value="<?php echo esc_url($icon['url']); ?>" placeholder="URL" class="icon-url" />
                                <button type="button" class="button ccs-remove-icon-button">Remove</button>
                            </li>
                            <?php
                        }
                    }
                    ?>
                </ul>
                <input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr($this->value()); ?>" />
                <button type="button" class="button ccs-add-icon-button">Add Icon</button>
            </div>
    
            <!-- The script will go here -->
            <?php
        }
    }
    
    // Register the custom control in your ccs_customizer_settings function
    $wp_customize->add_setting( 'ccs_social_media_icons' );
    $wp_customize->add_control( new CCS_Social_Media_Control(
        $wp_customize,
        'ccs_social_media_icons',
        array(
            'label'    => __( 'Social Media Icons', 'understrap-child' ),
            'section'  => 'ccs_footer',
            'settings' => 'ccs_social_media_icons',
        )
    ));
    
}
add_action( 'customize_register', 'theme_customizer_register' );

function ccs_custom_css() {
    $hero_btn_bg_color   = get_theme_mod('hero_button_bg_color');
    $hero_btn_text_color = get_theme_mod('hero_button_text_color');
    $cta_btn_bg_color    = get_theme_mod('cta_button_bg_color');
    $cta_btn_text_color  = get_theme_mod('cta_button_text_color');
    // ... any other theme_mod values
   
    $custom_css = "
        /* Customizer CSS */
        .hero-button {
            background-color: $hero_btn_bg_color !important;
            border: 1px solid $hero_btn_bg_color !important;
        }

        .hero-button span {
            color: $hero_btn_text_color !important;
        }

        .hero-button:hover {
            background-color: $hero_btn_text_color !important;
            border: 1px solid $hero_btn_text_color !important;
        }

        .hero-button:hover span {
            color: $hero_btn_bg_color !important;
        }

        .cta-button {
            border: 1px solid $cta_btn_text_color !important;
        }

        .cta-button:hover {
            background-color: $cta_btn_text_color !important;
            border: 1px solid $cta_btn_bg_color !important;
        }
        .cta-button:hover span {
            color: $cta_btn_bg_color !important;
        }
        /* ... any other custom CSS */
    ";

    wp_add_inline_style( 'ccs-customizer-css', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'ccs_custom_css', 20 );

function ccs_enqueue_scripts_and_styles() {
    wp_enqueue_style( 'ccs-customizer-css', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'ccs_enqueue_scripts_and_styles' );

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