<?php
/**
 * Template Name: Gestión Financiera
 *
 * Página de producto del módulo de Gestión Financiera.
 * Muestra la caja general (transacciones, vista por cuenta y cuadre por
 * sucursales), las comisiones (generar, pagar e historial), el manejo de
 * crédito de clientes, el control de facturas, el control de gastos y las
 * ventas por vendedor.
 *
 * IMÁGENES (elígelas en el Personalizador o guárdalas en /assets/img/ con
 * estos nombres exactos):
 *   fin-caja.png                → Caja general / transacciones (captura 1)
 *   fin-cuenta.png              → Vista por cuenta bancaria (captura 2)
 *   fin-cuadre.png              → Cuadre por sucursales
 *   fin-comisiones-generar.png  → Generador de comisiones (captura 3)
 *   fin-comisiones-gestion.png  → Pagar / gestión de comisiones (captura 4)
 *   fin-credito.png             → Crédito de clientes — listado (captura 5)
 *   fin-credito-ficha.png       → Crédito de clientes — ficha (captura 6)
 *   fin-facturas.png            → Control de facturas (captura 7)
 *   fin-gastos.png              → Control de gastos (captura 8)
 *   fin-ventas-vendedor.png     → Ventas por vendedor (captura 10)
 *   fin-hero.png                → (opcional) imagen destacada del hero
 *
 * VIDEO (opcional, guárdalo en /assets/video/):
 *   caja-general.mp4            → flujo: nuevo ingreso / retiro en caja
 * Mientras no exista, se muestra un marcador en su lugar.
 *
 * Para usarla: crea una página (Páginas → Añadir nueva) con el título
 * «Gestión Financiera» y el slug «financiera», y en «Atributos de página →
 * Plantilla» elige «Gestión Financiera». No necesita contenido. Los textos
 * se editan en Apariencia → Personalizar → Contenido del sitio →
 * «Página Gestión Financiera».
 *
 * @package Vlac_Systems
 */

get_header();

$img     = get_template_directory_uri() . '/assets/img';
$img_dir = get_template_directory() . '/assets/img/';
$vid_url = get_template_directory_uri() . '/assets/video';
$vid_dir = get_template_directory() . '/assets/video/';

// Renderiza una captura enmarcada. Prioridad de la imagen:
//   1) La elegida en el Personalizador (Biblioteca de medios de WordPress).
//   2) El archivo en /assets/img/.
//   3) Un marcador con las instrucciones.
$fin_shot = function ( $file, $caption, $opt_key = '' ) use ( $img, $img_dir ) {
	$url    = $opt_key ? vlac_opt( $opt_key ) : '';
	$exists = file_exists( $img_dir . $file );
	echo '<figure class="fin-shot"><div class="fin-frame"><div class="bar"><i></i><i></i><i></i></div>';
	if ( $url ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $url ), esc_attr( $caption ) );
	} elseif ( $exists ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $img . '/' . $file ), esc_attr( $caption ) );
	} else {
		printf( '<div class="fin-ph fin-ph-img">Elige la imagen en <b>Personalizar → Página Gestión Financiera</b><br>o sube <code>assets/img/%s</code></div>', esc_html( $file ) );
	}
	echo '</div>';
	if ( $caption ) {
		printf( '<figcaption>%s</figcaption>', esc_html( $caption ) );
	}
	echo '</figure>';
};

