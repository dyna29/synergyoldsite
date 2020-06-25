<?php
/**
 * @version		2.6.x
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2014 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;

// includes placehold
$yt_temp = JFactory::getApplication()->getTemplate();
include (JPATH_BASE . '/templates/'.$yt_temp.'/includes/placehold.php');

?>

<!-- Start K2 Tag Layout -->
<div id="k2Container" class="tagView<?php if($this->params->get('pageclass_sfx')) echo ' '.$this->params->get('pageclass_sfx'); ?>">

	<?php if($this->params->get('show_page_title')): ?>
	<!-- Page title -->
	<div class="componentheading<?php echo $this->params->get('pageclass_sfx')?>">
		<?php echo $this->escape($this->params->get('page_title')); ?>
	</div>
	<?php endif; ?>

	<?php if($this->params->get('tagFeedIcon',1)): ?>
	<!-- RSS feed icon -->
	<div class="k2FeedIcon">
		<a href="<?php echo $this->feed; ?>" title="<?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?>">
			<span><?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?></span>
		</a>
		<div class="clr"></div>
	</div>
	<?php endif; ?>

	<?php if(count($this->items)): ?>
	<div class="itemList">
		<?php foreach($this->items as $item): ?>

		<!-- Start K2 Item Layout -->
		<div class="catItemView">
			
			 <?php if($item->params->get('tagItemImage',1) ): ?>
			  <!-- Item Image -->
			  <div class="catItemImageBlock">
				  
					<a href="<?php echo $item->link; ?>" title="<?php if(!empty($item->image_caption)) echo K2HelperUtilities::cleanHtml($item->image_caption); else echo K2HelperUtilities::cleanHtml($item->title); ?>">
						
						<?php 
							//Create placeholder items images
							$src = isset($item->imageGeneric)? $item->imageGeneric : '';
							if (!empty( $src)) {								
								$thumb_img = '<img src="'.$src.'" alt="'.$item->title.'" />';
							} else if ($is_placehold) {					
								$thumb_img = yt_placehold($placehold_size['listing'],$item->title,$item->title);
							}	
							echo $thumb_img;
						?>
						<!-- Item video -->
						<?php if($this->item->params->get('catItemVideo') && !empty($this->item->video)): ?>
						  <div class="fa fa-play-circle"></div>
						<?php endif; ?>
					</a>
				  
				  <div class="clr"></div>
			  </div>
			 <?php endif; ?>
			  
			<div class="tagItemHeader">
				
			  <?php if($item->params->get('tagItemTitle',1)): ?>
			  <!-- Item title -->
			  <h3 class="tagItemTitle">
			  	<?php if ($item->params->get('tagItemTitleLinked',1)): ?>
					<a href="<?php echo $item->link; ?>">
			  		<?php echo $item->title; ?>
			  	</a>
			  	<?php else: ?>
			  	<?php echo $item->title; ?>
			  	<?php endif; ?>
			  </h3>
			  <?php endif; ?>
			  
				<aside class="article-aside">
					<dl class="article-info  muted">
						<!-- Date created -->
						<?php if($item->params->get('tagItemDateCreated',1)): ?>
							<dd class="create"><i class="ico-clock"></i><?php echo JHTML::_('date', $item->created , JText::_('K2_DATE_FORMAT_LC2')); ?></dd>		
						<?php endif; ?>						
										
						<?php if($item->params->get('tagItemCategory')): ?>
							<!-- Item category name -->
							<dd class="tagItemCategory">
								<span><?php echo JText::_('K2_PUBLISHED_ME'); ?></span>
								<a href="<?php echo $item->category->link; ?>"><?php echo $item->category->name; ?></a>
							</dd>
						<?php endif; ?>
								
						</dd>
												
											
					</dl>
				</aside>
		  </div>

		  
			 
			  
		  <?php if($item->params->get('tagItemIntroText',1)): ?>
		  <!-- Item introtext -->
		  <div class="tagItemIntroText">
			<?php echo $item->introtext; ?>
		  </div>
		  <?php endif; ?>

			 
		  
		  
		  <div class="clr"></div>
		  
		  <?php if($item->params->get('tagItemExtraFields',0) && count($item->extra_fields)): ?>
		  <!-- Item extra fields -->  
		  <div class="tagItemExtraFields">
		  	<h4><?php echo JText::_('K2_ADDITIONAL_INFO'); ?></h4>
		  	<ul>
				<?php foreach ($item->extra_fields as $key=>$extraField): ?>
				<?php if($extraField->value != ''): ?>
				<li class="<?php echo ($key%2) ? "odd" : "even"; ?> type<?php echo ucfirst($extraField->type); ?> group<?php echo $extraField->group; ?>">
					<?php if($extraField->type == 'header'): ?>
					<h4 class="tagItemExtraFieldsHeader"><?php echo $extraField->name; ?></h4>
					<?php else: ?>
					<span class="tagItemExtraFieldsLabel"><?php echo $extraField->name; ?></span>
					<span class="tagItemExtraFieldsValue"><?php echo $extraField->value; ?></span>
					<?php endif; ?>		
				</li>
				<?php endif; ?>
				<?php endforeach; ?>
				</ul>
		    <div class="clr"></div>
		  </div>
		  <?php endif; ?>
		  
			
			<?php if ($item->params->get('tagItemReadMore')): ?>
			<!-- Item "read more..." link -->
			<div class="tagItemReadMore">
				<a class="button" href="<?php echo $item->link; ?>">
					<?php echo JText::_('K2_READ_MORE_ME'); ?>
				</a>
			</div>
			<?php endif; ?>

			<div class="clr"></div>
		</div>
		<!-- End K2 Item Layout -->
		
		<?php endforeach; ?>
	</div>

	<!-- Pagination -->
	<?php if($this->pagination->getPagesLinks()): ?>
	<div class="k2Pagination">
		<?php echo $this->pagination->getPagesLinks(); ?>
		<div class="clr"></div>
		<?php echo $this->pagination->getPagesCounter(); ?>
	</div>
	<?php endif; ?>

	<?php endif; ?>
	
</div>
<!-- End K2 Tag Layout -->
