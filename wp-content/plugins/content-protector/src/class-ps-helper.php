<?php

namespace passster;

use Phpass\Hash;

class PS_Helper {

	/**
	 * Check if cookie is valid
	 *
	 * @param string $hash hash from password.
	 * @param string $admin_pass unique admin pass salt.
	 * @return boolean
	 */
	public static function is_cookie_valid( $hash, $admin_pass ) {

		$cookie_options = get_option( 'passster_advanced_settings' );
		$cookie         = false;

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
	 * Check if cookie is valid for multiple passwords
	 *
	 * @param string $hash hash from password.
	 * @param string $admin_pass unique admin pass salt.
	 * @return boolean
	 */
	public static function is_passwords_cookie_valid( $passwords ) {

		$cookie_options = get_option( 'passster_advanced_settings' );
		$cookie         = false;

		if ( ! empty( $cookie_options ) ) {
			if ( 'on' == $cookie_options['toggle_cookie'] ) {
				if ( isset( $_COOKIE['passster'] ) ) {
					$user_cookie = $_COOKIE['passster'];
					if ( in_array( $user_cookie, $passwords ) ) {
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
	 * @param array $atts added attributes.
	 * @return boolean
	 */
	public static function is_user_valid( $atts ) {

		$unlock = false;
		$user   = wp_get_current_user();

		if ( isset( $atts['role'] ) && ! empty( $atts['role'] ) ) {

			$roles = $user->roles;

			if ( strpos( $atts['role'], ',' ) !== false ) {

				$roles_array = explode( ',', $atts['role'] );

				foreach ( $roles_array as $role ) {
					if ( in_array( $role, $roles ) ) {
						$unlock = true;
					}
				}
			} else {
				if ( in_array( $atts['role'], $roles ) ) {
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

	/**
	 * Check if addon is activa
	 *
	 * @param string $addon current addon to check.
	 * @return boolean
	 */
	public static function is_addon_active( $addon ) {

		$addons = get_option( 'passster_addons' );

		if ( isset( $addons ) && ! empty( $addons ) ) {
			switch ( $addon ) {
				case 'captcha':
					if ( isset( $addons['passster_addons_captcha_toggle'] ) && 'on' === $addons['passster_addons_captcha_toggle'] ) {
						return true;
					} else {
						return false;
					}
					break;
				case 'multiple_passwords':
					if ( isset( $addons['passster_addons_multiple_passwords_toggle'] ) && 'on' === $addons['passster_addons_multiple_passwords_toggle'] ) {
						return true;
					} else {
						return false;
					}
					break;
				case 'user':
					if ( isset( $addons['passster_addons_users_toggle'] ) && 'on' === $addons['passster_addons_users_toggle'] ) {
						return true;
					} else {
						return false;
					}
					break;
				case 'recaptcha':
					if ( isset( $addons['passster_addons_recaptcha_toggle'] ) && 'on' === $addons['passster_addons_recaptcha_toggle'] ) {
						return true;
					} else {
						return false;
					}
					break;
				case 'link':
					if ( isset( $addons['passster_addons_link_toggle'] ) && 'on' === $addons['passster_addons_link_toggle'] ) {
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

	/**
	 * URL encode with base64
	 *
	 * @param string $input current input url.
	 * @return string
	 */
	public static function base64_url_encode( $input ) {
		return strtr( base64_encode( $input ), '+/=', '-_,' );
	}

	/**
	 * URL decode with base64
	 *
	 * @param string $input current base64 encoded url.
	 * @return string
	 */
	public static function base64_url_decode( $input ) {
		return base64_decode( strtr( $input, '-_,', '+/=' ) );
	}

	/**
	 * Calculate hex from rgb
	 *
	 * @param string  $hex given hex value.
	 * @param boolean $alpha given alpha transparent.
	 * @return string
	 */
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

	/**
	 * Set AMP headers
	 *
	 * @param string $auth the current $_POST argument.
	 * @param string $password the current password.
	 * @return void
	 */
	public static function set_amp_headers( $auth, $password ) {

		if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) {
			if ( ! empty( $_POST ) ) {
				header( 'Content-type: application/json' );
				header( 'Access-Control-Allow-Credentials: true' );
				header( 'Access-Control-Allow-Origin: ' . \get_bloginfo( 'url' ) . '.cdn.ampproject.org' );
				header( 'AMP-Access-Control-Allow-Source-Origin: ' . \get_bloginfo( 'url' ) );
				header( 'Access-Control-Expose-Headers: AMP-Access-Control-Allow-Source-Origin' );
				header( 'AMP-Redirect-To: ' . \get_the_permalink() );
				header( 'Access-Control-Expose-Headers: AMP-Redirect-To, AMP-Access-Control-Allow-Source-Origin' );

				if ( $password === $_POST['passster_password'] ) {
					setcookie( 'passster', $password, time() + 2592000, '/' );
				}
			}
		}
	}
}
