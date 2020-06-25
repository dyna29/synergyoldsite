<?php
/**
 * @package Sj Content Accordion
 * @version 2.5
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2012 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 *
 */
defined('_JEXEC') or die;
$uniquied = 'sj_accordion_'.time().rand();
JHtml::stylesheet('modules/mod_sj_content_accordion/assets/css/sj-accordion.css');
if( !defined('SMART_JQUERY') && $params->get('include_jquery', 0) == "1" ){
	JHtml::script('modules/mod_sj_content_accordion/assets/js/jquery-1.8.2.min.js');
	JHtml::script('modules/mod_sj_content_accordion/assets/js/jquery-noconflict.js');
	define('SMART_JQUERY', 1);
}

JHtml::script('modules/mod_sj_content_accordion/assets/js/jquery.sj_accordion.js'); 

ImageHelper::setDefault($params);


$item_first = (int)$params->get('item_first_display');
if($item_first >= (int)count($list)){
	$item_first = count($list) ;
}
else if($item_first <= 0){
	$item_first = 1;
}else{
	$item_first = $item_first ; 
}

if(!empty($list)){
		
?>

<script type="text/javascript">
//<![CDATA[
	jQuery(document).ready(function($) {
		 /*
		 imageloaded
		 */
		  $.fn.imagesLoaded = function( callback ) {
		    var $this = this,
		        $images = $this.find('img').add( $this.filter('img') ),
		        len = $images.length,
		        blank = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==',
		        loaded = [];
		
		    function triggerCallback() {
		      callback.call( $this, $images );
		    }
		
		    function imgLoaded( event ) {
		      var img = event.target;
		      if ( img.src !== blank && $.inArray( img, loaded ) === -1 ){
		        loaded.push( img );
		        if ( --len <= 0 ){
		          setTimeout( triggerCallback );
		          $images.unbind( '.imagesLoaded', imgLoaded );
		        }
		      }
		    }
		
		    // if no images, trigger immediately
		    if ( !len ) {
		      triggerCallback();
		    }
		
		    $images.bind( 'load.imagesLoaded error.imagesLoaded',  imgLoaded ).each( function() {
		      // cached images don't fire load sometimes, so we reset src.
		      var src = this.src;
		      // webkit hack from http://groups.google.com/group/jquery-dev/browse_thread/thread/eee6ab7b2da50e1f
		      // data uri bypasses webkit log warning (thx doug jones)
		      this.src = blank;
		      this.src = src;
		    });
		
		    return $this;
		  };
		  
		$(window).load(function(){
			$('#<?php echo $uniquied;?>').imagesLoaded( function(){});
		});
		$('#<?php echo $uniquied;?>').imagesLoaded( function(){
			
			$('#<?php echo $uniquied;?>').sj_accordion({
				items : '.acd-item',
				heading : '.acd-header',
				content : '.acd-content-wrap',
				active_class : 'selected',
				event : '<?php echo $params->get('accmouseenter', 'click');?>',
				delay : 300,
				duration : 500,
				active : '<?php echo $item_first;?>'
			}); 
			
			var height_content = function(){	
			  	$('.acd-item', '#<?php echo $uniquied;?>').each(function(){
			        var inner = $('.acd-content-wrap-inner', $(this).filter('.selected'));
		            if(inner.length){
		                var inner_height = inner.height();
		                inner.parent().css('height',inner_height);
		            }
			   });
			}
			if ( $.browser.msie  && parseInt($.browser.version, 10) <= 8){
			//nood
			}else{
	      		  $(window).resize(function() {
	        		height_content();
	       		 });
			}
		}); 
		
	}); 
//]]>	
</script>
	<?php if($params->get('pretext') != null){?>
	<div class="acd-pretext">
		<?php echo $params->get('pretext'); ?>
	</div>
	<?php }?>
	<div id="<?php echo $uniquied; ?>" class="sj-accordion">
		<div class="acd-items">
			<?php  foreach($list as $item){ ?>
			<div class="acd-item">
				<div class="acd-header">
					<?php echo SjContentAccordionHelper::truncate($item->title, $params->get('item_title_max_characters',25)); ?>
				</div>
				<div class="acd-content-wrap cf">
					<div class="acd-content-wrap-inner cf">
						<div class="acd-image cf">
							<a href="<?php echo $item->link ?>" title="<?php echo $item->title; ?>" <?php echo SjContentAccordionHelper::parseTarget($params->get('link_target')); ?>>
				    			<?php $img = SjContentAccordionHelper::getAImage($item, $params);
		    						echo SjContentAccordionHelper::imageTag($img);?>
							</a>
						</div>
						<?php if($params->get('item_description_display') == 1 || $params->get('item_readmore_display') == 1) {?>
						<div class="acd-content">
							<?php if($params->get('item_description_display') == 1) {?>
							<div class="acd-description">
								<?php echo SjContentAccordionHelper::truncate($item->introtext, $params->get('item_description_max_characters',200)); ?>
							</div>
							<?php }?>
							<?php if($params->get('item_readmore_display') == 1) {?>
							<div class="accd-readmore">
								<a href="<?php echo $item->link ?>" title="<?php echo $item->title; ?>" <?php echo SjContentAccordionHelper::parseTarget($params->get('link_target')); ?>>
								<?php echo $params->get('item_readmore_text'); ?>
								</a>
							</div>
							<?php } ?>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
	<?php if($params->get('posttext') != null){?>
	<div clss="acd-posttext">
		<?php echo $params->get('posttext'); ?>
	</div>
	<?php }?>
<?php }else{
	echo JText::_('Has no content to show!');
}?>
