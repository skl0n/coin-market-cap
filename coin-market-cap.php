<?php
/*
Plugin Name: Coin market cap
Description: Coin market cap
Version: 1.0
Text Domain: coin-market-cap 
Domain Path: /languages
*/

define('CLC_BASE_DIR', dirname(__FILE__) . '/');
define('CLC_LIB_DIR', dirname(__FILE__) . '/lib/');

include CLC_LIB_DIR . 'core.php';
include CLC_LIB_DIR . 'admin.php';
include CLC_LIB_DIR . 'setting.php';
include CLC_LIB_DIR . 'cron.php';

$core = cmc_core::getInstance();

add_action( 'wp_enqueue_scripts', [$core, 'include_styles_js'] );

add_shortcode('coin-market-cap-shortcode', [$core, 'show_shortcode_view']);

add_action('admin_menu', [cmc_admin::getInstance(), 'admin_menu']);

register_activation_hook( __FILE__, [cmc_admin::getInstance(), 'install']);

add_action('cmc_running_task', [$core->getCronClass(), 'init']);

add_action( 'wp_ajax_nopriv_cmc_update_history', [$core, 'update_history']);
add_action( 'wp_ajax_cmc_update_history', [$core, 'update_history']);
