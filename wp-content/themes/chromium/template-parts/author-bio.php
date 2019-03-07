<?php /* The template for displaying Author bios */ ?>

<aside class="author-info">

	<h3><?php esc_html_e( 'About Author', 'chromium' ); ?></h3>

	<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'chromium_author_bio_avatar_size', 76 ) ); ?>

	<h4 class="author-title" itemprop="author" itemscope="itemscope" itemtype="http://schema.org/Person">
		<?php echo esc_html( get_the_author() ); ?>
	</h4>

	<div class="author-bio">
		<?php the_author_meta( 'description' ); ?>
	</div>

	<?php printf( '<a class="author-link" rel="author" href="%s" itemprop="url">'.esc_html__( 'More Posts by ', 'chromium').'<span itemprop="name">%s</span><i class="chromium-icon-arrow-right"></i></a>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_html(get_the_author()) ); ?>

</aside>
