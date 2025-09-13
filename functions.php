<?php
/** 
 * Functions for theme Relational by Tradesouthwest
 * 
 * Sets up theme defaults and registers support for various WordPress features.
 * @version 1.1.3
 * @since   1.0.0
 */
/**
 * Proper ob_end_flush() for all levels
 *
 * This replaces the WordPress `wp_ob_end_flush_all()` function
 * with a replacement that doesn't cause PHP notices.
 */
if (defined('WP_DEBUG') && true === WP_DEBUG) :
    remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );
    add_action( 'shutdown', function() {
    while ( @ob_end_flush() );
    } );
endif;

if ( ! function_exists( 'wp_body_open' ) ) {
    /**
    * Add backwards compatibility support for wp_body_open function.
    */
    function wp_body_open() {
        do_action( 'wp_body_open' );
    }
}

/** 
 * FAST LOADER References ( find @id in DocBlocks )
 * @since 1.0.1
 * @return action and filter Hooks
 */
// ------------------------- Actions ---------------------------
// #f1
add_action( 'after_setup_theme',  'relational_theme_setup' );
// #f3 
/* Priority 0 to make it available to lower priority callbacks. */
add_action( 'after_setup_theme',  'relational_content_width', 0 );
// #f2
add_action( 'wp_print_scripts',   'relational_theme_queue_js' );
// #f4
add_action( 'wp_enqueue_scripts', 'relational_theme_scripts' );
// #f6
add_action( 'wp_head',            'relational_pingback_header' );
// #f12
add_action( 'admin_init',         'relational_theme_add_editor_styles' );
// #TO16
add_action( 'admin_menu',         'relational_theme_options_help_page' );
// #f5
add_action( 'widgets_init',       'relational_register_sidebars' );
// #f7
add_action( 'relational_render_attachment', 'relational_render_attachment_link' ); 
// #f9
add_action( 'relational_render_thumbnail',  'relational_render_thumbnail_mod' );
// #f10 
add_action( 'relational_exerpt_render',     'relational_exerpt_render_thumbnail' );
// #f11
add_action( 'relational_footer_meta',       'relational_footer_meta_render' );
// #f13
add_action( 'relational_show_hoverlink',    'relational_hoverlink_render' );

// #TO17
add_action( 'relational_hover_title',        'relational_perma_hover_titlelink' );
// ------------------------- Filters -----------------------------
// #f14
add_filter( 'excerpt_more',               'relational_custom_excerpt_more' );

/**
 * Setup function is hooked into the after_setup_theme hook, which runs before the init hook. 
 * The init hook is too late for some features, such as indicating support for post thumbnails.
 *
 * @since 1.1.1
 *
 * @id f1
 */

function relational_theme_setup() {
/* a.
 * Switch default core markup for search form, comment form, and comments
 * to output valid HTML5.
 */
/* b.
 * Let WordPress manage the document title.
 * By adding theme support, we declare that this theme does not use a
 * hard-coded "title" tag in the document head, and expect WordPress to provide it for us.
 *
 * Enable support for Post Thumbnails on posts and pages.
 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
 */
    // a.
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
 
    // b.
    add_theme_support( 'title-tag' );
    add_theme_support( 'automatic-feed-links' ); // rss feederz
    
    add_theme_support( "wp-block-styles" );
    add_theme_support( "responsive-embeds" );
    add_theme_support( "align-wide" );
    add_theme_support( 'editor-color-palette', array(
        array(
            'name'  => esc_attr__( 'medium grayish', 'relational' ),
            'slug'  => 'medium-grayish',
            'color' => '#464646',
        ),
        array(
            'name'  => esc_attr__( 'theme scheme color', 'relational' ),
            'slug'  => 'relational-scheme',
            'color' => get_theme_mod( 'relational_theme_color', '#40b76a' ),
        ),  
    ) );
    add_theme_support( 'post-thumbnails', array( 'post', 'page') );
    add_image_size( 'relational-featured', 520, 300, false);   
    add_theme_support( "custom-header",  array(
        'default-image'          => '',
        'uploads'                => true,
        'random-default'         => false,
        'header-text'            => false,
        'default-text-color'     => '000',
        'width'                  => 1200,
        'height'                 => 1600,
        'flex-height'            => true,
        'flex-width'             => true,
        'wp-head-callback'       => '',
        'admin-head-callback'    => '',
        'admin-preview-callback' => '',
        ) );
    //page background image and color support
    add_theme_support( 'custom-background', 
        array( 
	   'default-color'      => '#fcfcfc',
	   'default-image'       => '',
	   'wp-head-callback'     => '_custom_background_cb',
	   'admin-head-callback'   => '',
	   'admin-preview-callback' => ''
    ) );
    add_theme_support( 'custom-logo' );
    // woocommerce filters in lower part of this file
    add_theme_support( 'woocommerce' );
    // main nav in header - also nav menu in side-header
    register_nav_menus(
        array(
            'primary' => __('Main Menu Top', 'relational'),
            'social'  => __('Social Link in Header', 'relational')
        )
    );

    // TODO add_editor_style('editor-style.css');    
    load_theme_textdomain( 'relational', get_template_directory_uri() . '/languages' );
}

