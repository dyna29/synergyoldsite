<?php
/** 
 * YouTech menu template file.
 * 
 * @author The YouTech JSC
 * @package menusys
 * @filesource default.php
 * @license Copyright (c) 2011 The YouTech JSC. All Rights Reserved.
 * @tutorial http://www.smartaddons.com
 */
global $yt;
$doc = JFactory::getDocument();

if ($this->isRoot()){	
	$menucssid = $this->params->get('menustyle') . 'navigator' . $this->params->get('cssidsuffix');
	$addCssRight = $doc->direction =='rtl' ? "rtl" : "";
	echo '<ul id="'.$menucssid.'" class="clearfix navi'.($addCssRight=='rtl' ? ' navirtl':'').'">';
	if($this->haveChild()){
		$idx = 0;
		foreach($this->getChild() as $child){
			$child->addClass('level'.$child->get('level',1));
			++$idx;
			if ($idx==1){
				$child->addClass('first');
			} else if ($idx==$this->countChild()){
				$child->addClass('last');
			}
			if ($child->haveChild()){
				$child->addClass('havechild');
			}
			$child->getContent();
		}
	}
	echo "</ul>";
	
	// import assets
	$document = JFactory::getDocument();
	$fancyMenu				    = $yt->getParam('fancyMenu');
	
	$document->addScript($yt->templateurl().'menusys/class/common/js/jquery.easing.1.3.js');
	if($fancyMenu) $document->addScript($yt->templateurl().'menusys/class/common/js/gooeymenu.js');
	?>
	
	<script type="text/javascript">
		jQuery(function($){
			<?php if($fancyMenu) {?>
				gooeymenu.setup({id:'<?php echo $menucssid?>', fx:'swing'})
			<?php };?>
			
          
	    });
	</script>
	
	<?php
	$abspath = $this->params->get('basepath') . J_SEPARATOR . 'class';
	$abspath = realpath($abspath);
	!empty($abspath) or die($this->params->get('basepath') . ' does not exits. Please kindly set basepath for menusys');
	$relpath = array_pop( explode(JPATH_BASE, realpath($abspath), 2) );
	$relpath = str_replace("\\", "/", $relpath);
	
	
} else if ( $this->canAccess() ){
	$haveChild = $this->haveChild();
	$liClass = $this->haveClass() ? "class=\"{$this->getClass()}\"" : "";
?>

<li <?php echo $liClass; ?>>
	<?php echo $this->getLink(); ?>	
	<?php
		if($haveChild){
			$levelClassName = 'level'.($this->get('level',1)+1);
			if ($this->level>1){
				$subStyleWidth = $this->getSubmenuWidth();
			} else {
				// dropline doesnt set style for this level
				$subStyleWidth = "";
			}		
			
			echo "<ul class=\"{$levelClassName} subnavi\" $subStyleWidth>";			
			$cidx = 0;
			foreach($this->getChild() as $child){
				$child->addClass($levelClassName);
				++$cidx;
				if ($cidx==1){
					$child->addClass('first');
				} else if ($cidx==$this->countChild()){
					$child->addClass('last');
				}
				if ($child->haveChild()){
					$child->addClass('havechild');
				}
				$child->getContent();
			}
			echo "</ul>";
		}
	?>
</li>

<?php 
}
?>