<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package sfm-starter
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h3>
			<?php
				printf( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'sfm-starter' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h3>
		<hr>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-above" class="comment-navigation" role="navigation">
			<h3 class="sr-only"><?php _e( 'Comment navigation', 'sfm-starter' ); ?></h3>
			<ul class="pager">
				<li class="previous"><?php previous_comments_link( __( '&larr; Older Comments', 'sfm-starter' ) ); ?></li>
				<li class="next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'sfm-starter' ) ); ?></li>
			</ul>
		</nav><!-- #comment-nav-above -->
		<?php endif; // check for comment navigation ?>

		<ol class="media-list">
			<?php
				wp_list_comments( array(
					'style'      => 'ol',
					'callback'   => 'sfm_comment_display',
					'short_ping' => true,
				) );
			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="comment-navigation" role="navigation">
			<h3 class="sr-only"><?php _e( 'Comment navigation', 'sfm-starter' ); ?></h3>
			<ul class="pager">
				<li class="previous"><?php previous_comments_link( __( '&larr; Older Comments', 'sfm-starter' ) ); ?></li>
				<li class="next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'sfm-starter' ) ); ?></li>
			</ul>
		</nav><!-- #comment-nav-below -->
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'sfm-starter' ); ?></p>
	<?php endif; ?>
	
<!-- COMMENT REPLY FORM -->

	<section id="respond" class="respond-form">
	
		<h4 class="h3"><?php comment_form_title( __( 'Leave a Reply', 'sfm-starter' ), __( 'Leave a Reply to %s', 'sfm-starter' )); ?> <small><?php cancel_comment_reply_link(); ?></small></h4>

		<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
			<div class="alert alert-warning">
				<p><?php printf( __( 'You must be %1$slogged in%2$s to post a comment.', 'sfm-starter' ), '<a href="<?php echo wp_login_url( get_permalink() ); ?>">', '</a>' ); ?></p>
			</div>
		<?php else : ?>
	
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
	
		<?php if ( is_user_logged_in() ) : ?>
	
			<p class="small"><?php _e( 'Logged in as', 'sfm-starter' ); ?> <a href="<?php echo get_option( 'siteurl' ); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url( get_permalink() ); ?>" title="<?php _e( 'Log out of this account', 'sfm-starter' ); ?>"><?php _e( 'Log out', 'sfm-starter' ); ?> <?php _e( '&raquo;', 'sfm-starter' ); ?></a></p>
	
		<?php else : ?>
		
		<div class="form-group">
			<label for="author"><?php _e( 'Name', 'sfm-starter' ); ?> <?php if ($req) _e( '(required)'); ?></label>
			<input type="text" name="author" id="author" class="form-control" value="<?php echo esc_attr($comment_author); ?>" placeholder="<?php _e( 'Enter name', 'sfm-starter' ); ?>" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
		</div>

		<div class="form-group">
			<label for="email"><?php _e( 'Email', 'sfm-starter' ); ?> <?php if ($req) _e( '(required)'); ?></label>
			<input type="email" name="email" id="email" class="form-control" value="<?php echo esc_attr($comment_author_email); ?>" placeholder="<?php _e( 'Enter email', 'sfm-starter' ); ?>" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
		</div>
	
		<?php endif; ?>
		<div class="form-group">
			<textarea name="comment" id="comment" class="form-control" rows="5" placeholder="<?php _e( 'Enter comment', 'sfm-starter' ); ?>" tabindex="4"></textarea>
		</div>
		
		<div class="form-group">
			<button name="submit" type="submit" id="submit" class="btn btn-default" tabindex="5"><?php _e( 'Submit', 'sfm-starter' ); ?></button>
			<?php comment_id_fields(); ?>
		</div>
	
		<!--<div class="alert alert-info">
			<p id="allowed_tags" class="small"><strong>XHTML:</strong> <?php // _e( 'You can use these tags', 'sfm-starter' ); ?>: <code><?php // echo allowed_tags(); ?></code></p>
		</div>-->
	
		<?php do_action( 'comment_form', $post->ID ); ?>
	
		</form>
	
		<?php endif; // If registration required and not logged in ?>
	</section>

</div><!-- #comments -->
