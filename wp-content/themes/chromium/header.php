<?php /* The Header */ ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php endif; ?>
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>

		<div id="page" class="site"><!-- Site's Wrapper -->

			<header class="site-header"><!-- Site's Header -->

				<?php /* Top panel */
				if ( true == get_theme_mod( 'header_top_panel', true ) && (is_active_sidebar('top-sidebar-left') || is_active_sidebar('top-sidebar-right')) ) {
					get_template_part( 'template-parts/top-panel' );
				} ?>

				<?php /* Logo group */
					get_template_part( 'template-parts/logo-group' );
				?>

				<?php if (has_nav_menu( 'primary-nav' )) :
					$nav_class = '';
					if ( true == get_theme_mod('primary_nav_widgets', false) && (is_active_sidebar('primary-nav-widgets')) ) {
						$nav_class = ' with-widgets';
						if ( 'left' == get_theme_mod('primary_nav_widgets_position', 'right') ) {
							$nav_class .= ' reversed';
						}
					} ?>
					<nav id="site-navigation" class="main-navigation primary-nav<?php echo esc_attr($nav_class); ?>" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" role="navigation"><!-- Primary nav -->
						<a class="screen-reader-text skip-link" href="#content"><?php esc_html_e( 'Skip to content', 'chromium' ); ?></a>
						<?php if ( true == get_theme_mod('primary_nav_widgets', false) && (is_active_sidebar('primary-nav-widgets')) ) { echo '<div class="primary-nav-wrapper">'; } ?>
                        <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'chromium' ); ?></button>
                        <?php
                        wp_nav_menu( array('theme_location'  => 'primary-nav') );
                        ?>
						<?php if ( true == get_theme_mod('primary_nav_widgets', false) && (is_active_sidebar('primary-nav-widgets')) ) { ?>
							<aside id="sidebar-nav" class="widget-area nav-sidebar" role="complementary">
								<?php dynamic_sidebar( 'primary-nav-widgets' ); ?>
							</aside>
						<?php } ?>
						<?php if ( true == get_theme_mod('primary_nav_widgets', false) && (is_active_sidebar('primary-nav-widgets')) ) { echo '</div>'; } ?>
					</nav><!-- end of Primary nav -->
				<?php endif; ?>
			</header><!-- end of Site's Header -->

			<?php // Breadcrumbs by Yoast
				if ( function_exists('chromium_yoast_breadcrumbs') && function_exists('yoast_breadcrumb') ) { chromium_yoast_breadcrumbs(); }
			?>