// Renderiza un video autoplay. Prioridad:
//   1) El elegido en el Personalizador (Biblioteca de medios de WordPress).
//   2) El archivo en /assets/video/.
//   3) Un marcador con el nombre esperado.
$fin_video = function ( $base, $title, $sub, $opt_key = '' ) use ( $vid_dir, $vid_url ) {
	$wp_url  = '';
	$wp_type = '';
	if ( $opt_key ) {
		$vid_id = vlac_opt( $opt_key );
		if ( $vid_id ) {
			$wp_url  = wp_get_attachment_url( $vid_id );
			$wp_type = get_post_mime_type( $vid_id );
		}
	}
	$has_mp4  = file_exists( $vid_dir . $base . '.mp4' );
	$has_webm = file_exists( $vid_dir . $base . '.webm' );
	echo '<div class="fin-frame"><div class="bar"><i></i><i></i><i></i></div>';
	if ( $wp_url ) {
		echo '<video autoplay muted loop playsinline preload="metadata">';
		printf( '<source src="%s"%s />', esc_url( $wp_url ), $wp_type ? ' type="' . esc_attr( $wp_type ) . '"' : '' );
		echo '</video>';
	} elseif ( $has_mp4 || $has_webm ) {
		echo '<video autoplay muted loop playsinline preload="metadata">';
		if ( $has_webm ) {
			printf( '<source src="%s" type="video/webm" />', esc_url( $vid_url . '/' . $base . '.webm' ) );
		}
		if ( $has_mp4 ) {
			printf( '<source src="%s" type="video/mp4" />', esc_url( $vid_url . '/' . $base . '.mp4' ) );
		}
		echo '</video>';
	} else {
		echo '<div class="fin-ph">';
		echo '<svg viewBox="0 0 24 24" fill="none"><path d="M4 5h16v14H4zM10 9l6 3-6 3V9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>';
		printf( '<b>%s</b><span>%s</span>', esc_html( $title ), esc_html( $sub ) );
		printf( '<code>assets/video/%s.mp4</code>', esc_html( $base ) );
		echo '</div>';
	}
	echo '</div>';
};
?>

