<?php
/**
 * Customizer settings here.
 * @package: Relational Theme for WordPress
 * Header text setting and Theme specific attributes.
 *
 * https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
 *
*/

add_action( 'customize_register', 'relational_register_theme_customizer_setup' );

/**
 * Remove parts of the Options menu we don't use.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 * @since 1.0.2
*/

function relational_register_theme_customizer_setup($wp_customize)
{

    // Lead text
    $wp_customize->add_section('title_tagline', array(
            'title'             => __( 'Header and Lead Text', 'relational' ),
            'priority'          => 15
    )); 
    // Branding
    $wp_customize->add_section('colors', array(
            'title'             => __( 'Colors and Theme Branding', 'relational' ),
            'priority'          => 25
    )); 
    // Theme font choice section
    $wp_customize->add_section( 'relational_font_types', array(
        'title'       => __( 'Theme and Font Settings', 'relational' ),
        'capability'  => 'edit_theme_options',
        'description' => __( 'Select font type for theme', 'relational' ),
        'priority'    => 20
    ) );

    //-----------------Settings and Controls ----------------------------------

    $wp_customize->add_setting(
          'relational_title_color', array(
          'default'           => '',
          'sanitize_callback' => 'sanitize_hex_color',
          'type'              => 'theme_mod',
          'capability'        => 'edit_theme_options',
          'transport'         => 'refresh'
        )
    );
    $wp_customize->add_control( new WP_Customize_Color_Control(
        $wp_customize,
        'relational_title_color',
        array('label'  => __( 'Color for title and description', 'relational' ),
            'section'  => 'title_tagline',
            'settings' => 'relational_title_color',
            'priority' => 11
        ) ) 
    );
    $wp_customize->add_setting(	'relational_header_logowidth', 
        array(
        'default'           => '90',
        'sanitize_callback'	=> 'sanitize_text_field',
        'transport'			=> 'refresh'
        )
    );
    $wp_customize->add_control( 'relational_header_logo_control', 
        array(
            'settings'    => 'relational_header_logowidth',
            'section'     => 'title_tagline',
            'type'        => 'number',
            'label'       => __( 'MAX width of Logo', 'relational' ),
            'description' => __( 'Percent (number) of size changes width of logo.', 'relational' ),
            'priority'    => 9
        )
    );
    $wp_customize->add_setting(	'relational_header_lead', 
        array(
        'default'           => __('World Wide Website', 'relational'),
        'sanitize_callback'	=> 'sanitize_text_field',
        'transport'			=> 'refresh'
        )
    );
    $wp_customize->add_control( 'relational_header_lead_control', 
        array(
            'settings'    => 'relational_header_lead',
            'section'     => 'title_tagline',
            'type'        => 'text',
            'label'       => __( 'Write a Lead Line for the Header', 'relational' ),
            'description' => __( 'Appears just below site title and tag line. Try Authored by...', 'relational' ),
            'priority'    => 30
        )
    );
    
    $wp_customize->add_setting( 'relational_font_choices', array(
		'default'           => 'arial',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'esc_textarea',
		'capability'        => 'edit_theme_options',
        'transport'			=> 'refresh'
	) );
    $wp_customize->add_control(
        new WP_Customize_Control(
        $wp_customize,
        'container_type', array(
            'label'       => __( 'Font Choices', 'relational' ),
            'description' => __( "Choose Monospace, Arial, Montserrat", 'relational' ),
            'section'     => 'relational_font_types',
            'settings'    => 'relational_font_choices',
            'type'        => 'select',
            'choices'     => array(
                'mono'       => __( 'B612 Mono', 'relational' ),
                'montserrat' => __( 'Montserrat', 'relational' ),
                'arial'      => __( 'Helvetica, Arial font-stack', 'relational' ),
                'serif'      => __( 'Georgia, serif font-stack', 'relational' )
            ),
            'priority'    => '10'
        )
    ) );

    $wp_customize->add_setting( 'relational_font_alignment', array(
		'default'           => 'justify',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'esc_textarea',
		'capability'        => 'edit_theme_options',
        'transport'			=> 'refresh'
	) ); 
    $wp_customize->add_control( 'relational_font_alignment', array(
    
        'label'       => __( 'Select Alignment of Text', 'relational' ),
        'description' => __( "Aligns content text left, right or justify.", 'relational' ),
        'section'     => 'relational_font_types',
        'settings'    => 'relational_font_alignment',
        'type'        => 'select',
        'choices'     => array(
                        'justify' => __( 'Justify equal width text', 'relational' ),
                        'left'    => __( 'Standard Left alignment', 'relational' ),
                        'center'  => __( 'Center text alignment', 'relational' ),
                        'right'   => __( 'Right alignment ltr maybe', 'relational' ),
                    ),
        'priority'    => '12'
    ) );

    $wp_customize->add_setting( 'relational_thumbnail_display', array(
		'default'           => 'background_image',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'esc_textarea',
		'capability'        => 'edit_theme_options',
	) ); 
    $wp_customize->add_control( 'relational_thumbnail_display', array(
        'label'       => __( 'Thumbnail Position for Excerpts', 'relational' ),
        'description' => __( "Will only show thumbnail if one exists.", 'relational' ),
        'section'     => 'relational_font_types',
        'settings'    => 'relational_thumbnail_display',
        'type'        => 'select',
        'choices'     => array(
            'background_image' => __( 'Display as background image', 'relational' ),
            'above_excerpt'    => __( 'Display above the exceprt', 'relational' ),
            'beside_excerpt'   => __( 'Thumbnail to the side of excerpt', 'relational' ),
            'no_thumbnail'     => __( 'No thumbnail at all', 'relational' ),
        ),
        'priority'    => '15'
    ) );
    $wp_customize->add_setting( 'relational_authorbox_display', array(
		'default'           => 'authorbox_below',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'esc_textarea',
		'capability'        => 'edit_theme_options',
	) ); 
    $wp_customize->add_control( 'relational_authorbox_display', array(
        'label'       => __( 'Authoring Position for Posts', 'relational' ),
        'description' => __( "Set the desired position of author information box. Affects singular post only.", 'relational' ),
        'section'     => 'relational_font_types',
        'settings'    => 'relational_authorbox_display',
        'type'        => 'select',
        'choices'     => array(
            'authorbox_below'  => __( 'Display directly below post article', 'relational' ),
            'authorbox_above'  => __( 'Display above post article', 'relational' ),
            'authorbox_beside' => __( 'Display to the side of article', 'relational' ),
            'authorbox_none'   => __( 'No author box at all', 'relational' ),
        ),
        'priority'    => '17'
    ) );
    $wp_customize->add_setting( 'relational_authorbox_text', array(
		'default'           => '',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'sanitize_text_field',
		'capability'        => 'edit_theme_options',
	) ); 
    $wp_customize->add_control( 'relational_authorbox_text', array(
        'label'       => __( 'Author Heading', 'relational' ),
        'description' => __( 'Label at top of author box. Leave blank for none', 'relational' ),
        'section'     => 'relational_font_types',
        'settings'    => 'relational_authorbox_text',
        'type'        => 'text',
        'priority'    => '18'
    ) );
    $wp_customize->add_setting( 'relational_advertbox_text', array(
		'default'           => '',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'wp_kses_post',
		'capability'        => 'edit_theme_options',
	) ); 
    $wp_customize->add_control( 'relational_advertbox_text', array(
        'label'       => __( 'Advert or Text', 'relational' ),
        'description' => __( 'Text or image below author box. Blank for none', 'relational' ),
        'section'     => 'relational_font_types',
        'settings'    => 'relational_advertbox_text',
        'type'        => 'textarea',
        'priority'    => '19'
    ) );
    $wp_customize->add_setting( 'relational_checkbox_remove_advertbox', array(
        'capability'        => 'edit_theme_options',
        'default'           => false,
        'sanitize_callback' => 'relational_sanitize_checkbox'
    ) );
    $wp_customize->add_control( 'relational_checkbox_remove_advertbox', array(
        'type'        => 'checkbox',
        'section'     => 'relational_font_types', 
        'label'       => __( 'Remove Advert Boxes', 'relational' ),
        'description' => __( 'Check to remove Advert or Text box under from authorbox &amp; above headings.', 
                        'relational') .'<a class="notat" href="'. admin_url() .'themes.php?page=relational-theme-help&tab=theme_options#aRelNote" 
                         title="'. esc_attr__("opens in new window tab", "relational") .'" target="_blank">?</a>',
        'priority'    => '20'
    ) );
    $wp_customize->add_setting( 'relational_comment_counter', array(
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'relational_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'relational_comment_counter', array(
        'type'        => 'checkbox',
        'section'     => 'relational_font_types', 
        'label'       => __( 'Remove Comment Count', 'relational' ),
        'description' => __( 'Check to remove comment counts in post excerpt footer meta.', 'relational' ),
        'priority'    => '21'
    ) );

    $wp_customize->add_setting( 'relational_comment_notonpage', array(
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'relational_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'relational_comment_notonpage', array(
        'type'        => 'checkbox',
        'section'     => 'relational_font_types', 
        'label'       => __( 'Remove Comments From PAGES', 'relational' ),
        'description' => __( 'Check to remove the displaying of comments in pages (not posts).', 
                        'relational' ),
        'priority'    => '25'
    ) );
    $wp_customize->add_setting( 'relational_checkbox_remove_comclutter', array(
        'capability'        => 'edit_theme_options',
        'default'           => true,
        'sanitize_callback' => 'relational_sanitize_checkbox'
    ) );
    $wp_customize->add_control( 'relational_checkbox_remove_comclutter', array(
        'type'        => 'checkbox',
        'section'     => 'relational_font_types', 
        'label'       => __( 'Remove Accent Clutter', 'relational' ),
        'description' => __( 'Check to remove allowed tags from comment box &amp; accents &amp; dashed titles.', 'relational'),
        'priority'    => '26'
    ) );
    $wp_customize->add_setting( 'relational_indicator_maybe', array(
        'capability'        => 'edit_theme_options',
        'default'           => false,
        'sanitize_callback' => 'relational_sanitize_checkbox'

    ) );
    $wp_customize->add_control( 'relational_indicator_maybe', array(
        'type'        => 'checkbox',
        'section'     => 'relational_font_types', 
        'label'       => __( 'Remove Reading Progress Bar', 'relational' ),
        'description' => __( 'Check to remove the progress bar on sides of posts pages', 'relational'),
        'priority'    => '27'
    ) );
    $wp_customize->add_setting( 'relational_checkbox_emojicon', array(
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'relational_sanitize_checkbox'
    ) );
    $wp_customize->add_control( 'relational_checkbox_emojicon', array(
        'type'        => 'checkbox',
        'section'     => 'relational_font_types', // Add a default or your own section
        'label'       => __( 'Remove Emojicons', 'relational' ),
        'description' => __( 'Check box to remove emojicons from theme head. Speeds up page loads.', 'relational' ),
        'priority'    => '30'
    ) );
    $wp_customize->add_setting( 'relational_checkbox_noshow_hoverlink', array(
        'capability'        => 'edit_theme_options',
        'default'           => false,
        'sanitize_callback' => 'relational_sanitize_checkbox',
        'transport'         => 'refresh'
    ) );
    $wp_customize->add_control( 'relational_checkbox_noshow_hoverlink', array(
        'type'        => 'checkbox',
        'section'     => 'relational_font_types', 
        'label'       => __( 'Remove Hover Link', 'relational' ),
        'description' => __( 'Check box to remove copy-page-URL link in heading of pages. ', 'relational' ),
        'priority'    => '35'
    ) );
        
    /* ============= COLOR SECTION ============ */    
    $wp_customize->add_setting(
          'relational_theme_color', array(
          'default'           => '#40b76a',
          'sanitize_callback' => 'sanitize_hex_color',
          'type'              => 'theme_mod',
          'capability'        => 'edit_theme_options',
          'transport'         => 'refresh'
        )
    );
    $wp_customize->add_control( new WP_Customize_Color_Control(
        $wp_customize,
        'relational_theme_color',
        array('label'  => __( 'Color scheme for buttons and icons', 'relational' ),
            'section'  => 'colors',
            'settings' => 'relational_theme_color'
        ) ) 
    );
    $wp_customize->add_setting(
          'relational_anchor_color', array(
          'default'           => '#424242',
          'sanitize_callback' => 'sanitize_hex_color',
          'type'              => 'theme_mod',
          'capability'        => 'edit_theme_options',
          'transport'         => 'refresh'
        )
    );
    $wp_customize->add_control( new WP_Customize_Color_Control(
        $wp_customize,
        'relational_anchor_color',
        array('label'  => __( 'Color for navigation and titles', 'relational' ),
            'section'  => 'colors',
            'settings' => 'relational_anchor_color'
        ) ) 
    );
    $wp_customize->add_setting(
          'relational_sideleft_color', array(
          'default'           => '#ffffff',
          'sanitize_callback' => 'sanitize_hex_color',
          'type'              => 'theme_mod',
          'capability'        => 'edit_theme_options',
          'transport'         => 'refresh'
        )
    );
    $wp_customize->add_control( new WP_Customize_Color_Control(
        $wp_customize,
        'relational_sideleft_color',
        array('label'  => __( 'Background for left section', 'relational' ),
            'section'  => 'colors',
            'settings' => 'relational_sideleft_color'
        ) ) 
    );
    $wp_customize->add_setting(
          'relational_containermain_color', array(
          'default'           => '#ffffff',
          'sanitize_callback' => 'sanitize_hex_color',
          'type'              => 'theme_mod',
          'capability'        => 'edit_theme_options',
          'transport'         => 'refresh'
        )
    );
    $wp_customize->add_control( new WP_Customize_Color_Control(
        $wp_customize,
        'relational_containermain_color',
        array('label'  => __( 'Background for Main content right', 'relational' ),
            'section'  => 'colors',
            'settings' => 'relational_containermain_color'
        ) ) 
    );

    $wp_customize->add_setting(
          'relational_excerpt_ghost', array(
          'default'           => 'rgba(255,255,255, .426)',
          'sanitize_callback' => 'relational_sanitize_rgba',
          'type'              => 'theme_mod',
          'capability'        => 'edit_theme_options',
          'transport'         => 'refresh'
        )
    );
    $wp_customize->add_control( 'relational_excerpt_ghost', array(
        'type'        => 'text',
        'section'     => 'colors',
        'label'       => __( 'Overlay Mask for Excerpt', 'relational' ),
        'description' => '<p>' . __('Select color and opacity of background overlay for 
                         excerpts with thumbnails.', 'relational' ) . '</p>' 
                         . '<p><em>' . __('Learn RGBA at www.w3.org/wiki/CSS/Properties/color/RGBA', 'relational') 
                         .'</em></p>' 
                         . '<strong>' . __( 'Example CSS "rgba(255, 255, 255, .4)"', 'relational' ) . '</strong>'
    ) );

}

// Easy Boolean checker for checkbox
function relational_sanitize_checkbox( $checked ) {
	// Boolean check.
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
} 

/**
 * Check if string starts with 'rgba', else use hex sanity
 * sanitize the hex color and convert hex to rgba
 * @since 1.0.2
 */
function relational_sanitize_rgba( $color ) {
    
    if ( empty( $color ) || is_array( $color ) )
        return 'rgba(0,0,0,0)';

    if ( false === strpos( $color, 'rgba' ) ) {
        return sanitize_hex_color( $color );
    }
    $color = str_replace( ' ', '', $color );
    sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
    return 'rgba('.$red.','.$green.','.$blue.','.$alpha.')';
} 
