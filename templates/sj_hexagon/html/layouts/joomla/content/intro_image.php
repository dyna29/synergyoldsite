<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
// includes placehold
$yt_temp = JFactory::getApplication()->getTemplate();
include (JPATH_BASE . '/templates/'.$yt_temp.'/includes/placehold.php');

// Create a shortcut for params.
$params  = $displayData->params;

global $leadingFlag;
$doc = JFactory::getDocument();
$app = JFactory::getApplication();
$templateParams = JFactory::getApplication()->getTemplate(true)->params;

?>
<?php $images = json_decode($displayData->images);?>

<?php  if (isset($images->image_intro) and !empty($images->image_intro)) : ?>
	<?php $imgfloat = (empty($images->float_intro)) ? $params->get('float_intro') : $images->float_intro; ?>
    <?php
	
	// Begin:  The way to resize your image.
	$templateParams = JFactory::getApplication()->getTemplate(true)->params;
	YTTemplateUtils::getImageResizerHelper(array(
		'background' => $templateParams->get('thumbnail_background', '#000'), 
		'thumbnail_mode' => $templateParams->get('thumbnail_mode', 'fit')
		)
	);
	$imgW = (isset($leadingFlag) && $leadingFlag)?$templateParams->get('leading_width', '300'):$templateParams->get('intro_width', '200');
	$imgH = (isset($leadingFlag) && $leadingFlag)?$templateParams->get('leading_height', '300'):$templateParams->get('intro_height', '200');
	$imgsrc = YTTemplateUtils::resize($images->image_intro, $imgW, $imgH);
	
	//Create placeholder items images
	$src = $images->image_intro;
	if (file_exists(JPATH_BASE . '/' . $src)) {								
		$thumb_img = '<img src="'.$imgsrc.'" alt="'.$images->image_intro_alt.'" />';
	} else if ($is_placehold) {					
		$thumb_img = yt_placehold($placehold_size['listing']);
	}	
	?>
	<figure class="pull-<?php echo htmlspecialchars($imgfloat); ?> item-image" >
		
		<?php echo $thumb_img; ?>
		
		<?php if ($params->get('show_category') || $params->get('show_author') ) { ?>
		<aside class="article-aside">

		<?php // to do not that elegant would be nice to group the params ?>

				<dl class="article-info  muted">
					<?php if ($params->get('show_author') && !empty($displayData->author )) : ?>
					<dt></dt>
						<dd class="createdby" itemprop="author" itemscope itemtype="http://schema.org/Person">
							<i class="fa fa-user"></i>
							<?php $author = ($displayData->created_by_alias) ? $displayData->created_by_alias : $displayData->author; ?>
							<?php $author = '<span itemprop="name">' . $author . '</span>'; ?>
							<?php if (!empty($displayData->contact_link) && $params->get('link_author') == true) : ?>
								<?php echo JText::sprintf( JHtml::_('link', $displayData->contact_link, $author, array('itemprop' => 'url'))); ?>
							<?php else: ?>
								<?php echo JText::sprintf( $author); ?>
							<?php endif; ?>
						</dd>
					<?php endif; ?>


					<?php if ($params->get('show_category')) : ?>
					<dt></dt>
						<dd class="category-name">
							<?php $title = $this->escape($displayData->category_title); ?>
							<?php if ($params->get('link_category') && $displayData->catslug) : ?>
								<?php $url = '<a href="' . JRoute::_(ContentHelperRoute::getCategoryRoute($displayData->catslug)) . '" itemprop="genre">' . $title . '</a>'; ?>
								<?php echo JText::sprintf('COM_CONTENT_CATEGORY', $url); ?>
							<?php else : ?>
								<?php echo JText::sprintf('COM_CONTENT_CATEGORY', '<span itemprop="genre">' . $title . '</span>'); ?>
							<?php endif; ?>
						
						</dd>
					<?php endif; ?>

				</dl>
			
		</aside>
		<?php } ?>
    </figure>
<?php endif; ?>
