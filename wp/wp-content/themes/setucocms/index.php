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

get_header(); ?>


<!-- entry START --> 
				<div class="entry"><div class="entry"><div class="entry"><div class="entry"><div class="entry"><div class="entry"> 
 
					<div class="entryHead">
						<h2><span>タイトルタイトル</span></h2>
						<p><a href="#"><img src="<?php bloginfo('template_url'); ?>/images/front/setucocms/writer/icn_writer_noimage.png" alt="" /></a></p>
						<dl class="entryInfo">
							<dt class="date">日付</dt>
								<dd class="date">2010年09月12日</dd>
							<dt class="author">ライター</dt>
								<dd class="author"><a href="#">author</a></dd>
							<dt class="category">カテゴリー</dt>
								<dd class="category"><a href="#">未分類</a></dd>
						</dl>
						<dl class="entryComments">
							<dt class="comment">コメント数</dt>
								<dd class="comment"><a href="#">3コメント</a></dd>
						</dl>
						<dl class="entryTags">
							<dt class="tag">タグ</dt>
								<dd class="tag"><a href="#">未分類</a></dd>
								<dd class="tag"><a href="#">未分類</a></dd>
								<dd class="tag"><a href="#">未分類</a></dd>
						</dl>
					</div>
					
					<div class="entryBody">
						<p>テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト</p>
					</div>
					
					<p class="moreRead"><a href="#">続きを読む</a></p>
					
					<div class="socialButton">
						<ul>
							<li class="twitter"><a href="https://twitter.com/share" class="twitter-share-button" data-lang="ja" data-hashtags="setucocms">ツイート</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></li>
							<li class="hatena"><a href="http://b.hatena.ne.jp/entry/" class="hatena-bookmark-button" data-hatena-bookmark-layout="standard" title="このエントリーをはてなブックマークに追加"><img src="http://b.st-hatena.com/images/entry-button/button-only.gif" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a><script type="text/javascript" src="http://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script></li>
							<li class="plusone"><g:plusone size="medium"></g:plusone></li>
							<li class="facebook"><div class="fb-like" data-send="false" data-layout="button_count" data-show-faces="false"></div></li>
						</ul>
					</div>

				</div></div></div></div></div></div> 
				<!-- entry END -->


<?php get_sidebar(); ?>
<?php get_footer(); ?>
