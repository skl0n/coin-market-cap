<?php 

class cmc_cron {

	function init($force = false) {
		$settings = cmc_setting::getALL();
		if ($settings['cron_run'] || $force) {
			$this->run(60 * (int)$settings['cron_limit_time'], $force);
			if ( $this->checkLock($force) ) {
				$url = "https://api.coinmarketcap.com/v1/ticker/?limit={$settings['limit_cryptocurrency']}&ref=converter";
				$cryptoCurrencyData = json_decode(file_get_contents($url), true);
				$n = count($cryptoCurrencyData);
				$crytocurrency = [];
				for($i = 0; $i < $n; $i++) {
					$crytocurrency[] = [
						'id' => $cryptoCurrencyData[$i]['id'],
						'name' => $cryptoCurrencyData[$i]['name'],
						'symbol' => $cryptoCurrencyData[$i]['symbol'],
						'price_usd' => $cryptoCurrencyData[$i]['price_usd'], 
					];
				}

				cmc_setting::fill('cmc_crytocurrency', ['data' => $crytocurrency, 'time' => time()]);
				cmc_setting::save();
			}
		}   
	}

	function run($time = false, $force = false) {
		if ($time) {
			$time = $time + time(); 
		} else {
			$time = time();
		}
		if (!$force) {
			wp_schedule_single_event($time, 'cmc_running_task', []);
		}
	}

	public function checkLock($force = false) {
		if ($force) {
			return true;
		}
		// false - cron is running
		// true - cron not running
		$running_cron = get_transient('cmc_running'); 
		if ($running_cron && $running_cron == 1) {
			$time = microtime( true );
			$locked = get_transient('doing_cron');

			if ( $locked > $time + 10 * 60 ) { // 10 minutes
				$locked = 0;
			}
			if ((defined('WP_CRON_LOCK_TIMEOUT') && $locked + WP_CRON_LOCK_TIMEOUT > $time) || (!defined('WP_CRON_LOCK_TIMEOUT') && $locked + 60 > $time)) {
				return false;
			}
			if (function_exists('_get_cron_array')) {
				$crons = _get_cron_array();
			} else {
				$crons = get_option('cron');
			}
			if (!is_array($crons)) { 
				return false;
			}

			$values = array_values( $crons );
			if (isset($values['cmc_running_task'])) {
				$keys = array_keys( $crons );
				if ( isset($keys[0]) && $keys[0] > $time ) {
					return false;
				}
			}
		}
		$time = ini_get('max_execution_time');
		if ($time == 0) {
			set_transient( 'cmc_running', 1, 60 * 60 * 24 ); // 24 hour
		} else {
			set_transient( 'cmc_running', 1, $time + 60 );
		}
		return true;
	}
}