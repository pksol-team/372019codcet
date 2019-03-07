<?php /* The template for displaying 404 pages (Not Found) */
get_header(); ?>

		<main class="site-content" role="main" itemscope="itemscope" itemprop="mainContentOfPage"><!-- Main content -->

			<?php if ( function_exists('chromium_output_page_title') ) chromium_output_page_title(); ?>

			<span class="subtitle"><?php esc_html_e( "This page is not found", 'chromium' ); ?></span>

			<p><?php esc_html_e( "Sorry but the page you are looking for doesn't exist.", 'chromium' ); ?></p>

			<?php get_search_form(); ?>

			<a class="home-link" href="<?php echo esc_url( get_home_url() ); ?>" title="<?php esc_attr_e('Go back to Home Page', 'chromium'); ?>" rel="home">
				<i class="chromium-icon-arrow-right mirror"></i><?php esc_html_e('Go back to home page', 'chromium'); ?>
			</a>

		</main><!-- end of Main content -->

		<?php get_sidebar();?>

<?php get_footer(); ?>
