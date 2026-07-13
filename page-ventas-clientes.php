<?php
/**
 * Template Name: Ventas y Clientes
 *
 * Página de producto del módulo de Gestión de Ventas y Clientes.
 * Muestra el manejo de clientes (listado, ficha, direcciones y contactos)
 * y las capacidades de ventas (órdenes, cajas, productos, reportes).
 *
 * VIDEO (opcional, guárdalo en /assets/video/ con este nombre):
 *   clientes.mp4  → recorrido: listado → ficha → direcciones y contactos
 * Mientras no exista, se muestra un marcador en su lugar.
 *
 * Para usarla: crea una página (Páginas → Añadir nueva) con el título
 * «Ventas y Clientes» y el slug «ventas-clientes», y en «Atributos de
 * página → Plantilla» elige «Ventas y Clientes». No necesita contenido.
 *
 * @package Vlac_Systems
 */

get_header();

$img     = get_template_directory_uri() . '/assets/img';
$img_dir = get_template_directory() . '/assets/img/';
$vid_url = get_template_directory_uri() . '/assets/video';
$vid_dir = get_template_directory() . '/assets/video/';

$cli_has_mp4   = file_exists( $vid_dir . 'clientes.mp4' );
$cli_has_webm  = file_exists( $vid_dir . 'clientes.webm' );
$cli_has_video = $cli_has_mp4 || $cli_has_webm;
$cli_poster    = file_exists( $img_dir . 'clientes.png' ) ? $img . '/clientes.png' : '';

// Renderiza una captura enmarcada (o un marcador si el archivo no existe).
$vc_shot = function ( $file, $caption ) use ( $img, $img_dir ) {
	$exists = file_exists( $img_dir . $file );
	echo '<figure class="vc-shot"><div class="vc-frame"><div class="bar"><i></i><i></i><i></i></div>';
	if ( $exists ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $img . '/' . $file ), esc_attr( $caption ) );
	} else {
		printf( '<div class="vc-shot-ph">Coloca la imagen<br><code>assets/img/%s</code></div>', esc_html( $file ) );
	}
	echo '</div>';
	if ( $caption ) {
		printf( '<figcaption>%s</figcaption>', esc_html( $caption ) );
	}
	echo '</figure>';
};
?>

