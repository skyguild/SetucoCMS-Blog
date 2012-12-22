

			</div> 
			<!-- mainContent END --> 
 
			<!-- subContent START --> 
			<div id="subContent"> 
					
				<!-- navArea START --> 
				<div id="navArea"> 
 
					<form action="<?php echo home_url( '/' ); ?>" method="get"> 
						<dl> 
							<dt><label for="keyword">フリーワード検索</label></dt> 
							<dd><input type="text" name="s" id="s" value="検索ワードを入力" onfocus="if (this.value == '検索ワードを入力') { this.value=''; }" onblur="if(this.value == '') { this.value='検索ワードを入力'; }" tabindex="2" />
							</dd> 
						</dl> 
						<p><input type="submit" value="検索" tabindex="3" /></p> 
					</form>
 
					<!-- navList START --> 
					<div class="navList"> 
						<h3><img src="<?php bloginfo('template_url'); ?>/images/front/setucocms/h_nav_setucocms.png" alt="SetucoCMSって？" /></h3> 
						<p><?php bloginfo('description'); ?></p>
						<p class="linkText"><a href="http://setucocms.org" target="_blank">SetucoCMSプロジェクト</a></p>
					</div> 
					<!-- navList END --> 
 
					<!-- navList START --> 
					<!-- <div class="navList"> 
						<h3><img src="<?php bloginfo('template_url'); ?>/images/front/setucocms/h_nav_popular.png" alt="人気のエントリー" /></h3> 
						<ul>
							<li><a href="#">1stリリースを迎えて-謝辞-</a></li>
							<li><a href="#">1stリリースを迎えて-謝辞-</a></li>
							<li><a href="#">1stリリースを迎えて-謝辞-</a></li>
							<li><a href="#">1stリリースを迎えて-謝辞-</a></li>
							<li><a href="#">1stリリースを迎えて-謝辞-</a></li>
						</ul>
					</div>  -->
					<!-- navList END --> 
 
					<!-- navList START --> 
					<div class="navList"> 
						<h3><img src="<?php bloginfo('template_url'); ?>/images/front/setucocms/h_nav_category.png" alt="カテゴリー" /></h3> 
						<ul>
              <?php wp_list_categories('title_li&show_count=1'); ?>
						</ul>
					</div> 
					<!-- navList END --> 
 
					<!-- navList START --> 
					<div class="navList"> 
						<h3><img src="<?php bloginfo('template_url'); ?>/images/front/setucocms/h_nav_archive.png" alt="アーカイブ" /></h3> 
						<ul>
              <?php wp_get_archives('show_post_count=1&limit=12'); ?>
						</ul>
						<!-- <p class="linkText"><a href="#">さらに過去を表示する</a></p> -->
					</div> 
					<!-- navList END --> 
 
					<!-- navList START --> 
					<div class="navList"> 
						<h3><img src="<?php bloginfo('template_url'); ?>/images/front/setucocms/h_nav_writer.png" alt="ライター" /></h3> 
						<ul class="writerList heightLine">
						<?php

							$args = wp_parse_args( $args );
							extract( $args, EXTR_SKIP );

							$query_args = wp_array_slice_assoc( $args, array( 'orderby', 'order', 'number' ) );
							$query_args['fields'] = 'ids';
							$authors = get_users( $query_args );	

							foreach ( $authors as $author_id ){
								$author = get_userdata( $author_id );

								$output = "<li class='heightLineList'><a href='#'>";
								$output .= get_avatar( $author_id );
								$output .= "<br /><span>";
								$output .= "$author->nickname";
								$output .= "</span></a></li>";
								echo $output;
							}

						?>
						</ul>
					</div> 
					<!-- navList END --> 
 
					<!-- navList START --> 
					<div class="navList"> 
						<h3><img src="<?php bloginfo('template_url'); ?>/images/front/setucocms/h_nav_link.png" alt="リンク" /></h3> 
						<ul>
							<li><a href="http://setucocms.org" target="_blank">SetucoCMSプロジェクト</a></li>
							<li><a href="http://www.jec.ac.jp" target="_blank">日本電子専門学校</a></li>
							<li><a href="http://penguin.jec.ac.jp/" target="_blank">日本電子専門学校電設部</a></li>
						</ul>
					</div> 
					<!-- navList END --> 
	 
				 </div> 
				<!-- navArea END --> 
 
			</div> 
			<!-- subContent END --> 