<?php
/*
 * Template Name: Post Page
 * Template Post Type: post
 */
  
 get_header();  ?>
<div id="single-posts">
	<?php the_post_thumbnail('full')?>
<div class="vector-post-title">
	<h1><?php the_title();?></h1>
	<?php the_content(); ?>
</div>
</div>
 <?php get_footer(); ?>