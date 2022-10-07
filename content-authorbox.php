<?php 
/**
 * Content template authorbox
 * @since 1.0.2
 * // to Allow HTML in author bio section
 * // remove_filter('pre_user_description', 'wp_filter_kses');
 */
?>

    <section class="relational-authorby <?php echo esc_attr( relational_author_posit_maybe() ); ?>">
        <span class="relational-authortop"><?php echo esc_html( relational_authoring_box_text() ); ?></span>
            <table><tbody>
            <tr><td class="pcnt-twenty">
            <figure class="relational-authoring-avatar">
                <?php echo get_avatar(get_the_author_meta('ID'), 80); ?> 
            </figure>
            <p class="authoring-nicename" aria-role="heading">
            <?php echo get_the_author_meta( 'display_name', 
                                            absint(relational_get_post_author()) 
                                            ); ?></p>
            </td><td>
            <div class="authfloat">
                <p class="relational-user-descript">
                <?php echo get_the_author_meta( 'user_description', 
                                            absint(relational_get_post_author())
                                            ); ?></p>
                <p class="relational-user-website">
                <?php echo get_the_author_meta( 'user_url', 
                                            absint(relational_get_post_author())
                                            ); ?></p>
            </div></td></tr></tbody></table><div class="clearfix"></div>
         
    </section> 
    <div class="relational-advert-after-author">
        
        <?php echo wp_kses_post( relational_advertbox_text() ); ?>

    </div>
