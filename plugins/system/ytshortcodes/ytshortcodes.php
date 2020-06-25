<?php
/*
 * ------------------------------------------------------------------------
 * Copyright (C) 2009 - 2013 The YouTech JSC. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: The YouTech JSC
 * Websites: http://www.smartaddons.com - http://www.cmsportal.net
 * ------------------------------------------------------------------------
*/

defined('_JEXEC') or die('Restricted access');

// Import Joomla core library
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport('joomla.plugin.plugin');
jimport('joomla.version');

// Require shortcodes functions
require_once dirname(__FILE__) . "/includes/shortcodes-func.php";

// Include shortcode prepa
include_once dirname(__FILE__) . "/includes/shortcodes-prepa.php";

// Include googlemap
require_once dirname(__FILE__) . "/includes/libs/googlemap/googleMaps.lib.php";



class plgSystemYtshortcodes extends JPlugin{
	var $document = NULL;
	var $baseurl  = NULL;

	public function __construct(&$subject, $config){
		parent::__construct($subject, $config);
	}
	
	// Function on after render
	public function onAfterRender(){
		
		// Add shortcodes button into editor(frontend & backend)
		$this->addBtnShortCodes();
	}

	// Enable shortcodes in Articles content
	public function onContentPrepare($context, &$article, &$params, $page=0){

		$param = new stdClass;
        $param->api_key = $this->params->get('google_map_api_key');
        $param->width   = $this->params->get('google_map_width', '400');
        $param->height  = $this->params->get('google_map_height', '400');
        $param->zoom    = $this->params->get('google_map_zoom', '15');
        
        $is_mod = 1;

        $plugin = new Plugin_googleMaps($article, $param, $is_mod);
		$article->text = parse_shortcode($article->text);
		return true;
	}
	

	public function onBeforeCompileHead()
	{
		$app = JFactory::getApplication();
		//get language and direction
		$document = JFactory::getDocument();
		$this->direction = $document->direction;
		$this->baseurl = str_replace("/administrator", "", JURI::base());
		
		if( $app->isSite()){
			// include Bootstrap
			if($this->params->get('show_sjbootstrap', 0)=='1'){
				$this->ytStyleSheet('plugins/system/ytshortcodes/assets/css/bootstrap/bootstrap.css');
			}
			$this->ytStyleSheet("plugins/system/ytshortcodes/assets/css/shortcodes.css");
		}else{
			if(!defined('FONT_AWESOME')){
				$document->addStyleSheet($this->baseurl."plugins/system/ytshortcodes/assets/css/font-awesome.min.css");
				define('FONT_AWESOME', 1);
			}
			$document->addStyleSheet($this->baseurl."plugins/system/ytshortcodes/assets/css/shortcodes-backend.css");
		}
		
		if ($this->direction == 'rtl'){
			if($app->isSite()){
				$this->ytStyleSheet("plugins/system/ytshortcodes/assets/css/shortcodes-rtl.css");
			}
		}
		
		// include Jquery Joomla25
		$version = new JVersion();
		if($this->params->get('show_sjjquery', 0)==1 && $version->RELEASE=='2.5' ){
			$document->addScript($this->baseurl . "plugins/system/ytshortcodes/assets/js/jquery.min.js");
			$document->addScript($this->baseurl . "plugins/system/ytshortcodes/assets/js/jquery-noconflict.js");
		}
		
		// include Jquery
		if($this->params->get('show_sjbootstrap', 0)==1 && $app->isSite()){
			$document->addScript($this->baseurl . "plugins/system/ytshortcodes/assets/js/bootstrap.min.js");
			
		}
		
		if($app->isSite()){
			if($this->params->get('show_sjprettify', 1)==1){
				$document->addScript($this->baseurl . "plugins/system/ytshortcodes/assets/js/prettify.js");
			}
			$document->addScript($this->baseurl . "plugins/system/ytshortcodes/assets/js/shortcodes.js");
		}
		
	}
	
	public function ytStyleSheet($url){
		$app = JFactory::getApplication();
		$doc = JFactory::getDocument();
		$lessurl = str_replace('.css', '.less', str_replace('/css/', '/less/', $url));
		if(($app->getTemplate(true)->params->get('developing', 0)==1 || JRequest::getVar('less2css')=='all') && file_exists($lessurl)){
			YTLess::addStyleSheet($lessurl);
		}elseif(file_exists($url)){
			$doc->addStyleSheet($url);
		}else{
			die($url.' not exists');
		}
	}
	
