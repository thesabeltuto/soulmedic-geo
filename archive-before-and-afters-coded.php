<?php

// Start session
session_start();

// Base URIs
$gallery_full_url = "http://". $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$url_part = parse_url($gallery_full_url);
$url_host = $url_part['host'];
$url_path = $url_part['path'];
$gallery_base_url = "http://". $url_part['host'] . $url_part['path'];

// Defaults
$required_field_style = '';
$required_field_message = '';
$required_message = '';
$page_anchor = '#page_content';

// If user requested to get out of the gallery (gallery content to be restriceted again), 
// unset the session and redirect user again to the gallery in order for ended session 
// to officially take effect and not let user view the content even if clicking the browser's back button.
$page = (isset($_GET['page'])) ? $_GET['page'] : '';
switch ($page)
{
	case 'resetgallerysession':
		$page_name = '';
		if(isset($_SESSION['gallery_acceptance'])) 
		{
			unset($_SESSION['gallery_acceptance']);
			header("Location: $url_path");
		}
		break;
}

if($_POST) 
{
	// Create session (user successfully accepted to view the gallery)
	if($_POST['accept'] == 'accept') 
	{
		$_SESSION['gallery_acceptance'] = array(
			'accept' => $_POST['accept']
		);
	}
	// If the JavaScript were to be bypassed, we still have a PHP verification as fallback
	// Highlight the required field(s), if the submit button was clicked on but required field(s) left blank / checkbox left unchecked.
	if( !isset($_SESSION['gallery_acceptance']) )
	{
		$required_field_style = ' class="error_required" style="color:#f00;"';
		$required_field_message = '<span' . $required_field_style . '>&larr; This is a required field</span>';
		$required_message = '<span' . $required_field_style . '>There was a problem with your submission. Errors have been highlighted below. Check required fields.</span>';
	}
}


get_header(); 
?>
<script>
(function($) {	
	$(document).ready(function() {
		var breadcrumb = '<a href="/">Home</a><span class="fa fa-angle-double-right">  </span><h1>Before And Afters</h1>';
		$('div.breadcrumb').html(breadcrumb);
	});
})(jQuery);
					
</script>


<?php $page_layout 	= dttheme_option('specialty','archives-layout');
  	  $page_layout 	= !empty($page_layout) ? $page_layout : "with-right-sidebar";
	  
	  $post_layout 	= dttheme_option('specialty','archives-post-layout'); 
	  $post_layout 	= !empty($post_layout) ? $post_layout : "one-column";
	  
	  $show_sidebar = false;
	  $sidebar_class = "";
	  $post_class = "";
	  $columns = NULL;
	  
	#TO SET PAGE LAYOUT
	switch($page_layout):
		case 'with-left-sidebar':
			$page_class = $page_layout;
			$show_sidebar = true;
			$sidebar_class = "with-sidebar left-sidebar";
		break;

		case 'with-right-sidebar':
			$show_sidebar = true;
			$sidebar_class = "with-sidebar right-sidebar";
		break;
	endswitch;
	
	#TO SET POST LAYOUT
	switch($post_layout):
		case 'one-column':
			$post_class = " column dt-sc-one-column ";
		break;
		
		case 'one-half-column';
			$post_class = " column dt-sc-one-half";
			$columns = 2;
		break;
		
		case 'one-third-column':
			$post_class = " column dt-sc-one-third ";
			$columns = 3;
		break;
	endswitch;?>
    
    
    <? //if the user has agreed to view the gallery
