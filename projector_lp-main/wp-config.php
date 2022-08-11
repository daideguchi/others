<?php
/**
 * WordPress の基本設定
 *
 * このファイルは、インストール時に wp-config.php 作成ウィザードが利用します。
 * ウィザードを介さずにこのファイルを "wp-config.php" という名前でコピーして
 * 直接編集して値を入力してもかまいません。
 *
 * このファイルは、以下の設定を含みます。
 *
 * * MySQL 設定
 * * 秘密鍵
 * * データベーステーブル接頭辞
 * * ABSPATH
 *
 * @link http://wpdocs.osdn.jp/wp-config.php_%E3%81%AE%E7%B7%A8%E9%9B%86
 *
 * @package WordPress
 */

// 注意:
// Windows の "メモ帳" でこのファイルを編集しないでください !
// 問題なく使えるテキストエディタ
// (http://wpdocs.osdn.jp/%E7%94%A8%E8%AA%9E%E9%9B%86#.E3.83.86.E3.82.AD.E3.82.B9.E3.83.88.E3.82.A8.E3.83.87.E3.82.A3.E3.82.BF 参照)
// を使用し、必ず UTF-8 の BOM なし (UTF-8N) で保存してください。

// ** MySQL 設定 - この情報はホスティング先から入手してください。 ** //
/** WordPress のためのデータベース名 */
define('DB_NAME', 'LAA1357977-nzz6wt');

/** MySQL データベースのユーザー名 */
define('DB_USER', 'LAA1357977');

/** MySQL データベースのパスワード */
define('DB_PASSWORD', 'nLK1erv0');

/** MySQL のホスト名 */
define('DB_HOST', 'mysql138.phy.lolipop.lan');

/** データベースのテーブルを作成する際のデータベースの文字セット */
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
define('AUTH_KEY', ',s|-7z}k9h*lN5sb`{y2vY"Q2g9MMUp<u~`hy2i73X9P0?%n51uWxAFR^*He&`Os');
define('SECURE_AUTH_KEY', 'cU::+5Zk.gU"uUybzOu)Wfz/-ywbF=DuK4<s@O<<O}":KO,h-1)HLp2"f36U!3*^');
define('LOGGED_IN_KEY', '?72F;&.!/X"_qh=Q4&%+_+3,5{[9y%ji6VSka6{zA/<!m3Q~Z8wW<-l>"So4N1vC');
define('NONCE_KEY', '~a]O8t0Qvpl5noCcQU@}DGV^*JDK1_/$VEtNoe&eIx4g9((U~[7d3+lKu8lXb{~p');
define('AUTH_SALT', 'w5JwN[.Scx;xY9f=(Dc<*}V)V)?OTM>Yq6b/bP?+MiEfc0gSHYg,6]3Md.@cbkFe');
define('SECURE_AUTH_SALT', 'ltCJg4AQ6lvMvpCb4%QF<7>[PP"x1U0>eunr:.~Iy)j{u-G$FWiEX6?b|`^0FJgh');
define('LOGGED_IN_SALT', 'W!?*-5Lq_89vM|9[T;AqK5*vvz"}Uv,^vSF]k5F>`prWr,7rHLZT=G6C~T:_?scj');
define('NONCE_SALT', 't,6#J=bnU:2;/[0{p/]iA#]##5fzm4PI-:lvnJ;!6t$(fZJu5%vyI.>C=_c(4oA7');

/**#@-*/

/**
 * WordPress データベーステーブルの接頭辞
 *
 * それぞれにユニーク (一意) な接頭辞を与えることで一つのデータベースに複数の WordPress を
 * インストールすることができます。半角英数字と下線のみを使用してください。
 */
$table_prefix  = 'wp20211019072155_';

/**
 * 開発者へ: WordPress デバッグモード
 *
 * この値を true にすると、開発中に注意 (notice) を表示します。
 * テーマおよびプラグインの開発者には、その開発環境においてこの WP_DEBUG を使用することを強く推奨します。
 *
 * その他のデバッグに利用できる定数については Codex をご覧ください。
 *
 * @link http://wpdocs.osdn.jp/WordPress%E3%81%A7%E3%81%AE%E3%83%87%E3%83%90%E3%83%83%E3%82%B0
 */
define('WP_DEBUG', false);

/* 編集が必要なのはここまでです ! WordPress でブログをお楽しみください。 */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
  define('ABSPATH', dirname(__FILE__) . '/');
}

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
