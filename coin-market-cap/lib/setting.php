<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
class cmc_setting {	

	private static $settings = [];

	private static $optionKey = '';

	const DEFAULT_KEY = 'cmc_settings';

	public static function get($key = null, $default = null, $optionKey = null) {
		$optionKey = $optionKey ?: self::DEFAULT_KEY;
		if ($optionKey != self::$optionKey) {
			self::$settings[$optionKey] = get_option($optionKey); 
			self::$optionKey = $optionKey;
		}
		
		$value = isset(self::$settings[$optionKey][$key]) ? self::$settings[$optionKey][$key] : $default; 

		return $value;
	}

	public static function getAll($optionKey = null) {
		$optionKey = $optionKey ?: self::DEFAULT_KEY;
		if ($optionKey != self::$optionKey) {
			self::$settings[$optionKey] = get_option($optionKey, []); 
			self::$optionKey = $optionKey;
		}
		return self::$settings[$optionKey];
	}

	public static function fill($optionKey, $settings = []) {
		self::$optionKey = $optionKey;
		self::$settings[$optionKey] = $settings;
	}

	public static function set($optionKey, $key, $value) {
		self::$settings[$optionKey][$key] = $value;
	}

	public static function save() {
		$optionKey = self::$optionKey ?: self::DEFAULT_KEY;
		if (!$optionKey) {
			return false;
		}
		update_option($optionKey, self::$settings[$optionKey]);
		return true;
	}

	public static function setOptionKey($key) {
		self::$optionKey = $key;
	}

	public static function getOptionKey() {
		return self::$optionKey;
	}
}
