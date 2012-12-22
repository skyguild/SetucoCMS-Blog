<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

<!-- entry START --> 
<div class="entry"><div class="entry"><div class="entry"><div class="entry"><div class="entry"><div class="entry"> 

	<div class="entryHead">
		<h2><span><?php the_title(); ?></span></h2>
		<p class="avatar"><a href="#"><?php echo get_avatar(get_the_author_id()) ?></a></p>
		<dl class="infoParts">
			<dt class="date">日付</dt>
				<dd class="date"><?php the_date(); ?></dd>
			<dt class="author">ライター</dt>
				<dd class="author"><a href="#"><?php the_author(); ?></a></dd>
			<dt class="category">カテゴリー</dt>
				<dd class="category"><?php the_category(); ?></dd>
		</dl>
		<dl class="entryComments">
			<dt class="comment">コメント数</dt>
				<dd class="comment"><?php comments_popup_link('0コメント', '1コメント', 
'% コメント'); ?></dd>
		</dl>
		<dl class="entryTags">
			<dt class="tag">タグ</dt>
				<?php the_tags('<dd class="tag">', '</dd><dd class="tag">', '</dd>'); ?>
		</dl>
	</div>
	
	<div class="entryBody">
		<?php the_content(); ?>
	</div>
	
	<div class="socialButton">
		<ul>
			<li class="twitter">
				<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink() ?>?ad=sharetw" data-text="<?php the_title(); ?> | <?php echo bloginfo( 'name' ); ?>" data-lang="ja" data-hashtags="setucocms" data-via="SetucoCMS" data-related="SetucoCMS">ツイート</a>
			</li>
			<li class="hatena">
				<a href="http://b.hatena.ne.jp/entry/<?php the_permalink() ?>" class="hatena-bookmark-button" data-hatena-bookmark-layout="simple-balloon" title="このエントリーをはてなブックマークに追加"><img src="http://b.st-hatena.com/images/entry-button/button-only.gif" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a>
			</li>
			<li class="plusone">
				<g:plusone size="medium" data-href="<?php the_permalink() ?>"></g:plusone>
			</li>
			<li class="facebook">
				<fb:like href="<?php the_permalink() ?>" send="false" layout="button_count" show_faces="false"></fb:like>
			</li>
		</ul>
	</div>

</div></div></div></div></div></div> 
<!-- entry END -->

<?php endwhile; ?>

<!-- comment START --> 
<div class="entry"><div class="entry"><div class="entry"><div class="entry"><div class="entry"><div class="entry">
	<?php comments_template( '', true ); ?>

	<hr />

	<div id="trackback">
		<h2><img src="<?php bloginfo('template_url'); ?>/images/front/setucocms/h_trackback.gif" alt="トラックバック" width="141" height="31" /></h2>
		<p><input type="text" value="<?php trackback_url(); ?>" onclick="this.select(0,this.value.length)" /></p>
	</div>

</div></div></div></div></div></div> 
<!-- comment END -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