if(isset($_SESSION['gallery_acceptance'])) 
{
?>
      <!-- **Primary Section** -->
      <section id="primary" class="before-and-afters <?php echo $page_layout;?>">
      
		<?php if(get_option('wm4d_before_afters') != '' || get_option('wm4d_before_afters') != null) { ?>
            <article id="post-before-and-afters" <?php post_class('blog-entry'); ?>>
                <div class="blog-entry-inner">
                	<div class="entry-details">
                        <div class="entry-title"><h4>Before and Afters</h4></div>
                        <div class="entry-body"><?php echo do_shortcode(get_option('wm4d_before_afters')); ?></div>
                    </div>
                </div>
            </article>
		<?php } ?>
      
<?php	if( have_posts() ):
			$i = 1;
			while( have_posts() ):
				the_post();
				
				$temp_class = "";
				if($i == 1) $temp_class = $post_class." first"; else $temp_class = $post_class;
				if($i == $columns) $i = 1; else $i = $i + 1;?>
                
                <div class="<?php echo $temp_class;?>">
                	<!-- #post-<?php the_ID()?> starts -->
                    <a name="page_content"></a>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('blog-entry'); ?>>
                    	<!-- .blog-entry-inner -->
                        <div class="blog-entry-inner">
                                                    
                            <!-- .entry-details -->
                            <div class="entry-details">
                            	<?php if(is_sticky()): ?>
                                		<div class="featured-post"> <span class="fa fa-trophy"> </span> <?php _e('Featured','dt_themes');?></div>
                                <?php endif;?>
                                
                                <!-- .entry-title -->
                                <div class="entry-title">
                                	<h4><?php the_title();?></h4>
<?php /*?>                                	<h4><a href="<?php the_permalink();?>" title="<?php printf(esc_attr__('%s'),the_title_attribute('echo=0'));?>"><?php the_title();?></a></h4>
<?php */?>                                </div><!-- .entry-title -->
                                                                
                                <div class="entry-body"><?php the_content();?></div>
                                
                            
                            </div><!-- .entry-details -->
                            
                        </div><!-- .blog-entry-inner -->
                    </article><!-- #post-<?php the_ID()?> Ends -->
                </div>
<?php		endwhile;
		endif;?>
                   
           <!-- **Pagination** -->
           <div class="pagination">
                <div class="prev-post"><?php previous_posts_link('<span class="fa fa-angle-double-left"></span> Prev');?></div>
                <?php echo dttheme_pagination();?>
                <div class="next-post"><?php next_posts_link('Next <span class="fa fa-angle-double-right"></span>');?></div>
           </div><!-- **Pagination - End** -->
       
      </section><!-- **Primary Section** -->


<?php 
}else{ //if user has not agreed to view the gallery
?>      
      
      
      
      <!-- **Primary Section** -->
      <section id="primary" class="before-and-afters <?php echo $page_layout;?>">
      <p>To view the images in this Gallery, please agree to the disclaimer below:</p>

						<script type="text/javascript">
						var baa_gallery_access = jQuery.noConflict();
						
						baa_gallery_access(document).ready(function(){
						
							baa_gallery_access('#baa_gallery_access_disclaimer').css('color', '#f00');
							baa_gallery_access('#baa_gallery_access #submit').css('color', '#999').attr('disabled', 'disabled');
							baa_gallery_access('#baa_gallery_access #submit').attr('value', "You must first agree");
						
							baa_gallery_access('#baa_gallery_access #accept').change(function(){
						
								var disclaimer_color = this.checked ? '#333' : '#f00';
								baa_gallery_access('#baa_gallery_access_disclaimer,#baa_gallery_access #submit').css('color', disclaimer_color);
						
								var button_color = this.checked ? '#333' : '#999';
								baa_gallery_access('#baa_gallery_access #submit').css('color', button_color);
						
								document.baa_gallery_access.submit.disabled = !document.baa_gallery_access.submit.disabled;

								var button_text = this.checked ? "Continue" : "You must first agree";
								baa_gallery_access('#baa_gallery_access #submit').attr('value', button_text);
						
							});
						
						})(jQuery);
						</script>

						<?php if($required_message) echo $required_message; ?>
						<div style="border: 1px dotted #cccccc; background: #ffffcc; padding: 20px 20px 0 20px;">
								<div id="baa_gallery_access_disclaimer">I understand that the images in our gallery page are results of breast surgeries performed by Dr. Rosenbaum. These images are copyrighted and may not be reproduced or redistributed.</div>
							<form id="baa_gallery_access" name="baa_gallery_access" action="<?php echo $url_path; if($page_anchor) echo $page_anchor; ?>" method="post">
							<div id="login_form_test">
								<div class="field<?php echo $wrong_accept_class; ?>">
									<input type="checkbox" id="accept" name="accept" value="accept" /> I agree 
									<?php if($required_field_message) echo $required_field_message; ?>
								</div>
								<div class="field acenter">
									<input type="submit" name="submit" id="submit" value="Continue" />
								</div>
							</div>
							</form>
						</div>
       
      </section><!-- **Primary Section** -->
      
      
      <?php 
} //END if user has not agreed to view the gallery 
?>



        
<?php if($show_sidebar): ?>
	  <!-- **Secondary Section ** -->
      <section id="secondary" class="<?php echo $sidebar_class; ?>">
<?php 	get_sidebar();?>      
      </section><!-- **Secondary Section - End** -->
<?php endif; ?>
          
<?php get_footer();?>