<?php
/**
 * The template for displaying all pages
 */

get_header(); ?>

		<?php /* Additional Shortcode section for front Page */
		$frontpage_shortcode = get_theme_mod('frontpage_shortcode', '');
		if ( $frontpage_shortcode!='' && is_front_page() ) {
			echo '<div class="front-page-shortcode">'.do_shortcode($frontpage_shortcode).'</div>';
		} ?>
		
		<main class="site-content" role="main" itemscope="itemscope" itemprop="mainContentOfPage">

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->

<?php
get_sidebar();
get_footer();
