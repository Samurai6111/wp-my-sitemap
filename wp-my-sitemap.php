<?php
/*
@package    WordPress
@subpackage my_plugin
@author  Samurai6111 <samurai.blue6111@gmail.com>
Plugin Name: WP My Sitemap
Text Domain: my_plugin
Description: Wordpressで管理画面でサイトマップを表示させるプラグイン
Author: Shota Kawakatsu
Author URI: https://github.com/Samurai6111
Version: 1.0
Plugin URI: https://github.com/Samurai6111/wp-my-sitemap
*/

/*--------------------------------------------------
/* phpファイルのURLに直接アクセスされても中身見られないようにする
/*------------------------------------------------*/
if (!defined('ABSPATH')) exit;

//--------------------------------------------------
// 変数
//--------------------------------------------------
$wms_url = plugins_url('', __FILE__);
$wms_path = plugin_dir_path(__FILE__);

/**
 * ページ作成
 */
function wms_add_pages() {
	global $wms_path;
	add_menu_page(
		__('My Sitemap'),
		__('My Sitemap'),
		'manage_options',
		'wms_page',
		'wms_view',
		'dashicons-calendar-alt',
		100
	);
}
add_action('admin_menu', 'wms_add_pages');


/**
 * ページ読み込み時に実行される関数
 */
function wms_view() {
	global $wms_path;

	//--------------------------------------------------
	// インクルード
	//--------------------------------------------------
	require_once($wms_path . "/Includes/wms-includes.php");

	//--------------------------------------------------
	// ページ読み込み
	//--------------------------------------------------
	require_once($wms_path . "/Pages/wms-page.php");
}


/**
 * css読み込み
 */
function wms_load_css() {
	global $wms_url;
	wp_enqueue_style('wms_css', $wms_url . '/Assets/css/style.css', false, '1.0', 'all');
}
add_action('admin_enqueue_scripts', 'wms_load_css');


/**
 * css読み込み
 */
function wms_load_js() {
	global $wms_url;
	wp_enqueue_script('my-wpdb', $wms_url . '/Assets/js/wms.js', [], false, true);
}
// add_action('admin_enqueue_scripts', 'wms_load_js');
