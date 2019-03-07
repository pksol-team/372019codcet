<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
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
if ( !get_theme_mod( 'grid_blog', false ) ) {
	get_sidebar();
}
get_footer();
