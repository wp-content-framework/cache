<?php
/**
 * WP_Framework_Cache Models Cache Test
 *
 * @author Technote
 * @copyright Technote All Rights Reserved
 * @license http://www.opensource.org/licenses/gpl-2.0.php GNU General Public License, version 2
 * @link https://technote.space
 */

namespace WP_Framework_Cache\Tests\Models;

use WP_Framework_Cache\Classes\Models\Cache\File;
use WP_Framework_Cache\Classes\Models\Cache\Option;
use WP_Framework_Cache\Tests\TestCase;

/**
 * Class CacheTest
 * @package WP_Framework_Cache\Tests\Models
 * @group wp_framework
 * @group models
 */
class CacheTest extends TestCase {

	/**
	 * @var Option $option
	 */
	private static $option;

	/**
	 * @var File $file
	 */
	private static $file;

	public static function setUpBeforeClass() {
		parent::setUpBeforeClass();
		static::$option = Option::get_instance( static::$app );
		static::$file   = File::get_instance( static::$app );
	}

	public static function tearDownAfterClass() {
		parent::tearDownAfterClass();
		static::$option->flush();
		static::$file->flush();
	}

	/**
	 * @dataProvider provider_test_exists1
	 *
	 * @param bool $expected
	 * @param string $key
	 * @param string $group
	 * @param bool $common
	 */
	public function test_exists1( $expected, $key, $group, $common ) {
		$this->assertEquals( $expected, static::$option->exists( $key, $group, $common ) );
		$this->assertEquals( $expected, static::$file->exists( $key, $group, $common ) );
	}

	/**
	 * @return array
	 */
	public function provider_test_exists1() {
		return [
			[ false, 'test1', 'default', false ],
			[ false, 'test2', 'test_group', false ],

			[ false, 'test1', 'default', true ],
			[ false, 'test2', 'test_group', true ],
		];
	}

	/**
	 * @dataProvider provider_test_get1
	 *
	 * @param mixed $expected
	 * @param string $key
	 * @param string $group
	 * @param bool $common
	 * @param mixed $default
	 */
	public function test_get1( $expected, $key, $group, $common, $default ) {
		$this->assertEquals( $expected, static::$option->get( $key, $group, $common, $default ) );
		$this->assertEquals( $expected, static::$file->get( $key, $group, $common, $default ) );
	}

	/**
	 * @return array
	 */
	public function provider_test_get1() {
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
	 * @dataProvider provider_test_set
	 *
	 * @param bool $expected
	 * @param string $key
	 * @param mixed $value
	 * @param string $group
	 * @param bool $common
	 * @param null|int $expire
	 */
	public function test_set( $expected, $key, $value, $group, $common, $expire ) {
		$this->assertEquals( $expected, static::$option->set( $key, $value, $group, $common, $expire ) );
		$this->assertEquals( $expected, static::$file->set( $key, $value, $group, $common, $expire ) );
	}

	/**
	 * @return array
	 */
	public function provider_test_set() {
		if ( is_multisite() ) {
			return [
				[ true, 'test1', 'value1', 'default', false, null ],
				[ true, 'test1', 'value2', 'default', false, null ],
				[ true, 'test1', 'value1', 'test_group', false, null ],
				[ true, 'test2', 'value2', 'default', false, 1 ],
				[ true, 'test3', 'value3', 'default', false, 3 ],

				[ true, 'test1', 'value1', 'default', true, null ],
				[ true, 'test1', 'value2', 'default', true, null ],
				[ true, 'test1', 'value1', 'test_group', true, null ],
				[ true, 'test2', 'value2', 'default', true, 1 ],
				[ true, 'test3', 'value3', 'default', true, 3 ],
			];
		}

		return [
			[ true, 'test1', 'value1', 'default', false, null ],
			[ true, 'test1', 'value2', 'default', false, null ],
			[ true, 'test1', 'value1', 'test_group', false, null ],
			[ true, 'test2', 'value2', 'default', false, 1 ],
			[ true, 'test3', 'value3', 'default', false, 3 ],
		];
	}

	/**
	 * @dataProvider provider_test_exists2
	 * @depends      test_set
	 *
	 * @param bool $expected
	 * @param string $key
	 * @param string $group
	 * @param bool $common
	 */
	public function test_exists2( $expected, $key, $group, $common ) {
		$this->assertEquals( $expected, static::$option->exists( $key, $group, $common ) );
		$this->assertEquals( $expected, static::$file->exists( $key, $group, $common ) );
	}

	/**
	 * @return array
	 */
	public function provider_test_exists2() {
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
	 * @dataProvider provider_test_get2
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
		$this->assertEquals( $expected, static::$option->get( $key, $group, $common, $default ) );
		$this->assertEquals( $expected, static::$file->get( $key, $group, $common, $default ) );
	}

	/**
	 * @return array
	 */
	public function provider_test_get2() {
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
			[ true, 'test2', 'default', true, true ],
			[ true, 'test3', 'default', true, true ],
		];
	}

