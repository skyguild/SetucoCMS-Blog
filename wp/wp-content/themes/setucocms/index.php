<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>

<?php get_header(); ?>


<?php while ( have_posts() ) : the_post(); ?>

	<!-- entry START --> 
	<div class="entry"><div class="entry"><div class="entry"><div class="entry"><div class="entry"><div class="entry"> 

		<div class="entryHead">
			<h2><span><?php the_title(); ?></span></h2>
			<p><a href="#"><?php echo get_avatar(get_the_author_id()) ?></a></p>
			<dl class="entryInfo">
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
			<?php the_content(false, true); ?>
		</div>
		
		<p class="moreRead"><a href="<?php the_permalink(); ?>#more-<?php the_ID(); ?>">続きを読む</a></p>
		
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

<?php get_sidebar(); ?>

<?php get_footer(); ?>
