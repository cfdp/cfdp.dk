<?php

namespace cookiebot_addons\tests\integration\addons;

class Test_Hubspot_Leadin extends \WP_UnitTestCase {
	
	public function setUp() {
	
	}
	
	/**
	 * This will validate if the hook for "hubspot_leadin" still exists
	 *
	 * @since 2.1.0
	 */
	public function test_hook() {
		$content = file_get_contents( 'http://plugins.svn.wordpress.org/leadin/trunk/inc/class-leadin.php' );
		
		$this->assertNotFalse( strpos( $content, '$embedId  = \'leadin-scriptloader-js\';') );
	}
}