<?php
/**
 * Template Name: Inventario y Productos
 *
 * Página de producto del módulo de Gestión de Inventario y Productos.
 * Muestra el panel de inventario y sus herramientas: conteo de inventario
 * (con impresión térmica/PDF), situación de inventario (existencias),
 * registro de movimientos, traslados entre bodegas, gestión de traslados
 * y el catálogo de productos con su ficha.
 *
 * IMÁGENES (guárdalas en /assets/img/ con estos nombres exactos):
 *   inv-panel.png            → Panel de inventario (captura 1)
 *   inv-conteo.png           → Conteo de inventario (captura 2)
 *   inv-conteo-print.png     → Impresión del conteo — térmica / PDF (captura 3)
 *   inv-existencias.png      → Situación de inventario / existencias (captura 4)
 *   inv-movimientos.png      → Registro de movimientos de inventario (captura 5)
 *   inv-traslados.png        → Traslados entre bodegas (captura 6)
 *   inv-gestion-traslados.png→ Gestión / administración de traslados (captura 7)
 *   inv-productos.png        → Listado de productos (captura 8)
 *   inv-producto.png         → Ficha del producto (capturas 9-12)
 *   inv-hero.png             → (opcional) imagen destacada del hero
 *
 * VIDEO (opcional, guárdalo en /assets/video/):
 *   conteo-inventario.mp4    → flujo: escanear y contar productos
 * Mientras no exista, se muestra un marcador en su lugar.
 *
 * Para usarla: crea una página (Páginas → Añadir nueva) con el título
 * «Inventario y Productos» y el slug «inventario», y en «Atributos de
 * página → Plantilla» elige «Inventario y Productos». No necesita contenido.
 * Los textos se editan en Apariencia → Personalizar → Contenido del sitio →
 * «Página Inventario y Productos».
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
$inv_shot = function ( $file, $caption, $opt_key = '' ) use ( $img, $img_dir ) {
	$url    = $opt_key ? vlac_opt( $opt_key ) : '';
	$exists = file_exists( $img_dir . $file );
	echo '<figure class="inv-shot"><div class="inv-frame"><div class="bar"><i></i><i></i><i></i></div>';
	if ( $url ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $url ), esc_attr( $caption ) );
	} elseif ( $exists ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $img . '/' . $file ), esc_attr( $caption ) );
	} else {
		printf( '<div class="inv-ph inv-ph-img">Elige la imagen en <b>Personalizar → Página Inventario y Productos</b><br>o sube el archivo <code>assets/img/%s</code></div>', esc_html( $file ) );
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
$inv_video = function ( $base, $title, $sub, $opt_key = '' ) use ( $vid_dir, $vid_url ) {
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
	echo '<div class="inv-frame"><div class="bar"><i></i><i></i><i></i></div>';
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
		echo '<div class="inv-ph">';
		echo '<svg viewBox="0 0 24 24" fill="none"><path d="M4 5h16v14H4zM10 9l6 3-6 3V9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>';
		printf( '<b>%s</b><span>%s</span>', esc_html( $title ), esc_html( $sub ) );
		printf( '<code>assets/video/%s.mp4</code>', esc_html( $base ) );
		echo '</div>';
	}
	echo '</div>';
};
?>

<style>
	/* Estilos de la página de Inventario y Productos (ámbito local). */
	#inv-page{--inv-green:#2e9e5b;}

	/* HERO */
	#inv-page .inv-hero{position:relative;overflow:hidden;}
	#inv-page .inv-hero::before{content:"";position:absolute;inset:0;z-index:0;background:radial-gradient(700px 380px at 82% 8%,rgba(193,39,45,.07),transparent 60%),linear-gradient(180deg,#fff,var(--bg-alt));}
	#inv-page .inv-hero .hero-grid{position:relative;z-index:1;display:grid;grid-template-columns:1fr 1.12fr;gap:48px;align-items:center;padding:66px 0 84px;}
	#inv-page .inv-hero h1{font-size:clamp(32px,4.4vw,50px);font-weight:800;}
	#inv-page .inv-hero .lead{color:var(--muted);font-size:18px;margin:20px 0 8px;max-width:520px;}
	#inv-page .inv-hero .hero-cta{display:flex;gap:14px;flex-wrap:wrap;margin-top:28px;}
	#inv-page .inv-hero .hero-note{display:flex;align-items:center;gap:8px;font-size:13.5px;color:var(--muted);margin-top:22px;}
	#inv-page .inv-hero .hero-note svg{width:16px;height:16px;color:var(--inv-green);}

	/* Métricas rápidas bajo el hero */
	#inv-page .inv-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-top:34px;max-width:540px;}
	#inv-page .inv-stat{background:#fff;border:1px solid var(--line);border-radius:12px;padding:16px 18px;box-shadow:var(--shadow-sm);}
	#inv-page .inv-stat b{display:block;font-family:'Manrope';font-weight:800;font-size:21px;color:var(--red);line-height:1;}
	#inv-page .inv-stat span{display:block;color:var(--muted);font-size:12.5px;margin-top:7px;}

	/* MARCO (estilo navegador) para capturas y videos */
	#inv-page .inv-frame{background:#fff;border:1px solid #d9d9de;border-radius:14px;overflow:hidden;box-shadow:var(--shadow-md);}
	#inv-page .inv-frame .bar{display:flex;align-items:center;gap:6px;padding:9px 12px;background:#f3f3f5;border-bottom:1px solid #e6e6ea;}
	#inv-page .inv-frame .bar i{width:10px;height:10px;border-radius:50%;background:#d6d6dc;display:block;}
	#inv-page .inv-frame video,#inv-page .inv-frame img{width:100%;height:auto;display:block;background:#000;}
	#inv-page .inv-hero .inv-frame{box-shadow:var(--shadow-lg);}

	/* Marcador (placeholder) */
	#inv-page .inv-ph{aspect-ratio:16/10;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;text-align:center;background:var(--bg-alt);color:var(--muted);padding:24px;font-size:14px;}
	#inv-page .inv-ph svg{width:46px;height:46px;color:#c9c9d0;}
	#inv-page .inv-ph b{font-family:'Manrope';font-weight:700;color:var(--ink-strong);font-size:15px;}
	#inv-page .inv-ph code{font-size:13px;color:var(--red-dark);background:var(--red-soft);padding:4px 10px;border-radius:6px;}
	#inv-page .inv-ph-img{aspect-ratio:auto;padding:52px 20px;}

	/* HUB: tarjetas de herramientas del panel de inventario */
	#inv-page .inv-hub{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;}
	#inv-page .inv-tool{position:relative;background:#fff;border:1px solid var(--line);border-radius:var(--radius);padding:24px 22px;transition:transform .18s ease,box-shadow .18s ease,border-color .18s ease;overflow:hidden;}
	#inv-page .inv-tool::after{content:"";position:absolute;right:-40px;top:-40px;width:120px;height:120px;border-radius:50%;background:var(--red-soft);opacity:0;transition:opacity .2s ease;}
	#inv-page .inv-tool:hover{transform:translateY(-4px);box-shadow:var(--shadow-md);border-color:#e0d0d0;}
	#inv-page .inv-tool:hover::after{opacity:.6;}
	#inv-page .inv-tool>*{position:relative;z-index:1;}
	#inv-page .inv-tool .inv-ic{width:50px;height:50px;border-radius:13px;background:var(--red-soft);display:grid;place-items:center;margin-bottom:16px;}
	#inv-page .inv-tool .inv-ic svg{width:25px;height:25px;color:var(--red);}
	#inv-page .inv-tool h3{font-size:17px;font-weight:700;margin-bottom:7px;}
	#inv-page .inv-tool p{color:var(--muted);font-size:14px;}
	#inv-page .inv-tool .tag{display:inline-block;margin-top:14px;font-family:'Manrope';font-weight:700;font-size:11.5px;letter-spacing:.03em;text-transform:uppercase;color:var(--red-dark);background:var(--red-soft);padding:4px 10px;border-radius:999px;}

	/* FILAS ALTERNADAS (texto + imagen juntos) */
	#inv-page .inv-rows{display:flex;flex-direction:column;gap:60px;}
	#inv-page .inv-row{display:grid;grid-template-columns:1fr 1.15fr;gap:46px;align-items:center;}
	#inv-page .inv-row.reverse .inv-row-text{order:2;}
	#inv-page .inv-row.reverse .inv-row-media{order:1;}
	#inv-page .inv-row-text .inv-ic{width:52px;height:52px;border-radius:13px;background:var(--red-soft);display:grid;place-items:center;margin-bottom:18px;}
	#inv-page .inv-row-text .inv-ic svg{width:26px;height:26px;color:var(--red);}
	#inv-page .inv-row-text h3{font-size:clamp(20px,2.4vw,26px);font-weight:800;}
	#inv-page .inv-row-text p{color:var(--muted);font-size:16.5px;margin-top:14px;max-width:430px;}
	#inv-page .inv-row-text .inv-list{list-style:none;margin:18px 0 0;padding:0;display:flex;flex-direction:column;gap:10px;max-width:430px;}
	#inv-page .inv-row-text .inv-list li{display:flex;align-items:flex-start;gap:10px;color:var(--ink-strong);font-size:15px;}
	#inv-page .inv-row-text .inv-list svg{width:19px;height:19px;color:var(--inv-green);flex-shrink:0;margin-top:1px;}

	/* SECCIÓN DE VIDEO */
	#inv-page .inv-video-wrap{max-width:900px;margin:0 auto;}
	#inv-page .inv-video-wrap .cap{margin-top:16px;text-align:center;}
	#inv-page .inv-video-wrap .cap b{font-family:'Manrope';font-weight:700;font-size:16px;color:var(--ink-strong);display:block;}
	#inv-page .inv-video-wrap .cap span{color:var(--muted);font-size:14px;}

	@media (max-width:980px){
		#inv-page .inv-hub{grid-template-columns:repeat(2,1fr);}
	}
	@media (max-width:900px){
		#inv-page .inv-hero .hero-grid{grid-template-columns:1fr;gap:34px;padding:52px 0 56px;}
		#inv-page .inv-stats{max-width:none;}
		#inv-page .inv-row{grid-template-columns:1fr;gap:22px;}
		#inv-page .inv-row.reverse .inv-row-text{order:0;}
		#inv-page .inv-row.reverse .inv-row-media{order:0;}
	}
	@media (max-width:560px){
		#inv-page .inv-stats{grid-template-columns:1fr;}
		#inv-page .inv-hub{grid-template-columns:1fr;}
	}
