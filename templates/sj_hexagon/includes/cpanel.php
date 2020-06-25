<?php 
/*
 * ------------------------------------------------------------------------
 * Copyright (C) 2009 - 2014 The YouTech JSC. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: The YouTech JSC
 * Websites: http://www.smartaddons.com - http://www.cmsportal.net
 * ------------------------------------------------------------------------
*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<div id="cpanel_wrapper" style="direction:ltr" class="hidden-xs">
    <div class="accordion" id="ytcpanel_accordion">
        <div class="cpanel-head">
			Template Settings
			<div class="cpanel-reset">
				<a class="btn btn-info" href="#" onclick="javascript: onCPResetDefault(TMPL_COOKIE);" ><i class="fa fa-refresh fa-spin"></i> Reset</a>
			</div>
		</div>
		
    	<!--Body-->
        <div class="cpanel-theme">
           
          
                <!-- Style Color -->
				<div class="panel-group">
                    <h4 class="panel-heading">Theme Colors</h4>
                  
                    <div class="panel-theme-color">
						<span data-placement="top" title="Blue"    class="theme-color blue<?php echo ($templateColor=='blue')?' active':'';?>">Blue</span>
						<span data-placement="top" title="Red"     class="theme-color red<?php echo ($templateColor=='red')?' active':'';?>">Red</span>
						<span data-placement="top" title="Oranges" class="theme-color oranges<?php echo ($templateColor=='oranges')?' active':'';?>">Oranges</span>
						<span data-placement="top" title="Emerald"   class="theme-color emerald<?php echo ($templateColor=='emerald')?' active':'';?>">Emerald</span>
						
                    </div>
				</div>
				
                <!-- Layouts -->
				<div class="panel-group nomarginbottom">
					<h4 class="panel-heading">Layout</h4>
					<!-- Layout Style -->
					<div class="panel-layout typeLayout">
						
							<select onchange="javascript: onCPApply();" name="ytcpanel_typelayout" class="cp_select">
								<option value="wide"<?php echo ($typelayout=='wide')?' selected="selected"':'';?>>Wide</option>
								<option value="boxed"<?php echo ($typelayout=='boxed')?' selected="selected"':'';?>>Boxed</option>
							</select>
						
					</div>
				</div>
				
				<div class="panel-group nomarginbottom">
					<div class="panel-desc" style="margin:10px 0 3px;"> Patterns for Layout Style: Boxed </div>
					<div class="body-bg">
					<?php
					$path = JPATH_ROOT.'/templates/'.$yt->template.'/images/pattern/body';
					$files = JFolder::files($path, '.'); 
					foreach($files as $file) {
						$file = JFile::stripExt($file); ?>
						<a href="#" data-placement="top" title="<?php echo $file; ?>" class="pattern <?php echo $file; ?><?php echo ($yt->getParam('bgimage')==$file)?' active':''?>"><?php echo $file; ?></a>
						<?php
					}
					?>
					</div>
					<input type="hidden" name="ytcpanel_bgimage" value="<?php echo $yt->getParam('bgimage'); ?>"/>
						
				</div>
			
        </div>
        
       
       
      
    </div>
	
  
    <div id="cpanel_btn" class="isDown">
        <i class="fa fa-wrench"></i>
    </div>
	
</div>