<style>
	/* Estilos de la página de Gestión Financiera (ámbito local). */
	#fin-page{--fin-green:#2e9e5b;}

	/* HERO */
	#fin-page .fin-hero{position:relative;overflow:hidden;}
	#fin-page .fin-hero::before{content:"";position:absolute;inset:0;z-index:0;background:radial-gradient(700px 380px at 82% 8%,rgba(193,39,45,.07),transparent 60%),linear-gradient(180deg,#fff,var(--bg-alt));}
	#fin-page .fin-hero .hero-grid{position:relative;z-index:1;display:grid;grid-template-columns:1fr 1.12fr;gap:48px;align-items:center;padding:66px 0 84px;}
	#fin-page .fin-hero h1{font-size:clamp(32px,4.4vw,50px);font-weight:800;}
	#fin-page .fin-hero .lead{color:var(--muted);font-size:18px;margin:20px 0 8px;max-width:520px;}
	#fin-page .fin-hero .hero-cta{display:flex;gap:14px;flex-wrap:wrap;margin-top:28px;}
	#fin-page .fin-hero .hero-note{display:flex;align-items:center;gap:8px;font-size:13.5px;color:var(--muted);margin-top:22px;}
	#fin-page .fin-hero .hero-note svg{width:16px;height:16px;color:var(--fin-green);}

	/* Métricas rápidas bajo el hero */
	#fin-page .fin-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-top:34px;max-width:540px;}
	#fin-page .fin-stat{background:#fff;border:1px solid var(--line);border-radius:12px;padding:16px 18px;box-shadow:var(--shadow-sm);}
	#fin-page .fin-stat b{display:block;font-family:'Manrope';font-weight:800;font-size:21px;color:var(--red);line-height:1;}
	#fin-page .fin-stat span{display:block;color:var(--muted);font-size:12.5px;margin-top:7px;}

	/* MARCO (estilo navegador) para capturas y videos */
	#fin-page .fin-frame{background:#fff;border:1px solid #d9d9de;border-radius:14px;overflow:hidden;box-shadow:var(--shadow-md);}
	#fin-page .fin-frame .bar{display:flex;align-items:center;gap:6px;padding:9px 12px;background:#f3f3f5;border-bottom:1px solid #e6e6ea;}
	#fin-page .fin-frame .bar i{width:10px;height:10px;border-radius:50%;background:#d6d6dc;display:block;}
	#fin-page .fin-frame video,#fin-page .fin-frame img{width:100%;height:auto;display:block;background:#000;}
	#fin-page .fin-hero .fin-frame{box-shadow:var(--shadow-lg);}

	/* Marcador (placeholder) */
	#fin-page .fin-ph{aspect-ratio:16/10;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;text-align:center;background:var(--bg-alt);color:var(--muted);padding:24px;font-size:14px;}
	#fin-page .fin-ph svg{width:46px;height:46px;color:#c9c9d0;}
	#fin-page .fin-ph b{font-family:'Manrope';font-weight:700;color:var(--ink-strong);font-size:15px;}
	#fin-page .fin-ph code{font-size:13px;color:var(--red-dark);background:var(--red-soft);padding:4px 10px;border-radius:6px;}
	#fin-page .fin-ph-img{aspect-ratio:auto;padding:52px 20px;}

	/* HUB: tarjetas de módulos financieros */
	#fin-page .fin-hub{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;}
	#fin-page .fin-tool{position:relative;background:#fff;border:1px solid var(--line);border-radius:var(--radius);padding:24px 22px;transition:transform .18s ease,box-shadow .18s ease,border-color .18s ease;overflow:hidden;}
	#fin-page .fin-tool::after{content:"";position:absolute;right:-40px;top:-40px;width:120px;height:120px;border-radius:50%;background:var(--red-soft);opacity:0;transition:opacity .2s ease;}
	#fin-page .fin-tool:hover{transform:translateY(-4px);box-shadow:var(--shadow-md);border-color:#e0d0d0;}
	#fin-page .fin-tool:hover::after{opacity:.6;}
	#fin-page .fin-tool>*{position:relative;z-index:1;}
	#fin-page .fin-tool .fin-ic{width:50px;height:50px;border-radius:13px;background:var(--red-soft);display:grid;place-items:center;margin-bottom:16px;}
	#fin-page .fin-tool .fin-ic svg{width:25px;height:25px;color:var(--red);}
	#fin-page .fin-tool h3{font-size:17px;font-weight:700;margin-bottom:7px;}
	#fin-page .fin-tool p{color:var(--muted);font-size:14px;}

	/* FILAS ALTERNADAS (texto + imagen juntos) */
	#fin-page .fin-rows{display:flex;flex-direction:column;gap:60px;}
	#fin-page .fin-row{display:grid;grid-template-columns:1fr 1.15fr;gap:46px;align-items:center;}
	#fin-page .fin-row.reverse .fin-row-text{order:2;}
	#fin-page .fin-row.reverse .fin-row-media{order:1;}
	#fin-page .fin-row-text .fin-ic{width:52px;height:52px;border-radius:13px;background:var(--red-soft);display:grid;place-items:center;margin-bottom:18px;}
	#fin-page .fin-row-text .fin-ic svg{width:26px;height:26px;color:var(--red);}
	#fin-page .fin-row-text h3{font-size:clamp(20px,2.4vw,26px);font-weight:800;}
	#fin-page .fin-row-text p{color:var(--muted);font-size:16.5px;margin-top:14px;max-width:430px;}
	#fin-page .fin-row-text .fin-list{list-style:none;margin:18px 0 0;padding:0;display:flex;flex-direction:column;gap:10px;max-width:430px;}
	#fin-page .fin-row-text .fin-list li{display:flex;align-items:flex-start;gap:10px;color:var(--ink-strong);font-size:15px;}
	#fin-page .fin-row-text .fin-list svg{width:19px;height:19px;color:var(--fin-green);flex-shrink:0;margin-top:1px;}

	/* SECCIÓN DE VIDEO */
	#fin-page .fin-video-wrap{max-width:900px;margin:0 auto;}
	#fin-page .fin-video-wrap .cap{margin-top:16px;text-align:center;}
	#fin-page .fin-video-wrap .cap b{font-family:'Manrope';font-weight:700;font-size:16px;color:var(--ink-strong);display:block;}
	#fin-page .fin-video-wrap .cap span{color:var(--muted);font-size:14px;}

	@media (max-width:980px){
		#fin-page .fin-hub{grid-template-columns:repeat(2,1fr);}
	}
	@media (max-width:900px){
		#fin-page .fin-hero .hero-grid{grid-template-columns:1fr;gap:34px;padding:52px 0 56px;}
		#fin-page .fin-stats{max-width:none;}
		#fin-page .fin-row{grid-template-columns:1fr;gap:22px;}
		#fin-page .fin-row.reverse .fin-row-text{order:0;}
		#fin-page .fin-row.reverse .fin-row-media{order:0;}
	}
	@media (max-width:560px){
		#fin-page .fin-stats{grid-template-columns:1fr;}
		#fin-page .fin-hub{grid-template-columns:1fr;}
	}
