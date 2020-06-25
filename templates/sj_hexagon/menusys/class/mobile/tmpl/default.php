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
$typelayout = $yt->getParam('layouttype');

?>

<?php
if ($this->isRoot()){
	if($typelayout=='res'){ ?>
		<div id="yt-responivemenu" class="yt-resmenu ">
			<button data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar collapsed" type="button">
				<i class="fa fa-bars"></i> <?php echo JText::_('RESPONSIVE_MENU_TEXT'); ?>
			</button>
			<div id="resmenu_sidebar" class="nav-collapse collapse" >
				<ul class="nav resmenu">
				<?php
				if($this->haveChild()){
					$idx = 0;
					foreach($this->getChild() as $child){
						++$idx;
						$child->getContent('collapse');
					}
				}
				?>
				</ul>
			</div>
			
		</div>
	<?php
	}
}
?>
<script type="text/javascript">
	
	/*jQuery(document).click(function (e) {
		if (!jQuery(e.target).hasClass("nav-collapse") && jQuery(e.target).parents(".nav-collapse").length === 0) {
				jQuery('#resmenu_sidebar').removeClass('in');
		}
	});*/
	
	jQuery(document).ready(function($) {
		$('.btn-navbar').click(function(){
				$(this).children().toggleClass('fa-times');
		});
		$("ul.resmenu li.haveChild").each(function() {
			$(this).children(".res-wrapnav").css('display', 'none');
			var ua = navigator.userAgent,
			event = (ua.match(/iPad/i)) ? "touchstart" : "click";
			$(this).children(".menuress-toggle").bind(event, function() {
				
				$(this).parent().addClass(function(){
					if($(this).hasClass("active")){
						//$(this).removeClass("active");
						return "";
					}
					return "active";
				});
				
				$(this).siblings(".res-wrapnav").slideDown(350);
				$(this).parent().siblings("li").children(".res-wrapnav").slideUp(350);
				$(this).parent().siblings("li").removeClass("active");
			});
			
		});
		
	});
</script>