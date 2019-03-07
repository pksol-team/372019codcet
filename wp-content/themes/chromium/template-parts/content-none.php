<?php
/**
 * Template part for displaying a message that posts cannot be found.
 */
?>

<header class="page-header">
	<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'chromium' ); ?></h1>
</header>

<div class="page-content">
	<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

	<p><?php esc_html__( 'Ready to publish your first post? ', 'chromium'); ?>
		<a href="<?php echo esc_url(admin_url( 'post-new.php' ));?>"><?php esc_html_e( 'Get started here.', 'chromium' ); ?></a>
	</p>

	<?php elseif ( is_search() ) : ?>

	<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'chromium' ); ?></p>
	<?php get_search_form(); ?>

	<?php else : ?>

	<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'chromium' ); ?></p>
	<?php get_search_form(); ?>

	<?php endif; ?>
</div>
