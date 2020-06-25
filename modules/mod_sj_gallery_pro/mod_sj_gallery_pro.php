<?php
/**
 * @package Sj Gallery Pro
 * @version 2.5
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2012 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 * 
 */
defined('_JEXEC') or die;
require_once dirname( __FILE__ ).'/core/helper.php';
$cacheparams = new stdClass;
$cacheparams->cachemode = 'id';
// Class call from cache
$cacheparams->class = 'SjGalleryProReader';
$cacheparams->method = 'getList';
$cacheparams->methodparams = $params;
$items = SjGalleryProReader::getList($params);
require JModuleHelper::getLayoutPath('mod_sj_gallery_pro', $params->get('layout', 'default'));?>