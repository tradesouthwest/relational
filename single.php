<?php 
/**
 * Template to show single posts
 * @package WordPress
 * @subpackage Relational  
 * @since 1.0.2 Added advertbox.
 */

get_header(); ?>

	<main id="Main" class="main" role="main">
    
        <div class="space-above-fornav space-above-single"></div>
        <div class="relational-advert-above-heading">
        
            <?php echo wp_kses_post( relational_advertbox_above_header() ); ?>

        </div>

        <?php if ( 'true' == relational_indicator_maybe() ) : ?>

            <div class="indicator-wrapper">
            
                <div class="indicator" title="" 
                    aria-label="<?php esc_attr_e('percent of page read', 'relational'); ?>"></div>
                
            </div><!--<div class="page-read-icon"><i class="fa-clock"></i></div>-->
        
        <?php endif; ?>

        <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
        
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope 
            itemtype="https://schema.org/Article">
 
            <header class="single-article-header">
                
                <?php 
                    do_action( 'relational_hover_title' ); 
                ?>

            </header>

            <section class="post-content">
                <?php if ( relational_author_posit_maybe() == 'authorbox-above' ) 
                    get_template_part( 'content', 'authorbox' ); 
                ?>

                <?php 
                // check if the post has a Post Thumbnail assigned to it.
                if ( has_post_thumbnail() ) { 
                    do_action( 'relational_render_attachment' );
                } else {
                    echo '<div class="no-thumb"></div>'; }
                ?>

                <div class="inner_content">

                    <?php the_content( '', true ); ?>
                    
                    <?php if ( relational_author_posit_maybe() == 'authorbox-beside' ) 
                        get_template_part( 'content', 'authorbox' ); 
                    ?>

                </div>

                    <div class="post-footer">
                        <p><i class="fa-calendar-day"></i><span class="post_footer-date">
                        <?php printf( esc_attr( get_the_date() ) ); ?></span>
                        <i class="fa-category-folder"></i><span><?php the_category( ' &bull; ' ); ?></span>
                        <i class="fa-tags-list"></i><span><?php the_tags('<em class="tags">', ' ', '</em>'); ?></span></p>
                    </div>
                                        
                        <?php if ( 'authorbox-below' == relational_author_posit_maybe() ) 
                            get_template_part( 'content', 'authorbox' ); 
                        ?>

                <div class="pagination">
                            
                    <?php wp_link_pages(); ?>
                            
                </div>
            </section>
        </article>

            <aside class="aside-single-comments">

                <?php comments_template(); ?>
                
            </aside>
        
        <?php endwhile; ?>

		<?php else : ?>
            <div class="post-content">
		        <?php echo esc_url( home_url('/') ); ?>
            </div>
		<?php endif; ?>


        <nav class="faux-footer show-noshow">
            <p class="aligncenter"><a href="#Main" title="<?php esc_attr_e('Up to Top', 'relational'); ?>">
            <?php esc_attr_e('Up to Top', 'relational'); ?></a></p>
        </nav>

    </main>

<?php get_footer(); ?>
