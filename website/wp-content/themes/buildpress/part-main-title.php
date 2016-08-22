<?php

$main_tag = 'h1';

?>
<div class="main-title<?php echo( 'small-title-area' === get_theme_mod( 'main_title_mode', 'big-title-area' ) ? '  main-title--small' : '' ) ?>">
	<div class="container">
		<?php
		$subtitle = false;

		if ( is_home() || ( is_single() && 'post' === get_post_type() ) ) {
			$title    = get_the_title( get_option( 'page_for_posts' ) );
			$subtitle = get_field( 'subtitle', (int) get_option( 'page_for_posts' ) );

			if ( is_single() ) {
				$main_tag = 'h2';
			}
		} elseif ( is_category() ) {
			$title = __( 'Category' , 'buildpress_wp') . ': ' . single_cat_title( '', false );
		} elseif ( is_tag() ) {
			$title = __( 'Tag' , 'buildpress_wp') . ': ' . single_tag_title( '', false );
		} elseif ( is_search() ) {
			$title = __( 'Search Results For' , 'buildpress_wp') . ' &quot;' . get_search_query() . '&quot;';
		} elseif ( is_404() ) {
			$title = __( 'Error 404' , 'buildpress_wp');
		} elseif ( 'portfolio' == get_post_type() ) {
			if ( 'generic-title' === get_theme_mod( 'projects_title_mode', 'generic-title' ) ) {
				$title    = get_theme_mod( 'projects_title', 'Projects' );
			} else {
				$title    = get_the_title();
			}
			$subtitle = get_theme_mod( 'projects_subtitle', 'WHAT WE HAVE DONE SO FAR' );

		} elseif ( is_woocommerce_active() && is_woocommerce() ) {
			ob_start();
			woocommerce_page_title();
			$title    = ob_get_clean();
			$subtitle = get_field( 'subtitle', (int)get_option( 'woocommerce_shop_page_id' ) );

		} else {
			$title    = get_the_title();
			$subtitle = get_field( 'subtitle' );
		}

		?>
		<<?php echo $main_tag; ?> class="main-title__primary"><?php echo $title; ?></<?php echo $main_tag; ?>>

		<?php if ( $subtitle ): ?>
			<h3 class="main-title__secondary"><?php echo $subtitle; ?></h3>
		<?php endif; ?>

	</div>
</div>