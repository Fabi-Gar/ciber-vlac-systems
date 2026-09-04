<?php
/**
 * Página de resultados de búsqueda.
 *
 * El buscador de la cabecera y el del panel móvil llegan aquí. La consulta se
 * limita a páginas y entradas desde vlac_search_only_content() en functions.php,
 * para que no salgan adjuntos ni ruido de la biblioteca de medios.
 *
 * @package Vlac_Systems
 */

get_header();

$vlac_term  = get_search_query();
$vlac_found = (int) $GLOBALS['wp_query']->found_posts;
?>

<style>
	/* Estilos de la página de resultados (ámbito local). */
	#vlac-search-page .sr-hero{position:relative;overflow:hidden;}
	#vlac-search-page .sr-hero::before{content:"";position:absolute;inset:0;z-index:0;background:radial-gradient(700px 380px at 78% 10%,rgba(193,39,45,.07),transparent 60%),linear-gradient(180deg,#fff,var(--bg-alt));}
	#vlac-search-page .sr-hero .wrap{position:relative;z-index:1;padding:56px 24px 44px;}
	#vlac-search-page .sr-hero h1{font-size:clamp(26px,3.6vw,40px);font-weight:800;}
	#vlac-search-page .sr-hero h1 span{color:var(--red);}
	#vlac-search-page .sr-count{color:var(--muted);font-size:15.5px;margin-top:12px;}
	#vlac-search-page .sr-form{margin-top:26px;max-width:560px;}

	#vlac-search-page .sr-list{display:flex;flex-direction:column;gap:16px;}
	#vlac-search-page .sr-item{display:block;background:#fff;border:1px solid var(--line);border-radius:var(--radius);padding:24px 26px;transition:transform .18s ease,box-shadow .18s ease,border-color .18s ease;}
	#vlac-search-page .sr-item:hover{transform:translateY(-3px);box-shadow:var(--shadow-md);border-color:#e0d0d0;}
	#vlac-search-page .sr-kind{display:inline-block;font-family:'Manrope';font-size:11px;font-weight:700;letter-spacing:.09em;text-transform:uppercase;color:var(--red);background:var(--red-soft);border-radius:20px;padding:4px 11px;margin-bottom:11px;}
	#vlac-search-page .sr-item h2{font-size:20px;font-weight:800;color:var(--ink-strong);}
	#vlac-search-page .sr-item p{color:var(--muted);font-size:15px;margin-top:9px;}
	#vlac-search-page .sr-item .sr-go{display:inline-flex;align-items:center;gap:6px;margin-top:14px;font-family:'Manrope';font-weight:700;font-size:14px;color:var(--red);}
	#vlac-search-page .sr-item .sr-go svg{width:15px;height:15px;}

	/* Sin resultados */
	#vlac-search-page .sr-empty{background:#fff;border:1px solid var(--line);border-radius:var(--radius);padding:46px 32px;text-align:center;}
	#vlac-search-page .sr-empty .sr-ic{width:62px;height:62px;border-radius:16px;background:var(--red-soft);display:grid;place-items:center;margin:0 auto 20px;}
	#vlac-search-page .sr-empty .sr-ic svg{width:30px;height:30px;color:var(--red);}
	#vlac-search-page .sr-empty h2{font-size:22px;font-weight:800;}
	#vlac-search-page .sr-empty p{color:var(--muted);font-size:15.5px;margin-top:10px;}
	#vlac-search-page .sr-sugg{margin-top:28px;padding-top:26px;border-top:1px solid var(--line-soft);}
	#vlac-search-page .sr-sugg h3{font-family:'Manrope';font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--muted);margin-bottom:14px;}
	#vlac-search-page .sr-sugg-links{display:flex;flex-wrap:wrap;gap:9px;justify-content:center;}
	#vlac-search-page .sr-sugg-links a{font-size:14px;color:var(--ink);background:var(--bg-alt);border:1px solid var(--line);border-radius:22px;padding:8px 16px;}
	#vlac-search-page .sr-sugg-links a:hover{border-color:var(--red);color:var(--red);}

	/* Paginación de WordPress */
	#vlac-search-page .nav-links{display:flex;flex-wrap:wrap;gap:8px;justify-content:center;margin-top:40px;}
	#vlac-search-page .nav-links .page-numbers{display:grid;place-items:center;min-width:42px;height:42px;padding:0 13px;border:1px solid var(--line);border-radius:10px;background:#fff;color:var(--ink);font-size:14.5px;}
	#vlac-search-page .nav-links .page-numbers:hover{border-color:var(--red);color:var(--red);}
	#vlac-search-page .nav-links .page-numbers.current{background:var(--red);border-color:var(--red);color:#fff;font-weight:700;}
	#vlac-search-page .screen-reader-text{position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0 0 0 0);white-space:nowrap;}

	@media (max-width:900px){
		#vlac-search-page .sr-hero .wrap{padding:42px 24px 34px;}
		#vlac-search-page .sr-item{padding:20px 20px;}
	}
