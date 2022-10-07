<?php /* Page template @since 1.0.0 */
get_header(); ?>

	<main id="Main" class="main" role="main">

        <div class="space-above-fornav space-above-large"></div>
        <div class="relational-advert-above-heading above-heading-page">
        
            <?php echo wp_kses_post( relational_advertbox_above_header() ); ?>

        </div>

        <?php if ( have_posts() ) : ?>

        <?php while ( have_posts() ) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> 
                     itemscope itemtype="https://schema.org/Article">

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

                <section class="post-content page-post">
                    <figure class="relational-featured_image">
                        
                        <?php 
                        // check if the post has a Post Thumbnail assigned to it.
                        if ( has_post_thumbnail() ) { 
                            do_action( 'relation_render_attachment' );
                        } else {
                            echo '<div class="no-thumb"></div>'; }
                        ?>
                    </figure>
                    <div class="inner_content">

                        <?php the_content( '', true ); ?>

                    </div>
                    <div id="relationalAuthoringBox">

                        <?php 
                        if ( 'authorbox-none' != relational_author_posit_maybe() ) 
                            get_template_part( 'content', 'authorbox' ); 
                        ?>
                    
                    </div>
                    <div class="pagination">
                        
                        <?php wp_link_pages(); ?>
                        
                    </div>            
                </section>
            </article>

                <?php // if mod checked returns 1 
                if ( relational_comment_notonpage_maybe() == 'false' ) { 
                ?>

                <aside class="comments-section">

                    <?php comments_template(); ?>  

                </aside> 

                <?php 
                } ?>

        <?php endwhile; ?>

		    <?php else : ?>
            
            <div class="post-content">
		        
            <?php echo esc_url( home_url('/') ); ?>
            
            </div>

		    <?php endif; ?>
        
    </main>

<?php get_footer(); ?>
