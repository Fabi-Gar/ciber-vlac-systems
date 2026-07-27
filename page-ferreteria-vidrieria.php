<?php
/**
 * Template Name: Ferretería y Vidriería
 *
 * Página de rubro para ferreterías y vidrierías, resuelta con el molde de
 * módulo (CSS del tema + placeholders en el Personalizador). Recorre lo que
 * este negocio necesita del sistema: miles de artículos con unidad de medida
 * (unidad, metro, libra, m²), compras y proveedores, cotizaciones, etiquetas
 * con código de barras, inventario por bodega y punto de venta.
 *
 * IMÁGENES (guárdalas en /assets/img/ con estos nombres exactos):
 *   fer-medidas.png      → Ficha del artículo con su unidad de medida (captura 1)
 *   fer-catalogo.png     → Catálogo / listado de artículos con filtros (captura 2)
 *   fer-hero.png         → (opcional) imagen destacada del hero
 *
 * VIDEOS (guárdalos en /assets/video/):
 *   cotizacion-ferreteria.mp4 → armar la cotización de un trabajo y exportar en PDF
 *   existencias-bodega.mp4    → consultar existencias por bodega
 *   venta-ferreteria.mp4      → flujo: buscar el artículo, cobrar y facturar
 * Mientras no existan, se muestra un marcador en su lugar.
 *
 * Para usarla: crea una página (Páginas → Añadir nueva) con el título
 * «Ferretería y Vidriería» y el slug «ferreteria-vidrieria», y en «Atributos
 * de página → Plantilla» elige «Ferretería y Vidriería». No necesita contenido.
 * Los textos se editan en Apariencia → Personalizar → Contenido del sitio →
 * «Página Ferretería y Vidriería».
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
$fer_shot = function ( $file, $caption, $opt_key = '' ) use ( $img, $img_dir ) {
	$url    = $opt_key ? vlac_opt( $opt_key ) : '';
	$exists = file_exists( $img_dir . $file );
	echo '<figure class="fer-shot"><div class="fer-frame"><div class="bar"><i></i><i></i><i></i></div>';
	if ( $url ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $url ), esc_attr( $caption ) );
	} elseif ( $exists ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $img . '/' . $file ), esc_attr( $caption ) );
	} else {
		printf( '<div class="fer-ph fer-ph-img">Elige la imagen en <b>Personalizar → Página Ferretería y Vidriería</b><br>o sube el archivo <code>assets/img/%s</code></div>', esc_html( $file ) );
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
$fer_video = function ( $base, $title, $sub, $opt_key = '' ) use ( $vid_dir, $vid_url ) {
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
	echo '<div class="fer-frame"><div class="bar"><i></i><i></i><i></i></div>';
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
		echo '<div class="fer-ph">';
		echo '<svg viewBox="0 0 24 24" fill="none"><path d="M4 5h16v14H4zM10 9l6 3-6 3V9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>';
		printf( '<b>%s</b><span>%s</span>', esc_html( $title ), esc_html( $sub ) );
		printf( '<code>assets/video/%s.mp4</code>', esc_html( $base ) );
		echo '</div>';
	}
	echo '</div>';
};
?>

<style>
	/* Estilos de la página de Ferretería y Vidriería (ámbito local). */
	#fer-page{--fer-green:#2e9e5b;}

	/* HERO */
	#fer-page .fer-hero{position:relative;overflow:hidden;}
	#fer-page .fer-hero::before{content:"";position:absolute;inset:0;z-index:0;background:radial-gradient(720px 380px at 84% 6%,rgba(193,39,45,.08),transparent 62%),linear-gradient(180deg,#fff,var(--bg-alt));}
	#fer-page .fer-hero .hero-grid{position:relative;z-index:1;display:grid;grid-template-columns:1fr 1.12fr;gap:48px;align-items:center;padding:66px 0 84px;}
	#fer-page .fer-hero h1{font-size:clamp(32px,4.4vw,50px);font-weight:800;}
	#fer-page .fer-hero .lead{color:var(--muted);font-size:18px;margin:20px 0 8px;max-width:520px;}
	#fer-page .fer-hero .hero-cta{display:flex;gap:14px;flex-wrap:wrap;margin-top:28px;}
	#fer-page .fer-hero .hero-note{display:flex;align-items:center;gap:8px;font-size:13.5px;color:var(--muted);margin-top:22px;}
	#fer-page .fer-hero .hero-note svg{width:16px;height:16px;color:var(--fer-green);flex-shrink:0;}

	/* Métricas rápidas bajo el hero */
	#fer-page .fer-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-top:34px;max-width:540px;}
	#fer-page .fer-stat{background:#fff;border:1px solid var(--line);border-radius:12px;padding:16px 18px;box-shadow:var(--shadow-sm);}
	#fer-page .fer-stat b{display:block;font-family:'Manrope';font-weight:800;font-size:21px;color:var(--red);line-height:1;}
	#fer-page .fer-stat span{display:block;color:var(--muted);font-size:12.5px;margin-top:7px;}

	/* MARCO (estilo navegador) para capturas y videos */
	#fer-page .fer-frame{background:#fff;border:1px solid #d9d9de;border-radius:14px;overflow:hidden;box-shadow:var(--shadow-md);}
	#fer-page .fer-frame .bar{display:flex;align-items:center;gap:6px;padding:9px 12px;background:#f3f3f5;border-bottom:1px solid #e6e6ea;}
	#fer-page .fer-frame .bar i{width:10px;height:10px;border-radius:50%;background:#d6d6dc;display:block;}
	#fer-page .fer-frame video,#fer-page .fer-frame img{width:100%;height:auto;display:block;background:#000;}
	#fer-page .fer-hero .fer-frame{box-shadow:var(--shadow-lg);}
	/* Hero con foto real (sin barra de navegador). */
	#fer-page .fer-hero-photo{width:100%;height:auto;display:block;border-radius:var(--radius);box-shadow:var(--shadow-lg);object-fit:cover;}
	#fer-page .fer-shot{margin:0;}
	#fer-page .fer-shot figcaption{margin-top:12px;text-align:center;color:var(--muted);font-size:13.5px;}

	/* Marcador (placeholder) */
	#fer-page .fer-ph{aspect-ratio:16/10;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;text-align:center;background:var(--bg-alt);color:var(--muted);padding:24px;font-size:14px;}
	#fer-page .fer-ph svg{width:46px;height:46px;color:#c9c9d0;}
	#fer-page .fer-ph b{font-family:'Manrope';font-weight:700;color:var(--ink-strong);font-size:15px;}
	#fer-page .fer-ph code{font-size:13px;color:var(--red-dark);background:var(--red-soft);padding:4px 10px;border-radius:6px;}
	#fer-page .fer-ph-img{aspect-ratio:auto;padding:52px 20px;}

	/* CHIPS de unidades de medida (visual propio de esta página) */
	#fer-page .fer-units{display:flex;flex-wrap:wrap;gap:10px;margin-top:18px;max-width:440px;}
	#fer-page .fer-unit{display:inline-flex;align-items:center;gap:7px;background:#fff;border:1px solid var(--line);border-radius:999px;padding:7px 14px;font-size:13.5px;font-family:'Manrope';font-weight:700;color:var(--ink-strong);box-shadow:var(--shadow-sm);}
	#fer-page .fer-unit i{width:7px;height:7px;border-radius:50%;background:var(--red);display:block;}

	/* HUB: tarjetas de lo que resuelve */
	#fer-page .fer-hub{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;}
	#fer-page .fer-tool{position:relative;background:#fff;border:1px solid var(--line);border-radius:var(--radius);padding:24px 22px;transition:transform .18s ease,box-shadow .18s ease,border-color .18s ease;overflow:hidden;}
	#fer-page .fer-tool::after{content:"";position:absolute;right:-40px;top:-40px;width:120px;height:120px;border-radius:50%;background:var(--red-soft);opacity:0;transition:opacity .2s ease;}
	#fer-page .fer-tool:hover{transform:translateY(-4px);box-shadow:var(--shadow-md);border-color:#e0d0d0;}
	#fer-page .fer-tool:hover::after{opacity:.6;}
	#fer-page .fer-tool>*{position:relative;z-index:1;}
	#fer-page .fer-tool .fer-ic{width:50px;height:50px;border-radius:13px;background:var(--red-soft);display:grid;place-items:center;margin-bottom:16px;}
	#fer-page .fer-tool .fer-ic svg{width:25px;height:25px;color:var(--red);}
	#fer-page .fer-tool h3{font-size:17px;font-weight:700;margin-bottom:7px;}
	#fer-page .fer-tool p{color:var(--muted);font-size:14px;}

	/* FILAS ALTERNADAS (texto + imagen juntos) */
	#fer-page .fer-rows{display:flex;flex-direction:column;gap:60px;}
	#fer-page .fer-row{display:grid;grid-template-columns:1fr 1.15fr;gap:46px;align-items:center;}
	#fer-page .fer-row.reverse .fer-row-text{order:2;}
	#fer-page .fer-row.reverse .fer-row-media{order:1;}
	#fer-page .fer-row-text .fer-ic{width:52px;height:52px;border-radius:13px;background:var(--red-soft);display:grid;place-items:center;margin-bottom:18px;}
	#fer-page .fer-row-text .fer-ic svg{width:26px;height:26px;color:var(--red);}
	#fer-page .fer-row-text h3{font-size:clamp(20px,2.4vw,26px);font-weight:800;}
	#fer-page .fer-row-text p{color:var(--muted);font-size:16.5px;margin-top:14px;max-width:430px;}
	#fer-page .fer-list{list-style:none;margin:18px 0 0;padding:0;display:flex;flex-direction:column;gap:10px;max-width:430px;}
	#fer-page .fer-list li{display:flex;align-items:flex-start;gap:10px;color:var(--ink-strong);font-size:15px;}
	#fer-page .fer-list li svg{width:19px;height:19px;color:var(--fer-green);flex-shrink:0;margin-top:1px;}

	/* SECCIÓN DE VIDEO */
	#fer-page .fer-video-wrap{max-width:900px;margin:0 auto;}
	#fer-page .fer-video-wrap .cap{margin-top:16px;text-align:center;}
	#fer-page .fer-video-wrap .cap b{font-family:'Manrope';font-weight:700;font-size:16px;color:var(--ink-strong);display:block;}
	#fer-page .fer-video-wrap .cap span{color:var(--muted);font-size:14px;}

	@media (max-width:980px){
		#fer-page .fer-hub{grid-template-columns:repeat(2,1fr);}
	}
	@media (max-width:900px){
		#fer-page .fer-hero .hero-grid{grid-template-columns:1fr;gap:34px;padding:52px 0 56px;}
		#fer-page .fer-stats{max-width:none;}
		#fer-page .fer-row{grid-template-columns:1fr;gap:22px;}
		#fer-page .fer-row.reverse .fer-row-text{order:0;}
		#fer-page .fer-row.reverse .fer-row-media{order:0;}
	}
	@media (max-width:560px){
		#fer-page .fer-stats{grid-template-columns:1fr;}
		#fer-page .fer-hub{grid-template-columns:1fr;}
	}
