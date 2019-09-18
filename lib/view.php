<?php

class cmc_view {

	protected $data = [];

	function view($template, $data = []) {
		$data = $data ?: $this->data;

		extract($data);

		if ($path = $this->get_include($template)) {
			include $path;
			return;
		}

		trigger_error("Template($template) not exists");
	}

	function get_include($template) {

		$path = CLC_BASE_DIR.'view/'.$template.'.php';
		if (file_exists($path)) {
			return $path;
		}
		return false;
	} 
}