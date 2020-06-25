<?php
/**
 * @package Sj K2 Slick Slider
 * @version 3.0.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2013 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 *
 */
defined('_JEXEC') or die;

if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

//check the exist of k2 component on the site?

if(file_exists(JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'route.php') && file_exists(JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'utilities.php')){

	require_once dirname( __FILE__ ).'/core/helper.php';

	$layout = $params->get('layout', 'default');
	$cacheid = md5(serialize(array ($layout, $module->id)));
	$cacheparams = new stdClass;
	$cacheparams->cachemode = 'id';
	$cacheparams->class = 'K2SlickSliderHelper';
	$cacheparams->method = 'getList';
	$cacheparams->methodparams = $params;
	$cacheparams->modeparams = $cacheid;
	$list = JModuleHelper::moduleCache ($module, $params, $cacheparams);

	if(!empty($list)) {
		require JModuleHelper::getLayoutPath($module->module, $layout);
	} else {
		echo JText::_('HAS_NO_CONTENT');
	}

}else{
	echo JText::_('PLEASE_INSTALL_K2_COMPONENT_FIRST');
}