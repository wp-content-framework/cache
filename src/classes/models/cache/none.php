<?php
/**
 * WP_Framework_Cache Classes Models Cache None
 *
 * @version 0.0.1
 * @author Technote
 * @copyright Technote All Rights Reserved
 * @license http://www.opensource.org/licenses/gpl-2.0.php GNU General Public License, version 2
 * @link https://technote.space
 */

namespace WP_Framework_Cache\Classes\Models\Cache;

if ( ! defined( 'WP_CONTENT_FRAMEWORK' ) ) {
	exit;
}

/**
 * Class None
 * @package WP_Framework_Cache\Classes\Models\Cache
 */
class None implements \WP_Framework_Cache\Interfaces\Cache {

	use \WP_Framework_Cache\Traits\Cache;

	/**
	 * @param string $key
	 * @param string $group
	 *
	 * @return bool
	 */
	public function exists(
		/** @noinspection PhpUnusedParameterInspection */
		$key, $group = 'default'
	) {
		return false;
	}

	/**
	 * @param string $key
	 * @param string $group
	 * @param mixed $default
	 *
	 * @return mixed
	 */
	public function get(
		/** @noinspection PhpUnusedParameterInspection */
		$key, $group = 'default', $default = null
	) {
		return $default;
	}

	/**
	 * @param string $key
	 * @param mixed $value
	 * @param string $group
	 * @param null|int $expire
	 *
	 * @return bool
	 */
	public function set(
		/** @noinspection PhpUnusedParameterInspection */
		$key, $value, $group = 'default', $expire = null
	) {
		return true;
	}

	/**
	 * @param string $key
	 * @param string $group
	 *
	 * @return bool
	 */
	public function delete(
		/** @noinspection PhpUnusedParameterInspection */
		$key, $group = 'default'
	) {
		return true;
	}

	/**
	 * @return bool
	 */
	public function flush() {
		return true;
	}
}
