			
				<div id="pageNav">		
					<?php if (function_exists("custom_pagination")) {
						custom_pagination($additional_loop->max_num_pages);
					} ?>
				</div>

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
						<p style="margin-bottom:10px;"><?php bloginfo('description'); ?></p>

						<iframe width="250" height="141" src="http://www.youtube.com/embed/Gxbnpu_GzlQ?rel=0" frameborder="0" allowfullscreen></iframe>

						<p class="linkText"><a href="http://setucocms.org" target="_blank" onclick="_gaq.push(['_trackEvent', 'サイト誘導', 'setucocms.org', 'サイドバー']);">SetucoCMSプロジェクト</a></p>
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

							$author_count = array();
							foreach ( (array) $wpdb->get_results("SELECT DISTINCT post_author, COUNT(ID) AS count FROM $wpdb->posts WHERE post_type = 'post' AND " . get_private_posts_cap_sql( 'post' ) . " GROUP BY post_author") as $row )
								$author_count[$row->post_author] = $row->count;

							foreach ( $authors as $author_id ){
								$author = get_userdata( $author_id );
								$posts = isset( $author_count[$author->ID] ) ? $author_count[$author->ID] : 0;

								if ( $posts ){
									$user_email = md5( strtolower( trim( "$author->user_email" ) ) );
									$output = "<li class='heightLineList'><a href='";
									$output .= home_url();
									$output .= "/?author=$author_id'>";
									$output .= "<img src='http://www.gravatar.com/avatar/" . "$user_email" . "?d=mm' />";
									$output .= "<br /><span>";
									$output .= "$author->nickname";
									$output .= "</span></a></li>";
									echo $output;
								}
							}

						?>
						</ul>
					</div> 
					<!-- navList END --> 
 
					<!-- navList START --> 
					<div class="navList"> 
						<h3><img src="<?php bloginfo('template_url'); ?>/images/front/setucocms/h_nav_link.png" alt="リンク" /></h3> 
						<ul>
							<li><a href="http://setucocms.org" target="_blank" onclick="_gaq.push(['_trackEvent', 'サイト誘導', 'setucocms.org', 'サイドバー（リンク集）']);">SetucoCMSプロジェクト</a></li>
							<li><a href="http://www.jec.ac.jp" target="_blank" onclick="_gaq.push(['_trackEvent', 'サイト誘導', '日本電子専門学校', 'サイドバー（リンク集）']);">日本電子専門学校</a></li>
							<li><a href="http://penguin.jec.ac.jp/" target="_blank" onclick="_gaq.push(['_trackEvent', 'サイト誘導', '電設部', 'サイドバー（リンク集）']);">日本電子専門学校電設部</a></li>
						</ul>
					</div> 
					<!-- navList END --> 

					<div class="likebox" style="margin:20px 0; background-color:#fff; padding:5px;"><fb:like-box href="https://www.facebook.com/SetucoCMS" width="240" height="285" show_faces="true" stream="false" border_color="#fff" header="false"></fb:like-box></div>

					<div class="twitter_widget" style="margin-bottom:20px;"><a class="twitter-timeline" data-dnt="true" href="https://twitter.com/SetucoCMS" data-widget-id="303268976023179264">@SetucoCMS からのツイート</a></div>

					<div class="g-plus" data-width="250" data-href="//plus.google.com/109905071534815268660" data-rel="publisher"></div>

	 
				 </div> 
				<!-- navArea END --> 
 
			</div> 
			<!-- subContent END --> 