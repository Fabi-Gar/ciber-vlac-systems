/**
 * Menú móvil y acordeón de industrias.
 * Ciber Vlac Systems
 */
( function () {
	'use strict';

	var burger  = document.getElementById( 'burger' );
	var panel   = document.getElementById( 'mobilePanel' );

	if ( burger && panel ) {
		burger.addEventListener( 'click', function () {
			var open = panel.classList.toggle( 'open' );
			burger.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
			document.body.classList.toggle( 'lock', open );
		} );

		// Cerrar el panel al hacer clic en cualquier enlace.
		panel.querySelectorAll( 'a' ).forEach( function ( link ) {
			link.addEventListener( 'click', function () {
				panel.classList.remove( 'open' );
				burger.setAttribute( 'aria-expanded', 'false' );
				document.body.classList.remove( 'lock' );
			} );
		} );
	}

	// Acordeones del panel móvil (Aplicaciones, Industrias, …).
	document.querySelectorAll( '.m-acc-head' ).forEach( function ( head ) {
		var body = head.nextElementSibling;
		if ( ! body || ! body.classList.contains( 'm-acc-body' ) ) {
			return;
		}
		head.addEventListener( 'click', function () {
			var open = body.classList.toggle( 'open' );
			head.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
		} );
	} );
} )();
