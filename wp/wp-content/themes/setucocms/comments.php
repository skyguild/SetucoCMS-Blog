<div id="comments">
	<h2><img src="<?php bloginfo('template_url'); ?>/images/front/setucocms/h_comment.gif" alt="コメント" width="89" height="25" /></h2>

	<?php if ( have_comments() ) : ?>

		<?php while ( have_comments() ) : the_comment(); ?>

			<div class="commentList">
				<div class="text"><div><?php comment_text(); ?></div></div>

				<?php
					if(isset($comment->comment_author_email)){
						$comment_author = $comment->comment_author_email;
					}	else {
						$comment_author = "none";
					}

					$user_email = md5( strtolower( trim( $comment_author ) ) );
					$output_avatar = "<img src='http://www.gravatar.com/avatar/" . $user_email . "?d=mm' />";
				?>
				<?php if($comment->comment_author_url) : ?>
					<p class="avatar"><a href="<?php comment_author_url(); ?>" target="_blank"><?php echo $output_avatar; ?></a></p>
				<?php else : ?>
					<p class="avatar"><span><?php echo $output_avatar; ?></span></p>
				<?php endif; ?>

				<dl class="infoParts">
					<dt class="date">日付</dt>
						<dd class="date"><?php comment_date(); ?></dd>
					<dt class="author">ライター</dt>
						<dd class="author">

							<?php if($comment->comment_author_url) : ?>
								<a href="<?php comment_author_url(); ?>" target="_blank"><?php echo mb_strimwidth( get_comment_author() , 0 , 50 , "..." ); ?></a>
							<?php else : ?>
								<span><?php echo mb_strimwidth( get_comment_author() , 0 , 50 , "..." ); ?></span>
							<?php endif; ?>
						</dd>
				</dl>
			</div>

			<hr />
		<?php endwhile ?>
	<?php else: ?>
		<p>コメントはまだありません。</p>
		<hr />
	<?php endif; ?>

	<?php comment_form(); ?>
</div>