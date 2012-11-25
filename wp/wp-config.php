<?php
/**
 * The base configurations of the WordPress.
 *
 * このファイルは、MySQL、テーブル接頭辞、秘密鍵、言語、ABSPATH の設定を含みます。
 * より詳しい情報は {@link http://wpdocs.sourceforge.jp/wp-config.php_%E3%81%AE%E7%B7%A8%E9%9B%86 
 * wp-config.php の編集} を参照してください。MySQL の設定情報はホスティング先より入手できます。
 *
 * このファイルはインストール時に wp-config.php 作成ウィザードが利用します。
 * ウィザードを介さず、このファイルを "wp-config.php" という名前でコピーして直接編集し値を
 * 入力してもかまいません。
 *
 * @package WordPress
 */

// 注意: 
// Windows の "メモ帳" でこのファイルを編集しないでください !
// 問題なく使えるテキストエディタ
// (http://wpdocs.sourceforge.jp/Codex:%E8%AB%87%E8%A9%B1%E5%AE%A4 参照)
// を使用し、必ず UTF-8 の BOM なし (UTF-8N) で保存してください。

// ** MySQL 設定 - こちらの情報はホスティング先から入手してください。 ** //
/** WordPress のためのデータベース名 */
define('DB_NAME', 'blog_setuco');

/** MySQL データベースのユーザー名 */
define('DB_USER', 'root');

/** MySQL データベースのパスワード */
define('DB_PASSWORD', '');

/** MySQL のホスト名 */
define('DB_HOST', 'localhost');

/** データベースのテーブルを作成する際のデータベースのキャラクターセット */
define('DB_CHARSET', 'utf8');

/** データベースの照合順序 (ほとんどの場合変更する必要はありません) */
define('DB_COLLATE', '');

/**#@+
 * 認証用ユニークキー
 *
 * それぞれを異なるユニーク (一意) な文字列に変更してください。
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org の秘密鍵サービス} で自動生成することもできます。
 * 後でいつでも変更して、既存のすべての cookie を無効にできます。これにより、すべてのユーザーを強制的に再ログインさせることになります。
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'l#L5xb(SQPc%+2b-}a[3-G7Rgs j3d%rKHqBry+=o1oNaJ-io%]P>^*2+:E1-Qz}');
define('SECURE_AUTH_KEY',  'Uzm8{!h.zPL51tj4Z|Bug-Rna3kb&!X]NO%=rdL`PMvil>Bm%C:}rj3!Lcb.$x g');
define('LOGGED_IN_KEY',    'V{o~o)ZZdns+AQg>5(fM5&6,c}$R-+6WtFc+QtVq |j jObb@:fzz0P0sCd R|.Y');
define('NONCE_KEY',        'D}>A|-Jsv{7Tm:}2AymL+XcM72K:SHA$?O<u Q&d&Mi5|PuHgGL<&@a5)_-NC/LX');
define('AUTH_SALT',        ']b+Z8|dWydulj86Fgv{`.U4]Cx!y]pm=ZRZ)mG<+i7c`kDevWK5s09[E/-a*~KX+');
define('SECURE_AUTH_SALT', 'yPuY+eBEG]G!%nBq/|q6~QO#RO>^F3reZ,<[xk|%o0;h%:Eyh/l@BB%]o|cS 3mn');
define('LOGGED_IN_SALT',   '74S-kr_+XluCpRVld6OG{Uj&i8YHWHt0;Yt?2k|atoI@~^>a,|]6[RUnlvFkU]YT');
define('NONCE_SALT',       'T%zN|=>5O=quo1 ec.5CTJHWe|Qy{zAcyq3Y|CT{$II&B>-QI]=HLyZDD=-@d+QC');

/**#@-*/

/**
 * WordPress データベーステーブルの接頭辞
 *
 * それぞれにユニーク (一意) な接頭辞を与えることで一つのデータベースに複数の WordPress を
 * インストールすることができます。半角英数字と下線のみを使用してください。
 */
$table_prefix  = 'wp_';

/**
 * ローカル言語 - このパッケージでは初期値として 'ja' (日本語 UTF-8) が設定されています。
 *
 * WordPress のローカル言語を設定します。設定した言語に対応する MO ファイルが
 * wp-content/languages にインストールされている必要があります。例えば de_DE.mo を
 * wp-content/languages にインストールし WPLANG を 'de_DE' に設定することでドイツ語がサポートされます。
 */
define('WPLANG', 'ja');

/**
 * 開発者へ: WordPress デバッグモード
 *
 * この値を true にすると、開発中に注意 (notice) を表示します。
 * テーマおよびプラグインの開発者には、その開発環境においてこの WP_DEBUG を使用することを強く推奨します。
 */
define('WP_DEBUG', false);

/* 編集が必要なのはここまでです ! WordPress でブログをお楽しみください。 */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
