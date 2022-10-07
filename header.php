<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="//gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>><?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#content">
    <?php esc_attr_e( 'Skip to content', 'relational' ); ?></a>

<div class="page-wrap">
    <section class="sidemount" style="background-image: url(<?php echo esc_attr( 
                                        relational_sidemount_background()); ?>);">
        <header class="site-header">
            <div class="space-above"></div>
                
                <figure class="site-logo">
                    <?php 
                    if( has_custom_logo() ) : ?>
                    <?php 
                    if( function_exists( 'relational_theme_custom_logo' ) ) : ?>
                        <a title="<?php bloginfo('description'); ?>" 
                        href="<?php echo esc_url(home_url('/')); ?>">
                        <?php echo wp_kses_post( force_balance_tags( 
                                        relational_theme_custom_logo() ) ); ?></a>
                    <?php 
                    endif; ?>
                    <?php 
                    endif; ?>
                </figure>

                    <section class="hgroup">
                        <h1 class="site-title h1">
                        <a title="<?php bloginfo('description'); ?>" href="<?php echo esc_url(home_url('/')); ?>">
                        <?php bloginfo('name') ?></a></h1>
                        <h4 class="site-description"><span><?php bloginfo('description') ?></span></h4>
                        <?php  
                        if( function_exists( 'relational_header_lead_render' ) ): ?>

                            <p class="descriptor-alt"><?php echo esc_html( 
                                relational_header_lead_render() ); ?></p>

                        <?php 
                        endif; ?>
                        
                        <div class="site-icons">
                        <?php 
                        if(function_exists( 'relational_social_menu_render' ) ): ?>

                        <nav class="social-sites">
                            <?php
                            wp_nav_menu( array(
                                'theme_location'  => 'social',
                                'fallback_cb' => 'relational_social_menu_render'
                            )); ?>

                        </nav>
                        <?php 
                        else: ?>
                        
                        <span class="apport-social"></span>
                        <?php 
                        endif; ?>
                        
                        </div>
                    </section>
        </header>
      
        <footer id="copyFooter">
            <div id="footer-floats" class="footer-page">
                <div class="maybe-copyright" style="display:block">
                    <p class="text-muted"><?php 
                    $year   = date_i18n(__( 'Y', 'relational' )); ?>
                    <span><?php esc_html_e( 'Copyright ', 'relational' ); 
                    echo esc_attr( ' ' . $year . ' ' );
                    printf( esc_attr( bloginfo( 'name' ) ) ); ?></span></p>
                </div>
        </footer>

    </section>
        <?php // Section container-main ends in footer!
        ?>
        <section class="container-main">
            <header class="navbar-fixed">
                <nav id="nav" class="navbar navigation-top"> 

                <?php wp_nav_menu( array(
                    'theme_location'  => 'primary',
                    'fallback_cb' => 'wp_nav_menus'
                )); ?>

                </nav>
            </header><div class="clearfix"></div> 
            