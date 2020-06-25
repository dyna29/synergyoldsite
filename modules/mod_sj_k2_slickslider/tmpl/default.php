<?php
/**
 * @package Sj K2 Slick Slider
 * @version 3.0.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2013 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 */

defined('_JEXEC') or die;

JHtml::stylesheet('modules/'.$module->module.'/assets/css/sj-slickslider.css');
JHtml::stylesheet('modules/'.$module->module.'/assets/css/slickslider-font-color.css');
if (!defined('SMART_JQUERY') && ( int ) $params->get ( 'include_jquery', '1' )) {
	JHtml::script('modules/'.$module->module.'/assets/js/jquery-1.8.2.min.js');
	define('SMART_JQUERY', 1);
}
if (!defined('SMART_NOCONFLICT')){
	JHtml::script('modules/'.$module->module.'/assets/js/jquery-noconflict.js');
	define('SMART_NOCONFLICT', 1);
}
JHtml::script('modules/'.$module->module.'/assets/js/jcarousel.js');
JHtml::script('modules/'.$module->module.'/assets/js/jquery.cj-swipe.js');
ImageHelper::setDefault($params);
$start = (int)$params->get('start','1');
if ($start < 1 || $start > count($list)){
	$start = 1;
}
$pause_hover = ($params->get('pause_hover') == 'hover')?'hover':'';;
$interval = (int)$params->get('interval','4000');
$effect = ($params->get('effect') == 1)?' slide':'';

if ($params->get('play') != 1){
	$interval = 0;
} else {
	$interval = $params->get('interval', 5000);
}

$pag_position = $params->get('button_position' , 'conner-bl');
$pag_type = in_array($params->get('button_theme', 'num'), array('num', 'number')) ? 'type-num' : 'type-dot';
$slick_slider_background = $params->get('theme','theme1')=='theme1' ? 'bg-style1' : 'bg-style2';
?>
<?php if ($params->get('pretext') != ''){ ?>
<div class="text-block">
	<?php echo $params->get('pretext'); ?>
</div>
<?php }?>
<div id="sj_k2slickslider<?php echo $module->id; ?>" class="sj-k2slickslider <?php echo $effect ?> <?php echo 'slickslider-'.$params->get('item_image_position'); ?>"  data-interval="<?php echo $interval?>" data-pause="<?php echo $pause_hover?>" >
	<!-- Carousel items -->
    <div class="slickslider-items <?php echo $slick_slider_background?>">
    	<?php
    	$i=1;
    	foreach ($list as $item){
			if ($i==$start){$active = 'active';}
    		else $active = '';
    		$i++;
    	?>
    	<div class="slickslider-item item clearfix <?php echo $active; ?> ">
    		<?php 
				$no_image = '';	
				$img = K2SlickSliderHelper::getK2Image($item, $params);					
				$img = ImageHelper::init($img)->src();							
				
				//$img = (strpos($img,'http://') !== false || strpos($img,'https://') !== false)?$img:(JURI::root().$img);
			
			if((is_file($img) && file_exists($img)) || K2SlickSliderHelper::isUrl($img)){?>
			
				<div class="item-image">
					<div class="item-image-inner">
						<a href="<?php echo $item->link; ?>" title="<?php echo $item->displaytitle; ?>" <?php echo K2SlickSliderHelper::parseTarget($params->get('item_link_target')); ?> >					
							<img alt="<?php echo $item->displaytitle;?>" src="<?php echo $img;?>"/>					
						</a>
					</div>
				</div>
			<?php }else{$no_image = ' no-images';} ?>
			
			<div class="item-content<?php echo $no_image;?>">
				<div class="item-content-inner">
					<?php
					
					// display title
					
					if($item->displaytitle != '') { ?>					
					<div class="item-title">
						<a href="<?php echo $item->link; ?>" title="<?php echo $item->displaytitle; ?>" <?php echo K2SlickSliderHelper::parseTarget($params->get('item_link_target')); ?> >
							<?php echo $item->displaytitle; ?>
						</a>
					</div>
					<?php } 
					
					// display desc 
					
					if($item->displayIntrotext != '') { ?>
					<div class="item-description">
						<?php echo $item->displayIntrotext; ?>
					</div>
					<?php } 
					
					// show tags
				
					if($item->tags !=''){?>
						<div class="tags">
							<?php foreach ($item->tags as $tag): ?>
							<span class="tag-<?php echo $tag->id; ?>">
								<a class="label label-info" href="<?php echo $tag->link; ?>" title="<?php echo $tag->name; ?>" target="_blank"><?php echo $tag->name; ?></a>
							</span>
							<?php endforeach; ?>
						 </div>					
					<?php }						
					
					if( (int)$params->get('item_readmore_display', 1)){ ?>
					<div class="item-readmore">
						<a href="<?php echo $item->link; ?>" title="<?php echo $item->displaytitle; ?>" <?php echo K2SlickSliderHelper::parseTarget($params->get('item_link_target')); ?> >							
							<?php echo $params->get('item_readmore_text'); ?>
						</a>
					</div>
					<?php } // readmore display ?>
					
				
				</div>
			</div>
			
    	</div>
    	<?php } ?>
    </div>
    <!-- Carousel nav -->
	<div class="nav-pagination <?php echo $pag_position?> <?php echo $slick_slider_background; ?>" >
		<ul class="<?php echo $pag_type;?>">
			<li class="left" href="#sj_k2slickslider<?php echo $module->id?>" data-jslide="prev"></li>
			<?php for($i=0; $i<count($list); $i++){
				if ($i+1==$start){$sel = 'sel';}
	    		else $sel = '';
			?>
			<li class="pag-item <?php echo $sel; ?>" href="#sj_k2slickslider<?php echo $module->id?>" data-jslide="<?php echo $i?>"><?php echo $i+1;?></li>
			<?php } ?>
			<li class="right" href="#sj_k2slickslider<?php echo $module->id?>" data-jslide="next"></li>
		</ul>
	</div>
</div>

<script>
//<![CDATA[    					
	jQuery(document).ready(function($){
		$('#sj_k2slickslider<?php echo $module->id; ?>').each(function(){
			var $this = $(this), options = options = !$this.data('modal') && $.extend({}, $this.data());
			$this.jcarousel(options);
			
			$this.bind('jslide', function(e){
				var index = $(this).find(e.relatedTarget).index();
				// process for nav
				$('[data-jslide]').each(function(){
					var $nav = $(this), $navData = $nav.data(), href, $target = $($nav.attr('data-target') || (href = $nav.attr('href')) && href.replace(/.*(?=#[^\s]+$)/, ''));
					if ( !$target.is($this) ) return;
					if (typeof $navData.jslide == 'number' && $navData.jslide==index){
						$nav.addClass('sel');
					} else {
						$nav.removeClass('sel');
					}
				});
			});
			<?php if($params->get('swipe') == 1){ ?>
	
			
				$this.touchSwipeLeft(function(){
					$this.jcarousel('next');
					}
				);
				$this.touchSwipeRight(function(){
					$this.jcarousel('prev');
					}
				);
			<?php } ?>	
		});
		return ;
	});
//]]>	
</script>

<?php if ($params->get('posttext') != ''){ ?>
<div class="text-block">
	<?php echo $params->get('posttext'); ?>
</div>
<?php } ?>