/**
 * Only enable js if the visitor is browsing either a page or a post    
 * or if comments are open for the entry, or threaded comments are enabled
 *
 * @id f2
 * @since 1.0.0 
 */

function relational_theme_queue_js(){

    if ( (!is_admin()) && is_singular() && comments_open() && get_option('thread_comments') )
        wp_enqueue_script( 'comment-reply' );
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * @global int $content_width
 *
 * @id f3
 * @since 1.0.0
 */

function relational_content_width() {

	$GLOBALS['content_width'] = apply_filters( 'relational_content_width', 520 );
}

/**
 * Enqueue scripts and styles.
 * $handle, $src, $deps, $ver, $in_footer
 * @id f4
 * @since 1.0.0 
 * @uses  Can use jquery-slim.min.js that is included in dist folder
 */
function relational_theme_scripts() {
    
    // Load the main stylesheet.
    wp_enqueue_style( 'relational-style', get_stylesheet_uri() );
    // Add Dashicons, used in the main stylesheet.
    wp_enqueue_style( 'dashicons' );
    
    wp_enqueue_script( 'jquery-slim', 
	                    get_template_directory_uri()  
	                   . '/dist/jquery-slim.js',     /* .min */
	                    array( 'jquery' ) 
                        ); 
    wp_enqueue_script( 'relational-progress', 
	                    get_template_directory_uri()  
	                   . '/dist/relational-progress.js', 
	                    array( 'jquery', 'jquery-slim' ) 
                        );
    wp_enqueue_script( 'relational-theme', 
	                    get_template_directory_uri()  
	                   . '/dist/relational.js', 
	                    array( 'jquery', )
                        );
}

/**
 * Registers an editor stylesheet for the theme.
 *
 * @since 1.0.2
 * @id f12
 */
function relational_theme_add_editor_styles() {

    add_editor_style( 'editor-style.css' );
}

/**
 * Display background to sidemount section
 * @uses theme_mod relational_title_color
 * @since 1.0.2
 * @return URL
 */
function relational_sidemount_background()
{
    $bks  = ( '' != header_image() ) ? header_image() : '';
    //$bsw  = absint( get_custom_header()->width );
    //$bsh  = absint( get_custom_header()->height );
    
    ob_start();
    echo $bks;

        return ob_get_clean();
}
/**
 * Copy url of title and display title of post/page.
 * @since 1.0.2
 * @return HTML
 * @id TO17
 */

function relational_perma_hover_titlelink()
{

    $htm = '<button id="copy-text" onclick="copyToClipboard()" class="fa-copy-link" 
    title="' . __( 'click/tap here to copy link', 'relational') . '"></button> 
    <h2 class="articleheading">' . get_the_title() . '</h2> 
    <small class="perma-hover" aria-controls="content-to-copy"> 
    <a id="permaHover" class="perma-hover-link" href="' 
    . esc_attr( esc_url( get_permalink() ) ) . '" title="' 
    . esc_attr( esc_url( get_permalink() ) ) . '"></a></small>';

    $htm .= '<script>function copyToClipboard(text) {
    var inputc = document.body.appendChild(document.createElement("input"));
    inputc.value = window.location.href; inputc.focus(); inputc.select();
    document.execCommand("copy"); inputc.parentNode.removeChild(inputc);
    alert("URL Copied." + inputc.value); }</script>';

        echo $htm;
}

