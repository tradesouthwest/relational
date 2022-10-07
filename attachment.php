<?php 
/**
 * Template to show attachment posts
 * @since 1.0.0
 */

get_header(); ?>

	<main id="Main" class="main" role="main">
        <div class="space-above-fornav space-above-attachment"></div>

            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope 
                itemtype="https://schema.org/Article">

                <header class="single-page-header">
                     <?php 
                if ( function_exists( 'relational_upgrade_theme_maybe' ) ): 
                    if ( '1' != get_theme_mod( 'relational_checkbox_noshow_hoverlink') ) {
                        do_action( 'relational_hover_title' );  
                    } else {
                        print('<div class="perma-hover"></div>');
                    }
                endif; 
                ?>
                </header>
                <section class="post-content attachment-post">

                    <div class="entry-attachment">
                        <figure class="linked-attachment-container">
                        <?php if ( wp_attachment_is_image( $post->id ) ) :
                            $att_image = wp_get_attachment_image_src( $post->id, "full"); ?>

                        <span class="attachment">
                        <a href="<?php echo esc_attr( wp_get_attachment_url( $post->id ) ); ?>"
                            title ="<?php the_title_attribute(); ?>"
                            rel   ="attachment"><img src="<?php echo esc_attr($att_image[0]);?>"
                            width ="<?php echo esc_attr($att_image[1]);?>"
                            height="<?php echo esc_attr($att_image[2]);?>"
                            class ="img-responsive"
                            alt   ="<?php the_title_attribute(); ?>" /></a>
                        </span>
                        </figure>
                        <figcaption><?php the_excerpt(); // caption of atachment 
                            ?>
                        </figcaption>

                        <?php else : ?>

                        <a href ="<?php echo esc_url(wp_get_attachment_url($post->ID)) ?>"
                           title="<?php echo esc_attr(get_the_title($post->ID), 1 ) ?>"
                           rel  ="attachment"><?php printf( esc_url( basename($post->guid) ) ); ?></a>

                        <?php endif; ?>

                        <div class="inner_content">
                    
                            <?php the_content(); // description content of attachment ?>

                        </div>
                    </div>

		            <div class="post-footer">
                        <p><i class="fa-calendar-day"></i><span class="post_footer-date">
                        <?php printf( esc_attr( get_the_date() ) ); ?></span></p>
                    </div>
                    
                </section>
            </article>

            <aside class="aside-attachment-comments">

                <?php comments_template(); ?>
                
            </aside>

		<?php endwhile; ?>

		<?php else : ?>

		  <?php echo esc_url( home_url('/') ); ?>

		<?php endif; ?>

    <?php get_template_part( 'nav', 'content' ); ?>
</main>
   
<?php get_footer(); ?> 