<?php
/*
 * ------------------------------------------------------------------------
 * Copyright (C) 2009 - 2013 The YouTech JSC. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: The YouTech JSC
 * Websites: http://www.smartaddons.com - http://www.cmsportal.net
 * ------------------------------------------------------------------------
*/
// no direct access

defined( '_JEXEC' ) or die( 'Restricted access' );
global $is_placehold;
global $placehold_size;

// Array param for cookie
$placehold_size = array (
	'listing' => '270x185/999',
	'article' => '570x380/999',
	'related_items'=>'70x70/999',
	'latest_news' => '270x270/999',
	'popular' => '70x70',
	'featured_posts' => '230x230',
	'hot_stories' => '270x320',
	'slider' => '540x360/999',
	'more_new' => '840x560/999',
	'grid' => '435x200/999'

);

$is_placehold = 1;

if (!function_exists ('yt_placehold') ) {
	function yt_placehold ($size = '100x100',$icon='0xe942', $alt = '', $title = '' ) {
		return '<img src="http://placehold.it/'.$size.'" alt = "'. $alt .'" title = "'. $title .'"/>';
	}
}
?>