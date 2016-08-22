/* global define, Modernizr, BuildPressVars */
/**
 * Sticky navbar
 */

define( ['jquery', 'underscore'], function ( $, _ ) {
	'use strict';

	// just use the JS below if the sticky navbar is turned on
	if ( ! BuildPressVars.stickyNavbar ) {
		return;
	}

	// flag var, null for the start before we test
	var matched = null,
		adminBarHeight = $( 'body' ).hasClass( 'admin-bar' ) ? 32 : 0,
		stickyOffset   = $( '.js-sticky-offset' ).offset().top;

	// add sticky navbar events and classes
	var addStickyNavbar = function () {
		$( window).on( 'scroll.stickyNavbar', _.throttle( function() {
			$( 'body' ).toggleClass( 'is-sticky-navbar', $( window ).scrollTop() > ( stickyOffset - adminBarHeight ) );
		}, 20 ) ); // only trigered once every 20ms = 50 fps = very cool for performance
	};

	// cleanup for events and classes
	var removeStickyNavbar = function () {
		$( window ).off( 'scroll.stickyNavbar' );
		$( 'body' ).removeClass( 'is-sticky-navbar' );
	};

	// helper functions to determine if the screen width is wide enought to shown sticky navbar
	var	screenLargeEnough = function () {
		return Modernizr.mq( 'screen and (min-width: 992px)' );
	};

	// first init
	if ( null === matched ) {
		matched = screenLargeEnough();
		if ( matched ) {
			addStickyNavbar();
			$( window).trigger( 'scroll.stickyNavbar' );
		}
	}

	// event listener on the window resizing
	$( window ).on( 'resize', _.debounce( function() {
		// update sticky offset
		stickyOffset = $( '.js-sticky-offset' ).offset().top;

		// check if the sticky navbar should be contrusted or cleaned-up
		if ( ! matched && screenLargeEnough() ) {
			addStickyNavbar();
			matched = true;
			$( window).trigger( 'scroll.stickyNavbar' );
		}	else if ( matched && ! screenLargeEnough() ) {
			removeStickyNavbar();
			matched = false;
		}
	}, 40 ) );
} );