<style>
	/* Estilos de la página de Ventas y Clientes (ámbito local). */
	#vc-page{--vc-green:#2e9e5b;}

	/* HERO */
	#vc-page .vc-hero{position:relative;overflow:hidden;}
	#vc-page .vc-hero::before{content:"";position:absolute;inset:0;z-index:0;background:radial-gradient(700px 380px at 82% 8%,rgba(193,39,45,.07),transparent 60%),linear-gradient(180deg,#fff,var(--bg-alt));}
	#vc-page .vc-hero .hero-grid{position:relative;z-index:1;display:grid;grid-template-columns:1fr 1.12fr;gap:48px;align-items:center;padding:66px 0 84px;}
	#vc-page .vc-hero h1{font-size:clamp(32px,4.4vw,50px);font-weight:800;}
	#vc-page .vc-hero .lead{color:var(--muted);font-size:18px;margin:20px 0 8px;max-width:520px;}
	#vc-page .vc-hero .hero-cta{display:flex;gap:14px;flex-wrap:wrap;margin-top:28px;}
	#vc-page .vc-hero .hero-note{display:flex;align-items:center;gap:8px;font-size:13.5px;color:var(--muted);margin-top:22px;}
	#vc-page .vc-hero .hero-note svg{width:16px;height:16px;color:var(--vc-green);}

	/* MARCO DE PANTALLA (estilo navegador) */
	#vc-page .vc-frame{background:#fff;border:1px solid #d9d9de;border-radius:14px;overflow:hidden;box-shadow:var(--shadow-lg);}
	#vc-page .vc-frame .bar{display:flex;align-items:center;gap:6px;padding:9px 12px;background:#f3f3f5;border-bottom:1px solid #e6e6ea;}
	#vc-page .vc-frame .bar i{width:10px;height:10px;border-radius:50%;background:#d6d6dc;display:block;}
	#vc-page .vc-frame .bar .url{margin-left:8px;background:#fff;border:1px solid #e6e6ea;border-radius:6px;font-size:11px;color:var(--muted);padding:4px 12px;flex:1;font-family:'Inter';}
	#vc-page .vc-frame video,#vc-page .vc-frame img{width:100%;height:auto;display:block;background:#000;}
	/* Marcador mientras no hay video */
	#vc-page .vc-ph{aspect-ratio:16/10;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;text-align:center;background:var(--bg-alt);color:var(--muted);padding:24px;}
	#vc-page .vc-ph svg{width:46px;height:46px;color:#c9c9d0;}
	#vc-page .vc-ph b{font-family:'Manrope';font-weight:700;color:var(--ink-strong);font-size:15px;}
	#vc-page .vc-ph code{font-size:13px;color:var(--red-dark);background:var(--red-soft);padding:4px 10px;border-radius:6px;}

	/* PASOS DE CLIENTES */
	#vc-page .vc-steps{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;}
	#vc-page .vc-step{position:relative;background:#fff;border:1px solid var(--line);border-radius:var(--radius);padding:28px 22px;transition:transform .18s ease,box-shadow .18s ease,border-color .18s ease;}
	#vc-page .vc-step:hover{transform:translateY(-4px);box-shadow:var(--shadow-md);border-color:#e0d0d0;}
	#vc-page .vc-step .vc-ic{width:52px;height:52px;border-radius:13px;background:var(--red-soft);display:grid;place-items:center;margin-bottom:18px;}
	#vc-page .vc-step .vc-ic svg{width:26px;height:26px;color:var(--red);}
	#vc-page .vc-step h3{font-size:17px;font-weight:700;margin-bottom:8px;}
	#vc-page .vc-step p{color:var(--muted);font-size:14.5px;}

	/* SHOWCASE DE CAPTURAS */
	#vc-page .vc-shots{display:grid;grid-template-columns:repeat(2,1fr);gap:26px;}
	#vc-page .vc-shot{margin:0;}
	#vc-page .vc-shot .vc-frame{box-shadow:var(--shadow-md);}
	#vc-page .vc-shot figcaption{margin-top:14px;font-family:'Manrope';font-weight:600;font-size:15px;color:var(--ink-strong);text-align:center;}
	#vc-page .vc-shot-ph{padding:52px 20px;text-align:center;color:var(--muted);font-size:14px;background:var(--bg-alt);}
	#vc-page .vc-shot-ph code{display:inline-block;margin-top:8px;font-size:13px;color:var(--red-dark);background:var(--red-soft);padding:4px 10px;border-radius:6px;}

	@media (max-width:900px){
		#vc-page .vc-hero .hero-grid{grid-template-columns:1fr;gap:34px;padding:52px 0 56px;}
		#vc-page .vc-steps{grid-template-columns:1fr;}
		#vc-page .vc-shots{grid-template-columns:1fr;}
	}
</style>

