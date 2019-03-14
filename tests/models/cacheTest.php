<?php
/**
 * WP_Framework_Cache Models Cache Test
 *
 * @version 0.0.3
 * @author Technote
 * @copyright Technote All Rights Reserved
 * @license http://www.opensource.org/licenses/gpl-2.0.php GNU General Public License, version 2
 * @link https://technote.space
 */

namespace WP_Framework_Cache\Tests\Models;

/**
 * Class CacheTest
 * @package WP_Framework_Cache\Tests\Models
 * @group wp_framework
 * @group models
 */
class CacheTest extends \WP_Framework_Cache\Tests\TestCase {

	/**
	 * @var \WP_Framework_Cache\Classes\Models\Cache\Option $_option
	 */
	private static $_option;

	/**
	 * @var \WP_Framework_Cache\Classes\Models\Cache\Kv $_kv
	 */
	private static $_kv;

	public static function setUpBeforeClass() {
		parent::setUpBeforeClass();
		static::$_option = \WP_Framework_Cache\Classes\Models\Cache\Option::get_instance( static::$app );
		static::$_kv     = \WP_Framework_Cache\Classes\Models\Cache\Kv::get_instance( static::$app );
	}

	/**
	 * @dataProvider _test_exists1_provider
	 *
	 * @param bool $expected
	 * @param string $key
	 * @param string $group
	 */
	public function test_exists1( $expected, $key, $group ) {
		$this->assertEquals( $expected, static::$_option->exists( $key, $group ) );
		$this->assertEquals( $expected, static::$_kv->exists( $key, $group ) );
	}

	/**
	 * @return array
	 */
	public function _test_exists1_provider() {
		return [
			[ false, 'test1', 'default' ],
			[ false, 'test2', 'test_group' ],
		];
	}

	/**
	 * @dataProvider _test_get1_provider
	 *
	 * @param mixed $expected
	 * @param string $key
	 * @param string $group
	 * @param mixed $default
	 */
	public function test_get1( $expected, $key, $group, $default ) {
		$this->assertEquals( $expected, static::$_option->get( $key, $group, $default ) );
		$this->assertEquals( $expected, static::$_kv->get( $key, $group, $default ) );
	}

	/**
	 * @return array
	 */
	public function _test_get1_provider() {
		return [
			[ null, 'test1', 'default', null ],
			[ false, 'test2', 'test_group1', false ],
			[ true, 'test3', 'test_group3', true ],
			[ 0, 'test4', 'test_group4', 0 ],
			[ [], 'test5', 'test_group5', [] ],
		];
	}

	/**
	 * @dataProvider _test_set_provider
	 *
	 * @param bool $expected
	 * @param string $key
	 * @param mixed $value
	 * @param string $group
	 * @param null|int $expire
	 */
	public function test_set( $expected, $key, $value, $group, $expire ) {
		$this->assertEquals( $expected, static::$_option->set( $key, $value, $group, $expire ) );
		$this->assertEquals( $expected, static::$_kv->set( $key, $value, $group, $expire ) );
	}

	/**
	 * @return array
	 */
	public function _test_set_provider() {
		return [
			[ true, 'test1', 'value1', 'default', null ],
			[ false, 'test1', 'value1', 'default', null ],
			[ true, 'test1', 'value2', 'default', null ],
			[ true, 'test1', 'value1', 'test_group', null ],
			[ false, 'test1', 'value1', 'test_group', null ],
			[ true, 'test2', 'value2', 'default', 1 ],
			[ true, 'test3', 'value3', 'default', 3 ],
		];
	}

	/**
	 * @dataProvider _test_exists2_provider
	 * @depends      test_set
	 *
	 * @param bool $expected
	 * @param string $key
	 * @param string $group
	 */
	public function test_exists2( $expected, $key, $group ) {
		$this->assertEquals( $expected, static::$_option->exists( $key, $group ) );
		$this->assertEquals( $expected, static::$_kv->exists( $key, $group ) );
	}

	/**
	 * @return array
	 */
	public function _test_exists2_provider() {
		return [
			[ true, 'test1', 'default' ],
			[ true, 'test1', 'test_group' ],
			[ false, 'test1', 'test_group2' ],
			[ true, 'test2', 'default' ],
			[ true, 'test3', 'default' ],
			[ false, 'test4', 'default' ],
		];
	}

	/**
	 * @dataProvider _test_get2_provider
	 * @depends      test_exists2
	 *
	 * @param mixed $expected
	 * @param string $key
	 * @param string $group
	 * @param mixed $default
	 * @param int $sleep
	 */
	public function test_get2( $expected, $key, $group, $default, $sleep = 0 ) {
		if ( $sleep > 0 ) {
			sleep( $sleep );
		}
		$this->assertEquals( $expected, static::$_option->get( $key, $group, $default ) );
		$this->assertEquals( $expected, static::$_kv->get( $key, $group, $default ) );
	}

	/**
	 * @return array
	 */
	public function _test_get2_provider() {
		return [
			[ 'value2', 'test1', 'default', null ],
			[ 'value1', 'test1', 'test_group', null ],
			[ null, 'test1', 'test_group2', null ],
			[ true, 'test2', 'default', true, 2 ],
			[ 'value3', 'test3', 'default', true ],
			[ true, 'test3', 'default', true, 2 ],
		];
	}
}