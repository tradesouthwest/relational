<?php
/**
 * Hooks and filters settings
 *
 * @package: Relational Theme for WordPress
 * Theme specific attributes.
 * @since 1.0.0
*/

// to1
add_action( 'init', 'relational_check_disable_emojicons' );
// tm0
add_action( 'wp_head', 'relational_theme_customizer_css', 2 );  
// @id CS1 
add_action( 'customize_controls_print_styles', 'relational_footer_admin_styles' );
/**
 * Disable emojis in wp head
 * Defers emojis back to core files.
 *
 * @since 1.0.1
 * @return hooks 
*/

function relational_disable_wp_emojicons() 
{
    // all actions related to emojis 
    remove_filter( 'wp_mail',          'wp_staticize_emoji_for_email' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_action( 'wp_head',             'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles',     'print_emoji_styles' );
    remove_action( 'admin_print_styles',  'print_emoji_styles' );

    add_filter ( 'emoji_svg_url', '__return_false' );
    // filter to remove TinyMCE emojis
    // add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
}

/** to1
 * Disable emojis in wp head conditional
 *
 * @since 1.0.1
 * @return Bool
*/

function relational_check_disable_emojicons()
{
    //if ( !get_theme_mods() ) return;    
    $istrue = relational_mods_fire_once();
    // Make sure the request is for a user-facing page
    if ( !$istrue ) {

    $cleanhead = get_theme_mod( 'relational_checkbox_emojicon' );
    $clean     = ( empty( $cleanhead ) ) ? false : $cleanhead;
    
    if ( $clean == true ) : 

        return add_action( 'wp',    'relational_disable_wp_emojicons' );
    else: 
        return remove_action( 'wp', 'relational_disable_wp_emojicons' );
    endif;
    }
   
        return false;
} 

/**
 * Verify the request is for an actual page vs. resources or images.
 * @uses Normally fires during 'template_redirect' action hook.
 * @since 1.0.1
 * @return bool
*/

function relational_mods_fire_once() {
    // Make sure the request is for a user-facing page
    if ( 
        ! is_singular() && 
        ! is_page() && 
        ! is_single() && 
        ! is_archive() && 
        ! is_home() &&
        ! is_front_page() 
    ) {
        return false;
    } else {
        //run check for theme mod disable_emojicon
        return true;
    }

} 

/**
 * Text to header from customizer
 * @since 1.0.1
 * @return HTML string
 */

function relational_header_lead_render(){
    
    $lead = '';
        
    if ( get_theme_mod( 'relational_header_lead' ) ) :
    
        $lead = get_theme_mod( 'relational_header_lead' );
    
    endif;     

        return sanitize_text_field( $lead );
}

/** #CS1
 * customizer relational theme added styles
 * @since 1.0.2
 */
function relational_footer_admin_styles() {
    echo '<style id="relational-admin-footer">
   .notat{display:inline-block;padding: 3px; width: 1em; color: green;background: #fff;border-radius: 50%;}
   
   </style>';
   
}

/** tm0
 * CUSTOM FONT OUTPUT, CSS
 * The @font-face rule should be added to the stylesheet before any styles. (priority 2)
 * @uses background-image as linear gradient meerly remove any input background image.
 * @since 1.0.1
*/

function relational_theme_customizer_css() 
{   
    
        $font = '';
        $uria  = get_stylesheet_directory_uri() . '/dist/kmK_Zq85QVWbN1eW6lJV0A7d.woff2';
        $urib  = get_stylesheet_directory_uri() . '/dist/JTUHjIg1_i6t8kCHKm4532VJOt5-QNFgpCtr6Hw5aXo.woff2';
        $arialstack = ' "Myriad Pro", Myriad, "Liberation Sans", "Nimbus Sans L", "DejaVu Sans Condensed",
        Frutiger, "Frutiger Linotype", Univers, Calibri, "Gill Sans", "Gill Sans MT", Tahoma, Geneva, "Helvetica Neue", 
        Helvetica, Arial, sans-serif';
        $serifstack = ' Constantia, "Lucida Bright", Lucidabright, "Lucida Serif", Lucida, "DejaVu Serif", "Bitstream Vera Serif", "Liberation Serif", Georgia, serif';
        $lgw  = (empty( get_theme_mod( 'relational_header_logowidth' ) ) ) ? '90' 
                      : get_theme_mod( 'relational_header_logowidth' );
        $fnt  = (empty( get_theme_mod( 'relational_font_choices' ) ) ) ? 'arial' 
                      : get_theme_mod( 'relational_font_choices' );
        $cnv  = ( empty( get_theme_mod( 'relational_anchor_color' ) ) ) ? '#424242' 
                       : get_theme_mod( 'relational_anchor_color' );
        $clr  = ( empty( get_theme_mod( 'relational_theme_color' ) ) ) ? '#40b76a' 
                       : get_theme_mod( 'relational_theme_color' );
        $clrb = $clrc = $clr.'A8';
        $clt  = ( empty( get_theme_mod( 'relational_title_color' ) ) ) ? 'inherit' 
                       : get_theme_mod( 'relational_title_color' );
        $cls  = ( empty( get_theme_mod( 'relational_sideleft_color' ) ) ) ? '#ffffff' 
                       : get_theme_mod( 'relational_sideleft_color' );
        $clm  = ( empty( get_theme_mod( 'relational_containermain_color' ) ) ) ? '#ffffff' 
                       : get_theme_mod( 'relational_containermain_color' );
        $ghs  = ( empty ( get_theme_mod( 'relational_excerpt_ghost' ) ) ) 
              ? "rgba(255,255,255, .426)" : get_theme_mod( 'relational_excerpt_ghost' );
        $txt  = (empty( get_theme_mod( 'relational_font_alignment' ) ) ) ? 'justify' 
                      : get_theme_mod( 'relational_font_alignment' );
        $hdn  = ('1' == get_theme_mod( 'relational_checkbox_remove_comclutter')) 
                ? 'none' : 'block'; 
        $nbs  = ( 'block' === $hdn ) ? $clr : 'transparent';
        
    /* use above set values into inline styles */
    $font .= '<style id="relational-inline-style" type="text/css">';
    $font .= '.fa-clock:before,.fa-comm-count:before,.fa-copy-link:before,.fa-tags-list:before,.fa-category-folder:before,.fa-calendar-day:before
        {color: ' . esc_attr($clr) . '} .indicator{background-color:' . esc_attr($clr) . '}
        .relational-authorby{ border-left-color: ' . esc_attr($clr) . '}.excerpt-ghost{background: '. esc_attr($ghs) .'}.inner_content{text-align: ' . esc_attr($txt) . ';}
        .nav-previous, .nav-next, .postlink .btn-paging, .search-submit, .submit{background-image: linear-gradient( '. esc_attr($clrb) .', '. esc_attr($clr) .', '. esc_attr($clrc) .' );
        text-shadow: .5px .5px 2px #ddd;}.header-logo img{max-width:' . esc_attr($lgw) .'%;}.container-main{background-color:' . esc_attr($clm) . '}
        .sidemount{background-color:' . esc_attr($cls) . ';}
        .form-allowed-tags,.tagsatts{display:' . esc_attr($hdn) . ';}.site-title a, .post-title a{border-bottom-color: ' . esc_attr($nbs) . '}
        .single-article-header h2, .single-page-header h2{border-bottom: thin dashed '. esc_attr($nbs) .'}
        .social-sites a,.site-title a,.post-title a,#nav a,.excerpt-meta a{color:'.$cnv.';}
        .site-title a, .site-description, .descriptor-alt,.maybe-copyright{color:'. esc_attr($clt) .'</style>'; 
    if ( $fnt == 'arial' ) { 
        $font .= '<style id="relational-arial-style" type="text/css">';
        $font .= 'body, button, input, select, textarea, .h1{font-family:' . relational_sanitize_text($arialstack) . '}</style>';

    } elseif ( $fnt == 'serif' ) { 
        $font .= '<style id="relational-arial-style" type="text/css">';
        $font .= 'body, button, input, select, textarea, .h1{font-family:' . relational_sanitize_text($serifstack) . '}</style>'; 
        
    } elseif ( $fnt == 'mono' ) {
        $font .= '<style id="relational-mono-style" type="text/css">';
        $font .= 
        "@font-face {font-family: 'B612 Mono';font-style: normal;font-weight: 400;src: url( $uria );
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }";
        $font .= 'body, button, input, select, textarea, .h1{';
        $font .= 'font-family: "B612 Mono"}</style>'; 
    } elseif ( $fnt == 'montserrat' ) {
        $font .= '<style id="relational-montserrat-style" type="text/css">';
        $font .= 
        "@font-face {font-family: 'Montserrat';font-style: normal;font-weight: 400;src: url( $urib ) format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }";
        $font .= 'body, button, input, select, textarea, .h1{';
        $font .= 'font-family: "Montserrat";}</style>';
    } else {
    
        $font .= '<style id="relational-arial-style" type="text/css">';
        $font .= 'body, button, input, select, textarea, .h1{font-family:' . relational_sanitize_text($arialstack) . '}</style>'; 
    } 

        ob_start();
        printf('<!-- relational inline -->%s<!-- ends relational inline -->', $font);
        echo ob_get_clean(); 
} 

/**
 * information about website
 * @since 1.0.1
 * @return HTML string
 */

function relational_siteinfo_admin_render(){
    if ( !is_admin() ) return;
    ?>
    <div class="wrap">
        <div id="icon-themes" class="icon32"></div>
        <h2>Relational Theme Help</h2>
        <?php settings_errors(); ?>
        <?php
            if( isset( $_GET[ 'tab' ] ) ) {
                $active_tab = $_GET[ 'tab' ];
            } 
    $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'display_options';
        ?>
    <h2 class="nav-tab-wrapper">
    <a href="?page=relational-theme-help&tab=display_options" class="nav-tab">Environment</a>
    <a href="?page=relational-theme-help&tab=theme_options" class="nav-tab">Help</a>
    </h2>
    <?php 
    if( $active_tab == 'display_options' ) { ?>
    
    <section>
    <h2><?php _e( 'Basic Information', 'relational'); ?></h2>
    <div id="relational-short" style="background:#aafafa;height:3em">
        <?php echo relational_short_basic_debug_info(); ?>
    </div>
    <hr id="relational-hr"><br>
    <div id="relational-short" style="background:#aafafa;height:3em">
        <?php echo relational_change_log_info(); ?>
    </div>
    </section>
    <?php } else { ?>

    <section><h2><?php esc_html_e( 'Theme Help', 'relational' ); ?></h2>
    <p><?php esc_html_e( 'Relational is a blogging theme made for WordPress. Not over complex but just the right mix of customization tools to create a very versatile website. Features include fast loading templates, color scheme in Customizer, add lead text to header and an additional menu where you add your social links into header space. Footer switches between sections according to width of device viewing. Relational has an option to show comment count or not show. You can pick how to display a featured image: above or as background or even not show at all. Control thumbnail overlays in the Customizer. Relation theme uses Dashicons on frontend to save font imports and we use a classic font-stack as well as two font layers built into the theme so you do not have to ping any font CDN. Has attachment template for full page image display. Add custom header image or logo. Anchor link on every page makes it easy to copy page URI for convenient sharing. Fast and dependable theme for WordPress. Perfect for blogging or authoring news or company updates. prefers-reduced-motion is supported. All navigation to main top menu is pure CSS with no javascript to enhance functionality and speed.', 'relational' ); ?></p>
    <div>
    <ul class="relational-theme-notes">
    <li id="aRelNote"><h3><?php esc_html_e( 'Header and Lead Text', 'relational' ); ?></h3>
        </li>
    <li id="bRelNote"><strong><?php esc_html_e( 'MAX width of Logo', 'relational' ); ?></strong>
        <p><?php esc_html_e( 'Set the width of the header image in sidemount section. Default is 100 percent.', 'relational' ); ?></p></li>
    <li id="cRelNote"><strong><?php esc_html_e( 'Write a Lead Line for the Header', 'relational' ); ?></strong>
        <p><?php esc_html_e( 'This can be any text that you want to display just below the theme description and title, located in the left side section.', 'relational' ); ?></p></li>
    <li id="dRelNote"><strong><?php esc_html_e( 'Color for title and description', 'relational' ); ?></strong>
        <p><?php esc_html_e( 'Select a color for the text in the side-left column that works best to offset background color.', 'relational' ); ?></p></li>
        
    <li id="eRelNote"><h3><?php esc_html_e( 'Theme and Font Settings', 'relational' ); ?></h3>
        </li>
    <li id="fRelNote"><strong><?php esc_html_e( 'Choose Monospace, Arial, Montserrat', 'relational' ); ?></strong>
        <p><?php esc_html_e( 'There are three font types that come with Relational. Select one. You can change to your own fonts using the theme customizer by adding a font-family to the body element in the Customizer Additional CSS section.', 'relational' ); ?></p></li>
    <li id="gRelNote"><strong><?php esc_html_e( 'Select Alignment of Text', 'relational' ); ?></strong>
        <p><?php esc_html_e( 'This option sets the text to either left, right or center adjusted alignment for all paragraphs and any content that is inside of a blog post or a generic page. The alignment can be changed on a per paragraph or per page choice by using the WordPress editor settings. Content effected by this option is any content wrapped in the "inner-content" style selector.', 'relational' ); ?></p></li>
    <li id="hRelNote"><strong><?php esc_html_e( 'Thumbnail Position for Excerpts', 'relational' ); ?></strong>
        <p><?php esc_html_e( 'Thumbnails are the Featured Image that you select when you creat a post. This setting gives you the option to show your thumbnail image as a background image which fits the same size as the height of you excerpt in the blog posts excerts/blog page. Or you can have the Featured Image appear above the blog excerpt as a full sized image (not really a thumbnail but a fully Featured Image). You can also hide thumbnails completely with the last setting "No thumbnail at all"', 'relational' ); ?></p></li>
    <li id="iRelNote"><strong><?php esc_html_e( 'Remove Accent Clutter', 'relational' ); ?></strong>
        <p><?php esc_html_e( 'Checking this box removes dashed underlines in titles; space around and some text from under the comments form area.', 'relational' ); ?></p></li>
    <li id="jRelNote"><strong><?php esc_html_e( 'Remove Emojicons', 'relational' ); ?></strong>
        <p><?php esc_html_e( 'Removing emojicons from WordPress will save bandwidth on your server. This would be a good practice in general but would mostly be done only if you are sure none of your users are using a device that utilizes emoji icons or if you know that your site is not going to be promoting the use of emojicons.', 'relational' ); ?></p></li>
    <li id="kRelNote"><strong><?php esc_html_e( 'Remove Hover Link', 'relational' ); ?></strong>
        <p><?php esc_html_e( 'There is a link, with an icon, in the top corner of each post and on some or most of the pages with the exception of the blog posting page. If you want to remove the custom link then check this box. The purpose of this link if so that you can share the article by copying the link which, is the URL of the page you are currently on. Once it is copied to your clipboard, you can paste that link into email of other media sources.', 'relational' ); ?></p></li>
    <li id="lRelNote"><strong><?php esc_html_e( 'Remove Comment Count', 'relational' ); ?></strong>
        <p><?php esc_html_e( 'Comment counter is located in the foot of each blog post exceprt, just underneath the excerpt, in what is known as the excerpt meta-footer. Removing the count simply removes clutter that readers may find distracting or that the article author may not want to show the count due to some promotional philosophies.', 'relational' ); ?></p></li>
    <li id="mRelNote"><strong><?php esc_html_e( 'Remove Comments From PAGES', 'relational' ); ?></strong>
        <p><?php esc_html_e( 'Comments are normally only part of the blog post posts. This theme allows comments to pages. You may remove this special function by checking the box and saving the customizer settings.', 'relational' ); ?></p></li>
    
    
    <li id="nRelNote"><h3><?php esc_html_e( 'Colors and theme Branding', 'relational' ); ?></h3>
        </li>
    <li id="oRelNote"><strong><?php esc_html_e( 'Header Text Color', 'relational' ); ?></strong>
        <p><?php esc_html_e( 'Changes the color of the single page, single post article and site heading H2 tags and the main site-title in sidebar as well.', 'relational' ); ?></p></li>
    <li id="pRelNote"><strong><?php esc_html_e( 'Background Color', 'relational' ); ?></strong>
        <p><?php esc_html_e( 'Sets the background color for the entire site body. You might only see this if you have white space around your content. Otherwise this may not change much, visually.', 'relational' ); ?></p></li>
    <li id="qRelNote"><strong><?php esc_html_e( 'Color scheme for buttons and icons', 'relational' ); ?></strong>
        <p><?php esc_html_e( 'Controls color of icons and theme submit form buttons.', 'relational' ); ?></p></li>
    <li id="rRelNote"><strong><?php esc_html_e( 'Background for left section', 'relational' ); ?></strong>
        <p><?php esc_html_e( 'Controls background color of side-left section.', 'relational' ); ?></p></li>
    <li id="sRelNote"><strong><?php esc_html_e( 'Background for Main content right', 'relational' ); ?></strong>
        <p><?php esc_html_e( 'Controls background color of main content section.', 'relational' ); ?></p></li>
    
    <li id="tRelNote"><strong><?php esc_html_e( 'Up to Top Link', 'relational' ); ?></strong>
        <p><?php esc_html_e( 'Use faux-footer class name in Customizer Additional CSS to hide or change the Up to Top button.', 'relational' ); ?></p></li>
    </ul>
    <style>.relational-theme-notes li{border-bottom: thin solid #ccc;}.relational-theme-notes li p{margin: 0}
    .relational-theme-notes li strong{font-size: inherit; border: thin solid #ccc; padding:3px 3px 0;margin-right: 3px;background: #fafaf0;}
   .relational-theme-notes li strong:after{content: ": ";}.relational-theme-notes li{background: #fcfcfc;padding: 2px 3px}</style>
    </div></section>
    
    <?php } ?>
    
    </div>
<?php 
}
/**
	 * Return an array of plugin names and versions
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
function relational_basic_get_plugins() {
    $plugins     = array();
    include_once ABSPATH . '/wp-admin/includes/plugin.php';
    $all_plugins = get_plugins();
    foreach ( $all_plugins as $plugin_file => $plugin_data ) {
        if ( is_plugin_active( $plugin_file ) ) {
            $plugins[ $plugin_data['Name'] ] = $plugin_data['Version'];
        }
    }

    return $plugins;
}
//add_action ( 'relational_short_basic_debug', 'relational_short_basic_debug_info' );
function relational_short_basic_debug_info( $html = true ) {
		global $wp_version, $wpdb;

		$data = array(
			'WordPress Version'     => $wp_version,
			'PHP Version'           => phpversion(),
			'MySQL Version'         => $wpdb->db_version(),
			'WP_DEBUG'              => ( WP_DEBUG === true ) ?  
                                       'Enabled' : 'Disabled',
		);
		if ( $html ) {
			$html = '<ol>';
			foreach ( $data as $what_v => $v ) {
$html .= '<li style="display: inline;"><strong>' . $what_v . '</strong>: ' . $v . ' </li>';
			}
            $html .= '</ol>';
        }
        return $html;
}
//add_action( 'relational_basic_debug', 'relational_basic_debug_info' );
function relational_basic_debug_info( $html = true ) {
    global $wp_version, $wpdb, $wp_scripts;
    $wp          = $wp_version;
    $php         = phpversion();
    $mysql       = $wpdb->db_version();
    $plugins     = relational_basic_get_plugins();
    $stylesheet    = get_stylesheet();
    $theme         = wp_get_theme( $stylesheet );
    $theme_name    = $theme->get( 'Name' );
    $theme_version = $theme->get( 'Version' );
    $opcode_cache  = array(
        'Apc'       => function_exists( 'apc_cache_info' ) ? 'Yes' : 'No',
        'Memcached' => class_exists( 'eaccelerator_put' ) ? 'Yes' : 'No',
        'Redis'     => class_exists( 'xcache_set' ) ? 'Yes' : 'No',
    );
    $object_cache  = array(
        'Apc'       => function_exists( 'apc_cache_info' ) ? 'Yes' : 'No',
        'Apcu'      => function_exists( 'apcu_cache_info' ) ? 'Yes' : 'No',
        'Memcache'  => class_exists( 'Memcache' ) ? 'Yes' : 'No',
        'Memcached' => class_exists( 'Memcached' ) ? 'Yes' : 'No',
        'Redis'     => class_exists( 'Redis' ) ? 'Yes' : 'No',
    );
    $versions      = array(
        'WordPress Version'           => $wp,
        'PHP Version'                 => $php,
        'MySQL Version'               => $mysql,
        'JQuery Version'			  => $wp_scripts->registered['jquery']->ver,
        'Server Software'             => $_SERVER['SERVER_SOFTWARE'],
        'Your User Agent'             => $_SERVER['HTTP_USER_AGENT'],
        'Session Save Path'           => session_save_path(),
        'Session Save Path Exists'    => ( file_exists( session_save_path() ) ? 'Yes' : 'No' ),
        'Session Save Path Writeable' => ( is_writable( session_save_path() ) ? 'Yes' : 'No' ),
        'Session Max Lifetime'        => ini_get( 'session.gc_maxlifetime' ),
        'Opcode Cache'                => $opcode_cache,
        'Object Cache'                => $object_cache,
        'WPDB Prefix'                 => $wpdb->prefix,
        'WP Multisite Mode'           => ( is_multisite() ? 'Yes' : 'No' ),
        'WP Memory Limit'             => WP_MEMORY_LIMIT,
        'Currently Active Theme'      => $theme_name . ': ' . $theme_version,
        'Parent Theme'				  => $theme->template,
        'Currently Active Plugins'    => $plugins,
    );
    if ( $html ) {
        $debug = '';
        foreach ( $versions as $what => $version ) {
            $debug .= '<p><strong>' . $what . '</strong>: ';
            if ( is_array( $version ) ) {
                $debug .= '</p><ul class="ul-disc">';
                foreach ( $version as $what_v => $v ) {
                    $debug .= '<li><strong>' . $what_v . '</strong>: ' . $v . '</li>';
                }
                $debug .= '</ul>';
            } else {
                $debug .= $version . '</p>';
            }
        }
        return $debug;
    } else {
        return $versions;
    }
}
function relational_change_log_info(){

    $html = 
    '<pre>
    == Change Log ==
    1.1.1
    - added header image parameters
    - remove default background color for sidemounet and content sections
    - removed comment // register new phone-landscape featured image size. @width, @height, and @crop

    1.1.0
    - added web-accesible support for tab key navigation
    - shifted mobile ready menu elements to fit on screen

    1.0.31
    - fixed no excerpt clearfix
    - fixed spacing in social header
    - fixed menu width

    1.0.3
    - added sanity to some translations
    </pre>'; 
    
        return $html;
}