/** 
 * Attachment link for featured images
 *
 * @since 1.0.2
 * @return HTML
 * @id f7 action
 */

function relational_render_attachment_link(){
?>  
    <figure class="linked-attachment-container">
    <a class="imgwrap-link"
       href ="<?php echo esc_url( get_attachment_link( get_post_thumbnail_id() ) ); ?>" 
       title="<?php the_title_attribute( 'before=Permalink to: &after=' ); ?>">
    <?php 
    the_post_thumbnail( 'relational-featured', array( 
            'itemprop' => 'image', 
            'class'  => 'relational-featured',
            'alt'  => get_attachment_link( get_post_thumbnail_id() )
        ) 
    ); ?></a>
    </figure><?php 
}

/** 
 * Position thumbnail inside or above excerpt in blog posts relational_thumbnail_display
 *
 * @since 1.0.2
 * @return HTML
 * @id f10
 */

function relational_exerpt_render_thumbnail(){

    $class     = '';
    if ( !get_theme_mods() ) : 
        $class = "excerpt-background";
    else: 
    $choices   = ( empty( get_theme_mod( 'relational_thumbnail_display' ) ) )
               ? 'background_image' : get_theme_mod( 'relational_thumbnail_display' );

    switch ( $choices ) {
        case "background_image":
            $class = "excerpt-backgrnd";
        break;
        case "above_excerpt"   :
            $class = "above-excerpt";
        break;
        case "no_thumbnail"    :
            $class = "excerpt-nothumb";
        break;
        default                :
            $class="excerpt-backgrnd";
    }
    endif; 
            return $class;
}

/**
 * Render authoring box at position selected
 * @since 1.0.2
 * @return HTML
 * @toid 17
 */

function relational_author_posit_maybe(){

    $class     = '';
    if ( !get_theme_mods() ) : 
        $class = "authorbox-below";
    else: 
    $posits = ( empty( get_theme_mod( 'relational_authorbox_display' ) ) )
               ? 'authorbox_below' : get_theme_mod( 'relational_authorbox_display' );

    switch ( $posits ) {
        case "authorbox_below":
            $class = "authorbox-below";
        break;
        case "authorbox_above":
            $class = "authorbox-above";
        break;
        case "authorbox_beside":
            $class = "authorbox-beside";
        break;
        case "authorbox_none":
            $class = "authorbox-none";
        break;
        default              :
            $class = "authorbox-none";
    }
    endif;

        return $class;
}

/**
 * Author box position from customizer
 * @since 1.0.2
 * @return HTML string
 */
/**
 * @param int $post_id Post ID.
 *
 * @return int Post author ID.
 */
function relational_get_post_author() {
    global $post;
     
    // will use get_post_field() with 'post_author' to get author id        
    $author_id = get_post_field('post_author' , $post->ID);
        
        return absint($author_id);
}

/**
 * Render authoring box 
 * @since 1.0.2
 * @return HTML
 */
function relational_authoring_box_text(){
   
    $label = "";
    if ( !get_theme_mods() ) $label = "";
    
    $label = ( empty( get_theme_mod( 'relational_authorbox_text' ) ) )
               ? '' : get_theme_mod( 'relational_authorbox_text' );

    return wp_kses_post( $label );
}

/**
 * Render advertisement box
 * @since 1.0.2
 * @return HTML
 */
function relational_advertbox_text(){
   
    $show = get_theme_mod( 'relational_checkbox_remove_advertbox' );
    $rtrn = ( ( '' != $show ) || $show == '1' ) ? false : true;
    
    if ( !$rtrn ) return;

    $label = '<div class="relational-advert"><h3>Heading for Advertisment</h3>
            <img src="' . esc_url( get_template_directory_uri() . '/dist/imgs/image-alignment-300x200-demo.jpg') . '" 
            alt="advertisement placeholder" width="150" /><p>Paste HTML or img link into this area for advert</p></div>';
    if ( !get_theme_mods() ) $advert = '';
    
    $advert = ( empty( get_theme_mod( 'relational_advertbox_text' ) ) )
              ? wp_kses_post( $label ) : get_theme_mod( 'relational_advertbox_text' );

    return '<div class="relational_advertbox">' . wp_kses_post( $advert ) . '</div>';
}

