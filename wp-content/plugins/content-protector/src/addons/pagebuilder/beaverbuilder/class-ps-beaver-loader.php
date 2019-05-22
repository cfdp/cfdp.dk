<?php

class PS_Beaver_Loader {

	static public function init() {
		add_action( 'plugins_loaded', __CLASS__ . '::setup_hooks' );
	}

	static public function setup_hooks() {
		if ( ! class_exists( 'FLBuilder' ) ) {
			return;
		}

		// Load custom modules.
		add_action( 'init', __CLASS__ . '::load_modules' );
	}

	static public function load_modules() {
		require_once PASSSTER_PATH . '/src/addons/pagebuilder/beaverbuilder/modules/passster/class-ps-module.php';
	}
}

PS_Beaver_Loader::init();
