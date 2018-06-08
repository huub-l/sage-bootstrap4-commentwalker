<?php

namespace App;

/**
 * Plugin Name: Sage Bootstrap Comment Walker
 * Plugin URI:  https://github.com/jcjdamen/sage-bootstrap4-commentwalker
 * Version: 1.0.0
 * Description: A custom WordPress comment walker class to implement the Bootstrap 4 media object style in a custom theme using the WordPress comment system.
 * Author: Jelle Damen
 * Author URI: https://github.com/jcjdamen
 * GitHub Plugin URI: https://github.com/jcjdamen/sage-bootstrap4-commentwalker
 * GitHub Branch: master
 * License: GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 */

class Bootstrap_Comment_Walker extends \Walker_Comment
{
    /**
     * Output a comment in the HTML5 format.
     *
     * @access protected
     * @since 1.0.0
     *
     * @see wp_list_comments()
     *
     * @param object $comment Comment to display.
     * @param int $depth Depth of comment.
     * @param array $args An array of arguments.
     */
    protected function html5_comment( $comment, $depth, $args ) {
        $tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
        ?>
        <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent media' : 'media' ); ?>>

        <?php if ( 0 != $args['avatar_size'] ): ?>
            <div class="media-left">
                <a href="<?php echo get_comment_author_url(); ?>" class="media-object">
                    <?php echo get_avatar( $comment, $args['avatar_size'] ); ?>
                </a>
            </div>
        <?php endif; ?>

        <div class="media-body">

            <?php printf( '<h4 class="media-heading">%s</h4>', get_comment_author_link() ); ?>

            <div class="comment-metadata">
                <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
                    <time datetime="<?php comment_time( 'c' ); ?>">
                        <?php printf( _x( '%1$s at %2$s', '1: date, 2: time' ), get_comment_date(), get_comment_time() ); ?>
                    </time>
                </a>
            </div><!-- .comment-metadata -->

            <?php if ( '0' == $comment->comment_approved ) : ?>
                <p class="comment-awaiting-moderation label label-info"><?php _e( 'Your comment is awaiting moderation.' ); ?></p>
            <?php endif; ?>

            <div class="comment-content">
                <?php comment_text(); ?>
            </div><!-- .comment-content -->

            <ul class="list-inline">
                <?php edit_comment_link( __( 'Edit' ), '<li class="edit-link">', '</li>' ); ?>

                <?php
                comment_reply_link( array_merge( $args, array(
                    'add_below' => 'div-comment',
                    'depth'     => $depth,
                    'max_depth' => $args['max_depth'],
                    'before'    => '<li class="reply-link">',
                    'after'     => '</li>'
                ) ) );
                ?>

            </ul>

        </div>
        <?php
    }
}
