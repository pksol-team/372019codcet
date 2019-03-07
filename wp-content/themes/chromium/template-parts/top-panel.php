<?php // Top Panel ?>
	<div class="header-top"><!-- Header top section -->
		<div class="top-widgets-left">
			<?php if ( is_active_sidebar('top-sidebar-left') ) dynamic_sidebar( 'top-sidebar-left' ); ?>
		</div>
		<div class="top-widgets-right">
			<?php if ( is_active_sidebar('top-sidebar-right') ) dynamic_sidebar( 'top-sidebar-right' ); ?>
		</div>
	</div><!-- end of Header top section -->