</style>

<div id="vlac-search-page">

	<section class="sr-hero">
		<div class="wrap">
			<div class="sec-kicker"><?php esc_html_e( 'Búsqueda', 'vlac-systems' ); ?></div>
			<?php if ( '' !== $vlac_term ) : ?>
				<h1><?php esc_html_e( 'Resultados para', 'vlac-systems' ); ?> <span>«<?php echo esc_html( $vlac_term ); ?>»</span></h1>
				<p class="sr-count">
					<?php
					printf(
						/* translators: %s: número de resultados encontrados. */
						esc_html( _n( '%s resultado encontrado.', '%s resultados encontrados.', $vlac_found, 'vlac-systems' ) ),
						esc_html( number_format_i18n( $vlac_found ) )
					);
					?>
				</p>
			<?php else : ?>
				<h1><?php esc_html_e( '¿Qué estás buscando?', 'vlac-systems' ); ?></h1>
				<p class="sr-count"><?php esc_html_e( 'Escribe el módulo, la industria o el tema que te interesa.', 'vlac-systems' ); ?></p>
			<?php endif; ?>

			<div class="sr-form"><?php get_search_form(); ?></div>
		</div>
	</section>

	<section class="section">
		<div class="wrap">
			<?php if ( have_posts() ) : ?>

				<div class="sr-list">
					<?php
					while ( have_posts() ) :
						the_post();

						$vlac_type  = get_post_type_object( get_post_type() );
						$vlac_label = $vlac_type ? $vlac_type->labels->singular_name : '';
						?>
						<a class="sr-item" href="<?php the_permalink(); ?>">
							<?php if ( $vlac_label ) : ?>
								<span class="sr-kind"><?php echo esc_html( $vlac_label ); ?></span>
							<?php endif; ?>
							<h2><?php the_title(); ?></h2>
							<?php
							// La mayoría de las páginas del tema no tienen contenido propio
							// (todo va en la plantilla), así que sólo se muestra el extracto
							// cuando realmente hay algo que enseñar.
							$vlac_excerpt = trim( wp_strip_all_tags( get_the_excerpt() ) );
							if ( '' !== $vlac_excerpt ) :
								?>
								<p><?php echo esc_html( wp_trim_words( $vlac_excerpt, 32, '…' ) ); ?></p>
							<?php endif; ?>
							<span class="sr-go">
								<?php esc_html_e( 'Ver la página', 'vlac-systems' ); ?>
								<svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"/></svg>
							</span>
						</a>
						<?php
					endwhile;
					?>
				</div>

				<?php
				the_posts_pagination(
					array(
						'mid_size'  => 2,
						'prev_text' => __( 'Anterior', 'vlac-systems' ),
						'next_text' => __( 'Siguiente', 'vlac-systems' ),
					)
				);
				?>

			<?php else : ?>

				<div class="sr-empty">
					<div class="sr-ic">
						<svg width="30" height="30" viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="1.9"/><path d="M20 20l-3.5-3.5M8.5 11h5" stroke="currentColor" stroke-width="1.9" stroke-linecap="round"/></svg>
					</div>
					<h2><?php esc_html_e( 'No encontramos nada con esa búsqueda', 'vlac-systems' ); ?></h2>
					<p><?php esc_html_e( 'Prueba con otra palabra, o entra directo a una de estas secciones.', 'vlac-systems' ); ?></p>

					<div class="sr-sugg">
						<h3><?php esc_html_e( 'Lo más buscado', 'vlac-systems' ); ?></h3>
						<div class="sr-sugg-links">
							<a href="<?php echo esc_url( home_url( '/facturacion/' ) ); ?>"><?php esc_html_e( 'Facturador FEL', 'vlac-systems' ); ?></a>
							<a href="<?php echo esc_url( home_url( '/inventario/' ) ); ?>"><?php esc_html_e( 'Inventario', 'vlac-systems' ); ?></a>
							<a href="<?php echo esc_url( home_url( '/venta-en-linea/' ) ); ?>"><?php esc_html_e( 'Venta en línea', 'vlac-systems' ); ?></a>
							<a href="<?php echo esc_url( home_url( '/industrias/punto-de-venta/' ) ); ?>"><?php esc_html_e( 'Punto de venta', 'vlac-systems' ); ?></a>
							<a href="<?php echo esc_url( home_url( '/precios/' ) ); ?>"><?php esc_html_e( 'Precios', 'vlac-systems' ); ?></a>
							<a href="<?php echo esc_url( vlac_contact_url() ); ?>"><?php esc_html_e( 'Contacto', 'vlac-systems' ); ?></a>
						</div>
					</div>
				</div>

			<?php endif; ?>
		</div>
	</section>

</div>

<?php
get_footer();
