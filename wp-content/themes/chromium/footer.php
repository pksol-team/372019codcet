<?php /* The Footer */ ?>
			<footer class="site-footer" role="contentinfo" itemscope="itemscope" itemtype="http://schema.org/WPFooter"><!-- Site's Footer -->

				<?php /* Get footer shortcode if exists */
				$footer_shortcode = get_theme_mod( 'footer_shortcode_section' );
				if ( $footer_shortcode && $footer_shortcode!='' ) {
					echo '<div class="pre-footer-shortcode">'. do_shortcode($footer_shortcode) .'</div>';
				} ?>

				<?php if ( is_active_sidebar( 'footer-sidebar-1' ) || is_active_sidebar( 'footer-sidebar-2' ) || is_active_sidebar( 'footer-sidebar-3' ) || is_active_sidebar( 'footer-sidebar-4' ) ) { ?>
				<aside class="footer-widgets"><!-- Footer's widgets -->
					<div class="widget-area col-1">
						<?php if ( is_active_sidebar( 'footer-sidebar-1' ) ) : ?>
							<?php dynamic_sidebar( 'footer-sidebar-1' ); ?>
						<?php endif; ?>
					</div>
					<div class="widget-area col-2">
						<?php if ( is_active_sidebar( 'footer-sidebar-2' ) ) : ?>
							<?php dynamic_sidebar( 'footer-sidebar-2' ); ?>
						<?php endif; ?>
					</div>
					<div class="widget-area col-3">
						<?php if ( is_active_sidebar( 'footer-sidebar-3' ) ) : ?>
							<?php dynamic_sidebar( 'footer-sidebar-3' ); ?>
						<?php endif; ?>
					</div>
					<div class="widget-area col-4">
						<?php if ( is_active_sidebar( 'footer-sidebar-4' ) ) : ?>
							<?php dynamic_sidebar( 'footer-sidebar-4' ); ?>
						<?php endif; ?>
					</div>
				</aside><!-- end of Footer's widgets -->
				<?php } ?>

				<div class="site-info"><!-- Copyrights -->
					<?php /* Get copyright section text */
					$copy_text = get_theme_mod( 'copyright_section_text' );
					if ( $copy_text && $copy_text!='' ) {
						echo apply_filters( 'chromium-copyright-label', esc_html__('Copyright ', 'chromium') ).'&copy;&nbsp;<span itemprop="copyrightYear">' . date("Y") . '</span>&nbsp;
									<span itemprop="copyrightHolder">' . wp_kses_post($copy_text) . '</span>';
					} else {
						echo '&copy;&nbsp;<span itemprop="copyrightYear">' . date("Y") . '</span>&nbsp;
									<span itemprop="copyrightHolder">Chromium Theme by <a href="//themes.zone" target="_blank" itemprop="url">Themes Zone</a></span>';
					} ?>
				</div><!-- end of Copyrights -->

			</footer><!-- end of Site's Footer -->

		</div><!-- end of Site's Wrapper -->

		<?php wp_footer(); ?>

	</body>
</html>
