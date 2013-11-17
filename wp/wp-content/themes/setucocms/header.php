<!DOCTYPE html>

<html> 

<head>

	<?php
		$meta = array('description','title', 'og_image');
		$meta['description'] = get_bloginfo('description');
		$meta['title'] = get_bloginfo( 'name' );
		$meta['og_image'] = get_bloginfo('template_url') . "/images/front/setucocms/og_setuco.jpg";

		if ( is_single() ) {
			the_post();
			$meta['description'] = strip_tags( get_the_excerpt() );
			$meta['title'] = get_the_title() . " | " . $meta['title'];
		}
		// elseif(is_tag()) {
		// 	$meta['title'] = $_GET['tag'] . "のタグがついている記事一覧 | " . $meta['title'];
		// }
		// elseif(is_search()) {
		// 	$meta['title'] = wp_specialchars($s, 1) . "の検索結果 | " . $meta['title'];
		// }
		// elseif(is_date()) {
		// 	$meta['title'] = get_the_date(‘Y/m’) . "の記事 | " . $meta['title'];
		// }
		// elseif(is_category()) {
		// 	$category = get_the_category();
		// 	var_dump($category->name);
		// 	$meta['title'] =  " | " . $meta['title'];
		// }
	?>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
	<meta http-equiv="Content-Language" content="ja" />
	<meta http-equiv="content-style-type" content="text/css" /> 
	<meta http-equiv="content-script-type" content="text/javascript" /> 

	<meta name="author" content="SetucoCMS Project" /> 
	<meta name="copyright" content="日本電子専門学校　電設部" /> 
	<meta name="generator" content="WordPress <?php bloginfo( 'version' ); ?>" /> 
	<meta http-equiv="imagetoolbar" content="no" /> 

	<meta name="description" content="<?php echo $meta['description']; ?>" /> 
	<meta name="keywords" content="setucocms,CMS,国産CMS,オープンソース,oss,せつこ,Webデザイン,ウェブサイト,制作,ホームページ,プログラミング" /> 

	<link rel="start" href="<?php echo home_url( '/' ); ?>" title="このブログのトップページ" />
	
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" sizes="16x16" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'stylesheet_url' ); ?>" media="screen" /> 
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />


	<meta property="og:title" content="<?php echo $meta['title']; ?>" />
	<meta property="og:type" content="website" />
	<meta property="og:image" content="<?php echo $meta['og_image']; ?>" />
	<meta property="og:url" content="<?php echo home_url( '/' ); ?>" />
	<meta property="og:site_name" content="<?php bloginfo( 'name' ); ?>" />
	<meta property="og:description" content="<?php echo $meta['description']; ?>" />

	<!--[if lt IE 9]>
	<script type="text/javascript" src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/base.js"></script>

	<title><?php echo $meta['title']; ?></title>

	<?php if (!is_user_logged_in()) { ?>
		<script type="text/javascript">

			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-24180507-4']);
			_gaq.push(['_trackPageview']);

			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();

		</script>
	<?php } ?>

<?php wp_head(); ?>
</head>

<body>
 
	<!-- wrapper START --> 
	<div id="wrapper"> 
 
		<!-- header START -->
		<header> 
			<div id="header_inner"> 
				<h1><a href="<?php echo home_url( '/' ); ?>" tabindex="1"><?php echo bloginfo( 'name' ); ?></a></h1>
				<p class="descript">日本電子専門学校電設部SetucoCMSプロジェクトです。</p> 
				<ul class="utility">
					<li><a href="<?php bloginfo( 'rss_url' ); ?>" target="_blank" onclick="_gaq.push(['_trackEvent', 'ファン獲得', 'RSSフィード', 'ヘッダー']);"><img src="<?php bloginfo('template_url'); ?>/images/front/setucocms/icn_rss.png" alt="RSS" class="rollover" /></a></li>
					<li><a href="https://twitter.com/SetucoCMS" target="_blank" onclick="_gaq.push(['_trackEvent', 'ファン獲得', 'Twitter', 'ヘッダー']);"><img src="<?php bloginfo('template_url'); ?>/images/front/setucocms/icn_twitter.png" alt="ツイッター" class="rollover" /></a></li>
					<li><a href="https://www.facebook.com/SetucoCMS" target="_blank" onclick="_gaq.push(['_trackEvent', 'ファン獲得', 'Facebook', 'ヘッダー']);"><img src="<?php bloginfo('template_url'); ?>/images/front/setucocms/icn_facebook.png" alt="フェイスブック" class="rollover" /></a></li>
				</ul>
			</div>
		</header> 
		<!-- header END --> 
 
		<!-- content START --> 
		<div id="content"> 
 
			<!-- mainContent START --> 
			<div id="mainContent"> 