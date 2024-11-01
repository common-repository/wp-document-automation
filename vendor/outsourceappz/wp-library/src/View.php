<?php

namespace OA_WP_Library;

class View {
	protected $container;

	public function __construct($container) {
		$this->container = $container;
	}

	public function render($view_name, $data = array()) {
		$data['container'] = $this->container;
		$view_path = sprintf('%s/views/%s.php', $this->container['dir'], str_replace('.', '/', $view_name));
		extract($data);

		ob_start();
		require $view_path;
		return ob_get_clean();
	}

}