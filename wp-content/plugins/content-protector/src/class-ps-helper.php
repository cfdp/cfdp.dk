<?php

namespace passster;

use Phpass\Hash;

class PS_Helper {

	public static function is_cookie_valid( $hash, $admin_pass ) {

		$cookie_options = get_option( 'passster_advanced_settings' );

		$cookie = false;

		if ( ! empty( $cookie_options ) ) {

			if ( 'on' == $cookie_options['toggle_cookie'] ) {

				if ( isset( $_COOKIE['passster'] ) ) {

					$user_cookie = $_COOKIE['passster'];

					if ( $hash->checkPassword( $user_cookie, $admin_pass ) === true ) {
						$cookie = true;
					}
				}
			}
		}
		return $cookie;
	}
	/**
	 * Return user name and role as array
	 *
	 * @return array
	 */
	public static function is_user_valid( $atts ) {

		$unlock = false;
		$user   = wp_get_current_user();

		if ( isset( $atts['role'] ) && ! empty( $atts['role'] ) ) {

			$roles = $user->roles;

			if ( strpos( $atts['role'], ',' ) !== false ) {

				$roles_array = explode( ',', $atts['role'] );

				foreach ( $roles_array as $role ) {
					if ( $role === $roles[0] ) {
						$unlock = true;
					}
				}
			} else {
				if ( $atts['role'] === $roles[0] ) {
					$unlock = true;
				}
			}
		}

		if ( isset( $atts['user'] ) && ! empty( $atts['user'] ) ) {

			if ( strpos( $atts['user'], ',' ) !== false ) {

				$users_array = explode( ',', $atts['user'] );

				foreach ( $users_array as $user ) {
					if ( $user === $user->user_login ) {
						$unlock = true;
					}
				}
			} else {
				if ( $atts['user'] === $user->user_login ) {
					$unlock = true;
				}
			}
		}
		return $unlock;
	}



	public static function is_addon_active( $addon ) {

		$addons = get_option( 'passster_addons' );

		if ( isset( $addons ) && ! empty( $addons ) ) {
			switch ( $addon ) {
				case 'multiple_passwords':
					if ( 'on' === $addons['passster_addons_multiple_passwords_toggle'] && isset( $addons['passster_addons_multiple_passwords_toggle'] ) ) {
						return true;
					} else {
						return false;
					}
					break;
				case 'user':
					if ( 'on' === $addons['passster_addons_users_toggle'] && isset( $addons['passster_addons_users_toggle'] ) ) {
						return true;
					} else {
						return false;
					}
					break;
				case 'recaptcha':
					if ( 'on' === $addons['passster_addons_recaptcha_toggle'] && isset( $addons['passster_addons_recaptcha_toggle'] ) ) {
						return true;
					} else {
						return false;
					}
					break;
				case 'link':
					if ( 'on' === $addons['passster_addons_link_toggle'] && isset( $addons['passster_addons_link_toggle'] ) ) {
						return true;
					} else {
						return false;
					}
					break;
			}
		} else {
			update_option( 'passster_addons', array(
				'passster_addons_multiple_passwords_toggle' => 'off',
				'passster_addons_recaptcha_toggle' => 'off',
				'passster_addons_users_toggle'      => 'off',
				'passster_addons_link_toggle'      => 'off',
			));
		}
	}

	public static function base64_url_encode( $input ) {
		return strtr( base64_encode( $input ), '+/=', '-_,' );
	}

	public static function base64_url_decode( $input ) {
		return base64_decode( strtr( $input, '-_,', '+/=' ) );
	}

	public static function hex_to_rgb( $hex, $alpha = false ) {

		$hex      = str_replace( '#', '', $hex );
		$length   = strlen( $hex );
		$rgb['r'] = hexdec( $length == 6 ? substr( $hex, 0, 2 ) : ( $length == 3 ? str_repeat( substr( $hex, 0, 1 ), 2 ) : 0 ) );
		$rgb['g'] = hexdec( $length == 6 ? substr( $hex, 2, 2 ) : ( $length == 3 ? str_repeat( substr( $hex, 1, 1 ), 2 ) : 0 ) );
		$rgb['b'] = hexdec( $length == 6 ? substr( $hex, 4, 2 ) : ( $length == 3 ? str_repeat( substr( $hex, 2, 1 ), 2 ) : 0 ) );

		if ( $alpha ) {
			$rgb['a'] = $alpha;
		}

		return $rgb;
	}
}
