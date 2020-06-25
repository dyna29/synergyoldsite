<?php
/*
 * ------------------------------------------------------------------------
 * Copyright (C) 2009 - 2013 The YouTech JSC. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: The YouTech JSC
 * Websites: http://www.smartaddons.com - http://www.cmsportal.net
 * ------------------------------------------------------------------------
*/
defined('_JEXEC') or die;

if($yt->getParam('useSpecialPositions')==1){?>
<div id="yt_special_pos" class="row hidden-xs">
	
    <?php
	if($doc->countModules('sticky_left')){ ?>
	<div id="yt_sticky_left" >
        <div class="yt-sticky sticky-left clearfix">
			<jdoc:include type="modules" name="sticky_left" style="special" />
        </div>
    </div>
    <?php 
	} ?>
    <?php
	if($doc->countModules('sticky_right')){ ?>
    <div id="yt_sticky_right"  >
        <div class="yt-sticky sticky-right clearfix">
			<jdoc:include type="modules" name="sticky_right" style="special" />
        </div>
    </div>
    <?php } ?>
    
	
	<script type="text/javascript">
		function useSP(){
			jQuery(document).ready(function($){
				var width = $(window).width()+17; 
				var events = '<?php echo $yt->getParam("eventsSpecialPostion", "click")?>';
				if(width>767){
					
					<?php if($doc->countModules('sticky_left')){ ?>
						YTScript.slidePositions('#yt_sticky_left .yt-sticky', 'left', events);
					<?php } ?>
					<?php if($doc->countModules('sticky_right')){ ?>
						YTScript.slidePositions('#yt_sticky_right .yt-sticky', 'right', events);
					<?php } ?>
					
				}
			});
			
		}

		useSP();
		
	</script>

</div>
<?php } ?>

<?php
// Show Back To Top
if( $yt->getParam('showBacktotop'))  { ?>
	<a id="yt-totop" class="backtotop" href="#"><i class="fa fa-angle-up"></i> Top </a>
    <script type="text/javascript">
		
		jQuery('.backtotop').click(function () {
			jQuery('body,html').animate({
					scrollTop:0
				}, 1200);
			return false;
		});
    </script>
<?php } ?>
