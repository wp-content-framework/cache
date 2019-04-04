<?php
/**
 * WP_Framework_Cache Configs Config
 *
 * @version 0.0.11
 * @author Technote
 * @copyright Technote All Rights Reserved
 * @license http://www.opensource.org/licenses/gpl-2.0.php GNU General Public License, version 2
 * @link https://technote.space
 */

if ( ! defined( 'WP_CONTENT_FRAMEWORK' ) ) {
	exit;
}

return [

	// cache type
	'cache_type'                => null,

	// delete cache group
	'delete_cache_group'        => [],

	// delete cache common group
	'delete_cache_common_group' => [],

];