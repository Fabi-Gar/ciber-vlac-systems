/**
 * Menú móvil y acordeón de industrias.
 * Vlac Systems
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

	// Buscador de la cabecera: la lupa abre y cierra el desplegable.
	var searchWrap   = document.getElementById( 'navSearch' );
	var searchToggle = document.getElementById( 'searchToggle' );

	if ( searchWrap && searchToggle ) {
		var closeSearch = function () {
			searchWrap.classList.remove( 'open' );
			searchToggle.setAttribute( 'aria-expanded', 'false' );
		};

		searchToggle.addEventListener( 'click', function ( e ) {
			e.stopPropagation();
			var open = searchWrap.classList.toggle( 'open' );
			searchToggle.setAttribute( 'aria-expanded', open ? 'true' : 'false' );

			if ( open ) {
				var field = searchWrap.querySelector( '.vlac-search-input' );
				if ( field ) {
					field.focus();
				}
			}
		} );

		// Cerrar al hacer clic fuera o al pulsar Escape.
		document.addEventListener( 'click', function ( e ) {
			if ( ! searchWrap.contains( e.target ) ) {
				closeSearch();
			}
		} );

		document.addEventListener( 'keydown', function ( e ) {
			if ( 'Escape' === e.key ) {
				closeSearch();
			}
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
