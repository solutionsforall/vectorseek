<?php  
 /* 
 Template Name: Home 
 */  

 get_header(); 
?>
<div class="live-search-section">
	<?php echo do_shortcode("[wpdreams_ajaxsearchlite]"); ?>
</div>
<div class="grid-heading">
	<h2>
		Download <span>Brands of World Logos</span> in PNG SVG Ai and EPS formats.
	</h2>
</div>
<div class="grid-logos-section">
	<?php echo do_shortcode("[show_home_page_grid]"); ?>
</div>
<div class="logo-categories-section">
	<div class="logo-categories-heading">
		<h2>
		Logo Categories
	</h2>
	</div>
	<div class="logo-categories-list">
		
	</div>
</div>
<?php
 get_footer();

?>