/**
 * Render advertisement box
 * @since 1.0.2
 * @return HTML
 */
function relational_advertbox_above_header(){
   
    $show = get_theme_mod( 'relational_checkbox_remove_advertbox' );
    $rtrn = ( ( '' != $show ) || $show == '1' ) ? false : true;
    
    if ( !$rtrn ) return;

    $label = '<div class="relational-advert advert-alt">
            <p>Paste HTML or img link into this area for advert</p>
            <img src="' . esc_url( get_template_directory_uri() . '/dist/imgs/image-alignment-300x200-demo.jpg') . '" 
            alt="advertisement placeholder" width="150" /></div>';
    if ( !get_theme_mods() ) $advert = '';
    
    $advert = ( empty( get_theme_mod( 'relational_advertbox_text' ) ) )
              ? wp_kses_post( $label ) : get_theme_mod( 'relational_advertbox_text' );

    return '<div class="relational_advertabove">' . wp_kses_post( $advert ) . '</div>';
}

/**
 * relational_comment_notonpage from customizer
 * @since 1.0.2
 * @param string $show checked = hide div
 * @return Bool
 */

function relational_comment_notonpage_maybe(){

    $rtrn = 'false';
    $show = get_theme_mod( 'relational_comment_notonpage' );
    $rtrn = ( ( '' != $show ) || $show == '1' ) ? 'true' : 'false';
        
        return $rtrn;
}

/**
 * relational_comment_notonpage from customizer
 * @since 1.0.2
 * @param string $show checked = hide div
 * @return Bool
 */

function relational_indicator_maybe(){

    if ( !is_single() ) return false;
    $rtrn = 'false';
    if ( !get_theme_mod( 'relational_indicator_maybe' ) ) $rtrn = 'false';
    
    $show = get_theme_mod( 'relational_indicator_maybe', 'false' );
    $rtrn = ( ( '' != $show ) || $show == '1' ) ? 'false' : 'true';
        
        return $rtrn;
}

/**
 * Check to display comment counts from customizer
 * @since 1.0.2
 * @param string $show checked = hide div
 * @return Bool
 */

function relational_comment_counter_maybe(){
    $rtrn = 'false';
    $show = get_theme_mod( 'relational_comment_counter' );
    $rtrn = ( '' != ( $show ) || $show == '1' ) ? 'true' : 'false';
        
        return $rtrn;
}

/**
 * relational_checkbox_noshow_hoverlink from customizer
 * @since 1.0.2
 * @param string $show checked = hide div
 * @return Bool
 */

function relational_upgrade_theme_maybe(){

    // boolean placeholder for update TODO select options
    return true;
}

/** @id f13
 * Render hoverlink with option to hide
 * 
 * @since 1.0.2
 * @return HTML
 */

function relational_hoverlink_render(){
    ?>
    <div class="perma-hover">
        <span class="perma-hover-link">
        <?php printf( '<i class="fa-copy-link" title="%s"></i><em>%s</em>',
                __( 'hover aside to copy link', 'relational'),
                esc_html( esc_url( get_permalink() ) )
              ); ?>
        </span>
    </div>
<?php 
}

/**
 * Render footer meta with option to hide comment counts
 * 
 * @since 1.0.2
 * @return HTML
 */

function relational_footer_meta_render(){
    $html   = '';
    $iscomm = relational_comment_counter_maybe();
    ?>
    <p class="excerpt-meta"><i class="fa-calendar-day"></i><span class="post_footer-date">
    <?php printf( esc_attr( get_the_date() ) ); ?></span>
    <i class="fa-category-folder"></i><span><?php the_category( ' &bull; ' ); ?></span>
    <i class="fa-tags-list"></i><span><?php the_tags('<em class="tags">', ' ', '</em>'); ?></span>
    <?php 
	if ( $iscomm == 'false' ): 
    ?>
    <span class="comments-count-heading"><i class="fa-comm-count"></i>
    <?php get_template_part( 'comments', 'count' ); ?></span>
    <?php endif;
    ?>
    </p><?php
}

