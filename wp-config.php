<?php
# Database Configuration
define( 'DB_NAME', 'snapshot_ividf' );
define( 'DB_USER', 'ividf' );
define( 'DB_PASSWORD', 'fXdXhwdD9pH7mAfq6Vwk' );
define( 'DB_HOST', '127.0.0.1' );
define( 'DB_HOST_SLAVE', '127.0.0.1' );
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', 'utf8_unicode_ci');
$table_prefix = 'qtx_';

# Security Salts, Keys, Etc
define('AUTH_KEY',         'Z(5}2k_XC$*{SWun^lQa=8S4D!mY+QO(+~+Cjb+H?`N|1223LT?Kw>-x.(O230xu');
define('SECURE_AUTH_KEY',  ';k3$dA3/OL$-Y4}2h[Vw_)%`|?+ZM|%W.s)PF3p&aT@k}Hpn-DDu-8RG/Lgt|H1o');
define('LOGGED_IN_KEY',    '37;h^=N ;;~<10;dM(KH<u9~CZ*i<If|J8dvtSzf%f~uOu%-Svhk1SO-*R3LprOR');
define('NONCE_KEY',        'F`cp7(mW&aaw+v0Vw[Bn%&fTUS3RF;7,+wYhe]UBEjQ~-1K$w[>|m`]D tzoWGn?');
define('AUTH_SALT',        'M]S|y~vWPBM[b*raZzK/F2LWsk(FEG6gJL_cWS.$LSSwGw[ubtPU}3i_vnLS|i<l');
define('SECURE_AUTH_SALT', 'J@^bS$<C*Jh0Hr-[|:Wj<e1oL}yM^R>YcpqjU)|~mK|JQ X5i8IM"_Iz5fT( [:(');
define('LOGGED_IN_SALT',   'SH_Wt]3p,{(n^y"I_w4@2{%fS:vMZ{H;RcK6SP%RX}ogJiqCYi<yF}~Sh>AdUO{%');
define('NONCE_SALT',       'OfQ]cEF9.H=|TZh60F}6SyPNJ;cs|tN`csb87}_-bw"dXwWlxQ@zpHvCfm[};B/S');


# Localized Language Stuff

define( 'WP_CACHE', TRUE );

define( 'WP_AUTO_UPDATE_CORE', false );

define( 'PWP_NAME', 'ividf' );

define( 'FS_METHOD', 'direct' );

define( 'FS_CHMOD_DIR', 0775 );

define( 'FS_CHMOD_FILE', 0664 );

define( 'PWP_ROOT_DIR', '/nas/wp' );

define( 'WPE_APIKEY', '05bcb85f4cb7ec812d05e7169cda77965fbe95f7' );

define( 'WPE_FOOTER_HTML', "" );

define( 'WPE_CLUSTER_ID', '40602' );

define( 'WPE_CLUSTER_TYPE', 'pod' );

define( 'WPE_ISP', true );

define( 'WPE_BPOD', false );

define( 'WPE_RO_FILESYSTEM', false );

define( 'WPE_LARGEFS_BUCKET', 'largefs.wpengine' );

define( 'WPE_SFTP_PORT', 2222 );

define( 'WPE_LBMASTER_IP', '45.56.66.55' );

define( 'WPE_CDN_DISABLE_ALLOWED', false );

define( 'DISALLOW_FILE_EDIT', FALSE );

define( 'DISALLOW_FILE_MODS', FALSE );

define( 'DISABLE_WP_CRON', false );

define( 'WPE_FORCE_SSL_LOGIN', false );

define( 'FORCE_SSL_LOGIN', false );

/*SSLSTART*/ if ( isset($_SERVER['HTTP_X_WPE_SSL']) && $_SERVER['HTTP_X_WPE_SSL'] ) $_SERVER['HTTPS'] = 'on'; /*SSLEND*/

define( 'WPE_EXTERNAL_URL', false );

define( 'WP_POST_REVISIONS', FALSE );

define( 'WPE_WHITELABEL', 'wpengine' );

define( 'WP_TURN_OFF_ADMIN_BAR', false );

define( 'WPE_BETA_TESTER', false );

umask(0002);

$wpe_cdn_uris=array ( );

$wpe_no_cdn_uris=array ( );

$wpe_content_regexs=array ( );

$wpe_all_domains=array ( 0 => 'inventiondevfund.com', 1 => 'ividf.wpengine.com', 2 => 'www.inventiondevfund.com', );

$wpe_varnish_servers=array ( 0 => 'pod-40602', );

$wpe_special_ips=array ( 0 => '45.56.66.55', );

$wpe_ec_servers=array ( );

$wpe_largefs=array ( );

$wpe_netdna_domains=array ( 0 =>  array ( 'match' => 'ividf.wpengine.com', 'secure' => false, 'dns_check' => '0', 'zone' => '1bzv6341v42vp3ls222b61js', ), 1 =>  array ( 'match' => 'inventiondevfund.com', 'zone' => 'igt714euy8t3bqzjl4e3t401', 'enabled' => true, ), );

$wpe_netdna_domains_secure=array ( );

$wpe_netdna_push_domains=array ( );

$wpe_domain_mappings=array ( );

$memcached_servers=array ( );

//define( 'WP_SITEURL', 'http://ividf.staging.wpengine.com' );

//define( 'WP_HOME', 'http://ividf.staging.wpengine.com' );
define('WPLANG','');

# WP Engine ID


# WP Engine Settings






define('WP_DEBUG', false);
define('WP_MEMORY_LIMIT', '128M');



# That's It. Pencils down
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
require_once(ABSPATH . 'wp-settings.php');

$_wpe_preamble_path = null; if(false){}
