<?php
/**
 * The template for displaying archive pages
 */
 get_header(); ?>

 	<main class="site-content" role="main" itemscope="itemscope" itemprop="mainContentOfPage"><!-- Main content -->

 	<?php if ( function_exists('chromium_output_page_title') ) chromium_output_page_title(); ?>

 	<?php
 	if ( have_posts() ) :

 		/* Start the Loop */
 		while ( have_posts() ) : the_post();

 			get_template_part( 'template-parts/content', get_post_format() );

 		endwhile;

 		/* Pagination */
 		the_posts_pagination( array(
 			'mid_size' => 2,
 			'prev_text' => '<i class="chromium-icon-arrow-right mirror"></i>',
 			'next_text' => '<i class="chromium-icon-arrow-right"></i>',
 		) );

 	else :

 		get_template_part( 'template-parts/content', 'none' );

 	endif; ?>

 	</main><!-- end of Main content -->

 <?php
 get_sidebar();
 get_footer();
