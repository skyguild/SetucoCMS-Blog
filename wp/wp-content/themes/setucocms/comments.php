<h2>コメント</h2>

<?php if ( have_comments() ) : ?>
	<?php while ( have_comments() ) : the_comment(); ?>
		<?php $comment = get_comment(); ?>

		<div class="entryHead">
			<?php comment_text(); ?>

			<?php if($comment->comment_author_url) : ?>
				<p><a href="<?php comment_author_url(); ?>" target="_blank"><?php echo get_avatar($comment->comment_author_email); ?></a></p>
			<?php else : ?>
				<p><span><?php echo get_avatar($comment); ?></span></p>
			<?php endif; ?>

			<dl class="entryInfo">
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
	<?php endwhile ?>
<?php else: ?>
	<p>コメントはまだありません。</p>
<?php endif; ?>

<hr />

<?php comment_form(); ?>