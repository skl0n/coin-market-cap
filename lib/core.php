<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if (!class_exists('cmc_view')) {
	include CLC_LIB_DIR . 'view.php';
}

class cmc_core extends cmc_view {

	private static $me = null;

	private $cron = null;

	function __construct() {
		$this->cron = new cmc_cron();
	}

	function getCronClass() {
		return $this->cron;
	}

	public static function getInstance() {
		if (!self::$me) {
			self::$me = new self();
		}
		return self::$me;
	}

	public function include_styles_js() {
		wp_enqueue_style('select2', plugins_url("/assets/select2.min.css", dirname( __FILE__ )));
		wp_enqueue_style('css-cmc', plugins_url("/assets/styles.css", dirname( __FILE__ )));
		wp_enqueue_style('dashicons');

		wp_enqueue_script('select2', plugins_url("/assets/select2.min.js",  dirname( __FILE__ )), ['jquery']);
		wp_enqueue_script('js-cmc', plugins_url("/assets/scripts.js",  dirname( __FILE__ )), ['jquery', 'select2']);

		 $jsParameters = [
            'request_url'   => site_url() . '/wp-admin/admin-ajax.php',
		 ];

        wp_localize_script('js-cmc', 'cmc_parameters', $jsParameters);
	}

	public function show_shortcode_view() {
		
		$this->data['crytocurrency'] = cmc_setting::getAll('cmc_crytocurrency');
		$this->view('shortcode');
	}

	public function update_history() {
		if (isset($_POST['left']) && isset($_POST['right'])) {
			$settings = cmc_setting::getALL(cmc_setting::DEFAULT_KEY);
			$historyData = cmc_setting::getALL('cmc_history');
			if (!empty($_POST['left']) && !empty($_POST['right'])) {
				$key = md5($_POST['left'] . '-' . $_POST['right']);
				if (!isset($historyData['keys'][$key])) {
					if (count($historyData['history']) == $settings['limit_count_history']) {
						$deleted = array_shift($historyData['history']);
						unset($historyData['keys'][$deleted['key']]);
					}
					$historyData['history'][] = ['left' => $_POST['left'], 'right' => $_POST['right'], 'key' => $key];
					$historyData['keys'][$key] = true;
					cmc_setting::fill('cmc_history', $historyData);
					cmc_setting::save('cmc_history');
				}
			}
			ksort($historyData['history']);
			echo json_encode($historyData['history']);
		}
		exit;
	}
}