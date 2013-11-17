
 
		</div> 
		<!-- content END -->

	</div> 
	<!-- wrapper END -->

	<!-- footer START --> 
	<footer>
		
		<!-- footer_inner START -->
		<div class="footer_inner">

			<!-- tagCloud START --> 
			<div id="tagCloud"> 
				<h3><img src="<?php bloginfo('template_url'); ?>/images/front/setucocms/h_tagCloud.png" alt="タグ" /></h3>
				<ul>
					<?php
						$tags = get_tags();
						$i = 0;
					?>
					<?php foreach ($tags as $tag) : ?>
						<?php if($tag->count >=10) : ?>
							<li class="level10"><a href="<?php echo get_tag_link($tag->term_id); ?>"><?php echo $tag->name ?></a></li>
						<?php elseif($tag->count != 0) : ?>
							<li class="level<?php echo $tag->count; ?>"><a href="<?php echo get_tag_link($tag->term_id); ?>"><?php echo $tag->name ?></a></li>
						<?php endif ?>
						<?php if (++$i == 40) break; ?>
					<?php endforeach ?>
				</ul> 
			</div> 
			<!-- tagCloud END -->
			
			<p class="backTop"><a href="#wrapper">ページの先頭に戻る</a></p>
			
		</div>
		<!-- footer_inner END -->
		
		<!-- copyright_area START -->
		<div class="copyright_area">
			<p class='copyright'>Copyright &copy; 2012 SetucoCMS Project AllRight reserved.</p>
		</div>
		<!-- copyright_area END -->
			
	</footer>
	<!-- footer END -->
 

	<!-- twitter -->
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

	<!-- hatena bookmark -->
	<script type="text/javascript" src="http://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script>

	<!-- google plusone+ -->
	<script type="text/javascript">
		window.___gcfg = {lang: 'ja'};

		(function() {
			var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			po.src = 'https://apis.google.com/js/plusone.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
		})();
	</script>
	
	<!-- facebook -->
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/ja_JP/all.js#xfbml=1";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>

<?php wp_footer(); ?>
</body> 

</html> 