</style>

<div id="inv-page">

	<!-- HERO -->
	<section class="inv-hero">
		<div class="wrap">
			<div class="hero-grid">
				<div class="hero-copy">
					<span class="eyebrow"><span class="dot"></span> <?php echo esc_html( vlac_opt( 'inv_eyebrow', 'Inventario y Productos' ) ); ?></span>
					<h1><?php echo wp_kses_post( vlac_opt( 'inv_title', 'Un solo <span class="accent">panel</span> para todo tu <span class="accent">inventario</span>' ) ); ?></h1>
					<p class="lead"><?php echo esc_html( vlac_opt( 'inv_sub', 'Conteos, existencias, movimientos y traslados entre bodegas, más un catálogo de productos completo con costos, precios e historial de inventario.' ) ); ?></p>
					<div class="hero-cta">
						<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'hero_cta1_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
						<a class="btn btn-ghost" href="<?php echo esc_url( vlac_opt( 'hero_cta2_url', '#' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta2_txt', 'Ver una demo' ) ); ?></a>
					</div>
					<div class="hero-note">
						<svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
						Conteo con lector · Movimientos auditables · Traslados entre sucursales
					</div>

					<div class="inv-stats">
						<div class="inv-stat"><b>Inversión</b><span>Valor de existencias en tiempo real</span></div>
						<div class="inv-stat"><b>Potencial</b><span>Proyección de ventas del stock</span></div>
						<div class="inv-stat"><b>Multibodega</b><span>Traslados entre tus sucursales</span></div>
					</div>
				</div>

				<div class="inv-visual">
					<?php
					$inv_hero_key  = vlac_opt( 'inv_img_hero' ) ? 'inv_img_hero' : 'inv_img_panel';
					$inv_hero_file = file_exists( $img_dir . 'inv-hero.png' ) ? 'inv-hero.png' : 'inv-panel.png';
					$inv_shot( $inv_hero_file, '', $inv_hero_key );
					?>
				</div>
			</div>
		</div>
	</section>

	<!-- PANEL: TODAS LAS HERRAMIENTAS -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Panel de inventario</div>
				<h2>Todas tus herramientas de inventario en un lugar</h2>
				<p>Accede al conteo, las existencias, los movimientos y los traslados desde un panel central, ordenado por lo que necesitas hacer.</p>
			</div>

			<div class="inv-hub">
				<div class="inv-tool">
					<div class="inv-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="6" y="4" width="12" height="16" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M9 4V3h6v1M9 10h6M9 14h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Conteo de inventario</h3>
					<p>Realiza y registra conteos físicos de productos en tus bodegas.</p>
					<span class="tag">Herramientas de conteo</span>
				</div>
				<div class="inv-tool">
					<div class="inv-ic"><svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.7"/><path d="M12 7v5l3 2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Historial de conteos</h3>
					<p>Consulta los conteos realizados previamente y su estado.</p>
					<span class="tag">Herramientas de conteo</span>
				</div>
				<div class="inv-tool">
					<div class="inv-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3zm0 0v18M4 7.5l8 4.5 8-4.5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg></div>
					<h3>Existencias</h3>
					<p>Consulta las existencias actuales, costos y precios de venta.</p>
					<span class="tag">Operaciones</span>
				</div>
				<div class="inv-tool">
					<div class="inv-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M7 7h11l-3-3M17 17H6l3 3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Movimientos</h3>
					<p>Historial detallado de entradas y salidas de inventario.</p>
					<span class="tag">Operaciones</span>
				</div>
				<div class="inv-tool">
					<div class="inv-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M21 12a9 9 0 01-9 9 9 9 0 01-7-3.3M3 12a9 9 0 019-9 9 9 0 017 3.3M20 4v4h-4M4 20v-4h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Actualización de inventario</h3>
					<p>Carga archivos o actualiza de forma masiva el stock.</p>
					<span class="tag">Operaciones</span>
				</div>
				<div class="inv-tool">
					<div class="inv-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M3 7h11v8H3zM14 10h4l3 3v2h-7z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="7" cy="18" r="1.6" stroke="currentColor" stroke-width="1.6"/><circle cx="17.5" cy="18" r="1.6" stroke="currentColor" stroke-width="1.6"/></svg></div>
					<h3>Traslados</h3>
					<p>Crea y envía traslados de mercancía entre tus sucursales.</p>
					<span class="tag">Traslados entre bodegas</span>
				</div>
				<div class="inv-tool">
					<div class="inv-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 15a3 3 0 100-6 3 3 0 000 6z" stroke="currentColor" stroke-width="1.7"/><path d="M19.4 13a1.6 1.6 0 00.3 1.8l.1.1a2 2 0 11-2.8 2.8l-.1-.1a1.6 1.6 0 00-2.7 1.1V19a2 2 0 11-4 0v-.1A1.6 1.6 0 006.8 17l-.1.1a2 2 0 11-2.8-2.8l.1-.1A1.6 1.6 0 004 12.6a2 2 0 010-4A1.6 1.6 0 005.3 6l-.1-.1a2 2 0 112.8-2.8l.1.1A1.6 1.6 0 0011 4V4a2 2 0 014 0A1.6 1.6 0 0017.2 6l.1-.1a2 2 0 112.8 2.8l-.1.1a1.6 1.6 0 001.4 2.2h.2a2 2 0 010 4h-.2z" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Gestión de traslados</h3>
					<p>Administra, autoriza, recibe o cancela traslados de inventario.</p>
					<span class="tag">Traslados entre bodegas</span>
				</div>
				<div class="inv-tool">
					<div class="inv-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M20 7L9 18l-5-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M20 12v6a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h9" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Productos</h3>
					<p>Catálogo completo con costos, precios, fotos e inventario.</p>
					<span class="tag">Catálogo</span>
				</div>
			</div>
		</div>
	</section>

	<!-- CONTEO DE INVENTARIO + IMPRESIÓN -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Conteo de inventario</div>
				<h2>Cuenta con el lector y compara físico contra sistema</h2>
				<p>Escanea, ajusta y detecta sobrantes, faltantes y exactos al instante; luego imprime el resultado en térmica o PDF.</p>
			</div>

			<div class="inv-rows">
				<div class="inv-row">
					<div class="inv-row-text">
						<div class="inv-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M3 6v12M7 6v12M11 6v12M15 6v12M19 6v12M21 6v12" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
						<h3>Escanea y cuenta</h3>
						<p>Escanea el código de barras con el lector o la cámara, ingresa el conteo físico y el sistema calcula la diferencia por producto.</p>
						<ul class="inv-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Lector, cámara o ingreso manual del código</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Resumen de sobrantes, faltantes y exactos</li>
						</ul>
					</div>
					<div class="inv-row-media"><?php $inv_shot( 'inv-conteo.png', '', 'inv_img_conteo' ); ?></div>
				</div>

				<div class="inv-row reverse">
					<div class="inv-row-text">
						<div class="inv-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M6 9V3h12v6M6 18H4a2 2 0 01-2-2v-3a2 2 0 012-2h16a2 2 0 012 2v3a2 2 0 01-2 2h-2M6 14h12v7H6z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
						<h3>Imprime el conteo</h3>
						<p>Genera el reporte del conteo con SKU, sistema, físico, diferencia y estado, listo para imprimir en formato térmico o exportar a PDF.</p>
						<ul class="inv-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Impresión térmica y PDF con tu logo</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Totales de sobrantes, faltantes y exactos</li>
						</ul>
					</div>
					<div class="inv-row-media"><?php $inv_shot( 'inv-conteo-print.png', '', 'inv_img_conteo_print' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- EXISTENCIAS Y MOVIMIENTOS -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Existencias y movimientos</div>
				<h2>Sabe cuánto tienes, cuánto vale y cómo se mueve</h2>
				<p>La situación de tu inventario y el detalle de cada entrada y salida, siempre auditable.</p>
			</div>

			<div class="inv-rows">
				<div class="inv-row">
					<div class="inv-row-text">
						<div class="inv-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3zm0 0v18M4 7.5l8 4.5 8-4.5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg></div>
						<h3>Situación de inventario</h3>
						<p>Inversión en existencias, potencial de ventas y cantidad de productos en tarjetas de un vistazo, con la existencia, costo y precio de venta de cada producto.</p>
						<ul class="inv-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Inversión, potencial y total de productos</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Búsqueda, categorías, filtros y descarga</li>
						</ul>
					</div>
					<div class="inv-row-media"><?php $inv_shot( 'inv-existencias.png', '', 'inv_img_existencias' ); ?></div>
				</div>

				<div class="inv-row reverse">
					<div class="inv-row-text">
						<div class="inv-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M7 7h11l-3-3M17 17H6l3 3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
						<h3>Registro de movimientos</h3>
						<p>Cada ingreso y salida con fecha, usuario, tipo, SKU, producto, existencias y cantidad anterior. Filtra por período, producto y categoría.</p>
						<ul class="inv-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Pestañas de todos, ingresos y salidas con totales</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Trazabilidad completa por usuario y fecha</li>
						</ul>
					</div>
					<div class="inv-row-media"><?php $inv_shot( 'inv-movimientos.png', '', 'inv_img_movimientos' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- TRASLADOS ENTRE BODEGAS -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Traslados entre bodegas</div>
				<h2>Mueve mercancía entre sucursales con control total</h2>
				<p>Del envío a la recepción, con estados claros y administración centralizada.</p>
			</div>

			<div class="inv-rows">
				<div class="inv-row">
					<div class="inv-row-text">
						<div class="inv-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M3 7h11v8H3zM14 10h4l3 3v2h-7z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="7" cy="18" r="1.6" stroke="currentColor" stroke-width="1.6"/><circle cx="17.5" cy="18" r="1.6" stroke="currentColor" stroke-width="1.6"/></svg></div>
						<h3>Traslados</h3>
						<p>Crea y envía traslados de productos entre tus bodegas, con totales por estado —solicitado, recepcionado y enviado— y el detalle de quién envía.</p>
						<ul class="inv-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Ingresos y salidas por traslado</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Filtros por período, código y quién envía</li>
						</ul>
					</div>
					<div class="inv-row-media"><?php $inv_shot( 'inv-traslados.png', '', 'inv_img_traslados' ); ?></div>
				</div>

				<div class="inv-row reverse">
					<div class="inv-row-text">
						<div class="inv-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 15a3 3 0 100-6 3 3 0 000 6z" stroke="currentColor" stroke-width="1.7"/><path d="M19.4 13a1.6 1.6 0 00.3 1.8l.1.1a2 2 0 11-2.8 2.8l-.1-.1a1.6 1.6 0 00-2.7 1.1V19a2 2 0 11-4 0v-.1A1.6 1.6 0 006.8 17l-.1.1a2 2 0 11-2.8-2.8l.1-.1A1.6 1.6 0 004 12.6a2 2 0 010-4A1.6 1.6 0 005.3 6l-.1-.1a2 2 0 112.8-2.8l.1.1A1.6 1.6 0 0011 4V4a2 2 0 014 0A1.6 1.6 0 0017.2 6l.1-.1a2 2 0 112.8 2.8l-.1.1a1.6 1.6 0 001.4 2.2h.2a2 2 0 010 4h-.2z" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
						<h3>Gestión de traslados</h3>
						<p>Administra todos los traslados por estado —anulado, solicitado, cotización, recepcionado y enviado—, autoriza, recibe o cancela, y consulta quién envía y quién recibe.</p>
						<ul class="inv-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Contadores por estado y acciones rápidas</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Origen y destino de cada traslado</li>
						</ul>
					</div>
					<div class="inv-row-media"><?php $inv_shot( 'inv-gestion-traslados.png', '', 'inv_img_gestion' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- PRODUCTOS -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Productos</div>
				<h2>Un catálogo que lo dice todo del producto</h2>
				<p>Desde el listado con filtros avanzados hasta la ficha con inventario, precios y opciones.</p>
			</div>

			<div class="inv-rows">
				<div class="inv-row">
					<div class="inv-row-text">
						<div class="inv-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></div>
						<h3>Listado de productos</h3>
						<p>Busca por SKU, código de barras o nombre y filtra por categoría, color, medida, marca, existencias, tipo, proveedor o ingrediente.</p>
						<ul class="inv-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Foto, SKU, código de barras y vencimiento</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Búsqueda por foto y descarga masiva</li>
						</ul>
					</div>
					<div class="inv-row-media"><?php $inv_shot( 'inv-productos.png', '', 'inv_img_productos' ); ?></div>
				</div>

				<div class="inv-row reverse">
					<div class="inv-row-text">
						<div class="inv-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="4" y="3" width="16" height="18" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M8 8h8M8 12h8M8 16h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
						<h3>Ficha del producto</h3>
						<p>Existencias, ganancia, tipo, SKU, costo, precio y código de barras; más el historial de inventario, las listas de precios y opciones avanzadas.</p>
						<ul class="inv-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Movimientos, precios y programación de horarios</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Sucursales, stock mínimo y avisos de vencimiento</li>
						</ul>
					</div>
					<div class="inv-row-media"><?php $inv_shot( 'inv-producto.png', '', 'inv_img_producto' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- VIDEO: CONTEO EN ACCIÓN -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">En acción</div>
				<h2>Un conteo de inventario, paso a paso</h2>
				<p>Mira cómo se escanea, se ajusta el físico y se resuelven las diferencias.</p>
			</div>

			<div class="inv-video-wrap">
				<?php $inv_video( 'conteo-inventario', 'Video: conteo de inventario', 'Escanea, cuenta y guarda', 'inv_video_conteo' ); ?>
				<div class="cap">
					<b>Conteo de inventario en vivo</b>
					<span>Escanea productos, compara físico contra sistema y guarda el conteo</span>
				</div>
			</div>
		</div>
	</section>

	<!-- CAPACIDADES -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Todo lo que incluye</div>
				<h2>Pensado para el control de tu stock</h2>
			</div>
			<div class="feat-grid">
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="6" y="4" width="12" height="16" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M9 4V3h6v1M9 10h6M9 14h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Conteo con lector</h3>
					<p>Escanea, compara físico contra sistema e imprime.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3zm0 0v18M4 7.5l8 4.5 8-4.5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg></div>
					<h3>Existencias valorizadas</h3>
					<p>Inversión, potencial de ventas y costo por producto.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M7 7h11l-3-3M17 17H6l3 3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Movimientos auditables</h3>
					<p>Cada entrada y salida con usuario, fecha y razón.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M3 7h11v8H3zM14 10h4l3 3v2h-7z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="7" cy="18" r="1.6" stroke="currentColor" stroke-width="1.6"/><circle cx="17.5" cy="18" r="1.6" stroke="currentColor" stroke-width="1.6"/></svg></div>
					<h3>Traslados multibodega</h3>
					<p>Envía, recibe y administra traslados entre sucursales.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M21 12a9 9 0 01-9 9 9 9 0 01-7-3.3M3 12a9 9 0 019-9 9 9 0 017 3.3M20 4v4h-4M4 20v-4h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Actualización masiva</h3>
					<p>Carga archivos para actualizar el stock de golpe.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M20 7L9 18l-5-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M20 12v6a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h9" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Catálogo completo</h3>
					<p>Precios, listas, fotos, historial y opciones por producto.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- CTA -->
	<section class="section">
		<div class="wrap">
			<div class="cta-strip">
				<h2><?php echo esc_html( vlac_opt( 'inv_cta_title', 'Toma el control de tu inventario hoy' ) ); ?></h2>
				<p><?php echo esc_html( vlac_opt( 'inv_cta_sub', 'Cuenta, valoriza, mueve y controla tu stock desde un solo panel conectado a tus ventas y compras.' ) ); ?></p>
				<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'cta_btn_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
			</div>
		</div>
	</section>

</div>

<?php
get_footer();
