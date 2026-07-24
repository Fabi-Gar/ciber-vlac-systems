<?php
/**
 * Template Name: Punto de Venta (POS)
 *
 * Página de producto del módulo de Punto de Venta / Cajero.
 * Recorre el turno completo de caja: apertura, toma de órdenes, cobro con
 * múltiples formas de pago, facturación, gastos y operaciones, cálculo de
 * billetes, cierre con arqueo, libro de caja, historial y subcajas.
 *
 * IMÁGENES (guárdalas en /assets/img/ con estos nombres exactos):
 *   pos-cajas.png        → Listado de cajas / cajas abiertas (captura 1)
 *   pos-apertura.png     → Diálogo de apertura de caja (captura 2)
 *   pos-orden.png        → Pantalla de orden — POS principal (captura 3)
 *   pos-pago.png         → Cobro / tipos de pago (captura 4)
 *   pos-factura.png      → Emisión de factura / recibo térmico (captura 5)
 *   pos-gastos.png       → Registro de gastos (captura 6)
 *   pos-resumen.png      → Resumen de caja (efectivo, gastos, propinas, totales) (captura 7)
 *   pos-libro.png        → Libro de caja / historial de cajas (captura 8)
 *   pos-hero.png         → (opcional) imagen destacada del hero
 *
 * VIDEOS (guárdalos en /assets/video/):
 *   operaciones-caja.mp4 → operaciones de caja: retiros, refuerzos, abonos y anticipos
 *   calculo-billetes.mp4 → arqueo: contar billetes por denominación y cuadrar
 *   venta-pos.mp4        → flujo: tomar la orden, cobrar y facturar
 * Mientras no existan, se muestra un marcador en su lugar.
 *
 * Para usarla: crea una página (Páginas → Añadir nueva) con el título
 * «Punto de Venta» y el slug «punto-de-venta», y en «Atributos de página →
 * Plantilla» elige «Punto de Venta (POS)». No necesita contenido.
 * Los textos se editan en Apariencia → Personalizar → Contenido del sitio →
 * «Página Punto de Venta».
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
$pos_shot = function ( $file, $caption, $opt_key = '' ) use ( $img, $img_dir ) {
	$url    = $opt_key ? vlac_opt( $opt_key ) : '';
	$exists = file_exists( $img_dir . $file );
	echo '<figure class="pos-shot"><div class="pos-frame"><div class="bar"><i></i><i></i><i></i></div>';
	if ( $url ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $url ), esc_attr( $caption ) );
	} elseif ( $exists ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $img . '/' . $file ), esc_attr( $caption ) );
	} else {
		printf( '<div class="pos-ph pos-ph-img">Elige la imagen en <b>Personalizar → Página Punto de Venta</b><br>o sube el archivo <code>assets/img/%s</code></div>', esc_html( $file ) );
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
$pos_video = function ( $base, $title, $sub, $opt_key = '' ) use ( $vid_dir, $vid_url ) {
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
	echo '<div class="pos-frame"><div class="bar"><i></i><i></i><i></i></div>';
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
		echo '<div class="pos-ph">';
		echo '<svg viewBox="0 0 24 24" fill="none"><path d="M4 5h16v14H4zM10 9l6 3-6 3V9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>';
		printf( '<b>%s</b><span>%s</span>', esc_html( $title ), esc_html( $sub ) );
		printf( '<code>assets/video/%s.mp4</code>', esc_html( $base ) );
		echo '</div>';
	}
	echo '</div>';
};
?>

<style>
	/* Estilos de la página de Punto de Venta (ámbito local). */
	#pos-page{--pos-green:#2e9e5b;--pos-blue:#4c4ddc;}

	/* HERO */
	#pos-page .pos-hero{position:relative;overflow:hidden;}
	#pos-page .pos-hero::before{content:"";position:absolute;inset:0;z-index:0;background:radial-gradient(760px 400px at 18% 6%,rgba(193,39,45,.08),transparent 62%),linear-gradient(180deg,#fff,var(--bg-alt));}
	#pos-page .pos-hero .hero-grid{position:relative;z-index:1;display:grid;grid-template-columns:1fr 1.12fr;gap:48px;align-items:center;padding:66px 0 84px;}
	#pos-page .pos-hero h1{font-size:clamp(32px,4.4vw,50px);font-weight:800;}
	#pos-page .pos-hero .lead{color:var(--muted);font-size:18px;margin:20px 0 8px;max-width:520px;}
	#pos-page .pos-hero .hero-cta{display:flex;gap:14px;flex-wrap:wrap;margin-top:28px;}
	#pos-page .pos-hero .hero-note{display:flex;align-items:center;gap:8px;font-size:13.5px;color:var(--muted);margin-top:22px;}
	#pos-page .pos-hero .hero-note svg{width:16px;height:16px;color:var(--pos-green);flex-shrink:0;}

	/* Métricas rápidas bajo el hero */
	#pos-page .pos-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-top:34px;max-width:540px;}
	#pos-page .pos-stat{background:#fff;border:1px solid var(--line);border-radius:12px;padding:16px 18px;box-shadow:var(--shadow-sm);}
	#pos-page .pos-stat b{display:block;font-family:'Manrope';font-weight:800;font-size:21px;color:var(--red);line-height:1;}
	#pos-page .pos-stat span{display:block;color:var(--muted);font-size:12.5px;margin-top:7px;}

	/* MARCO (estilo navegador) para capturas y videos */
	#pos-page .pos-frame{background:#fff;border:1px solid #d9d9de;border-radius:14px;overflow:hidden;box-shadow:var(--shadow-md);}
	#pos-page .pos-frame .bar{display:flex;align-items:center;gap:6px;padding:9px 12px;background:#f3f3f5;border-bottom:1px solid #e6e6ea;}
	#pos-page .pos-frame .bar i{width:10px;height:10px;border-radius:50%;background:#d6d6dc;display:block;}
	#pos-page .pos-frame video,#pos-page .pos-frame img{width:100%;height:auto;display:block;background:#000;}
	#pos-page .pos-hero .pos-frame{box-shadow:var(--shadow-lg);}
	#pos-page .pos-shot{margin:0;}
	#pos-page .pos-shot figcaption{margin-top:12px;text-align:center;color:var(--muted);font-size:13.5px;}

	/* Marcador (placeholder) */
	#pos-page .pos-ph{aspect-ratio:16/10;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;text-align:center;background:var(--bg-alt);color:var(--muted);padding:24px;font-size:14px;}
	#pos-page .pos-ph svg{width:46px;height:46px;color:#c9c9d0;}
	#pos-page .pos-ph b{font-family:'Manrope';font-weight:700;color:var(--ink-strong);font-size:15px;}
	#pos-page .pos-ph code{font-size:13px;color:var(--red-dark);background:var(--red-soft);padding:4px 10px;border-radius:6px;}
	#pos-page .pos-ph-img{aspect-ratio:auto;padding:52px 20px;}

	/* LÍNEA DE TIEMPO DEL TURNO (layout propio de esta página) */
	#pos-page .pos-flow{position:relative;display:flex;flex-direction:column;gap:34px;}
	#pos-page .pos-flow::before{content:"";position:absolute;left:23px;top:14px;bottom:14px;width:2px;background:linear-gradient(180deg,var(--red-soft),var(--line),var(--red-soft));}
	#pos-page .pos-step{position:relative;display:grid;grid-template-columns:64px 1fr;align-items:start;gap:0;}
	#pos-page .pos-step .num{position:relative;z-index:1;width:48px;height:48px;border-radius:50%;background:#fff;border:2px solid var(--red-soft);color:var(--red);display:grid;place-items:center;font-family:'Manrope';font-weight:800;font-size:17px;box-shadow:var(--shadow-sm);}
	#pos-page .pos-step .body{background:#fff;border:1px solid var(--line);border-radius:var(--radius);padding:22px 24px;box-shadow:var(--shadow-sm);transition:transform .18s ease,box-shadow .18s ease,border-color .18s ease;}
	#pos-page .pos-step:hover .body{transform:translateY(-3px);box-shadow:var(--shadow-md);border-color:#e0d0d0;}
	#pos-page .pos-step h3{font-size:17.5px;font-weight:700;margin-bottom:7px;}
	#pos-page .pos-step p{color:var(--muted);font-size:14.5px;}
	#pos-page .pos-step .tag{display:inline-block;margin-top:13px;font-family:'Manrope';font-weight:700;font-size:11.5px;letter-spacing:.03em;text-transform:uppercase;color:var(--red-dark);background:var(--red-soft);padding:4px 10px;border-radius:999px;}

	/* MOSAICO DE FORMAS DE PAGO */
	#pos-page .pos-pays{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;}
	#pos-page .pos-pay{background:#fff;border:1px solid var(--line);border-radius:12px;padding:18px 16px;text-align:center;transition:transform .16s ease,border-color .16s ease,box-shadow .16s ease;}
	#pos-page .pos-pay:hover{transform:translateY(-3px);border-color:#e0d0d0;box-shadow:var(--shadow-sm);}
	#pos-page .pos-pay .ic{width:44px;height:44px;border-radius:12px;background:var(--red-soft);display:grid;place-items:center;margin:0 auto 12px;}
	#pos-page .pos-pay .ic svg{width:22px;height:22px;color:var(--red);}
	#pos-page .pos-pay b{display:block;font-family:'Manrope';font-weight:700;font-size:14.5px;color:var(--ink-strong);}
	#pos-page .pos-pay span{display:block;color:var(--muted);font-size:12.5px;margin-top:5px;}

	/* FILAS ALTERNADAS (texto + imagen juntos) */
	#pos-page .pos-rows{display:flex;flex-direction:column;gap:60px;}
	#pos-page .pos-row{display:grid;grid-template-columns:1fr 1.15fr;gap:46px;align-items:center;}
	#pos-page .pos-row.reverse .pos-row-text{order:2;}
	#pos-page .pos-row.reverse .pos-row-media{order:1;}
	#pos-page .pos-row-text .pos-ic{width:52px;height:52px;border-radius:13px;background:var(--red-soft);display:grid;place-items:center;margin-bottom:18px;}
	#pos-page .pos-row-text .pos-ic svg{width:26px;height:26px;color:var(--red);}
	#pos-page .pos-row-text h3{font-size:clamp(20px,2.4vw,26px);font-weight:800;}
	#pos-page .pos-row-text p{color:var(--muted);font-size:16.5px;margin-top:14px;max-width:430px;}
	/* Lista con checks. Se usa en las filas y en el bloque de cierre. */
	#pos-page .pos-list{list-style:none;margin:18px 0 0;padding:0;display:flex;flex-direction:column;gap:10px;max-width:430px;}
	#pos-page .pos-list li{display:flex;align-items:flex-start;gap:10px;color:var(--ink-strong);font-size:15px;}
	#pos-page .pos-list li svg{width:19px;height:19px;color:var(--pos-green);flex-shrink:0;margin-top:1px;}

	/* CIERRE: tarjetas de arqueo */
	#pos-page .pos-close{display:grid;grid-template-columns:1.05fr 1fr;gap:46px;align-items:center;}
	#pos-page .pos-close-cards{display:grid;grid-template-columns:repeat(2,1fr);gap:14px;}
	#pos-page .pos-cc{background:#fff;border:1px solid var(--line);border-radius:12px;padding:18px;box-shadow:var(--shadow-sm);}
	#pos-page .pos-cc b{display:block;font-family:'Manrope';font-weight:800;font-size:15px;color:var(--ink-strong);}
	#pos-page .pos-cc span{display:block;color:var(--muted);font-size:13px;margin-top:6px;}
	#pos-page .pos-cc.ok{border-color:#cfe8d9;}
	#pos-page .pos-cc.ok b{color:var(--pos-green);}
	#pos-page .pos-cc.warn{border-color:#e8d2d2;}
	#pos-page .pos-cc.warn b{color:var(--red);}

	/* SECCIÓN DE VIDEO */
	#pos-page .pos-video-wrap{max-width:900px;margin:0 auto;}
	#pos-page .pos-video-wrap .cap{margin-top:16px;text-align:center;}
	#pos-page .pos-video-wrap .cap b{font-family:'Manrope';font-weight:700;font-size:16px;color:var(--ink-strong);display:block;}
	#pos-page .pos-video-wrap .cap span{color:var(--muted);font-size:14px;}

	@media (max-width:980px){
		#pos-page .pos-pays{grid-template-columns:repeat(3,1fr);}
	}
	@media (max-width:900px){
		#pos-page .pos-hero .hero-grid{grid-template-columns:1fr;gap:34px;padding:52px 0 56px;}
		#pos-page .pos-stats{max-width:none;}
		#pos-page .pos-row{grid-template-columns:1fr;gap:22px;}
		#pos-page .pos-row.reverse .pos-row-text{order:0;}
		#pos-page .pos-row.reverse .pos-row-media{order:0;}
		#pos-page .pos-close{grid-template-columns:1fr;gap:26px;}
	}
	@media (max-width:560px){
		#pos-page .pos-stats{grid-template-columns:1fr;}
		#pos-page .pos-pays{grid-template-columns:repeat(2,1fr);}
		#pos-page .pos-flow::before{left:17px;}
		#pos-page .pos-step{grid-template-columns:46px 1fr;}
		#pos-page .pos-step .num{width:36px;height:36px;font-size:14px;}
		#pos-page .pos-step .body{padding:18px 18px;}
		#pos-page .pos-close-cards{grid-template-columns:1fr;}
	}
