<?php
/**
 * Compatibility hooks for BuildPress WP theme.
 *
 * For 3rd party plugins/features.
 *
 * @package BuildPress
 */


/**
 * Add custom row styles to the Page Builder
 *
 * @param  array $styles
 * @return array
 */
function pt_panels_row_styles( $styles ) {
	$styles['wide-no-container'] = _x( 'Wide (No Container)', 'backend', 'buildpress_wp' );
	$styles['wide-color']        = _x( 'Wide Solid Background Color', 'backend', 'buildpress_wp' );
	$styles['wide-color-dark']   = _x( 'Wide Solid Background Dark Color', 'backend', 'buildpress_wp' );
	$styles['wide-pattern']      = _x( 'Wide Pattern Background', 'backend', 'buildpress_wp' );
	$styles['wide-image']        = _x( 'Wide Image Background', 'backend', 'buildpress_wp' );
	return $styles;
}
add_filter( 'siteorigin_panels_row_styles', 'pt_panels_row_styles', 10, 1 );



/**
 * Add custom row styles to the Page Builder
 *
 * @param  string $default
 * @param  array $row_data
 * @return string
 */
function pt_panels_before_row( $default, $row_data ) {
	if ( in_array( 'wide-no-container', $row_data[ 'style' ] ) ) {
		return '</div>';
	}
	else if ( in_array( 'wide-color', $row_data[ 'style' ] ) ) {
		return '</div>
			<div class="wide-color"><div class="container">';
	}
	else if ( in_array( 'wide-color-dark', $row_data[ 'style' ] ) ) {
		return '</div>
			<div class="wide-color-dark"><div class="container">';
	}
	else if ( in_array( 'wide-pattern', $row_data[ 'style' ] ) ) {
		return '</div>
			<div class="wide-pattern"><div class="container">';
	}
	else if ( in_array( 'wide-image', $row_data[ 'style' ] ) ) {
		return '</div>
			<div class="wide-image"><div class="container">';
	}
	else {
		return $default;
	}
}
add_filter( 'siteorigin_panels_before_row', 'pt_panels_before_row', 10, 2 );



/**
 * Add custom row styles to the Page Builder
 *
 * @param  string $default
 * @param  array $row_data
 * @return string
 */
function pt_panels_after_row( $default, $row_data ) {
	if ( in_array( 'wide-no-container', $row_data[ 'style' ] ) ) {
		return '<div class="container">';
	}
	else if (
		in_array( 'wide-color', $row_data[ 'style' ] ) ||
		in_array( 'wide-color-dark', $row_data[ 'style' ] ) ||
		in_array( 'wide-pattern', $row_data[ 'style' ] ) ||
		in_array( 'wide-image', $row_data[ 'style' ] )
	) {
		return '</div></div>
			<div class="container">';
	}
	else {
		return $default;
	}
}
add_filter( 'siteorigin_panels_after_row', 'pt_panels_after_row', 10, 2 );



/**
 * Remove the default Page Builder widgets
 */
remove_action( 'widgets_init', 'siteorigin_panels_widgets_init' );
remove_action( 'widgets_init', 'origin_widgets_init' );



/**
 * Add custom separator as an option for the Breadcrumbs NavXT plugin when the plugin is activated
 */
if ( ! function_exists( 'pt_custom_hseparator' ) ) {
	function pt_custom_hseparator() {
		add_option( 'bcn_options', array( 'hseparator' => '' ) );
	}
	add_action( 'activate_breadcrumb-navxt/breadcrumb-navxt.php', 'pt_custom_hseparator', 90 );
}



/**
 * Change post type labels and arguments for Portfolio Post Type plugin.
 *
 * @param array $args Existing arguments.
 *
 * @return array Amended arguments.
 */
if ( ! function_exists( 'pt_change_portfolio_labels' ) ) {
	function pt_change_portfolio_labels( array $args ) {
		$labels = array(
			'name'               => _x( 'Projects', 'backend', 'buildpress_wp' ),
			'singular_name'      => _x( 'Project', 'backend', 'buildpress_wp' ),
			'add_new'            => _x( 'Add New Item', 'backend', 'buildpress_wp' ),
			'add_new_item'       => _x( 'Add New Project', 'backend', 'buildpress_wp' ),
			'edit_item'          => _x( 'Edit Project', 'backend', 'buildpress_wp' ),
			'new_item'           => _x( 'Add New Project', 'backend', 'buildpress_wp' ),
			'view_item'          => _x( 'View Item', 'backend', 'buildpress_wp' ),
			'search_items'       => _x( 'Search Projects', 'backend', 'buildpress_wp' ),
			'not_found'          => _x( 'No projects found', 'backend', 'buildpress_wp' ),
			'not_found_in_trash' => _x( 'No projects found in trash', 'backend', 'buildpress_wp' ),
		);
		$args['labels'] = $labels;

		// Update project single permalink format, and archive slug as well.
		$args['rewrite']     = array( 'slug' => get_theme_mod( 'projects_slug', 'project' ) );
		$args['has_archive'] = false;
		// Don't forget to visit Settings->Permalinks after changing these to flush the rewrite rules.

		return $args;
	}
	add_filter( 'portfolioposttype_args', 'pt_change_portfolio_labels' );
}



/**
 * Essential Grid - disable the notice for purchase code
 */
if ( ! BUILDPRESS_DEVELOPMENT && function_exists( 'set_ess_grid_as_theme' ) ) {
	define( 'ESS_GRID_AS_THEME', true );
	set_ess_grid_as_theme();
}