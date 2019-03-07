<?php // Logo & Hgroup Sidebar ?>

	<div class="site-branding"><!-- Logo & hgroup -->

		<?php /* Get logo image */
		 $custom_logo_id = get_theme_mod( 'custom_logo' );
		 if ($custom_logo_id && $custom_logo_id!='') : ?>
			<div class="site-logo" itemscope itemtype="http://schema.org/Organization">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" title="<?php esc_attr( bloginfo( 'name' ) );?>" itemprop="url">
						<?php echo wp_get_attachment_image( $custom_logo_id , 'full', array('itemprop' => 'logo' ) ); ?>
					</a>
			</div>
		<?php else : /* Output Text Logo */ ?>
			<div class="header-group">
				<?php
				if ( is_front_page() && is_home() ) : ?>
					<h1 class="site-title" itemprop="headline">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" rel="home" itemprop="url">
								<?php esc_html_e( get_bloginfo( 'name' ) ); ?>
							</a>
					</h1>
				<?php else : ?>
					<p class="site-title" itemprop="headline">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" rel="home" itemprop="url">
								<?php esc_html_e( get_bloginfo( 'name' ) ); ?>
							</a>
					</p>
				<?php endif;
				$description = get_bloginfo( 'description', 'display' );
				if ( $description || is_customize_preview() ) : ?>
					<p class="site-description"><?php echo esc_html($description); /* WPCS: xss ok. */ ?></p>
				<?php
				endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( is_active_sidebar( 'hgroup-sidebar' ) ) : ?>
				<div class="hgroup-sidebar">
						<?php dynamic_sidebar( 'hgroup-sidebar' ); ?>
				</div>
		<?php endif; ?>

		<?php if (has_nav_menu( 'logo-group-nav' )) : ?>
			<nav id="logo-navigation" class="logo-group-nav logo-navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'chromium' ); ?></button>
                <a class="screen-reader-text skip-link" href="#content"><?php esc_html_e( 'Skip to content', 'chromium' ); ?></a>
				<?php wp_nav_menu( array('theme_location'  => 'logo-group-nav') ); ?>
			</nav>
		<?php endif; ?>

	</div><!-- end of Logo & hgroup -->
