<?php
/**
 * The template for displaying Comments
 * @package Relational
 * @since 1.0.2
 * The area of the page that contains both current comments
 * and the comment form.
 */

/** 
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */

if ( post_password_required() )
    return;
    ?>

    <h5 class="comments-count-heading"><?php get_template_part( 'comments', 'count' ); ?></h5>
        <ol id="relationalComm" class="commentlist" itemscope="commentText" 
            itemtype="https://schema.org/UserComments">
        <?php
            wp_list_comments( array(
                'style'      => 'ol',
				'short_ping' => true,
				'avatar_size'=> 34,
			) );
        ?></ol>

    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
        <ul id="comment-nav-below" class="navigation comment-navigation">
            <ul class="pager">
                <li class="previous"><?php previous_comments_link(
                        esc_attr__("&laquo; Older Comments", "relational") ); ?></li>
                <li class="next"><?php next_comments_link(
                        esc_attr__("Newer Comments &raquo;", "relational") ); ?></li>
            </ul>
        </ul>
    <?php endif; ?>

    <?php 
    $wurl = wp_login_url( apply_filters( 'the_permalink', esc_url(get_permalink()) ) );
    $comment_args = array(
        // Change the title of send button
        'label_submit' => esc_attr__( 'Send', 'relational' ),

        // Change the title of the reply section
        'title_reply' => esc_attr__( 'Reply or Comment', 'relational' ),

        // Remove "Text or HTML to be displayed after the set of comment fields".
        'comment_notes_after' => '<p class="form-allowed-tags">'
            . esc_html__( 'You may use these ', 'relational' ) . '<abbr title="' 
            . esc_attr__( 'HyperText Markup Language', 'relational') .'">'
            . esc_html__( 'HTML', 'relational' ) . '</abbr>'
            . esc_html__( ' tags and attributes: ', 'relational' ) . '</p>
            <span class="tagsatts"><code>' . allowed_tags() . '</code></span>',

        // Redefine default textarea (the comment body).
        'comment_field' => '<span class="comment-form-comment"><label for="comment">'
            . esc_attr__( 'Respond', 'relational' ) . '<span class="screen-reader-text">'
            . esc_html__( 'Comment textarea box', 'relational' ) . '</label><br>
            <textarea id="comment" name="comment" aria-required="true"></textarea>
            </span>',

        //logged in check
        'must_log_in' => '<p class="must-log-in">'
            . esc_html__( 'You must be ', 'relational' ) . '<a href="'. esc_url($wurl) 
            .'">'. esc_html__( 'logged in ', 'relational' ) .'</a>'
            . esc_html__( 'to post a comment.', 'relational' ) .'</p>',


        'comment_notes_before' => '<p class="comment-notes">' .
            esc_html__( 'Your email address will not be published.', 'relational' ) 
            . '</p>',
    );
    ?>
            <div class="fieldset-commentform">
                <?php comment_form( $comment_args ); ?>
            </div> 
