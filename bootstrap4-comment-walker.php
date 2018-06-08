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

class bootstrap_comment_walker extends \Walker_Comment
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
    protected function html5_comment($comment, $depth, $args) {
        $tag = ($args['style'] === 'div') ? 'div' : 'li';
        ?>
        <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class($this->has_children ? 'has-children media' : ' media'); ?>>

        <?php if ( 0 != $args['avatar_size'] ): ?>
            <a href="<?php echo get_comment_author_url(); ?>">
                <?php echo get_avatar( $comment, $args['avatar_size'] ); ?>
            </a>
        <?php endif; ?>

        <div class="media-body">
        <article id="comment-<?php comment_ID(); ?>">

            <h5><?php _e('By'); ?>&nbsp;<?php echo get_comment_author_link(); ?>&nbsp;<?php _e('on'); ?>
                <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>"
                   datetime="<?php comment_time('c'); ?>"><?php comment_date(); ?>
                </a>
            </h5>

            <?php if ( '0' == $comment->comment_approved ) : ?>
                <p class="comment-awaiting-moderation label label-info"><?php _e( 'Your comment is awaiting moderation.' ); ?></p>
            <?php endif; ?>

            <?php comment_text(); ?>

            <ul class="list-inline">
                <?php edit_comment_link(__('Edit'), '<li class="edit-link list-inline-item chip">', '</li>'); ?>
                <?php
                comment_reply_link(array_merge($args, array(
                    'add_below' => 'div-comment',
                    'depth'     => $depth,
                    'max_depth' => $args['max_depth'],
                    'before'    => '<li class=" reply-link list-inline-item chip">',
                    'after'     => '</li>'
                )));
                ?>
            </ul>
        </article>
        <?php
    }
}
