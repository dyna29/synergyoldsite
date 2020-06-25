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

<!-- Start K2 Item Layout -->
<div class="catItemView">

	<!-- Plugins: BeforeDisplay -->
	<?php echo $this->item->event->BeforeDisplay; ?>

	<!-- K2 Plugins: K2BeforeDisplay -->
	<?php echo $this->item->event->K2BeforeDisplay; ?>

	
		  <?php if($this->item->params->get('latestItemImage') ): ?>
		  <!-- Item Image -->
		  <div class="catItemImageBlock">
			 
				<a href="<?php echo $this->item->link; ?>" title="<?php if(!empty($this->item->image_caption)) echo K2HelperUtilities::cleanHtml($this->item->image_caption); else echo K2HelperUtilities::cleanHtml($this->item->title); ?>">
					
					<?php 
						//Create placeholder items images
						$src = isset( $this->item->image)? $this->item->image : '';
						if (!empty( $src)) {								
							$thumb_img = '<img src="'.$src.'" alt="'.$item->title.'" />';
						} else if ($is_placehold) {					
							$thumb_img = yt_placehold($placehold_size['listing'],$this->item->title,$this->item->title);
						}	
						echo $thumb_img;
					?>
				</a>
			  
		  </div>
		  <?php endif; ?>
	      <div class="main-item">  
		<div class="catItemHeader">		
		  <?php if($this->item->params->get('latestItemTitle')): ?>
		  <!-- Item title -->
		  <h2 class="latestItemTitle">
			<?php if ($this->item->params->get('latestItemTitleLinked')): ?>
				<a href="<?php echo $this->item->link; ?>">
				<?php echo $this->item->title; ?>
			</a>
			<?php else: ?>
			<?php echo $this->item->title; ?>
			<?php endif; ?>
		  </h2>
		  <?php endif; ?>
		</div>
		
		<aside class="article-aside">
			<dl class="article-info  muted">
					<!-- Date created -->
					<?php if($this->item->params->get('latestItemDateCreated',1)): ?>
						<dd class="create"><?php echo JHTML::_('date', $this->item->created , JText::_('DATE_FORMAT_LC1')); ?></dd>	
					<?php endif; ?>		
					<?php if($this->item->params->get('latestItemCategory')): ?>
					<!-- Item category name -->
					<dd class="latestItemCategory">
						<span><?php echo JText::_('K2_PUBLISHED_IN'); ?></span>
						<a href="<?php echo $this->item->category->link; ?>"><?php echo $this->item->category->name; ?></a>
					</dd>
					<?php endif; ?>	
					
					<?php if($this->item->params->get('latestItemCommentsAnchor') && ( ($this->item->params->get('comments') == '2' && !$this->user->guest) || ($this->item->params->get('comments') == '1')) ): ?>
					<!-- Anchor link to comments below -->
					<dd class="latestItemCommentsLink">
						<?php if(!empty($this->item->event->K2CommentsCounter)): ?>
							<!-- K2 Plugins: K2CommentsCounter -->
							<?php echo $this->item->event->K2CommentsCounter; ?>
						<?php else: ?>
							<?php if($this->item->numOfComments > 0): ?>
							<a href="<?php echo $this->item->link; ?>#itemCommentsAnchor">
								<?php echo $this->item->numOfComments; ?> <?php echo ($this->item->numOfComments>1) ? JText::_('K2_COMMENTS') : JText::_('K2_COMMENT'); ?>
							</a>
							<?php else: ?>
							<a href="<?php echo $this->item->link; ?>#itemCommentsAnchor">
								<?php echo JText::_('K2_BE_THE_FIRST_TO_COMMENT'); ?>
							</a>
							<?php endif; ?>
						<?php endif; ?>
					</dd>
					<?php endif; ?>

					
				
										
									
			</dl>
		</aside>
		
	

  <!-- Plugins: AfterDisplayTitle -->
  <?php echo $this->item->event->AfterDisplayTitle; ?>

  <!-- K2 Plugins: K2AfterDisplayTitle -->
  <?php echo $this->item->event->K2AfterDisplayTitle; ?>

 

	  <!-- Plugins: BeforeDisplayContent -->
	  <?php echo $this->item->event->BeforeDisplayContent; ?>

	  <!-- K2 Plugins: K2BeforeDisplayContent -->
	  <?php echo $this->item->event->K2BeforeDisplayContent; ?>

	  

	  <?php if($this->item->params->get('latestItemIntroText')): ?>
	  <!-- Item introtext -->
	  <div class="latestItemIntroText">
	  	<?php echo $this->item->introtext; ?>
		
	  </div>
	  <?php endif; ?>
	   <?php if($this->item->params->get('latestItemTags') && count($this->item->tags)): ?>
	      <div class="latestItemLinks">
		      <?php if($this->item->params->get('latestItemTags') && count($this->item->tags)): ?>
		      <!-- Item tags -->
		      <div class="latestItemTagsBlock">
			      <span><?php echo JText::_('K2_TAGGED_UNDER'); ?></span>
			      <ul class="latestItemTags">
				<?php foreach ($this->item->tags as $tag): ?>
				<li><a href="<?php echo $tag->link; ?>"><?php echo $tag->name; ?></a></li>
				<?php endforeach; ?>
			      </ul>
			      <div class="clr"></div>
		      </div>
		      <?php endif; ?>
	    
			    <div class="clr"></div>
	      </div>
	      <?php endif; ?>

	      </div>
	      <div class="clr"></div>

	  <!-- Plugins: AfterDisplayContent -->
	  <?php echo $this->item->event->AfterDisplayContent; ?>

	  <!-- K2 Plugins: K2AfterDisplayContent -->
	  <?php echo $this->item->event->K2AfterDisplayContent; ?>

	  <div class="clr"></div>
  

 

  <?php if($this->params->get('latestItemVideo') && !empty($this->item->video)): ?>
  <!-- Item video -->
  <div class="latestItemVideoBlock">
  	<h3><?php echo JText::_('K2_RELATED_VIDEO'); ?></h3>
	  <span class="latestItemVideo<?php if($this->item->videoType=='embedded'): ?> embedded<?php endif; ?>"><?php echo $this->item->video; ?></span>
  </div>
  <?php endif; ?>

	
	<?php if ($this->item->params->get('latestItemReadMore')): ?>
	<!-- Item "read more..." link -->
	<div class="latestItemReadMore">
		<a class="button" href="<?php echo $this->item->link; ?>">
			<?php echo JText::_('K2_READ_MORE'); ?>
		</a>
	</div>
	<?php endif; ?>

	<div class="clr"></div>

  <!-- Plugins: AfterDisplay -->
  <?php echo $this->item->event->AfterDisplay; ?>

  <!-- K2 Plugins: K2AfterDisplay -->
  <?php echo $this->item->event->K2AfterDisplay; ?>

	<div class="clr"></div>
</div>
<!-- End K2 Item Layout -->