<div id="vc-page">

	<!-- HERO -->
	<section class="vc-hero">
		<div class="wrap">
			<div class="hero-grid">
				<div class="hero-copy">
					<span class="eyebrow"><span class="dot"></span> <?php echo esc_html( vlac_opt( 'vc_eyebrow', 'Ventas y Clientes' ) ); ?></span>
					<h1><?php echo wp_kses_post( vlac_opt( 'vc_title', 'Gestiona tus <span class="accent">clientes</span> y tus <span class="accent">ventas</span> en un solo lugar' ) ); ?></h1>
					<p class="lead"><?php echo esc_html( vlac_opt( 'vc_sub', 'Un directorio completo de clientes con sus direcciones y contactos, conectado a tus órdenes, cajas y reportes de venta.' ) ); ?></p>
					<div class="hero-cta">
						<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'hero_cta1_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
						<a class="btn btn-ghost" href="<?php echo esc_url( vlac_opt( 'hero_cta2_url', '#' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta2_txt', 'Ver una demo' ) ); ?></a>
					</div>
					<div class="hero-note">
						<svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
						Fichas completas · Múltiples direcciones y contactos · Historial de compras
					</div>
				</div>

				<!-- Video del flujo de clientes (o marcador) -->
				<div class="vc-frame">
					<div class="bar"><i></i><i></i><i></i><span class="url">app.tunegocio.com.gt/clientes</span></div>
					<?php if ( $cli_has_video ) : ?>
						<video autoplay muted loop playsinline preload="metadata"<?php echo $cli_poster ? ' poster="' . esc_url( $cli_poster ) . '"' : ''; ?>>
							<?php if ( $cli_has_webm ) : ?>
								<source src="<?php echo esc_url( $vid_url . '/clientes.webm' ); ?>" type="video/webm" />
							<?php endif; ?>
							<?php if ( $cli_has_mp4 ) : ?>
								<source src="<?php echo esc_url( $vid_url . '/clientes.mp4' ); ?>" type="video/mp4" />
							<?php endif; ?>
						</video>
					<?php else : ?>
						<div class="vc-ph">
							<svg viewBox="0 0 24 24" fill="none"><path d="M4 5h16v14H4zM10 9l6 3-6 3V9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
							<b>Aquí irá el video del flujo de clientes</b>
							<span>Listado → ficha → direcciones y contactos</span>
							<code>assets/video/clientes.mp4</code>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

	<!-- CLIENTES: LISTADO / FICHA / DIRECCIONES Y CONTACTOS -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Clientes</div>
				<h2>Toda la información de tu cliente, ordenada</h2>
				<p>Desde el listado hasta la ficha detallada con sus direcciones y contactos.</p>
			</div>

			<div class="vc-steps">
				<div class="vc-step">
					<div class="vc-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></div>
					<h3>Listado de clientes</h3>
					<p>Búsqueda por código, nombre, NIT, DPI, teléfono o correo, con filtro de activos y foto de cada cliente.</p>
				</div>
				<div class="vc-step">
					<div class="vc-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="4" y="3" width="16" height="18" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M8 8h8M8 12h8M8 16h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Ficha completa</h3>
					<p>Nombre, alias, NIT, DPI, correo, teléfono, descuento, tipo y fecha de nacimiento. Búsqueda automática por NIT o DPI.</p>
				</div>
				<div class="vc-step">
					<div class="vc-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 21s7-5.5 7-11a7 7 0 10-14 0c0 5.5 7 11 7 11z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><circle cx="12" cy="10" r="2.5" stroke="currentColor" stroke-width="1.7"/></svg></div>
					<h3>Direcciones y contactos</h3>
					<p>Registra múltiples direcciones y contactos por cliente, más su historial de órdenes y límite de crédito.</p>
				</div>
			</div>

			<div class="vc-shots" style="margin-top:34px;">
				<?php $vc_shot( 'vc-clientes.png', 'Listado de clientes' ); ?>
				<?php $vc_shot( 'vc-ficha.png', 'Ficha del cliente' ); ?>
				<?php $vc_shot( 'vc-direcciones.png', 'Direcciones y contactos' ); ?>
				<?php $vc_shot( 'vc-contactos.png', 'Historial y límite de crédito' ); ?>
			</div>
		</div>
	</section>

	<!-- VENTAS: CAPACIDADES -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Ventas</div>
				<h2>De la orden al reporte, todo conectado</h2>
			</div>

			<div class="vc-shots" style="margin-bottom:44px;">
				<?php $vc_shot( 'vc-ordenes.png', 'Órdenes con estados y utilidad' ); ?>
				<?php $vc_shot( 'vc-cajas.png', 'Historial de cajas' ); ?>
				<?php $vc_shot( 'vc-productos.png', 'Productos vendidos' ); ?>
				<?php $vc_shot( 'vc-reportes.png', 'Reportes por vendedor y tipo de pago' ); ?>
			</div>

			<div class="feat-grid">
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 7h16l-1 12H5L4 7zM8 7V5a4 4 0 018 0v2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Órdenes con estados</h3>
					<p>Pagada, preparada, entregada… por mesa, domicilio o mostrador.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="6" width="18" height="12" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M3 10h18M7 15h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Historial de cajas</h3>
					<p>Apertura y cierre, efectivo, cajero y totales por caja.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M6 3h9l3 3v15H6z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M9 8h6M9 12h6M9 16h3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Productos vendidos</h3>
					<p>Detalle por vendedor, orden, lista de precio, costo y precio.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 20V10M10 20V4M16 20v-7M22 20H2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Reportes de venta</h3>
					<p>Ventas por vendedor y distribución por tipo de pago.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.7"/><path d="M12 7v10M9.5 9.5a2.5 2.5 0 015 0c0 2-2.5 1.5-2.5 3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg></div>
					<h3>Utilidad en tiempo real</h3>
					<p>Total bruto, costos, gastos, propina y nómina de un vistazo.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 21s7-5.5 7-11a7 7 0 10-14 0c0 5.5 7 11 7 11z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="12" cy="10" r="2.4" stroke="currentColor" stroke-width="1.6"/></svg></div>
					<h3>Domicilios y mesas</h3>
					<p>Controla entregas a domicilio y el estado de cada mesa.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- CTA -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="cta-strip">
				<h2><?php echo esc_html( vlac_opt( 'vc_cta_title', 'Conoce a fondo a tus clientes y tus ventas' ) ); ?></h2>
				<p><?php echo esc_html( vlac_opt( 'vc_cta_sub', 'Centraliza tu cartera de clientes y controla cada venta desde un solo sistema.' ) ); ?></p>
				<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'cta_btn_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
			</div>
		</div>
	</section>

</div>

<?php
get_footer();
