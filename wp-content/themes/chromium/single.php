<?php
/**
 * The template for displaying all single posts
 */

get_header(); ?>

	<main class="site-content" role="main" itemscope="itemscope" itemprop="mainContentOfPage"><!-- Main content -->

		<?php // Start the Loop.
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', 'single' );

			// Related posts output
			if ( true == get_theme_mod( 'related_posts', true ) ) {
				get_template_part( 'template-parts/related-posts' );
			}

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}

		endwhile; ?>

	</main><!-- end of Main content -->

<?php
get_sidebar();
get_footer();
