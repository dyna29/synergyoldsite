 <?php
	$uri =  JFactory::getURI(); 
	$pageURL = $uri->toString();
	//var_dump($pageURL ]); die(); ?>
     
		  <div class="socials" >
			  <h3 class="title">Share this template</h3>
			  
			   <div id="facebook" style="float:left; padding-left:5px; width:80px;">
				<div class="fb-share-button" data-href="<?php echo $pageURL; ?>" data-width="90" data-type="box_count" data-action="share" data-show-faces="true" data-share="true"></div>
				<div id="fb-root"></div>
					 <script>(function(d, s, id) {
							 var js, fjs = d.getElementsByTagName(s)[0];
							 if (d.getElementById(id)) return;
							 js = d.createElement(s); js.id = id;
							 js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
							 fjs.parentNode.insertBefore(js, fjs);
						   }(document, 'script', 'facebook-jssdk'));</script>
					
				</div>
			  
			  
			  <div id="twitter" style="float:left; margin-right: 10px;">
				   <a class="twitter-share-button"
					href="https://twitter.com/share"
				      
				       data-via="your_screen_name"
				       data-text="Checking out this page about the Tweet Button"
				       data-related="twitterdev:Twitter Developer Relations"
				       data-count="vertical">
				     Tweet
				     </a>
				   <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
				   
			</div>
			  <div id="plusone" style="float:left; margin-right: 10px;">
				  			  <!-- Place this tag in your head or just before your close body tag. -->
				<script src="https://apis.google.com/js/platform.js" async defer></script>
				
				<!-- Place this tag where you want the +1 button to render. -->
				<div class="g-plusone" data-size="tall"></div>
			</div>
			  

			 
			<div id="linkedin" style="width:95px; float:left;">
				   <script src="//platform.linkedin.com/in.js" type="text/javascript">
					 lang: en_US
				   </script>
				   <script type="IN/Share" data-counter="top"></script>
			</div>
			
			
			<div id="fbsend" style="float:left; width:60px;">
				<div id="fb-root"></div>
				      <div id="fb-root"></div>
					<script>(function(d, s, id) {
					  var js, fjs = d.getElementsByTagName(s)[0];
					  if (d.getElementById(id)) return;
					  js = d.createElement(s); js.id = id;
					  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
					  fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));</script>
					<div class="fb-send" data-href="https://www.facebook.com/SmartAddons.page?ref=ts&amp;amp;fref=ts" data-width="90" data-colorscheme="light"></div>
				
			</div>
			
			
		 </div>