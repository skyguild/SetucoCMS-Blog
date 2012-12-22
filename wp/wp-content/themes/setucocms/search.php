<?php get_header(); ?>

<!-- entry START --> 
<div class="entry single"><div class="entry"><div class="entry"><div class="entry"><div class="entry"><div class="entry">
	<div class="entryHead">
		<p><strong><?php echo $_GET['s']; ?></strong>の検索結果</p>
	</div>
</div></div></div></div></div></div> 
<!-- entry END -->

<?php if( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<?php include("entry_parts.php"); ?>
	<?php endwhile; ?>
<?php else : ?>
		<!-- entry START --> 
		<div class="entry"><div class="entry"><div class="entry"><div class="entry"><div class="entry"><div class="entry">

			<div class="entryBody">
				<p>「<?php echo $_GET['s']; ?>」に一致するページはありませんでした。<br />以下のことを確認して再度検索してみてください。</p>

				<p>キーワードに誤字・脱字はありませんか？<br />
				キーワードは長すぎませんか？<br />
				一般的なキーワードに変えてみてください。</p>
			</div>
		</div></div></div></div></div></div> 
		<!-- entry END -->

<?php endif; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
