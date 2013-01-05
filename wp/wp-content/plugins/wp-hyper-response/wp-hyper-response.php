<?php
/*
Plugin Name: WP Hyper Response
Plugin URI: http://stocker.jp/diary/wp-hyper-response/
Description: WordPressサイト及び管理画面のレスポンスを向上させるプラグインです。
Version: 1.3
Author: なつき(@Stocker_jp)
Author URI: http://stocker.jp/
*/

// admin_head（管理画面のヘッダ）で wp_hyper_response()関数を実行（優先度 9999=最低）
add_action ( 'admin_head', 'wp_hyper_response', 9999 );

// wp_head（サイトのヘッダ）で wp_hyper_response()関数を実行（優先度 9999=最低）
add_action ( 'wp_head', 'wp_hyper_response', 9999 );


// wp_hyper_response関数
function wp_hyper_response() {

	// flush関数を実行（バッファを吐かせる）
	flush();

}
    
?>