	// Function add shortcodes button into editor
	public function addBtnShortCodes()
	{
		$page   = JResponse::GetBody();
		$button = $this->listShortCodes();
		$stext  = '<script  type="text/javascript">
						function jSelectShortcode(text) {
							jQuery("#yt_shorcodes").removeClass("open");
							text = text.replace(/\'/g, \'"\');
							
							//1.Editor Content
							if(document.getElementById(\'jform_articletext\') != null) {
								jInsertEditorText(text, \'jform_articletext\');
							}
							if(document.getElementById(\'jform_description\') != null) {
								jInsertEditorText(text, \'jform_description\');
							}
							
							//2.Editor K2
							if(document.getElementById(\'description\') != null) {
								jInsertEditorText(text, \'description\');
							}
							if(document.getElementById(\'text\') != null) {
								jInsertEditorText(text, \'text\');
							}
							
							//3.Editor VirtueMart 
							if(document.getElementById(\'category_description\') != null) {
								jInsertEditorText(text, \'category_description\');
							}
							if(document.getElementById(\'product_desc\') != null) {
								jInsertEditorText(text, \'product_desc\');
							}
							
							//4.Editor Contact
							if(document.getElementById(\'jform_misc\') != null) {
								jInsertEditorText(text, \'jform_misc\');
							}
							
							//5.Editor Easyblog
							if(document.getElementById(\'write_content\') != null) {
								jInsertEditorText(text, \'write_content\');
							}
							
							//6.Editor Joomshoping
							if(document.getElementById(\'description1\') != null) {
								jInsertEditorText(text, \'description1\');
							}
							
							//6.Editor HTML
							if(document.getElementById(\'jform_content\') != null) {
								jInsertEditorText(text, \'jform_content\');
							}
							
							SqueezeBox.close();
						}
				   </script>';
		$page = str_replace('<div id="editor-xtd-buttons">', '<div id="editor-xtd-buttons">' . $button, $page);
		$page = str_replace('<div id="editor-xtd-buttons" class="btn-toolbar pull-left">', '<div id="editor-xtd-buttons" class="btn-toolbar pull-left">' . $button, $page);
		$page = str_replace('</body>', $stext . '</body>', $page);
		JResponse::SetBody($page);
	}
	
	// Build shorcodes list
	public function listShortCodes()
	{
		$shortcoders = array(
		'accordion' => array(
			'name'		=> "Accordion",
			'desc'		=> "Accordion",
			'syntax'	=> "[accordion]<br/>[acc_item title=\'ITEM_TITLE\']ADD_CONTENT_HERE[/acc_item]<br/>[acc_item title=\'ITEM_TITLE\']ADD_CONTENT_HERE[/acc_item]<br/>[acc_item title=\'ITEM_TITLE\']ADD_CONTENT_HERE[/acc_item]<br/>[/accordion]<br/>",
			'icon'		=> "list-ul"
		),
		'gallery' => array(
			'name'		=> "Gallery",
			'desc'		=> "Gallery",
			'syntax'	=> "[gallery title=\'GALLERY_TITLE\' width=\'IMAGE_THUMB_WIDTH\' height=\'IMAGE_THUMB_HEIGHT\' columns=\'3\']<br/>[gallery_item title=\'IMAGE_TITLE\' src=\'IMAGE_SRC\' video_addr=\'VIDEO_ADDRESS\']IMAGE_DESCRIPTION[/gallery_item]<br/>[gallery_item title=\'IMAGE_TITLE\' src=\'IMAGE_SRC\' video_addr=\'VIDEO_ADDRESS\']IMAGE_DESCRIPTION[/gallery_item]<br/>[gallery_item title=\'IMAGE_TITLE\' src=\'IMAGE_SRC\' video_addr=\'VIDEO_ADDRESS\']IMAGE_DESCRIPTION[/gallery_item]<br/>[/gallery]",
			'icon'		=> "photo"
		),
		'icon' => array(
			'name'		=> "Retina Icons",
			'desc'		=> "Retina Icons",
			'syntax'	=> "[icon type=\'fa|gly\' name=\'twitter\' size=\'FONT_SIZE\' color=\'COLOR\' align=\'left|right|none\'] ",
			'icon'		=> "desktop"
		),
		
		'spacer' => array(
			'name'		=> "Add Space",
			'desc'		=> "Add Space",
			'syntax'	=> "[space height=\'30\']<br/>",
			'icon'		=> "arrows-v"
		),
		'googlefont' => array(
			'name'		=> "Google Font",
			'desc'		=> "Google Font",
			'syntax'	=> "[googlefont font=\'FONT_NAME\' size=\'FONT_SIZE\' color=\'COLOR\' font_weight=\'normal|bold\' align=\'left|right|none\' margin=\'1em 0 1em 0\'] ADD_CONTENT_HERE[/googlefont]<br/>",
			'icon'		=> "text-width"
		),
		'social' => array(
			'name'		=> "Social Icons",
			'desc'		=> "Social Icons",
			'syntax'	=> "[social type=\'facebook\' title=\'ADD_TITLE_HERE\' color=\'yes|no\']PLACE_LINK_HERE[/social]",
			'icon'		=> "twitter"
		),
		'blockquote' => array(
			'name'		=> "Blockquote",
			'desc'		=> "Blockquote",
			'syntax'	=> "[quote width=\'auto\' align=\'left|right|none\' border=\'COLOR\' color=\'COLOR\' title=\'SOMEONE_FAMOUS_TITLE\']ADD_CONTENT_HERE[/quote]",
			'icon'		=> "quote-left"
		),
		'googlemap' => array(
			'name'		=> "Google Map",
			'desc'		=> "Google Map",
			'syntax'	=> "[googleMaps align=\'left|right|none\' addr=\'ADDRESS OR Latitude/Longitude\' label=\'GOOLE_MAP_LABEL\' width=100% height=400]<br/>",
			'icon'		=> "map-marker"
		),
		'highlighter' => array(
			'name'		=> "Syntax Highlighting",
			'desc'		=> "Syntax highlighting of code snippets in a web page",
			'syntax'	=> "[highlighter label=\'Example\' ]YOUR_CODE_HERE[/highlighter]<br/>",
			'icon'		=> "list-alt"
		),
		
		'buttons' => array(
			'name'		=> "Buttons",
			'desc'		=> "Buttons",
			'syntax'	=> "[button type=\'info\' target=\'_self\' link=\'#\' icon=\'info-sign\']ADD_BUTTON_CONTENT[/button]",
			'icon'		=> "square"
		),
		'list' => array(
			'name'		=> "List Style",
			'desc'		=> "List Style",
			'syntax'	=> "[list type=\'disc\']<br/>[list_item]ADD_LIST_CONTENT[/list_item] <br/>[list_item]ADD_LIST_CONTENT[/list_item] <br/>[/list]",
			'icon'		=> "list-ol"
		),
		'testimonial' => array(
			'name'		=> "Testimonial",
			'desc'		=> "Testimonial",
			'syntax'	=> "[testimonial author=\'TESTIMONIAL_AUTHOR\' position=\'AUTHOR_POSITION\' avatar=\'URL_IMAGES\']ADD_TESTIMONIAL_HERE[/testimonial]",
			'icon'		=> "comment"
		),
		'clear' => array(
			'name'		=> "Clear Floated ",
			'desc'		=> "Clear Floated ",
			'syntax'	=> "[clear]<br/>",
			'icon'		=> "sign-in"
		),
		'br' => array(
			'name'		=> "Line Break",
			'desc'		=> "Line Break",
			'syntax'	=> "[br]<br/>",
			'icon'		=> "cut"
		),
		'tabs' => array(
			'name'		=> "Togglable Tabs",
			'desc'		=> "Togglable Tabs",
			'syntax'	=> "[tabs]<br/>[tab_item title=\'ITEM_TITLE\']ADD_CONTENT_HERE[/tab_item]<br/>[tab_item title=\'ITEM_TITLE\']ADD_CONTENT_HERE[/tab_item]<br/>[tab_item title=\'ITEM_TITLE\']ADD_CONTENT_HERE[/tab_item]<br/>[/tabs]",
			'icon'		=> "folder"
		),
		'column' => array(
			'name'		=> "Columns",
			'desc'		=> "Columns",
			'syntax'	=> "[columns grid=\'yes|no\' ]<br/>[column_item col=\'4\']ADD_CONTENT_HERE[/column_item]<br/>[column_item col=\'4\']ADD_CONTENT_HERE[/column_item]<br/>[column_item col=\'4\']ADD_CONTENT_HERE[/column_item]<br/>[/columns]",
			'icon'		=> "columns"
		),
		'lightbox' => array(
			'name'		=> "Lightbox",
			'desc'		=> "Lightbox",
			'syntax'	=> "[lightbox src=\'IMAGE_SRC\' width=\'IMAGE_WIDTH\' height=\'IMAGE_HEIGHT\' lightbox=\'on|off\' style=\'none|borderInner|shadow|border|reflect\' title=\'IMAGE_TITLE\' align=\'left|right|none\']",
			'icon'		=> "arrows-alt"
		),
		
		'toggle' => array(
			'name'		=> "Toggle Boxes",
			'desc'		=> "Toggle Boxes",
			'syntax'	=> "[toggle_box]<br/>[toggle_item icon=\'user\' title=\'ITEM_TITLE\']ADD_CONTENT_HERE[/toggle_item]<br/>[toggle_item icon=\'heart\' title=\'ITEM_TITLE\' active=\'yes|no\']ADD_CONTENT_HERE[/toggle_item]<br/>[/toggle_box]",
			'icon'		=> "tasks"
		),

		'dropcap' => array(
			'name'		=> "Dropcap",
			'desc'		=> "Dropcap",
			'syntax'	=> "[dropcap type=\'square\' color=\'COLOR\' background=\'COLOR\' ]ADD_CONTENT_HERE[/dropcap]",
			'icon'		=> "font"
		),
		
		'message' => array(
			'name'		=> "Message Boxe",
			'desc'		=> "Message Boxe",
			'syntax'	=> "[message_box title=\'MESSAGE_TITLE\' type=\'error\' close=\'yes|no\']ADD_CONTENT_HERE[/message_box]",
			'icon'		=> "warning"
		),
		
		'vimeo' => array(
			'name'		=> "Vimeo",
			'desc'		=> "Vimeo",
			'syntax'	=> "[vimeo height=\'HEIGHT\' width=\'WIDTH\' align=\'left|right|none\']PLACE_LINK_HERE[/vimeo]",
			'icon'		=> "vimeo-square"
		),
		'divider' => array(
			'name'		=> "Divider",
			'desc'		=> "Divider",
			'syntax'	=> "[divider margin=\'0 2em 0 2em\']<br/>",
			'icon'		=> "minus"
		),
		'pricing' => array(
			'name'		=> "Pricing Tables",
			'desc'		=> "Pricing Tables",
			'syntax'	=> "[pricing columns=\'3\']<br/>[plan title=\'PRICING_TITLE\' button_link=\'http://\' button_label=\'PRICING_BUTTON_LABEL\' price=\'$0\'  per=\'Yes|No\']TEXT_OF_PLAN[/plan]<br/>[plan title=\'PRICING_TITLE\' button_link=\'http://\' button_label=\'PRICING_BUTTON_LABEL\' price=\'$30\' featured=\'true\' per=\'Yes|No\']TEXT_OF_PLAN[/plan]<br/>[plan title=\'PRICING_TITLE\' button_link=\'http://\' button_label=\'PRICING_BUTTON_LABEL\' price=\'$70\' per=\'Yes|No\']TEXT_OF_PLAN[/plan]<br/>[/pricing]<br/>",
			'icon'		=> "table"
		),
		'youtube' => array(
			'name'		=> "Youtube",
			'desc'		=> "Youtube",
			'syntax'	=> "[youtube height=\'HEIGHT\' width=\'WIDTH\' align=\'left|right|none\']PLACE_LINK_HERE[/youtube]<br/>",
			'icon'		=> "youtube"
		),
		'slideshow' => array(
			'name'		=> "Slideshow",
			'desc'		=> "Slideshow",
			'syntax'	=> "[slideshow width=\'SLIDESHOW_WIDTH\' height=\'SLIDESHOW_HEIGHT\' align=\'left|right|none\' caption=\'yes|no\' count=\'3\' autoslide=\'yes|no\']<br/>[slider_item title=\'CAPTION_TITLE\' src=\'IMAGE_SRC\' ]CAPTION_DESCRIPTION [/slider_item]<br/>[slider_item title=\'CAPTION_TITLE\' src=\'IMAGE_SRC\' ]CAPTION_DESCRIPTION [/slider_item]<br/>[slider_item title=\'CAPTION_TITLE\' src=\'IMAGE_SRC\' ]CAPTION_DESCRIPTION [/slider_item]<br/>[/slideshow]",
			'icon'		=> "film"
		),
		'tooltip' => array(
			'name'		=> "Tooltip",
			'desc'		=> "Tooltip",
			'syntax'	=> "[tooltip link=\'#\' title=\'TITLE\' position=\'top|right|bottom|left\']ADD_CONTENT_HERE[/tooltip]<br/>",
			'icon'		=> "text-height"
		),
		'modal' => array(
			'name'		=> "Modal",
			'desc'		=> "Modal",
			'syntax'	=> "[modal title=\'TITLE\' header=\'TITLE_HEADER\']ADD_CONTENT_HERE[/modal]<br/>",
			'icon'		=> "external-link"
		),
		'carousel' => array(
			'name'		=> "Carousel",
			'desc'		=> "Carousel",
			'syntax'	=> "[carousel width=\'CAROUSEL_WIDTH\' height=\'CAROUSEL_HEIGHT\' align=\'left|right|none\' control=\'yes|no\' count=\'3\' autoslide=\'yes|no\']<br/>[carousel_item ]ADD_CONTENT_HERE [/carousel_item]<br/>[carousel_item ]ADD_arousel_item]<br/>[carousel_item ]ADD_CONTENT_HERE [/carousel_item]<br/>[/carousel]",
			'icon'		=> "bolt"
		),
		'audio_player' => array(
			'name'		=> "Audio Player",
			'desc'		=> "Audio Player",
			'syntax'	=> "[audio_player src=\'MP3_SRC\' single=\'SONG_NAME\' artist=\'ARTIST_NAME\']<br/>",
			'icon'		=> "music"
		),
		'playerlist' => array(
			'name'		=> "Player list",
			'desc'		=> "Player list",
			'syntax'	=> "[playerlist  title=\'TITLE_PLAYERLIST\']<br/>[player_item src=\'MP3_SRC\' song=\'SONG_NAME\' artist=\'ARTIST_NAME\']<br/>[player_item src=\'MP3_SRC\' song=\'SONG_NAME\' artist=\'ARTIST_NAME\']<br/>[player_item src=\'MP3_SRC\' song=\'SONG_NAME\' artist=\'ARTIST_NAME\']<br/> [/playerlist]",
			'icon'		=> "music"
		),
		'skill' => array(
			'name'		=> "Our Skills",
			'desc'		=> "Our Skills",
			'syntax'	=> "[skill width=\'WIDTH_SKILL\' no_number=\'yes|no\']<br/>[skill_item title=\'TITLE_SKILL\' number=\'85\']<br/>[skill_item title=\'TITLE_SKILL\' number=\'80\']<br/>[skill_item title=\'TITLE_SKILL\' number=\'90\']<br/>[/skill]",
			'icon'		=> "align-left"
		),
		'points' => array(
			'name'		=> "Points Of Interest",
			'desc'		=> "Points Of Interest",
			'syntax'	=> "[points width=\'WIDTH_IMAGE\' src=\'IMAGE_SRC\']<br/>[points_item x=\'30%\' y=\'30%\' position=\'top|right|bottom|left\'] ADD_CONTENT_HERE [/points_item]<br/>[/points]",
			'icon'		=> "dot-circle-o"
		)
		
	);

		$text  = '';
		$linkShortcode='';
		
		if(count($shortcoders)){
			$text .='<div id="yt_shorcodes">';
			$text .='<span class="button-shortcodes btn-text">Yt Shortcodes</span>
			<span class="button-shortcodes btn-act"><span class="arrow"></span></span>';
			$text .='<ul>';
			
			foreach($shortcoders as $key => $shortcoder) {
				$text .= '<li class="item item-'.$key.'">';
				$text .= '<a class="pointer" href="javascript: void(0);" onclick="jSelectShortcode(\'' . $shortcoder['syntax'] . '\')" title="' . $shortcoder['desc'] . '">';
				$text .= '<i class="fa fa-'.$shortcoder['icon'].'"> </i> '.$shortcoder['name'] ;
				$text .= '</a>';
				$text .= '</li>';
			}
			
		
			$linkShortcode ="http://demo.smartaddons.com/extensions/yt-shortcode/index.php";
			$text .='<li class="allShortcode"><a href="'.$linkShortcode.'"  target="_blank">  Click here to view example YT Shortcodes</a></li>';
			$text .='</ul>';
			$text .='</div>';
			$text .='
			<script type="text/javascript">
				jQuery(document).ready(function($) {
				  $("#yt_shorcodes .btn-act,#yt_shorcodes > ul li").click(function(){
				  	if( $(this).parent().attr("class")==="open" ){
				  		$(this).parent().removeClass("open");
				  	}else {
				  		$(this).parent().addClass("open");
				  	}
				  });
				  
				 
				})
			</script>
			';
		}
		return $text;
	}
}