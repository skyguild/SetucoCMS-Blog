<div id="comment">
	<h2><img src="<?php bloginfo('template_url'); ?>/images/front/setucocms/h_comment.gif" alt="コメント" width="89" height="25" /></h2>

	<?php if ( have_comments() ) : ?>
		<?php while ( have_comments() ) : the_comment(); ?>
			<?php $comment = get_comment(); ?>

			<div class="commentList">
				<div class="text"><div><?php comment_text(); ?></div></div>

				<?php if($comment->comment_author_url) : ?>
					<p class="avatar"><a href="<?php comment_author_url(); ?>" target="_blank"><?php echo get_avatar($comment->comment_author_email); ?></a></p>
				<?php else : ?>
					<p class="avatar"><span><?php echo get_avatar($comment); ?></span></p>
				<?php endif; ?>

				<dl class="infoParts">
					<dt class="date">日付</dt>
						<dd class="date"><?php comment_date(); ?></dd>
					<dt class="author">ライター</dt>
						<dd class="author">

							<?php if($comment->comment_author_url) : ?>
								<a href="<?php comment_author_url(); ?>" target="_blank"><?php comment_author() ?></a>
							<?php else : ?>
								<span><?php comment_author() ?></span>
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