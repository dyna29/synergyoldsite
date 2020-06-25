<?php
/**
 * @package Sj Responsive Listing for K2
 * @version 2.5.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2013 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 */

defined('_JEXEC') or die;
JHtml::script('templates/' . JFactory::getApplication()->getTemplate().'/html/mod_sj_k2_reslisting/js/jquery.prettyPhoto.js');
if(isset($list['items'])) {
ImageHelper::setDefault($params);

foreach($list['items']  as $item){ ?>
	<div class="respl-item first-load category-<?php echo $item->catid ?>" data-id=" <?php echo $item->id; ?>" data-date="<?php echo strtotime($item->created); ?>" data-rdate="<?php echo strtotime($item->created); ?>" data-publishUp="<?php echo strtotime($item->publish_up); ?>" data-alpha="<?php echo trim(strtoupper($item->title)); ?>" data-ralpha="<?php echo trim(strtoupper($item->title)); ?>" data-order="<?php echo ($params->get('FeaturedItems') == '2')?$items->featured_ordering:$item->ordering; ?>" data-rorder="<?php echo ($params->get('FeaturedItems') == '2')?$items->featured_ordering:$item->ordering; ?>" data-hits="<?php echo $item->hits; ?>" data-best="<?php echo ($item->rating == null)?0:$item->rating->rating_count; ?>" data-comments="<?php echo ($item->numOfComments == null)?0:$item->numOfComments; ?>" data-modified="<?php echo strtotime($item->modified) ?>" data-rand="random" data-catid="<?php echo $item->catid ?>">
		<div class="item-inner">
			<div class="item-more">
				<div class="more-image clearfix">
					<?php
					$img = K2ResponsiveListing::getK2Image($item, $params); 
					if($img){
					?>
					<a href="<?php echo $item->link ?>" <?php echo K2ResponsiveListing::parseTarget($params->get('link_target','_self'))?> title="<?php echo $item->title?>" >
						<?php echo K2ResponsiveListing::imageTag($img); ?>
						
					</a>
					<?php } ?>
					<a href="<?php echo $item->link ?>" <?php echo K2ResponsiveListing::parseTarget($params->get('link_target','_self'))?>  title="<?php echo $item->title?>" class="link_detail"></a>
					<a data-rel="prettyPhoto" href="<?php echo K2ResponsiveListing::imageSrc($img); ?>" class="zoom_img"></a>
					
					<div class="more-desc">
					<div class="more-inner">
						<?php if($params->get('item_title_display',1) == 1){?>
						<div class="more-title">
							<a href="<?php echo $item->link ?>" <?php echo K2ResponsiveListing::parseTarget($params->get('link_target','_self'))?> title="<?php echo $item->title?>" >
								<?php echo K2ResponsiveListing::truncate($item->title, $params->get('item_title_max_characters',25)); ?>
							 </a>
						</div>
						<?php }?>
						<?php if($params->get('item_hits_display', 1) == 1){?>
						<div class="more-read" data-read="<?php echo JText::_('READ_LABEL')?>" data-times="<?php echo ((int)$item->hits>1)?JText::_('TIMES_LABEL'):JText::_('TIME_LABEL')?>">&nbsp;<?php echo $item->hits ?>&nbsp;</div>
						<?php }?>
						<?php if($params->get('item_cat_display', 1) == 1){?>
						<div class="more-public" data-value="<?php echo JText::_('PUBLISHED_LABEL')?>">&nbsp;
							<a href="<?php echo $item->categoryLink ?>" <?php echo K2ResponsiveListing::parseTarget($params->get('link_target','_self'))?> title="<?php echo $item->categoryname?>" >
								<?php echo $item->categoryname ?>
							</a>
						</div>
						<?php }?>
						<?php if($params->get('item_description_display', 1) == 1) {?>
						<div class="more-content">
								<?php
									$description = '';
									$introtext = K2ResponsiveListing::_cleanText($item->introtext);
									$fulltext = K2ResponsiveListing::_cleanText($item->fulltext);
									if(strip_tags($introtext) != ''){
										$description = $introtext;
									}else if(strip_tags($fulltext) != ''){
										$description = $fulltext;
									}else{
										$description = '';
									}
									if($description != ''){
										echo K2ResponsiveListing::truncate($description, (int)$params->get('item_des_maxlength_layout_grid'));
									}
								?>
					 	</div>
					 	<?php } ?>
					 	<?php if($params->get('item_created_display',1) == 1) {?>
					 	<div class="more-post" data-value="<?php echo JText::_('POST_LABEL')?>"><?php echo  JHTML::_('date', $item->created,JText::_('DATE_FORMAT_LC3')) ?></div>
					 	<?php }?>
					 	<?php if($params->get('item_readmore_display', 1) == 1){?>
					 	<div class="more-readmore">
					 		<a href="<?php echo $item->link ?>" <?php echo K2ResponsiveListing::parseTarget($params->get('link_target','_self'))?> title="<?php echo $item->title?>" >
					 			<?php echo JText::_('READ_MORE_GRID_LABEL') ?>
					 		</a>
					 	</div>
					 	<?php }?>
				 	</div>
				 </div>
				</div>
				
			</div>
		</div>
	</div>
<?php } 
}?>