/**
 * relational_social_menu only used as fallback
 *
 * @since 1.0.1 
 * @return null
 */
function relational_social_menu_render(){
 
    return false;
} 

/**
 * Support for logo upload, output. 
 *
 * @since 1.0.1 
 */
function relational_theme_custom_logo() {
    $output = '';

    if ( function_exists( 'the_custom_logo' ) ) {
        $custom_logo_id = get_theme_mod( 'custom_logo' );
        $logo           = wp_get_attachment_image_src( $custom_logo_id , 'full' );

        if ( has_custom_logo() ) {
            $output = '<div class="header-logo"><img src="'. esc_url( $logo[0] ) .'" 
            alt="'. get_bloginfo( 'name' ) .'"></div>'; 
        } else { 
            $output = ''; 
        }
    }

        // Output sanitized in header to assure all html displays.
        return $output;
}

/**
 * Sanity check
 * @see https://themefoundation.com/wordpress-theme-customizer/
 */ 
function relational_sanitize_text( $input ) {

    return wp_kses_post( force_balance_tags( $input ) );
}

/**
 * Remove ellipsis and set read more text.
 * Dev note: Title attribute is not attribute realted, it is text from the theme_mod only. 
 * Only `get_the_title` would work if you want the actual title of the post.
 * @return HTML
 *
 * @id f14
 */

function relational_custom_excerpt_more($link) {

    return 
    sprintf( '<em class="excrpt-more"><a href="%1$s" class="more-link">%2$s</a></em>',
        esc_url( get_permalink( get_the_ID() ) ),
        sprintf( __( 'Continue reading %s', 'relational' ), 
        '<span class="screen-reader-text">' . get_the_title( get_the_ID() ) . '</span>' 
        )
    );
}

/**
 * Footer sidebar/widget declarations
 *
 * @id f5 
 */

function relational_register_sidebars() {

    register_sidebar(array(
        'id'            => 'footer-sidebar',
        'name'          => __('Sidebar as Footer', 'relational'),
        'description'   => __('Used on every page.', 'relational'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widgettitle">',
        'after_title'   => '</h4>',
    ));
}

/**
 * Header for singular articles
 * Add pingback url auto-discovery header for singular articles.
 *
 * @since 1.0.0
 * @return wp_head
 * @id f6
 */
function relational_pingback_header() {

	if ( is_singular() && pings_open() ) {

		printf( '<link rel="pingback" href="%s">'
                 . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}

/** 
 * -------- Woo support --------
 * Removes woo wrappers and replace with this theme's content
 * wrappers so that woo content fits in this theme.
 *
 * @https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 */

if ( class_exists( 'WooCommerce' ) ) : 

function relational_woocommerce_support() {
   
    remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end', 10);
    add_action(    'woocommerce_before_main_content', 'relational_theme_wrapper_start', 10);
    add_action(    'woocommerce_after_main_content',  'relational_theme_wrapper_end', 10);
}
// start wrapper
function relational_theme_wrapper_start() {
    echo '<div id="content-woo">';
}
// end wrapper
function relational_theme_wrapper_end() {
    echo '</div>';
}

endif;
/* -------- ends Woo weady -------- */

/**
 * **************** CHILD THEME INFO ****************
 * @example for path if using a child theme
 * "require_once ( get_stylesheet_directory() . '/theme-options.php' );"
 *
 * @uses You would use the above method for any file you move to child theme directory.
 */

/**
 * Customizer additions.
 *
 * @since 1.0.0 
 */ 
require_once get_template_directory() . '/inc/customizer.php';

/**
 * Customizer extensions and addtional functionality.
 *
 * @since 1.0.1
 */
require_once get_template_directory() . '/inc/theme-options.php'; 

/** @id TO16
 * Add theme menu
 *
 * @since 1.0.1
 * @uses add_theme_page()
 * $page_title, $menu_title, $capability, $menu_slug, $function
 */
function relational_theme_options_help_page() {

    add_theme_page(
        __( 'Theme Information', 'relational' ),
        __( 'Relational Help', 'relational' ),
        'edit_theme_options',
        'relational-theme-help',
        'relational_siteinfo_admin_render'
    );
}
?>
