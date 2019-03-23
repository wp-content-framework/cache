<?php
/**
 * WP_Framework_Cache Models Cache Test
 *
 * @version 0.0.5
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

	public static function setUpBeforeClass() {
		parent::setUpBeforeClass();
		static::$_option = \WP_Framework_Cache\Classes\Models\Cache\Option::get_instance( static::$app );
	}

	/**
	 * @dataProvider _test_exists1_provider
	 *
	 * @param bool $expected
	 * @param string $key
	 * @param string $group
	 * @param bool $common
	 */
	public function test_exists1( $expected, $key, $group, $common ) {
		$this->assertEquals( $expected, static::$_option->exists( $key, $group, $common ) );
	}

	/**
	 * @return array
	 */
	public function _test_exists1_provider() {
		return [
			[ false, 'test1', 'default', false ],
			[ false, 'test2', 'test_group', false ],

			[ false, 'test1', 'default', true ],
			[ false, 'test2', 'test_group', true ],
		];
	}

	/**
	 * @dataProvider _test_get1_provider
	 *
	 * @param mixed $expected
	 * @param string $key
	 * @param string $group
	 * @param bool $common
	 * @param mixed $default
	 */
	public function test_get1( $expected, $key, $group, $common, $default ) {
		$this->assertEquals( $expected, static::$_option->get( $key, $group, $common, $default ) );
	}

	/**
	 * @return array
	 */
	public function _test_get1_provider() {
		return [
			[ null, 'test1', 'default', false, null ],
			[ false, 'test2', 'test_group1', false, false ],
			[ true, 'test3', 'test_group3', false, true ],
			[ 0, 'test4', 'test_group4', false, 0 ],
			[ [], 'test5', 'test_group5', false, [] ],

			[ null, 'test1', 'default', true, null ],
			[ false, 'test2', 'test_group1', true, false ],
			[ true, 'test3', 'test_group3', true, true ],
			[ 0, 'test4', 'test_group4', true, 0 ],
			[ [], 'test5', 'test_group5', true, [] ],
		];
	}

	/**
	 * @dataProvider _test_set_provider
	 *
	 * @param bool $expected
	 * @param string $key
	 * @param mixed $value
	 * @param string $group
	 * @param bool $common
	 * @param null|int $expire
	 */
	public function test_set( $expected, $key, $value, $group, $common, $expire ) {
		$this->assertEquals( $expected, static::$_option->set( $key, $value, $group, $common, $expire ) );
	}

	/**
	 * @return array
	 */
	public function _test_set_provider() {
		if ( is_multisite() ) {
			return [
				[ true, 'test1', 'value1', 'default', false, null ],
				[ false, 'test1', 'value1', 'default', false, null ],
				[ true, 'test1', 'value2', 'default', false, null ],
				[ true, 'test1', 'value1', 'test_group', false, null ],
				[ false, 'test1', 'value1', 'test_group', false, null ],
				[ true, 'test2', 'value2', 'default', false, 1 ],
				[ true, 'test3', 'value3', 'default', false, 3 ],

				[ true, 'test1', 'value1', 'default', true, null ],
				[ false, 'test1', 'value1', 'default', true, null ],
				[ true, 'test1', 'value2', 'default', true, null ],
				[ true, 'test1', 'value1', 'test_group', true, null ],
				[ false, 'test1', 'value1', 'test_group', true, null ],
				[ true, 'test2', 'value2', 'default', true, 1 ],
				[ true, 'test3', 'value3', 'default', true, 3 ],
			];
		}

		return [
			[ true, 'test1', 'value1', 'default', false, null ],
			[ false, 'test1', 'value1', 'default', false, null ],
			[ true, 'test1', 'value2', 'default', false, null ],
			[ true, 'test1', 'value1', 'test_group', false, null ],
			[ false, 'test1', 'value1', 'test_group', false, null ],
			[ true, 'test2', 'value2', 'default', false, 1 ],
			[ true, 'test3', 'value3', 'default', false, 3 ],

			[ false, 'test1', 'value2', 'default', true, null ],
			[ false, 'test1', 'value1', 'test_group', true, null ],
			[ false, 'test2', 'value2', 'default', true, 1 ],
			[ false, 'test3', 'value3', 'default', true, 3 ],
		];
	}

	/**
	 * @dataProvider _test_exists2_provider
	 * @depends      test_set
	 *
	 * @param bool $expected
	 * @param string $key
	 * @param string $group
	 * @param bool $common
	 */
	public function test_exists2( $expected, $key, $group, $common ) {
		$this->assertEquals( $expected, static::$_option->exists( $key, $group, $common ) );
	}

	/**
	 * @return array
	 */
	public function _test_exists2_provider() {
		return [
			[ true, 'test1', 'default', false ],
			[ true, 'test1', 'test_group', false ],
			[ false, 'test1', 'test_group2', false ],
			[ true, 'test2', 'default', false ],
			[ true, 'test3', 'default', false ],
			[ false, 'test4', 'default', false ],

			[ true, 'test1', 'default', true ],
			[ true, 'test1', 'test_group', true ],
			[ false, 'test1', 'test_group2', true ],
			[ true, 'test2', 'default', true ],
			[ true, 'test3', 'default', true ],
			[ false, 'test4', 'default', true ],
		];
	}

	/**
	 * @dataProvider _test_get2_provider
	 * @depends      test_exists2
	 *
	 * @param mixed $expected
	 * @param string $key
	 * @param string $group
	 * @param bool $common
	 * @param mixed $default
	 * @param int $sleep
	 */
	public function test_get2( $expected, $key, $group, $common, $default, $sleep = 0 ) {
		if ( $sleep > 0 ) {
			sleep( $sleep );
		}
		$this->assertEquals( $expected, static::$_option->get( $key, $group, $common, $default ) );
	}

	/**
	 * @return array
	 */
	public function _test_get2_provider() {
		return [
			[ 'value2', 'test1', 'default', false, null ],
			[ 'value1', 'test1', 'test_group', false, null ],
			[ null, 'test1', 'test_group2', false, null ],
			[ true, 'test2', 'default', false, true, 2 ],
			[ 'value3', 'test3', 'default', false, true ],

			[ 'value3', 'test3', 'default', true, true ],

			[ true, 'test3', 'default', false, true, 2 ],

			[ 'value2', 'test1', 'default', true, null ],
			[ 'value1', 'test1', 'test_group', true, null ],
			[ null, 'test1', 'test_group2', true, null ],
			[ true, 'test2', 'default', true, true, 2 ],
			[ true, 'test3', 'default', true, true ],
		];
	}
}