</style>

<div id="fer-page">

	<!-- HERO -->
	<section class="fer-hero">
		<div class="wrap">
			<div class="hero-grid">
				<div class="hero-copy">
					<span class="eyebrow"><span class="dot"></span> <?php echo esc_html( vlac_opt( 'fer_eyebrow', 'Ferretería y Vidriería' ) ); ?></span>
					<h1><?php echo wp_kses_post( vlac_opt( 'fer_title', 'El sistema para tu <span class="accent">ferretería</span> y <span class="accent">vidriería</span>' ) ); ?></h1>
					<p class="lead"><?php echo esc_html( vlac_opt( 'fer_sub', 'Maneja miles de artículos con su unidad de medida, cotiza trabajos y vende rápido en caja, con tu inventario por bodega siempre al día.' ) ); ?></p>
					<div class="hero-cta">
						<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'hero_cta1_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
						<a class="btn btn-ghost" href="<?php echo esc_url( vlac_opt( 'hero_cta2_url', '#' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta2_txt', 'Ver una demo' ) ); ?></a>
					</div>
					<div class="hero-note">
						<svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
						Venta por unidad, metro o m² · Cotizaciones · Inventario multibodega
					</div>

					<div class="fer-stats">
						<div class="fer-stat"><b>Por medida</b><span>Unidad, metro, libra o m²</span></div>
						<div class="fer-stat"><b>Cotiza</b><span>Presupuesta un trabajo</span></div>
						<div class="fer-stat"><b>Multibodega</b><span>Existencias por sucursal</span></div>
					</div>
				</div>

				<div class="fer-visual">
					<?php
					// El hero muestra una foto real de la ferretería (sin barra de
					// navegador). Prioridad: imagen del Personalizador, luego el
					// archivo /assets/img/fer-hero.png, y si no hay, un marcador.
					$fer_hero_url = vlac_opt( 'fer_img_hero' );
					if ( ! $fer_hero_url && file_exists( $img_dir . 'fer-hero.png' ) ) {
						$fer_hero_url = $img . '/fer-hero.png';
					}
					if ( $fer_hero_url ) {
						printf( '<img class="fer-hero-photo" src="%s" alt="%s" loading="lazy" />', esc_url( $fer_hero_url ), esc_attr( get_the_title() ) );
					} else {
						echo '<div class="fer-frame"><div class="fer-ph fer-ph-img">Sube una foto de la ferretería en <b>Personalizar → Página Ferretería y Vidriería → Hero</b><br>o el archivo <code>assets/img/fer-hero.png</code></div></div>';
					}
					?>
				</div>
			</div>
		</div>
	</section>

	<!-- LO QUE RESUELVE -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Pensado para el rubro</div>
				<h2>Lo que una ferretería y vidriería necesita, resuelto</h2>
				<p>De miles de artículos con su medida a las cotizaciones, el inventario y la venta en caja.</p>
			</div>

			<div class="fer-hub">
				<div class="fer-tool">
					<div class="fer-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 7h16M4 12h16M4 17h10" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Miles de artículos</h3>
					<p>Catálogo grande con marca, categoría y código de barras, siempre buscable.</p>
				</div>
				<div class="fer-tool">
					<div class="fer-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M3 12h18M6 9l-3 3 3 3M18 9l3 3-3 3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Unidad de medida</h3>
					<p>Vende por unidad, metro, libra, m² o la medida que definas.</p>
				</div>
				<div class="fer-tool">
					<div class="fer-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="4" y="3" width="16" height="18" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M8 8h8M8 12h8M8 16h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Cotizaciones</h3>
					<p>Presupuesta un trabajo y conviértelo en venta cuando lo aprueben.</p>
				</div>
				<div class="fer-tool">
					<div class="fer-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3zm0 0v18M4 7.5l8 4.5 8-4.5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg></div>
					<h3>Inventario multibodega</h3>
					<p>Existencias por bodega y traslados entre tus sucursales.</p>
				</div>
				<div class="fer-tool">
					<div class="fer-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M3 5h2l2.4 10.2a2 2 0 002 1.6h7.6a2 2 0 002-1.6L21 8H6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><circle cx="10" cy="20" r="1.4" stroke="currentColor" stroke-width="1.5"/><circle cx="17" cy="20" r="1.4" stroke="currentColor" stroke-width="1.5"/></svg></div>
					<h3>Punto de venta</h3>
					<p>Cobra rápido en mostrador con cualquier forma de pago.</p>
				</div>
				<div class="fer-tool">
					<div class="fer-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 19V5M4 19h16M8 16l3-4 3 2 4-6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Informes</h3>
					<p>Qué se vende, cuánto ganas y qué te queda, por período.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- ARTÍCULOS Y MEDIDAS -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Artículos y medidas</div>
				<h2>Cada artículo con la medida en la que lo vendes</h2>
				<p>Desde un tornillo por unidad hasta el vidrio por m² o el cable por metro, sin cuentas a mano.</p>
			</div>

			<div class="fer-rows">
				<div class="fer-row">
					<div class="fer-row-text">
						<div class="fer-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M3 12h18M6 9l-3 3 3 3M18 9l3 3-3 3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
						<h3>Unidad de medida por artículo</h3>
						<p>Define en qué unidad se vende cada artículo y crea las que necesites. El precio y la existencia se manejan en esa misma medida.</p>
						<div class="fer-units">
							<span class="fer-unit"><i></i>Unidad</span>
							<span class="fer-unit"><i></i>Metro</span>
							<span class="fer-unit"><i></i>Libra</span>
							<span class="fer-unit"><i></i>m²</span>
							<span class="fer-unit"><i></i>Pliego</span>
							<span class="fer-unit"><i></i>Quintal</span>
						</div>
						<ul class="fer-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Crea tus propias medidas cuando las necesites</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Marca, categoría, costo, precio y código de barras</li>
						</ul>
					</div>
					<div class="fer-row-media"><?php $fer_shot( 'fer-medidas.png', '', 'fer_img_medidas' ); ?></div>
				</div>

				<div class="fer-row reverse">
					<div class="fer-row-text">
						<div class="fer-ic"><svg viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="1.7"/><path d="M20 20l-3.5-3.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></div>
						<h3>Catálogo grande y buscable</h3>
						<p>Encuentra cualquier artículo por nombre, SKU o código y fíltralo por categoría o marca, aunque manejes miles de referencias.</p>
						<ul class="fer-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Búsqueda rápida entre miles de referencias</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Filtros por categoría y marca</li>
						</ul>
					</div>
					<div class="fer-row-media"><?php $fer_shot( 'fer-catalogo.png', '', 'fer_img_catalogo' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- COTIZACIONES E INVENTARIO -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Cotizaciones e inventario</div>
				<h2>Cotiza el trabajo y controla lo que hay</h2>
				<p>Del presupuesto a la venta aprobada, con tus existencias por bodega siempre al día.</p>
			</div>

			<div class="fer-rows">
				<div class="fer-row">
					<div class="fer-row-text">
						<div class="fer-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="4" y="3" width="16" height="18" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M8 8h8M8 12h8M8 16h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
						<h3>Cotizaciones</h3>
						<p>Arma la cotización de un trabajo con sus artículos y medidas, entrégala en PDF y conviértela en venta cuando el cliente la apruebe.</p>
						<ul class="fer-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Cotización en PDF con tu logo</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>De la cotización aprobada a la factura</li>
						</ul>
					</div>
					<div class="fer-row-media"><?php $fer_video( 'cotizacion-ferreteria', 'Video: cotización de un trabajo', 'Arma la cotización y entrégala en PDF', 'fer_video_cotizacion' ); ?></div>
				</div>

				<div class="fer-row reverse">
					<div class="fer-row-text">
						<div class="fer-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3zm0 0v18M4 7.5l8 4.5 8-4.5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg></div>
						<h3>Existencias por bodega</h3>
						<p>Consulta cuánto tienes de cada artículo en cada bodega o sucursal, con su costo y precio, y traslada mercadería cuando la necesites.</p>
						<ul class="fer-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Stock por bodega y traslados entre sucursales</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Stock mínimo y movimientos auditables</li>
						</ul>
					</div>
					<div class="fer-row-media"><?php $fer_video( 'existencias-bodega', 'Video: existencias por bodega', 'Consulta el stock de cada bodega', 'fer_video_existencias' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- VIDEO: UNA VENTA -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">En acción</div>
				<h2>Una venta de mostrador, de principio a fin</h2>
				<p>Mira cómo se busca el artículo, se cobra y se entrega el comprobante.</p>
			</div>

			<div class="fer-video-wrap">
				<?php $fer_video( 'venta-ferreteria', 'Video: una venta de mostrador', 'Busca el artículo, cobra y factura', 'fer_video_venta' ); ?>
				<div class="cap">
					<b>Venta de mostrador en vivo</b>
					<span>Busca el artículo, elige la forma de pago y emite el comprobante</span>
				</div>
			</div>
		</div>
	</section>

	<!-- CAPACIDADES -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Todo lo que incluye</div>
				<h2>Pensado para el día a día de tu negocio</h2>
			</div>
			<div class="feat-grid">
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M3 12h18M6 9l-3 3 3 3M18 9l3 3-3 3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Venta por medida</h3>
					<p>Unidad, metro, libra, m² o la medida que definas.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 7h16M4 12h16M4 17h10" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Catálogo enorme</h3>
					<p>Miles de artículos con marca y categoría.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="4" y="3" width="16" height="18" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M8 8h8M8 12h8M8 16h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Cotizaciones</h3>
					<p>Presupuesta y convierte en venta al aprobar.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3zm0 0v18M4 7.5l8 4.5 8-4.5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg></div>
					<h3>Inventario multibodega</h3>
					<p>Existencias por bodega y traslados.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M3 5h2l2.4 10.2a2 2 0 002 1.6h7.6a2 2 0 002-1.6L21 8H6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><circle cx="10" cy="20" r="1.4" stroke="currentColor" stroke-width="1.5"/><circle cx="17" cy="20" r="1.4" stroke="currentColor" stroke-width="1.5"/></svg></div>
					<h3>Punto de venta</h3>
					<p>Cobra rápido en mostrador con cualquier forma de pago.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 19V5M4 19h16M8 16l3-4 3 2 4-6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Informes</h3>
					<p>Qué se vende, cuánto ganas y qué te queda.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- CTA -->
	<section class="section">
		<div class="wrap">
			<div class="cta-strip">
				<h2><?php echo esc_html( vlac_opt( 'fer_cta_title', 'Ordena tu ferretería y vidriería hoy' ) ); ?></h2>
				<p><?php echo esc_html( vlac_opt( 'fer_cta_sub', 'Controla miles de artículos por medida, cotiza y vende desde un solo sistema conectado.' ) ); ?></p>
				<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'cta_btn_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
			</div>
		</div>
	</section>

</div>

<?php
get_footer();
