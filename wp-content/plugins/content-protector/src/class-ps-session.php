<?php

namespace passster;

use EAMann\Sessionz\Manager;
use EAMann\Sessionz\Handlers\MemoryHandler;

class PS_Session {

	public function __construct() {
		// Queue up the session stack
		$wp_session_handler = Manager::initialize();
		$wp_session_handler->addHandler( new DatabaseHandler() );
		$wp_session_handler->addHandler( new MemoryHandler() );

		add_action( 'plugins_loaded', array( $this, 'wp_session_manager_start_session' ), 10, 0 );
	}

	public function wp_session_manager_start_session() {
		if ( session_status() !== PHP_SESSION_ACTIVE ) {
			session_start();
		}
	}

	public static function get_instance() {
		new PS_Session();
	}
}
