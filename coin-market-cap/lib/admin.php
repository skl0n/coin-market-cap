<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if (!class_exists('cmc_view')) {
	include CLC_LIB_DIR . 'view.php';
}

class cmc_admin extends cmc_view {

	private static $me = null;

	private static $defaultSettings = [
		'cron_run' => true,
		'cron_limit_time' => 5,
		'limit_cryptocurrency' => 100,
		'limit_count_history' => 10
	];

	public static function getInstance() {
		if (!self::$me) {
			self::$me = new self();
		}
		return self::$me;
	}

	function admin_menu() {
		if(is_admin()) {
			//settings menu for admin
			add_menu_page('CoinMarketCap', 'CoinMarketCap', 'manage_options', 'cmc-settings', [$this, 'settings'], '', '1.23456112233901');
		}
	}

	function install() {
		if (!cmc_setting::getAll()) {
			cmc_setting::fill(cmc_setting::DEFAULT_KEY, self::$defaultSettings);
			cmc_setting::save();
			cmc_setting::fill('cmc_history', []);
			cmc_setting::save();
			cmc_core::getInstance()->getCronClass()->init();
		}
	}

	function settings() {
		if (!empty($_POST)) {
			$settings = $_POST;
			if (!isset($_POST['cron_run'])) {
				$settings['cron_run'] = false;
			}
			if ($settings['cron_run']) {
				cmc_core::getInstance()->getCronClass()->init();
			}
			cmc_setting::fill(cmc_setting::DEFAULT_KEY, $settings);
			cmc_setting::save();
		}
		$this->data['setting'] = cmc_setting::getAll();
		$this->view('admin/settings');
	}
}