</style>

<div id="pos-page">

	<!-- HERO -->
	<section class="pos-hero">
		<div class="wrap">
			<div class="hero-grid">
				<div class="hero-copy">
					<span class="eyebrow"><span class="dot"></span> <?php echo esc_html( vlac_opt( 'pos_eyebrow', 'Punto de Venta' ) ); ?></span>
					<h1><?php echo wp_kses_post( vlac_opt( 'pos_title', 'Tu <span class="accent">caja</span> completa, del turno a la <span class="accent">factura</span>' ) ); ?></h1>
					<p class="lead"><?php echo esc_html( vlac_opt( 'pos_sub', 'Abre la caja, toma órdenes, cobra con cualquier forma de pago, factura, registra gastos y cierra con arqueo. Todo queda cuadrado y auditable al final del turno.' ) ); ?></p>
					<div class="hero-cta">
						<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'hero_cta1_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
						<a class="btn btn-ghost" href="<?php echo esc_url( vlac_opt( 'hero_cta2_url', '#' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta2_txt', 'Ver una demo' ) ); ?></a>
					</div>
					<div class="hero-note">
						<svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
						Cobro rápido · Impresión térmica · Cierre con arqueo de billetes
					</div>

					<div class="pos-stats">
						<div class="pos-stat"><b>Multipago</b><span>Efectivo, tarjeta, crédito y más</span></div>
						<div class="pos-stat"><b>Multicaja</b><span>Cajas y subcajas por sucursal</span></div>
						<div class="pos-stat"><b>Cuadre</b><span>Detalle completo por tipo de pago</span></div>
					</div>
				</div>

				<div class="pos-visual">
					<?php
					$pos_hero_key  = vlac_opt( 'pos_img_hero' ) ? 'pos_img_hero' : 'pos_img_orden';
					$pos_hero_file = file_exists( $img_dir . 'pos-hero.png' ) ? 'pos-hero.png' : 'pos-orden.png';
					$pos_shot( $pos_hero_file, '', $pos_hero_key );
					?>
				</div>
			</div>
		</div>
	</section>

	<!-- EL TURNO DE CAJA, PASO A PASO -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">El turno de caja</div>
				<h2>Un flujo pensado para el cajero, de la apertura al cierre</h2>
				<p>Cada paso del turno está en el sistema, en orden, sin planillas paralelas ni cuentas a mano.</p>
			</div>

			<div class="pos-flow">
				<div class="pos-step">
					<div class="num">1</div>
					<div class="body">
						<h3>Apertura de caja</h3>
						<p>El cajero abre su caja con el efectivo inicial y, si aplica, los montos de otras monedas. Queda registrado quién abrió y a qué hora.</p>
						<span class="tag">Inicio del turno</span>
					</div>
				</div>
				<div class="pos-step">
					<div class="num">2</div>
					<div class="body">
						<h3>Nueva orden</h3>
						<p>Busca productos por nombre, SKU o código de barras, arma la orden con cantidades, combos y descuentos, y asígnala a un cliente, mesa o habitación.</p>
						<span class="tag">Venta</span>
					</div>
				</div>
				<div class="pos-step">
					<div class="num">3</div>
					<div class="body">
						<h3>Cobro y facturación</h3>
						<p>Cobra con una o varias formas de pago, aplica propina y recargos, y emite la factura o el recibo térmico al instante.</p>
						<span class="tag">Cobro</span>
					</div>
				</div>
				<div class="pos-step">
					<div class="num">4</div>
					<div class="body">
						<h3>Gastos y operaciones</h3>
						<p>Registra gastos con firma, retiros, refuerzos de caja, anticipos, abonos de crédito y retenciones de IVA sin salir de la caja.</p>
						<span class="tag">Durante el turno</span>
					</div>
				</div>
				<div class="pos-step">
					<div class="num">5</div>
					<div class="body">
						<h3>Cierre con arqueo</h3>
						<p>Cuenta los billetes, el sistema suma y compara contra lo esperado, y marca el sobrante o faltante antes de cerrar.</p>
						<span class="tag">Fin del turno</span>
					</div>
				</div>
				<div class="pos-step">
					<div class="num">6</div>
					<div class="body">
						<h3>Libro de caja e historial</h3>
						<p>Todo el turno queda en el libro de caja y en el historial: ingresos, salidas, facturas emitidas y resumen por vendedor.</p>
						<span class="tag">Control</span>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- CAJAS Y APERTURA -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Cajas y apertura</div>
				<h2>Cada cajero con su caja, y tú viendo todas</h2>
				<p>Controla qué cajas están abiertas, quién las tiene y con cuánto efectivo iniciaron.</p>
			</div>

			<div class="pos-rows">
				<div class="pos-row">
					<div class="pos-row-text">
						<div class="pos-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="6" width="18" height="12" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M3 10h18M8 14h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
						<h3>Listado de cajas</h3>
						<p>Consulta las cajas abiertas con su número, cajero responsable, fecha de apertura y el efectivo que tienen en el momento.</p>
						<ul class="pos-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Cajas abiertas y cerradas con su estado</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Subcajas para varios puntos de cobro</li>
						</ul>
					</div>
					<div class="pos-row-media"><?php $pos_shot( 'pos-cajas.png', '', 'pos_img_cajas' ); ?></div>
				</div>

				<div class="pos-row reverse">
					<div class="pos-row-text">
						<div class="pos-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3v18M8 7h8M8 12h8M8 17h8" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg></div>
						<h3>Apertura de caja</h3>
						<p>Confirma el efectivo de apertura y deja constancia de quién abrió el turno. Si hay que reabrir una caja, también queda registrado.</p>
						<ul class="pos-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Efectivo de apertura y otras monedas</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Confirmación de apertura, cierre y reapertura</li>
						</ul>
					</div>
					<div class="pos-row-media"><?php $pos_shot( 'pos-apertura.png', '', 'pos_img_apertura' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- LA ORDEN Y EL COBRO -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Órdenes y cobro</div>
				<h2>Arma la orden y cóbrala en segundos</h2>
				<p>Productos, cantidades, descuentos y propina; luego la forma de pago y la factura.</p>
			</div>

			<div class="pos-rows">
				<div class="pos-row">
					<div class="pos-row-text">
						<div class="pos-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M3 5h2l2.4 10.2a2 2 0 002 1.6h7.6a2 2 0 002-1.6L21 8H6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/><circle cx="10" cy="20" r="1.4" stroke="currentColor" stroke-width="1.6"/><circle cx="17" cy="20" r="1.4" stroke="currentColor" stroke-width="1.6"/></svg></div>
						<h3>Nueva orden</h3>
						<p>Agrega productos por búsqueda o código de barras, ajusta cantidad y precio, aplica descuentos por producto y asigna la orden a un cliente, mesa o habitación.</p>
						<ul class="pos-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Combos de productos y descuentos aplicados</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Subtotal, propina, recargo y total en vivo</li>
						</ul>
					</div>
					<div class="pos-row-media"><?php $pos_shot( 'pos-orden.png', '', 'pos_img_orden' ); ?></div>
				</div>

				<div class="pos-row reverse">
					<div class="pos-row-text">
						<div class="pos-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="2.5" y="5" width="19" height="14" rx="2.5" stroke="currentColor" stroke-width="1.7"/><path d="M2.5 9.5h19M6 15h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
						<h3>Tipos de pago</h3>
						<p>Cobra en efectivo, tarjeta, transferencia, crédito, bonos o saldo a favor, e incluso divide el pago entre varias formas en una misma orden.</p>
						<ul class="pos-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Pago dividido y otras monedas con equivalencia</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>División de propina entre el personal</li>
						</ul>
					</div>
					<div class="pos-row-media"><?php $pos_shot( 'pos-pago.png', '', 'pos_img_pago' ); ?></div>
				</div>

				<div class="pos-row">
					<div class="pos-row-text">
						<div class="pos-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M6 9V3h12v6M6 18H4a2 2 0 01-2-2v-3a2 2 0 012-2h16a2 2 0 012 2v3a2 2 0 01-2 2h-2M6 14h12v7H6z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
						<h3>Factura y recibo</h3>
						<p>Emite la factura electrónica o el recibo térmico con tu logo, y comparte el comprobante por correo o mensaje sin imprimir nada.</p>
						<ul class="pos-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Impresión térmica o PDF y envío digital</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Facturas y notas de crédito emitidas del turno</li>
						</ul>
					</div>
					<div class="pos-row-media"><?php $pos_shot( 'pos-factura.png', '', 'pos_img_factura' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- FORMAS DE PAGO -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Formas de pago</div>
				<h2>Cobra como tu cliente quiera pagar</h2>
				<p>Todas las formas de pago conviven en la misma orden y cuadran solas al cierre.</p>
			</div>

			<div class="pos-pays">
				<div class="pos-pay">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><rect x="2.5" y="6" width="19" height="12" rx="2" stroke="currentColor" stroke-width="1.7"/><circle cx="12" cy="12" r="2.6" stroke="currentColor" stroke-width="1.7"/></svg></div>
					<b>Efectivo</b><span>Con cálculo de vuelto</span>
				</div>
				<div class="pos-pay">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><rect x="2.5" y="5" width="19" height="14" rx="2.5" stroke="currentColor" stroke-width="1.7"/><path d="M2.5 9.5h19" stroke="currentColor" stroke-width="1.7"/></svg></div>
					<b>Tarjeta</b><span>Débito y crédito</span>
				</div>
				<div class="pos-pay">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 12h16M14 6l6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<b>Transferencia</b><span>A tus cuentas bancarias</span>
				</div>
				<div class="pos-pay">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.7"/><path d="M12 7v5l3 2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<b>Crédito</b><span>Con abonos posteriores</span>
				</div>
				<div class="pos-pay">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.7"/><path d="M8.5 14.5c.6.9 1.7 1.5 3 1.5 1.7 0 3-.9 3-2.2 0-2.8-5.5-1.5-5.5-4.1C9 8.5 10.2 8 11.5 8c1.2 0 2.2.5 2.8 1.4M12 6.5v11" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg></div>
					<b>Abono a crédito</b><span>Pagos parciales de una cuenta</span>
				</div>
				<div class="pos-pay">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3l2.6 5.6 6 .8-4.4 4.2 1.1 6L12 16.8 6.7 19.6l1.1-6L3.4 9.4l6-.8L12 3z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg></div>
					<b>Saldo a favor</b><span>Del cliente frecuente</span>
				</div>
				<div class="pos-pay">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><path d="M6 4h12v16l-3-2-3 2-3-2-3 2V4z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9.5 9h5M9.5 13h5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg></div>
					<b>Anticipo</b><span>Servicios y contratos</span>
				</div>
				<div class="pos-pay">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 6h16v12H4z" stroke="currentColor" stroke-width="1.7"/><path d="M8 10h8M8 14h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<b>Otras monedas</b><span>Con su equivalente</span>
				</div>
			</div>
		</div>
	</section>

	<!-- GASTOS Y OPERACIONES -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Gastos y operaciones</div>
				<h2>Todo lo que entra y sale, registrado en la caja</h2>
				<p>No solo ventas: gastos, retiros, refuerzos, anticipos y retenciones también viven aquí.</p>
			</div>

			<div class="pos-rows">
				<div class="pos-row">
					<div class="pos-row-text">
						<div class="pos-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M7 7h11l-3-3M17 17H6l3 3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
						<h3>Registro de gastos</h3>
						<p>Anota el gasto con su monto, tipo, proveedor, nota y el nombre de quien firma. Sale del efectivo de la caja y se refleja de inmediato en el total.</p>
						<ul class="pos-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Firma responsable y observaciones</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Caja chica, nómina, multas y adelantos</li>
						</ul>
					</div>
					<div class="pos-row-media"><?php $pos_shot( 'pos-gastos.png', '', 'pos_img_gastos' ); ?></div>
				</div>

				<div class="pos-row reverse">
					<div class="pos-row-text">
						<div class="pos-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 15a3 3 0 100-6 3 3 0 000 6z" stroke="currentColor" stroke-width="1.7"/><path d="M12 3v3M12 18v3M3 12h3M18 12h3M5.6 5.6l2.1 2.1M16.3 16.3l2.1 2.1M18.4 5.6l-2.1 2.1M7.7 16.3l-2.1 2.1" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg></div>
						<h3>Operaciones de caja</h3>
						<p>Retiros, refuerzos de caja, abonos de crédito, anticipos de servicios, saldos a favor, pagos de contrato y retención de IVA, cada uno con su comprobante.</p>
						<ul class="pos-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Ingresos por operación y salidas separados</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Retención de IVA y cuentas bancarias</li>
						</ul>
					</div>
					<div class="pos-row-media"><?php $pos_video( 'operaciones-caja', 'Video: operaciones de caja', 'Retiros, refuerzos, abonos y anticipos', 'pos_video_operaciones' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- CIERRE Y ARQUEO -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Cierre y arqueo</div>
				<h2>Cierra el turno cuadrado, sin sacar la calculadora</h2>
				<p>Cuenta los billetes, compara contra lo esperado y cierra con el sobrante o faltante a la vista.</p>
			</div>

			<div class="pos-close">
				<div class="pos-close-text">
					<div class="pos-close-cards">
						<div class="pos-cc"><b>Cálculo de billetes</b><span>Ingresa cuántos billetes hay de cada denominación y el sistema suma el total.</span></div>
						<div class="pos-cc"><b>Total esperado</b><span>Apertura, ventas, operaciones y gastos, todo calculado.</span></div>
						<div class="pos-cc ok"><b>Sobrante</b><span>Cuando el efectivo contado supera lo esperado.</span></div>
						<div class="pos-cc warn"><b>Faltante</b><span>Cuando falta efectivo, con la diferencia exacta.</span></div>
					</div>
					<ul class="pos-list" style="margin-top:22px;">
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Efectivo de apertura y de cierre lado a lado</li>
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Confirmación antes de cerrar, con quién y cuándo</li>
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Reporte de cierre en térmica o PDF</li>
					</ul>
				</div>
				<div class="pos-close-media">
					<?php $pos_video( 'calculo-billetes', 'Video: cálculo de billetes', 'Cuenta por denominación y cuadra la caja', 'pos_video_billetes' ); ?>
				</div>
			</div>

			<div class="pos-rows" style="margin-top:60px;">
				<div class="pos-row reverse">
					<div class="pos-row-text">
						<div class="pos-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="4" y="3" width="16" height="18" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M8 8h8M8 12h8M8 16h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
						<h3>Resumen de caja</h3>
						<p>El detalle completo del turno: efectivo en caja por moneda, ingresos de ventas y de contratos, gastos, propinas, facturas emitidas y resumen por vendedor.</p>
						<ul class="pos-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Totales de efectivo, gastos, anticipos y abonos</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Productos vendidos y órdenes procesadas</li>
						</ul>
					</div>
					<div class="pos-row-media"><?php $pos_shot( 'pos-resumen.png', '', 'pos_img_resumen' ); ?></div>
				</div>

				<div class="pos-row">
					<div class="pos-row-text">
						<div class="pos-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 5a2 2 0 012-2h11v18H6a2 2 0 01-2-2V5z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M17 3h1a2 2 0 012 2v14a2 2 0 01-2 2h-1M8 8h6M8 12h6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg></div>
						<h3>Libro de caja e historial</h3>
						<p>Consulta el libro de caja del turno y el historial de todas las cajas cerradas, con filtros por período, cajero y sucursal.</p>
						<ul class="pos-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Ingresos y salidas en orden cronológico</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Historial de cajas con apertura, cierre y diferencia</li>
						</ul>
					</div>
					<div class="pos-row-media"><?php $pos_shot( 'pos-libro.png', '', 'pos_img_libro' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- VIDEO: UNA VENTA EN ACCIÓN -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">En acción</div>
				<h2>Una venta completa, de principio a fin</h2>
				<p>Mira cómo se arma la orden, se cobra y se emite el comprobante.</p>
			</div>

			<div class="pos-video-wrap">
				<?php $pos_video( 'venta-pos', 'Video: una venta en el punto de venta', 'Arma la orden, cobra y factura', 'pos_video_venta' ); ?>
				<div class="cap">
					<b>Punto de venta en vivo</b>
					<span>Agrega productos, elige la forma de pago e imprime el comprobante</span>
				</div>
			</div>
		</div>
	</section>

	<!-- CAPACIDADES -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Todo lo que incluye</div>
				<h2>Pensado para el día a día de tu caja</h2>
			</div>
			<div class="feat-grid">
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M3 5h2l2.4 10.2a2 2 0 002 1.6h7.6a2 2 0 002-1.6L21 8H6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/><circle cx="10" cy="20" r="1.4" stroke="currentColor" stroke-width="1.6"/><circle cx="17" cy="20" r="1.4" stroke="currentColor" stroke-width="1.6"/></svg></div>
					<h3>Cobro rápido</h3>
					<p>Búsqueda por código de barras, combos y descuentos.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="2.5" y="5" width="19" height="14" rx="2.5" stroke="currentColor" stroke-width="1.7"/><path d="M2.5 9.5h19" stroke="currentColor" stroke-width="1.7"/></svg></div>
					<h3>Multipago</h3>
					<p>Efectivo, tarjeta, crédito, bonos y saldo a favor.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M6 9V3h12v6M6 18H4a2 2 0 01-2-2v-3a2 2 0 012-2h16a2 2 0 012 2v3a2 2 0 01-2 2h-2M6 14h12v7H6z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Facturación e impresión</h3>
					<p>Factura electrónica, recibo térmico y envío digital.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 6h16v12H4z" stroke="currentColor" stroke-width="1.7"/><path d="M8 10h8M8 14h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Arqueo de billetes</h3>
					<p>Cuenta por denominación y detecta sobrante o faltante.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M7 7h11l-3-3M17 17H6l3 3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Gastos y operaciones</h3>
					<p>Retiros, refuerzos, anticipos, abonos y retenciones.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="6" width="18" height="12" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M3 10h18" stroke="currentColor" stroke-width="1.7"/></svg></div>
					<h3>Cajas y subcajas</h3>
					<p>Varios puntos de cobro por sucursal, cada uno controlado.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- CTA -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="cta-strip">
				<h2><?php echo esc_html( vlac_opt( 'pos_cta_title', 'Pon a trabajar tu punto de venta hoy' ) ); ?></h2>
				<p><?php echo esc_html( vlac_opt( 'pos_cta_sub', 'Cobra más rápido, factura al instante y cierra cada turno cuadrado, con la caja conectada a tu inventario y tus ventas.' ) ); ?></p>
				<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'cta_btn_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
			</div>
		</div>
	</section>

</div>

<?php
get_footer();
