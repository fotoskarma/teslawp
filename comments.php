<?php if (post_password_required()) return; ?>

<div class="postComments">

    <?php if (have_comments()) : ?>

        <?php wp_list_comments(array('callback' => 'teslawp_comment', 'end-callback' => 'teslawp_comment_end', 'style' => 'div')); ?>

        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) :?>
            <nav id="comment-nav-below" class="navigation" role="navigation">
                <h1 class="assistive-text section-heading"><?php _e('Comment navigation', 'teslawp'); ?></h1>
                <div class="nav-previous"><?php previous_comments_link(__('&larr; Older Comments', 'teslawp')); ?></div>
                <div class="nav-next"><?php next_comments_link(__('Newer Comments &rarr;', 'teslawp')); ?></div>
            </nav>
        <?php endif; ?>

        <?php
        if (!comments_open() && get_comments_number()) :
            ?>
            <p class="nocomments"><?php _e('Comments are closed.', 'teslawp'); ?></p>
        <?php endif; ?>

    <?php endif; ?>

</div>

<?php
$user = wp_get_current_user();
$user_identity = $user->exists() ? $user->display_name : '';
$commenter = wp_get_current_commenter();
$req = get_option( 'require_name_email' );
$aria_req = ( $req ? " aria-required='true'" : '' );
comment_form(array(
    'fields' => array(
		'author' => '<input placeholder="Name'.($req?' *':'').'" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />',
		'email'  => '<input placeholder="E-mail'.($req?' *':'').'" id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' />'
	),
    'comment_field'        => '<div class="commentWrapper"><div class="commentContainer"><textarea placeholder="'.__('Type your message here','teslawp').($req?' *':'').'" id="comment" name="comment" cols="" rows="" aria-required="true"></textarea></div></div></fieldset>',
    'must_log_in'          => '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.','teslawp' ), wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) ) . '</p>',
    'logged_in_as'         => '<fieldset>',
    'comment_notes_before' => '<fieldset>',
    'comment_notes_after'  => '<br><div id="errorNotificationArea"></div>',
    'id_form'              => 'postForm',
    'id_submit'            => 'comment_submit',
    'title_reply'          => __( 'LEAVE A COMMENT','teslawp' ),
    'title_reply_to'       => __( 'REPLY TO','teslawp' ).' "%s" /',
    'cancel_reply_link'    => __( 'CANCEL REPLY','teslawp' ),
    'label_submit'         => __( 'Reply','teslawp' ),
));
?>
