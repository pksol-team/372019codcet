<?php
/**
 * Template part for displaying article's header
 */
?>
	<header class="entry-header"><!-- Article's Header -->
		<?php $title = get_the_title();
			if ( empty($title) || $title = '' ) { ?>
				<h1 class="entry-title" itemprop="headline">
					<meta itemprop="mainEntityOfPage" content="<?php esc_url(the_permalink()); ?>">
					<a href="<?php esc_url(the_permalink()); ?>" title="<?php esc_attr_e( 'Click here to read more', 'chromium' ); ?>" rel="bookmark" itemprop="url"><?php esc_html_e( 'Click here to read more', 'chromium' ); ?></a>
				</h1>
			<?php } else {
				echo '<meta itemprop="mainEntityOfPage" content="'.esc_url(get_permalink()).'">';
				the_title( '<h1 class="entry-title" itemprop="headline"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" itemprop="url">', '</a></h1>' );
		} ?>
        <div class="entry-header-meta">
			<?php
			// Author
			if ( function_exists('chromium_entry_author') && (false == get_theme_mod( 'blog_hide_author', false )) ) { chromium_entry_author(); }
			// Date
			if ( function_exists('chromium_entry_publication_time') && (false == get_theme_mod( 'blog_hide_date', false )) ) { chromium_entry_publication_time(); }
			// Edit link
			edit_post_link(sprintf( __( 'Edit<span class="screen-reader-text"> "%s"</span>', 'chromium' ), esc_html(get_the_title()) ), '<span class="edit-link">','</span>' );
			?>
        </div>
	</header><!-- end of Article's Header -->
