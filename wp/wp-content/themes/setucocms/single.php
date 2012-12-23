<?php get_header(); ?>


<?php include("entry_parts.php"); ?>

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
