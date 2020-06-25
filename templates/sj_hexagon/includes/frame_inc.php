<?php
/*
 * ------------------------------------------------------------------------
 * Copyright (C) 2009 - 2014 The YouTech JSC. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: The YouTech JSC
 * Websites: http://www.smartaddons.com - http://www.cmsportal.net
 * ------------------------------------------------------------------------
*/

defined( '_JEXEC' ) or die( 'Restricted access' );
include_once (J_TEMPLATEDIR.J_SEPARATOR.'includes'.J_SEPARATOR.'lib'.J_SEPARATOR.'template.php');
include_once (J_TEMPLATEDIR.J_SEPARATOR.'includes'.J_SEPARATOR.'lib'.J_SEPARATOR.'renderxml.php');

// Object of class YtTemplate
global $yt;
$doc = JFactory::getDocument();
$app 	 = JFactory::getApplication();
$Itemid = JRequest::getInt('Itemid');
$view 	= $app->input->get('layout');

// Array param for cookie
$params_cookie =	array(
						  'bgimage',
						  'themecolor',
						  'templateLayout',
						  'menustyle',
						  'activeNotice',
						  'typelayout'
					);
$yt = new YtTemplate($this, $params_cookie);

// Get param template
$layout						= $yt->getParam('templateLayout');
$templateColor				= $yt->getParam('themecolor');
$keepmenu				 	= $yt->getParam('keepMenu');
$direction					= $doc->direction;
$typelayout					= $yt->getParam('typelayout');

$menustyle					= $yt->getParam('menustyle');
$overrideLayouts			= trim($yt->getParam('overrideLayouts'));
$setGeneratorTag			= $yt->getParam('setGeneratorTag');
$showCpanel					= $yt->getParam('showCpanel');
$specialPos					= $yt->getParam('useSpecialPositions');

$bodyFont 					= $yt->getParam('bodyFont');
$bodySelectors				= $yt->getParam('bodySelectors');
$menuFont 					= $yt->getParam('menuFont');
$menuSelectors				= $yt->getParam('menuSelectors');
$headingFont 				= $yt->getParam('headingFont');
$headingSelectors			= $yt->getParam('headingSelectors');
$otherFont 					= $yt->getParam('otherFont');
$otherSelectors				= $yt->getParam('otherSelectors');

$layoutType					= $yt->getParam('layouttype');
$layoutFixed				= $yt->getParam('layoutFixed');
$layoutFloat				= $yt->getParam('layoutFloat');
$layoutRes					= $yt->getParam('layoutRes');
$animatescroll				= $yt->getParam('animateScroll');


if(isset($_COOKIE[$yt->template.'_typelayout'])){
	$typelayout = $_COOKIE[$yt->template.'_typelayout'];
}else{
	$typelayout = $yt->getParam('typelayout');
}

//Layout option
if($layoutType=='fixed')$doc->addStyleDeclaration('.container{width:'.$yt->getParam('layoutFixed'). 'px}');
else if($layoutType=='float') $doc->addStyleDeclaration('.container{width:'.$yt->getParam('layoutFloat'). '%}');
else if($layoutType=='res') $doc->addStyleDeclaration('.container{width:'.$yt->getParam('layoutRes'). 'px}');

// Include Class YtRenderXML
if($layout=='-1' || $layout=='') die(JTEXT::_("SELECT_LAYOUT_NOW"));


// Parse layout
$boolOverride = false;
if(trim($overrideLayouts)!=''){
	$overrideLayouts = explode(' ', $overrideLayouts);
	
	if( count($overrideLayouts)>=1 ) {
		for($i=0; $i<count($overrideLayouts); $i++){
			$layoutItemArray[] = explode('=', $overrideLayouts[$i]);
		}
		if( !empty($layoutItemArray) ){
			foreach($layoutItemArray as $item){
				if($Itemid == $item[0]){
					$boolOverride = true; 
					$layout = trim($item[1]);
				}
			}
		}
	}
}

if($boolOverride == true && isset($layout) && $layout != ''){
	$yt_render = new YtRenderXML($layout.'.xml');
}else{
	$yt_render = new YtRenderXML($layout.'.xml');
}

// Set GeneratorTag
$this->setGenerator($setGeneratorTag);


/*** CSS Framework ***
**********************/
// Include  CSS k2 reslisting 
$yt->ytStyleSheet('css/sj-reslisting-me.css');

// Include  Bootstrap CSS
if($direction == 'ltr'){$yt->ytStyleSheet('asset/bootstrap/css/bootstrap.min.css');}
else $yt->ytStyleSheet('asset/bootstrap/css/bootstrap-rtl.css');

// non-responsive
if($layoutType !='res') $yt->ytStyleSheet('asset/bootstrap/css/non-responsive.css');

// Include Cpanel
if($showCpanel) $yt->ytStyleSheet('css/cpanel.css');

// Include Cpanel
if($specialPos) $yt->ytStyleSheet('css/sticky.css');

$yt->ytStyleSheet('css/template.css');
$yt->ytStyleSheet('css/pattern.css');
$yt->ytStyleSheet('css/your_css.css');

// Include  Font awesome
if(!defined('FONT_AWESOME')){$yt->ytStyleSheet('asset/fonts/awesome/css/font-awesome.min.css'); define('FONT_AWESOME', 1);}

// Include css in layout(.xml)
if(isset($yt_render->arr_TH['stylesheet'])){
	foreach($yt_render->arr_TH['stylesheet'] as $tagStyle){
		$yt->ytStyleSheet('css/'.$tagStyle);
	}
}

// Include css with IE9, IE10
if($yt->ieversion()==9) $yt->ytStyleSheet('css/template-ie9.css');  
if($yt->ieversion()==10 || $yt->ieversion()==11)  $yt->ytStyleSheet('css/template-ie10.css');  

// Include css RTL
if($direction == 'rtl')$yt->ytStyleSheet('css/template-rtl.css');


// Enable & disable responsive
if($showCpanel) $yt->ytStyleSheet('asset/minicolors/jquery.miniColors.css');

if($layoutType=='res'||$layoutType=='float') $yt->ytStyleSheet('css/responsive.css'); 

/**************************** Jquery Framework ************************
**********************************************************************/
// Include jQuery & bootstrap's javascript
if(!defined('BOOTSTRAP_JS') && $view == null){
	$doc->addScript($yt->templateurl().'asset/bootstrap/js/bootstrap.min.js');
	define('BOOTSTRAP_JS', 1);
}
// Include jQuery KeepMenu
if($keepmenu) $doc->addScript($yt->templateurl().'js/keepmenu.js');

// Include Cpanel
if($showCpanel) {
	$doc->addScript($yt->templateurl().'js/ytcpanel.js');
	$doc->addScript($yt->templateurl().'asset/minicolors/jquery.miniColors.min.js');
}


// Include Scroll Reveal Effect
if($animatescroll) $doc->addScript($yt->templateurl().'js/scrollReveal.js');
 
// Include Sticky
if($specialPos) $doc->addScript($yt->templateurl().'js/ytsticky.js');

$doc->addScript($yt->templateurl().'js/yt-script.js');

//Touch Carousel Bootstrap3
//$doc->addScript($yt->templateurl().'js/touchswipe.min.js');

// Apply Cpanel
$doc->addCustomTag('
<script type="text/javascript">var TMPL_NAME = "'.$yt->template.'";var TMPL_COOKIE = '.json_encode($params_cookie).';</script>');
?>
