<?php

namespace cookiebot_addons\tests\integration\addons;

class Test_Ga_Google_Analytics extends \WP_UnitTestCase {
	
	public function setUp() {
	
	}
	
	/**
	 * This will validate if the hook "ga_google_analytics_tracking_code" still exists
	 *
	 * @since 2.1.0
	 */
	public function test_host_analyticsjs_local() {
		$content = file_get_contents( 'http://plugins.svn.wordpress.org/ga-google-analytics/trunk/inc/plugin-core.php' );
		
		$this->assertNotFalse( strpos( $content, 'ga_google_analytics_tracking_code') );
	}
}