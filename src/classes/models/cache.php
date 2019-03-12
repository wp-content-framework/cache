<?php
/**
 * WP_Framework_Cache Classes Models Cache
 *
 * @version 0.0.1
 * @author Technote
 * @copyright Technote All Rights Reserved
 * @license http://www.opensource.org/licenses/gpl-2.0.php GNU General Public License, version 2
 * @link https://technote.space
 */

namespace WP_Framework_Cache\Classes\Models;

if ( ! defined( 'WP_CONTENT_FRAMEWORK' ) ) {
	exit;
}

/**
 * Class Cache
 * @package WP_Framework_Cache\Classes\Models
 */
class Cache implements \WP_Framework_Cache\Interfaces\Cache {

	use \WP_Framework_Cache\Traits\Cache;

	/**
	 * @var \WP_Framework_Cache\Interfaces\Cache $_cache
	 */
	private $_cache;

	/**
	 * initialized
	 */
	protected function initialized() {
		if ( $this->apply_filters( 'cache_enabled' ) && $cache_type = $this->app->get_config( 'config', 'cache_type' ) ) {
			$cache_type  = ucwords( strtolower( $cache_type ) );
			$cache_class = "\WP_Framework_Cache\Classes\Models\Cache\{$cache_type}";
			if ( ! class_exists( $cache_class ) ) {
				$cache_class = '\WP_Framework_Cache\Classes\Models\Cache\None';
			}
		} else {
			$cache_class = '\WP_Framework_Cache\Classes\Models\Cache\None';
		}
		/** @var \WP_Framework_Core\Traits\Singleton $cache_class */
		$this->_cache = $cache_class::get_instance( $this->app );
	}

	/**
	 * @param string $key
	 * @param string $group
	 *
	 * @return bool
	 */
	public function exists( $key, $group = 'default' ) {
		return $this->_cache->exists( $key, $group );
	}

	/**
	 * @param string $key
	 * @param string $group
	 * @param mixed $default
	 *
	 * @return mixed
	 */
	public function get( $key, $group = 'default', $default = null ) {
		return $this->_cache->get( $key, $group, $default );
	}

	/**
	 * @param string $key
	 * @param mixed $value
	 * @param string $group
	 * @param null|int $expire
	 *
	 * @return bool
	 */
	public function set( $key, $value, $group = 'default', $expire = null ) {
		return $this->_cache->set( $key, $value, $group, $expire );
	}

	/**
	 * @param string $key
	 * @param mixed $value
	 * @param string $group
	 * @param null|int $expire
	 *
	 * @return bool
	 */
	public function replace( $key, $value, $group = 'default', $expire = null ) {
		return $this->_cache->replace( $key, $value, $group, $expire );
	}

	/**
	 * @param string $key
	 * @param string $group
	 *
	 * @return bool
	 */
	public function delete( $key, $group = 'default' ) {
		return $this->_cache->delete( $key, $group );
	}

	/**
	 * @return bool
	 */
	public function flush() {
		return $this->_cache->flush();
	}

	/**
	 * @return bool
	 */
	public function close() {
		return $this->_cache->close();
	}
}
