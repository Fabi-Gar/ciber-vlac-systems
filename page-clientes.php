<?php
/**
 * Template Name: Nuestros clientes
 *
 * Página que muestra la cartera de negocios que confían en Vlac Systems.
 * Los datos se leen de /assets/data/negocios.json a través de
 * vlac_get_businesses() y se pueden filtrar por categoría.
 *
 * Para usarla: crea una página (Páginas → Añadir nueva) con el título
 * «Nuestros clientes» y el slug «clientes», y en «Atributos de página →
 * Plantilla» elige «Nuestros clientes». No necesita contenido.
 *
 * @package Vlac_Systems
 */

get_header();

$vlac_clients = vlac_get_businesses();

// Categorías únicas para los botones de filtro, ordenadas alfabéticamente.
$vlac_cats = array();
foreach ( $vlac_clients as $c ) {
	if ( ! empty( $c['category'] ) ) {
		$vlac_cats[ $c['category'] ] = true;
	}
}
$vlac_cats = array_keys( $vlac_cats );
sort( $vlac_cats );
?>

<style>
	/* Estilos de la página de clientes (ámbito local). */
	.clients-hero{position:relative;overflow:hidden;}
	.clients-hero::before{content:"";position:absolute;inset:0;z-index:0;background:radial-gradient(700px 360px at 82% 0%,rgba(193,39,45,.07),transparent 60%),linear-gradient(180deg,#fff,var(--bg-alt));}
	.clients-hero .wrap{position:relative;z-index:1;padding:66px 24px 40px;text-align:center;}
	.clients-hero .sec-kicker{margin-bottom:14px;}
	.clients-hero h1{font-size:clamp(30px,4vw,46px);font-weight:800;max-width:760px;margin:0 auto;}
	.clients-hero p{color:var(--muted);font-size:17px;margin:16px auto 0;max-width:560px;}
	.clients-stats{display:flex;justify-content:center;gap:34px;flex-wrap:wrap;margin-top:30px;}
	.clients-stat{text-align:center;}
	.clients-stat b{display:block;font-family:'Manrope';font-weight:800;font-size:30px;color:var(--red);line-height:1;}
	.clients-stat span{font-size:13px;color:var(--muted);letter-spacing:.02em;}

	.clients-filters{display:flex;flex-wrap:wrap;gap:10px;justify-content:center;margin:0 auto 40px;padding:0 24px;max-width:var(--maxw);}
	.filter-chip{font-family:'Manrope';font-weight:600;font-size:14px;color:var(--ink);background:#fff;border:1px solid var(--line);border-radius:999px;padding:9px 18px;cursor:pointer;transition:background .15s,color .15s,border-color .15s;}
	.filter-chip:hover{border-color:#cfcfd4;}
	.filter-chip.is-active{background:var(--red);border-color:var(--red);color:#fff;box-shadow:0 6px 16px rgba(193,39,45,.24);}

	.clients-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:20px;padding-bottom:20px;}
	.client-card{display:flex;flex-direction:column;align-items:center;text-align:center;gap:14px;background:#fff;border:1px solid var(--line);border-radius:var(--radius);padding:26px 18px;box-shadow:var(--shadow-sm);transition:transform .18s ease,box-shadow .18s ease,border-color .18s ease;}
	.client-card:hover{transform:translateY(-4px);box-shadow:var(--shadow-md);border-color:#e0d0d0;}
	.client-card[hidden]{display:none;}
	.client-logo{width:96px;height:96px;display:flex;align-items:center;justify-content:center;border-radius:14px;background:var(--bg-alt);border:1px solid var(--line-soft);overflow:hidden;}
	.client-logo img{max-width:74px;max-height:74px;width:auto;height:auto;object-fit:contain;filter:grayscale(1);opacity:.78;transition:filter .2s ease,opacity .2s ease;}
	.client-card:hover .client-logo img{filter:grayscale(0);opacity:1;}
	.client-name{font-family:'Manrope';font-weight:700;font-size:15px;color:var(--ink-strong);line-height:1.25;}
	.client-cat{font-size:12px;color:var(--muted);letter-spacing:.02em;}
	.clients-empty{grid-column:1/-1;text-align:center;color:var(--muted);padding:40px 0;}

	.clients-cta{margin-top:8px;}

	@media (max-width:640px){
		.clients-grid{grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:14px;}
		.clients-stats{gap:22px;}
	}
</style>

<!-- HERO CLIENTES -->
<section class="clients-hero">
	<div class="wrap">
		<div class="sec-kicker"><?php esc_html_e( 'Nuestros clientes', 'vlac-systems' ); ?></div>
		<h1><?php echo esc_html( vlac_opt( 'clients_title', 'Negocios reales que crecen con Vlac Systems' ) ); ?></h1>
		<p><?php echo esc_html( vlac_opt( 'clients_sub', 'De norte a sur del país, cientos de comercios, restaurantes, clínicas y talleres ya facturan y gestionan su operación con nosotros.' ) ); ?></p>

		<div class="clients-stats">
			<div class="clients-stat">
				<b><?php echo esc_html( count( $vlac_clients ) ); ?>+</b>
				<span><?php esc_html_e( 'Negocios activos', 'vlac-systems' ); ?></span>
			</div>
			<div class="clients-stat">
				<b><?php echo esc_html( count( $vlac_cats ) ); ?></b>
				<span><?php esc_html_e( 'Rubros distintos', 'vlac-systems' ); ?></span>
			</div>
			<div class="clients-stat">
				<b>100%</b>
				<span><?php esc_html_e( 'Certificados ante la SAT', 'vlac-systems' ); ?></span>
			</div>
		</div>
	</div>
</section>

<section class="section">
	<?php if ( ! empty( $vlac_clients ) ) : ?>
		<div class="clients-filters" id="clientsFilters" role="tablist" aria-label="<?php esc_attr_e( 'Filtrar clientes por categoría', 'vlac-systems' ); ?>">
			<button type="button" class="filter-chip is-active" data-cat="all"><?php esc_html_e( 'Todos', 'vlac-systems' ); ?></button>
			<?php foreach ( $vlac_cats as $cat ) : ?>
				<button type="button" class="filter-chip" data-cat="<?php echo esc_attr( $cat ); ?>"><?php echo esc_html( $cat ); ?></button>
			<?php endforeach; ?>
		</div>

		<div class="wrap">
			<div class="clients-grid" id="clientsGrid">
				<?php foreach ( $vlac_clients as $client ) : ?>
					<article class="client-card" data-cat="<?php echo esc_attr( $client['category'] ); ?>">
						<div class="client-logo">
							<img src="<?php echo esc_url( $client['logoUrl'] ); ?>" alt="<?php echo esc_attr( $client['name'] ); ?>" loading="lazy" decoding="async" width="74" height="74" />
						</div>
						<div>
							<div class="client-name"><?php echo esc_html( $client['name'] ); ?></div>
							<div class="client-cat"><?php echo esc_html( $client['category'] ); ?></div>
						</div>
					</article>
				<?php endforeach; ?>
				<p class="clients-empty" id="clientsEmpty" hidden><?php esc_html_e( 'No hay clientes en esta categoría.', 'vlac-systems' ); ?></p>
			</div>
		</div>
	<?php else : ?>
		<div class="wrap"><p class="clients-empty"><?php esc_html_e( 'Pronto mostraremos aquí a nuestros clientes.', 'vlac-systems' ); ?></p></div>
	<?php endif; ?>
</section>

<!-- CTA -->
<section class="section" style="padding-top:0;">
	<div class="wrap">
		<div class="cta-strip">
			<h2><?php echo esc_html( vlac_opt( 'clients_cta_title', '¿Listo para sumar tu negocio a la lista?' ) ); ?></h2>
			<p><?php echo esc_html( vlac_opt( 'clients_cta_sub', 'Configura tu marca, activa tu Facturador FEL y empieza a facturar en minutos.' ) ); ?></p>
			<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'cta_btn_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
		</div>
	</div>
</section>

<script>
	( function () {
		var filters = document.getElementById( 'clientsFilters' );
		if ( ! filters ) { return; }
		var cards = Array.prototype.slice.call( document.querySelectorAll( '#clientsGrid .client-card' ) );
		var empty = document.getElementById( 'clientsEmpty' );

		filters.addEventListener( 'click', function ( e ) {
			var btn = e.target.closest( '.filter-chip' );
			if ( ! btn ) { return; }

			filters.querySelectorAll( '.filter-chip' ).forEach( function ( c ) {
				c.classList.remove( 'is-active' );
			} );
			btn.classList.add( 'is-active' );

			var cat = btn.getAttribute( 'data-cat' );
			var visible = 0;
			cards.forEach( function ( card ) {
				var show = ( cat === 'all' || card.getAttribute( 'data-cat' ) === cat );
				card.hidden = ! show;
				if ( show ) { visible++; }
			} );
			if ( empty ) { empty.hidden = visible !== 0; }
		} );
	} )();
</script>

<?php
get_footer();