	/**
	 * @dataProvider provider_test_delete
	 * @depends      test_get2
	 *
	 * @param bool $expected
	 * @param string $key
	 * @param string $group
	 * @param bool $common
	 */
	public function test_delete( $expected, $key, $group, $common ) {
		$this->assertEquals( $expected, static::$option->delete( $key, $group, $common ) );
		$this->assertEquals( $expected, static::$file->delete( $key, $group, $common ) );
	}

	/**
	 * @return array
	 */
	public function provider_test_delete() {
		if ( is_multisite() ) {
			return [
				[ true, 'test1', 'test_group', false ],
				[ false, 'test1', 'test_group', false ],
				[ true, 'test1', 'test_group', true ],
				[ false, 'test1', 'test_group', true ],
			];
		}

		return [
			[ true, 'test1', 'test_group', false ],
			[ false, 'test1', 'test_group', false ],
		];
	}

	/**
	 * @dataProvider provider_test_delete_group
	 * @depends      test_delete
	 *
	 * @param bool $expected
	 * @param string $group
	 * @param bool $common
	 */
	public function test_delete_group( $expected, $group, $common ) {
		$this->assertEquals( $expected, static::$option->delete_group( $group, $common ) );
		$this->assertEquals( $expected, static::$file->delete_group( $group, $common ) );
	}

	/**
	 * @return array
	 */
	public function provider_test_delete_group() {
		if ( is_multisite() ) {
			return [
				[ true, 'default', false ],
				[ false, 'test_group', false ],
				[ false, 'test_group2', false ],
				[ false, 'default', false ],

				[ true, 'default', true ],
				[ false, 'test_group', true ],
				[ false, 'test_group2', true ],
				[ false, 'default', true ],
			];
		}

		return [
			[ true, 'default', false ],
			[ false, 'test_group', false ],
			[ false, 'test_group2', false ],
			[ false, 'default', false ],
		];
	}

	/**
	 * @dataProvider provider_test_exists3
	 * @depends      test_delete_group
	 *
	 * @param bool $expected
	 * @param string $key
	 * @param string $group
	 * @param bool $common
	 */
	public function test_exists3( $expected, $key, $group, $common ) {
		$this->assertEquals( $expected, static::$option->exists( $key, $group, $common ) );
		$this->assertEquals( $expected, static::$file->exists( $key, $group, $common ) );
	}

	/**
	 * @return array
	 */
	public function provider_test_exists3() {
		return [
			[ false, 'test1', 'default', false ],
			[ false, 'test1', 'test_group', false ],
			[ false, 'test1', 'test_group2', false ],
			[ false, 'test2', 'default', false ],
			[ false, 'test3', 'default', false ],
			[ false, 'test4', 'default', false ],

			[ false, 'test1', 'default', true ],
			[ false, 'test1', 'test_group', true ],
			[ false, 'test1', 'test_group2', true ],
			[ false, 'test2', 'default', true ],
			[ false, 'test3', 'default', true ],
			[ false, 'test4', 'default', true ],
		];
	}
}