</style>

<div id="fin-page">

	<!-- HERO -->
	<section class="fin-hero">
		<div class="wrap">
			<div class="hero-grid">
				<div class="hero-copy">
					<span class="eyebrow"><span class="dot"></span> <?php echo esc_html( vlac_opt( 'fin_eyebrow', 'Gestión Financiera' ) ); ?></span>
					<h1><?php echo wp_kses_post( vlac_opt( 'fin_title', 'Toda tu <span class="accent">operación financiera</span> bajo control' ) ); ?></h1>
					<p class="lead"><?php echo esc_html( vlac_opt( 'fin_sub', 'Caja general, comisiones, crédito de clientes, facturas, gastos y ventas por vendedor: el dinero de tu negocio, ordenado en un solo lugar.' ) ); ?></p>
					<div class="hero-cta">
						<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'hero_cta1_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
						<a class="btn btn-ghost" href="<?php echo esc_url( vlac_opt( 'hero_cta2_url', '#' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta2_txt', 'Ver una demo' ) ); ?></a>
					</div>
					<div class="hero-note">
						<svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
						Cuentas y cajas · Comisiones automáticas · Crédito y cobros
					</div>

					<div class="fin-stats">
						<div class="fin-stat"><b>Saldo total</b><span>De todas tus cuentas y cajas</span></div>
						<div class="fin-stat"><b>Utilidad</b><span>Ventas, costo y utilidad del mes</span></div>
						<div class="fin-stat"><b>Comisiones</b><span>Genera, aprueba y paga por vendedor</span></div>
					</div>
				</div>

				<div class="fin-visual">
					<?php
					$fin_hero_key  = vlac_opt( 'fin_img_hero' ) ? 'fin_img_hero' : 'fin_img_caja';
					$fin_hero_file = file_exists( $img_dir . 'fin-hero.png' ) ? 'fin-hero.png' : 'fin-caja.png';
					$fin_shot( $fin_hero_file, '', $fin_hero_key );
					?>
				</div>
			</div>
		</div>
	</section>

	<!-- MÓDULOS FINANCIEROS -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Gestión financiera</div>
				<h2>Seis módulos, un solo tablero del dinero</h2>
				<p>Desde la caja general hasta las ventas por vendedor, todo conectado a tus ventas, compras e inventario.</p>
			</div>

			<div class="fin-hub">
				<div class="fin-tool">
					<div class="fin-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="6" width="18" height="12" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M3 10h18M7 15h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Caja general</h3>
					<p>Cuentas bancarias y cajas, transacciones y cuadre por sucursales.</p>
				</div>
				<div class="fin-tool">
					<div class="fin-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M21 12A9 9 0 113 12a9 9 0 0118 0z" stroke="currentColor" stroke-width="1.6"/><path d="M12 7v10M9.5 9.2c0-1 1.1-1.7 2.5-1.7s2.5.7 2.5 1.7-1.1 1.5-2.5 1.5-2.5.7-2.5 1.7 1.1 1.7 2.5 1.7 2.5-.7 2.5-1.7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg></div>
					<h3>Comisiones</h3>
					<p>Genera, aprueba, paga y consulta el historial por vendedor.</p>
				</div>
				<div class="fin-tool">
					<div class="fin-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="2" y="5" width="20" height="14" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M2 9h20" stroke="currentColor" stroke-width="1.7"/><circle cx="17" cy="14" r="1.4" fill="currentColor"/></svg></div>
					<h3>Crédito de clientes</h3>
					<p>Límites, utilizado, disponible, abonos y estado de cada crédito.</p>
				</div>
				<div class="fin-tool">
					<div class="fin-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M6 3h9l3 3v15l-2-1.4L14 21l-2-1.4L10 21l-2-1.4L6 21V3z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 8h6M9 12h6M9 16h3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg></div>
					<h3>Facturas</h3>
					<p>Control de todos los DTE emitidos, con estado y tipo de pago.</p>
				</div>
				<div class="fin-tool">
					<div class="fin-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3v18M12 3l-4 4M12 3l4 4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/><rect x="4" y="14" width="16" height="7" rx="1.6" stroke="currentColor" stroke-width="1.6"/></svg></div>
					<h3>Gastos</h3>
					<p>Registra y clasifica los gastos por cuenta, categoría y usuario.</p>
				</div>
				<div class="fin-tool">
					<div class="fin-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 20V10M10 20V4M16 20v-7M22 20H2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Ventas por vendedor</h3>
					<p>Monto cobrado por cada vendedor y distribución por tipo de pago.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- CAJA GENERAL -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Caja general</div>
				<h2>El movimiento del dinero, cuenta por cuenta</h2>
				<p>Saldo total, cuentas bancarias y cajas, con cada ingreso, retiro y transferencia registrado.</p>
			</div>

			<div class="fin-rows">
				<div class="fin-row">
					<div class="fin-row-text">
						<div class="fin-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="6" width="18" height="12" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M3 10h18M7 15h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
						<h3>Transacciones</h3>
						<p>Saldo total y tarjetas de cada cuenta bancaria, con nuevos ingresos, retiros y transferencias, y el panel de utilidad del mes.</p>
						<ul class="fin-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Ingreso, retiro y transferencia entre cuentas</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Utilidad del mes: ventas, costo y anticipos</li>
						</ul>
					</div>
					<div class="fin-row-media"><?php $fin_shot( 'fin-caja.png', '', 'fin_img_caja' ); ?></div>
				</div>

				<div class="fin-row reverse">
					<div class="fin-row-text">
						<div class="fin-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M3 9h18M7 13h5M7 16h8" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
						<h3>Vista por cuenta</h3>
						<p>Entra a una cuenta o caja y ve su saldo, ingresos y salidas del período, con filtros por caja, tipo, categoría, cliente y usuario.</p>
						<ul class="fin-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Estado de cuenta del período por caja</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Cuadre por sucursales de un vistazo</li>
						</ul>
					</div>
					<div class="fin-row-media"><?php $fin_shot( 'fin-cuenta.png', '', 'fin_img_cuenta' ); ?></div>
				</div>

				<div class="fin-row">
					<div class="fin-row-text">
						<div class="fin-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M3 21V9l9-6 9 6v12M3 21h18M9 21v-6h6v6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
						<h3>Cuadre por sucursales</h3>
						<p>Consolida el saldo, los ingresos y las salidas de cada sucursal para cerrar el día o el período con las cuentas claras.</p>
						<ul class="fin-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Totales por sucursal y cuenta</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Cierre de período con todo conciliado</li>
						</ul>
					</div>
					<div class="fin-row-media"><?php $fin_shot( 'fin-cuadre.png', '', 'fin_img_cuadre' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- COMISIONES -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Comisiones</div>
				<h2>De la venta a la comisión pagada</h2>
				<p>Genera comisiones por mes, apruébalas, págalas y consulta su historial por vendedor.</p>
			</div>

			<div class="fin-rows">
				<div class="fin-row">
					<div class="fin-row-text">
						<div class="fin-ic"><svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/><path d="M12 3a9 9 0 019 9h-9V3z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg></div>
						<h3>Generar comisiones</h3>
						<p>Elige mes y año, genera las comisiones y filtra por tipo de pago. Ve usuarios, órdenes, ventas y comisión total, y aprueba lo seleccionado.</p>
						<ul class="fin-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Comisión por vendedor y por tipo de pago</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Tabla de comisiones y metas por vendedor</li>
						</ul>
					</div>
					<div class="fin-row-media"><?php $fin_shot( 'fin-comisiones-generar.png', '', 'fin_img_com_generar' ); ?></div>
				</div>

				<div class="fin-row reverse">
					<div class="fin-row-text">
						<div class="fin-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
						<h3>Pagar e historial</h3>
						<p>Revisa el detalle orden por orden —comisión, pagado, pendiente y descuento—, aprueba o anula, y consulta las comisiones aprobadas y su historial.</p>
						<ul class="fin-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Detalle por orden y por producto</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Crédito pagado, efectivo y tarjeta separados</li>
						</ul>
					</div>
					<div class="fin-row-media"><?php $fin_shot( 'fin-comisiones-gestion.png', '', 'fin_img_com_gestion' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- CRÉDITO DE CLIENTES -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Crédito de clientes</div>
				<h2>Controla lo que te deben, cliente por cliente</h2>
				<p>Límites, saldos, abonos y estados de crédito, con exportación a PDF y Excel.</p>
			</div>

			<div class="fin-rows">
				<div class="fin-row">
					<div class="fin-row-text">
						<div class="fin-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="2" y="5" width="20" height="14" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M2 9h20" stroke="currentColor" stroke-width="1.7"/><circle cx="17" cy="14" r="1.4" fill="currentColor"/></svg></div>
						<h3>Cartera de crédito</h3>
						<p>Todos tus clientes con su crédito, utilizado y estado —al día, vencido, sin crédito—, con totales de vencido y por recibir, y filtros por sucursal.</p>
						<ul class="fin-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Estados: sin crédito, al día, vencido, a recibir</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Descarga en PDF y Excel</li>
						</ul>
					</div>
					<div class="fin-row-media"><?php $fin_shot( 'fin-credito.png', '', 'fin_img_credito' ); ?></div>
				</div>

				<div class="fin-row reverse">
					<div class="fin-row-text">
						<div class="fin-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="4" y="3" width="16" height="18" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M8 8h8M8 12h8M8 16h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
						<h3>Ficha del crédito</h3>
						<p>Límite, utilizado, disponible, período de cobranza y órdenes pendientes, más los abonos del cliente. Actualiza el límite o bloquea el crédito vencido.</p>
						<ul class="fin-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Abonos activos y anulados con su tipo de pago</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Bloqueo automático si el crédito está vencido</li>
						</ul>
					</div>
					<div class="fin-row-media"><?php $fin_shot( 'fin-credito-ficha.png', '', 'fin_img_credito_ficha' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- FACTURAS Y GASTOS -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Facturas y gastos</div>
				<h2>Lo que entra y lo que sale, documentado</h2>
				<p>El control de tus facturas emitidas y de cada gasto del negocio, siempre a la mano.</p>
			</div>

			<div class="fin-rows">
				<div class="fin-row">
					<div class="fin-row-text">
						<div class="fin-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M6 3h9l3 3v15l-2-1.4L14 21l-2-1.4L10 21l-2-1.4L6 21V3z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 8h6M9 12h6M9 16h3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg></div>
						<h3>Control de facturas</h3>
						<p>Todos los DTE emitidos con número, usuario, NIT, cliente, tipo, caja, estado y tipo de pago, con total del período y filtros por fecha, NIT y estado.</p>
						<ul class="fin-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Ligadas a su orden de venta</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Estado facturada y tipo de documento</li>
						</ul>
					</div>
					<div class="fin-row-media"><?php $fin_shot( 'fin-facturas.png', '', 'fin_img_facturas' ); ?></div>
				</div>

				<div class="fin-row reverse">
					<div class="fin-row-text">
						<div class="fin-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3v18M12 3l-4 4M12 3l4 4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/><rect x="4" y="14" width="16" height="7" rx="1.6" stroke="currentColor" stroke-width="1.6"/></svg></div>
						<h3>Control de gastos</h3>
						<p>Total de gastos y tarjetas por categoría, con cada gasto por cuenta, caja, categoría, usuario y tipo de pago; imprime en térmica o PDF.</p>
						<ul class="fin-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Filtros por período, cuenta, caja y categoría</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Detalle del gasto con impresión térmica y PDF</li>
						</ul>
					</div>
					<div class="fin-row-media"><?php $fin_shot( 'fin-gastos.png', '', 'fin_img_gastos' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- VENTAS POR VENDEDOR -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Ventas por vendedor</div>
				<h2>Quién vende cuánto, y cómo cobran</h2>
				<p>Monto cobrado por cada vendedor y participación de cada método de pago, en gráficas claras.</p>
			</div>

			<div class="fin-rows">
				<div class="fin-row">
					<div class="fin-row-text">
						<div class="fin-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 20V10M10 20V4M16 20v-7M22 20H2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
						<h3>Rendimiento por vendedor</h3>
						<p>Gráfica del monto total cobrado por cada vendedor y distribución por tipo de pago, con el detalle por vendedor y sus totales por período.</p>
						<ul class="fin-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Ventas por vendedor y método de pago</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Rango de fechas configurable</li>
						</ul>
					</div>
					<div class="fin-row-media"><?php $fin_shot( 'fin-ventas-vendedor.png', '', 'fin_img_ventas' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- VIDEO: CAJA EN ACCIÓN -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">En acción</div>
				<h2>Un movimiento de caja, paso a paso</h2>
				<p>Mira cómo se registra un ingreso o retiro y se refleja en el saldo de la cuenta.</p>
			</div>

			<div class="fin-video-wrap">
				<?php $fin_video( 'caja-general', 'Video: movimiento de caja', 'Ingreso, retiro y transferencia', 'fin_video_caja' ); ?>
				<div class="cap">
					<b>Caja general en vivo</b>
					<span>Registra un ingreso o retiro y observa el saldo actualizarse</span>
				</div>
			</div>
		</div>
	</section>

	<!-- CAPACIDADES -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Todo lo que incluye</div>
				<h2>Pensado para las finanzas de tu negocio</h2>
			</div>
			<div class="feat-grid">
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="6" width="18" height="12" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M3 10h18M7 15h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Cuentas y cajas</h3>
					<p>Múltiples cuentas bancarias y cajas con su saldo real.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M7 7h11l-3-3M17 17H6l3 3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Ingresos y retiros</h3>
					<p>Transferencias entre cuentas y transacciones trazables.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/><path d="M12 7v10M9.5 9.2c0-1 1.1-1.7 2.5-1.7s2.5.7 2.5 1.7-1.1 1.5-2.5 1.5-2.5.7-2.5 1.7 1.1 1.7 2.5 1.7 2.5-.7 2.5-1.7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg></div>
					<h3>Comisiones por vendedor</h3>
					<p>Genera, aprueba y paga con historial completo.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="2" y="5" width="20" height="14" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M2 9h20" stroke="currentColor" stroke-width="1.7"/></svg></div>
					<h3>Crédito y abonos</h3>
					<p>Límites, disponible, abonos y bloqueo de vencidos.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M6 3h9l3 3v15H6z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Facturas y gastos</h3>
					<p>Control de DTE emitidos y de cada gasto del negocio.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 20V10M10 20V4M16 20v-7M22 20H2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Reportes por vendedor</h3>
					<p>Ventas y métodos de pago en gráficas claras.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- CTA -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="cta-strip">
				<h2><?php echo esc_html( vlac_opt( 'fin_cta_title', 'Ordena las finanzas de tu negocio hoy' ) ); ?></h2>
				<p><?php echo esc_html( vlac_opt( 'fin_cta_sub', 'Controla tu caja, tus comisiones, tu crédito y tus gastos desde un solo lugar conectado a tus ventas.' ) ); ?></p>
				<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'cta_btn_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
			</div>
		</div>
	</section>

</div>

<?php
get_footer();
