<?php
/**
 * @package Sj Responsive Listing for K2
 * @version 2.5.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2013 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 */

defined('_JEXEC') or die;



JHtml::stylesheet('modules/'.$module->module.'/assets/css/isotope.css');
if( !defined('SMART_JQUERY') && $params->get('include_jquery', 0) == "1" ){
	JHtml::script('modules/'.$module->module.'/assets/js/jquery-1.8.2.min.js');
	JHtml::script('modules/'.$module->module.'/assets/js/jquery-noconflict.js');
	define('SMART_JQUERY', 1);
}

JHtml::script('modules/'.$module->module.'/assets/js/jquery.isotope.js');

$instance	= rand().time();
$tag_id = 'sj_k2reslisting_'.rand().time();
?>
<!--[if lt IE 9]><div id="<?php echo $tag_id; ?>" class="sj-responsive-listing msie lt-ie9"><![endif]-->
<!--[if IE 9]><div id="<?php echo $tag_id; ?>" class="sj-responsive-listing msie"><![endif]-->
<!--[if gt IE 9]><!--><div id="<?php echo $tag_id; ?>" class="sj-responsive-listing"><!--<![endif]-->
   <?php if($params->get('pretext')!= null){ ?>
		<div class="respl-pretext">
			<?php echo $params->get('pretext');?>
		</div>
   <?php }?>
	<div class="respl-wrap clearfix">
		<div class="respl-header">
			<?php $maxwidth = ($params->get('sort_byform_display',1)== 0 && $params->get('layout_select_display',1) == 0 )?'max-width:100%':'';?>
			<div class="respl-categories" data-label="<?php echo JText::_('CATEOGRY_LABEL') ?>" style="<?php echo $maxwidth ?>"  >
				<div class="respl-cats-wrap respl-group"  >
					<div class="cats-curr respl-btn dropdown-toggle" data-toggle="dropdown">
						<span class="sort-curr" data-filter_value=""><?php echo JText::_('ALL_LABEL')?></span>
						<span class="sort-arrow respl-arrow"></span>
					</div>
					<ul class="respl-cats respl-dropdown-menu respl-option" data-option-key="filter">
						<?php foreach($list['categories'] as $items){  ?>
							<li class="respl-cat <?php echo (isset($items->sel))?$items->sel:''; ?>" data-value="<?php echo $items->id ?>">
								<a href="#<?php echo $tag_id; ?>" data-rl_value="<?php echo ($items->id == '*')?'*':'.category-'.$items->id?>" class="<?php echo ($params->get('count_items_display',0) == 0)?'respl-count':''; ?>" data-count="<?php echo $items->count ?>">
									<?php echo ($items->title == JText::_('ALL_LABEL'))?JText::_('ALL_LABEL'):K2ResponsiveListing::truncate($items->name, $params->get('tal_max_characters')) ?>
								</a>
							</li>
						<?php }?>
					</ul>
					<div class="clear"></div>
				</div>
			</div>
			<div class="respl-sort-view" >
			<?php if($params->get('sort_byform_display',1) == 1){
		
						$value_curr ='';
						$data_curr =  '';
						$select_sort =   $params->get('itemsOrdering','title');
						switch($select_sort){
							case '':
								 $value_curr = 'id';
								 $data_curr = JText::_('K2_DEFAULT');
								 break;
							case 'date':
								$value_curr = 'date';
								$data_curr = JText::_('K2_OLDEST_FIRST');
								break;
							case 'rdate':
								$value_curr = 'rdate';
								$data_curr = JText::_('K2_MOST_RECENT_FIRST');
								break;
							case 'publishUp':
								$value_curr = 'publishUp';
								$data_curr = JText::_('K2_RECENTLY_PUBLISHED');
								break;
							case 'alpha':
								$value_curr = 'alpha';
								$data_curr = JText::_('K2_TITLE_ALPHABETICAL');
								break;
							case 'ralpha':
								$value_curr = 'ralpha';
								$data_curr = JText::_('K2_TITLE_REVERSEALPHABETICAL');
								break;
							case 'order':
								$value_curr = 'order';
								$data_curr = JText::_('K2_ORDERING');
								break;
							case 'rorder':
								$value_curr = 'rorder';
								$data_curr = JText::_('K2_ORDERING_REVERSE');
								break;
							case 'hits':
								$value_curr = 'hits';
								$data_curr = JText::_('K2_MOST_POPULAR');
								break;
							case 'best':
								$value_curr = 'best';
								$data_curr = JText::_('K2_HIGHEST_RATED');
								break;
							case 'comments':
								$value_curr = 'comments';
								$data_curr = JText::_('K2_MOST_COMMENTED');
								break;
							case 'modified':
								$value_curr = 'modified';
								$data_curr = JText::_('K2_LATEST_MODIFIED');
								break;	
							case 'rand':
								$value_curr = 'random';
								$data_curr = JText::_('K2_RANDOM_ORDERING');
								break;	
							default:
								$value_curr = 'id';
								$data_curr = JText::_('K2_DEFAULT');
								break;
						} 
						
					$oderbys  = $params->get('itemsOrdering_display');
					
				if(!empty($oderbys)) {
						$value_first = $value_curr;
						$data_first = $data_curr;
					if(in_array($value_curr,$oderbys)) {
						 $value_first = $value_curr;
						 $data_first = $data_curr;
					 } else {
						$value_first = $oderbys[0];
						if($oderbys[0] == ''){
							$data_first = JText::_('K2_DEFAULT');
						}else if($oderbys[0] == 'date' ){
							$data_first = JText::_('K2_OLDEST_FIRST');
						}else if($oderbys[0] == 'rdate' ){
							$data_first = JText::_('K2_MOST_RECENT_FIRST');
						}else if($oderbys[0] == 'publishUp' ){
							$data_first = JText::_('K2_RECENTLY_PUBLISHED');
						}else if($oderbys[0] == 'alpha' ){
							$data_first = JText::_('K2_TITLE_ALPHABETICAL');
						}else if($oderbys[0] == 'ralpha' ){
							$data_first = JText::_('K2_TITLE_REVERSEALPHABETICAL');
						}else if($oderbys[0] == 'order' ){
							$data_first = JText::_('K2_ORDERING');
						}else if($oderbys[0] == 'rorder' ){
							$data_first = JText::_('K2_ORDERING_REVERSE');
						}else if($oderbys[0] == 'hits' ){
							$data_first = JText::_('K2_MOST_POPULAR');
						}else if($oderbys[0] == 'best' ){
							$data_first = JText::_('K2_HIGHEST_RATED');
						}else if($oderbys[0] == 'comments' ){
							$data_first = JText::_('K2_MOST_COMMENTED');
						}else if($oderbys[0] == 'modified' ){
							$data_first = JText::_('K2_LATEST_MODIFIED');
						}else if($oderbys[0] == 'rand' ){
							$data_first = JText::_('K2_RANDOM_ORDERING');
						}
					}
					
				?>
				<div class="respl-sort" data-label="<?php echo JText::_('SORT_BY_LABEL')?>" >
					<div class="sort-wrap respl-group">
						<div class="sort-inner respl-btn dropdown-toggle"  data-curr_value="<?php echo  $value_first; ?>" data-curr="<?php echo $data_first ?>">
							<span class="sort-arrow respl-arrow"></span>
						</div>
						<ul class="sort-select respl-dropdown-menu respl-option" data-option-key="sortBy">
							<?php 
							$oderbys  = $params->get('itemsOrdering_display');
							foreach($oderbys as $key => $oder){
								if($oder == '') { ?>
									<li ><a href="#<?php echo $tag_id; ?>" data-rl_value="id"><?php echo JText::_('K2_DEFAULT')?></a></li>
								<?php }
								else if($oder == 'date') {?>
									<li ><a href="#<?php echo $tag_id; ?>" data-rl_value="date"><?php echo JText::_('K2_OLDEST_FIRST')?></a></li>
								<?php }
								else if($oder == 'rdate') {?>
									<li ><a href="#<?php echo $tag_id; ?>" data-rl_value="rdate"><?php echo JText::_('K2_MOST_RECENT_FIRST')?></a></li>	
								<?php } 
								else if($oder == 'publishUp') { ?>
									<li ><a href="#<?php echo $tag_id; ?>" data-rl_value="publishUp"><?php echo JText::_('K2_RECENTLY_PUBLISHED')?></a></li>
								<?php }
								else if($oder == 'alpha') { ?>
									<li ><a href="#<?php echo $tag_id; ?>" data-rl_value="alpha"><?php echo JText::_('K2_TITLE_ALPHABETICAL')?></a></li>
								<?php }
								else if($oder == 'ralpha') {?>
									<li ><a href="#<?php echo $tag_id; ?>" data-rl_value="ralpha"><?php echo JText::_('K2_TITLE_REVERSEALPHABETICAL')?></a></li>
								<?php }
								else if($oder == 'order') {?>
									<li ><a href="#<?php echo $tag_id; ?>" data-rl_value="order"><?php echo JText::_('K2_ORDERING')?></a></li>
								<?php } 
								else if($oder == 'rorder') {?>
									<li ><a href="#<?php echo $tag_id; ?>" data-rl_value="rorder"><?php echo JText::_('K2_ORDERING_REVERSE')?></a></li>
								<?php }
								else if($oder == 'hits') {?>
									<li ><a href="#<?php echo $tag_id; ?>" data-rl_value="hits"><?php echo JText::_('K2_MOST_POPULAR')?></a></li>
								<?php }
								else if($oder == 'best') {?>
									<li ><a href="#<?php echo $tag_id; ?>" data-rl_value="best"><?php echo JText::_('K2_HIGHEST_RATED')?></a></li>
								<?php }
								else if($oder == 'comments') {?>
									<li ><a href="#<?php echo $tag_id; ?>" data-rl_value="comments"><?php echo JText::_('K2_MOST_COMMENTED')?></a></li>
								<?php }
								else if($oder == 'modified') {?>
									<li ><a href="#<?php echo $tag_id; ?>" data-rl_value="modified"><?php echo JText::_('K2_LATEST_MODIFIED')?></a></li>
								<?php }
								else if($oder == 'rand') {?>
									<li ><a href="#<?php echo $tag_id; ?>" data-rl_value="random"><?php echo JText::_('K2_RANDOM_ORDERING')?></a></li>
								<?php }?>
							<?php }?>
							
						</ul>
					</div>
				</div>
				<?php } 
				}?>
				
				<?php if($params->get('layout_select_display',1) == 1) {?>
				<ul class="respl-view respl-option" data-label="<?php echo JText::_('VIEW_LABEL')?>" data-option-key="layoutMode">
					<li class="view-grid <?php echo ($params->get('default_view',1) == 1)?'sel':''?>">
						<a href="#<?php echo $tag_id; ?>" data-rl_value="fitRows">
						</a>
					</li>
					<li class="view-list <?php echo ($params->get('default_view',1) == 0)?'sel':''?>">
						<a href="#<?php echo $tag_id; ?>" data-rl_value="straightDown">
						</a>
					</li>
				</ul>
				<?php }?>
			</div>
		</div>
		
		<?php $class_respl= 'respl01-'.$params->get('nb-column1',6).' respl02-'.$params->get('nb-column2',4).' respl03-'.$params->get('nb-column3',2).' respl04-'.$params->get('nb-column4',1) ?>
		
		<div class="respl-items <?php echo $class_respl?> <?php echo ($params->get('default_view',1) == 1)?'grid':'list'?> clearfix  module-<?php echo $module->id?>">
			<?php require JModuleHelper::getLayoutPath($module->module, $layout.'_items'); ?>
		</div>
		
		<?php
			$classloaded = ($params->get('itemCount', 2) >= K2ResponsiveListing::$total || $params->get('itemCount', 2)== 0 )?'loaded':'';
			
		?>
		
		<div class="respl-loader respl-btn <?php echo $classloaded?>" >
			<a class="respl-button" href="#<?php echo $tag_id; ?>"  data-rl_allready="<?php echo JText::_('ALL_READY_LABEL');?>"
				data-rl_start="<?php echo $params->get('itemCount', 2)?>"
				data-rl_ajaxurl1="<?php echo (string)JURI::getInstance(); ?>"
				data-rl_load="<?php echo $params->get('itemCount', 2)?>"
				data-rl_total="<?php echo K2ResponsiveListing::$total ?>"
				data-rl_moduleid="<?php echo $module->id; ?>">
				
				<span class="loader-label" >
					<?php if ($classloaded){
						echo JText::_('ALL_READY_LABEL');
					} else { ?>
					<?php echo JText::_('LOAD_MORE_WORK')?> (<span class="load-number" data-more="<?php echo $params->get('itemCount', 2)?>" data-total="<?php echo K2ResponsiveListing::$total - $params->get('itemCount', 2)?>">/</span>)
					<?php } ?>
				</span>
			</a>
		</div>
		<div class="clear"></div>
	</div>
	<?php if($params->get('posttext')!= ''){ ?>
		<div class="respl-posttext">
			<?php echo $params->get('posttext');?>
		</div>
    <?php }?>
</div>