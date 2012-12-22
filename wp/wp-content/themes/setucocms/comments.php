<h2>コメント</h2>

<?php if ( have_comments() ) : ?>
	<div class="entryHead">
		<h2><span>コメントコメントコメントコメント</span></h2>
		<p><a href="#"><?php echo get_avatar(get_the_author_id()) ?></a></p>
		<dl class="entryInfo">
			<dt class="date">日付</dt>
				<dd class="date">2012年12月22日</dd>
			<dt class="author">ライター</dt>
				<dd class="author"><a href="#"><?php the_author(); ?></a></dd>
		</dl>
	</div>
<?php else: ?>
	<p>コメントはまだありません。</p>
<?php endif; ?>

<hr />

<?php comment_form(); ?>