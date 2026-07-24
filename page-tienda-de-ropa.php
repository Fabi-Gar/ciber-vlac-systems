<?php
/**
 * Template Name: Tienda de Ropa
 *
 * Página de rubro para tiendas de ropa, resuelta con el molde de módulo
 * (CSS del tema + placeholders en el Personalizador). Recorre lo que una
 * tienda de ropa necesita del sistema: variantes por talla y color,
 * inventario por variante, etiquetas con código de barras, catálogo con
 * fotos, punto de venta e informes por temporada.
 *
 * IMÁGENES (guárdalas en /assets/img/ con estos nombres exactos):
 *   ropa-producto.png    → Ficha del producto con color, talla y marca (captura 1)
 *   ropa-existencias.png → Existencias por variante / SKU (captura 2)
 *   ropa-etiquetas.png   → Etiqueta con código de barras (captura 3)
 *   ropa-catalogo.png    → Catálogo / listado con fotos (captura 4)
 *   ropa-informes.png    → Informe de ventas por temporada (captura 5)
 *   ropa-hero.png        → (opcional) imagen destacada del hero
 *
 * VIDEOS (guárdalos en /assets/video/):
 *   variantes-ropa.mp4   → registrar una prenda con sus tallas, colores y marca
 *   venta-ropa.mp4       → flujo: realizar una venta y cobrar
 * Mientras no existan, se muestra un marcador en su lugar.
 *
 * Para usarla: crea una página (Páginas → Añadir nueva) con el título
 * «Tienda de Ropa» y el slug «tienda-de-ropa», y en «Atributos de página →
 * Plantilla» elige «Tienda de Ropa». No necesita contenido.
 * Los textos se editan en Apariencia → Personalizar → Contenido del sitio →
 * «Página Tienda de Ropa».
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
$ropa_shot = function ( $file, $caption, $opt_key = '' ) use ( $img, $img_dir ) {
	$url    = $opt_key ? vlac_opt( $opt_key ) : '';
	$exists = file_exists( $img_dir . $file );
	echo '<figure class="ropa-shot"><div class="ropa-frame"><div class="bar"><i></i><i></i><i></i></div>';
	if ( $url ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $url ), esc_attr( $caption ) );
	} elseif ( $exists ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $img . '/' . $file ), esc_attr( $caption ) );
	} else {
		printf( '<div class="ropa-ph ropa-ph-img">Elige la imagen en <b>Personalizar → Página Tienda de Ropa</b><br>o sube el archivo <code>assets/img/%s</code></div>', esc_html( $file ) );
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
$ropa_video = function ( $base, $title, $sub, $opt_key = '' ) use ( $vid_dir, $vid_url ) {
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
	echo '<div class="ropa-frame"><div class="bar"><i></i><i></i><i></i></div>';
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
		echo '<div class="ropa-ph">';
		echo '<svg viewBox="0 0 24 24" fill="none"><path d="M4 5h16v14H4zM10 9l6 3-6 3V9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>';
		printf( '<b>%s</b><span>%s</span>', esc_html( $title ), esc_html( $sub ) );
		printf( '<code>assets/video/%s.mp4</code>', esc_html( $base ) );
		echo '</div>';
	}
	echo '</div>';
};
?>

<style>
	/* Estilos de la página de Tienda de Ropa (ámbito local). */
	#ropa-page{--ropa-green:#2e9e5b;}

	/* HERO */
	#ropa-page .ropa-hero{position:relative;overflow:hidden;}
	#ropa-page .ropa-hero::before{content:"";position:absolute;inset:0;z-index:0;background:radial-gradient(720px 380px at 84% 6%,rgba(193,39,45,.08),transparent 62%),linear-gradient(180deg,#fff,var(--bg-alt));}
	#ropa-page .ropa-hero .hero-grid{position:relative;z-index:1;display:grid;grid-template-columns:1fr 1.12fr;gap:48px;align-items:center;padding:66px 0 84px;}
	#ropa-page .ropa-hero h1{font-size:clamp(32px,4.4vw,50px);font-weight:800;}
	#ropa-page .ropa-hero .lead{color:var(--muted);font-size:18px;margin:20px 0 8px;max-width:520px;}
	#ropa-page .ropa-hero .hero-cta{display:flex;gap:14px;flex-wrap:wrap;margin-top:28px;}
	#ropa-page .ropa-hero .hero-note{display:flex;align-items:center;gap:8px;font-size:13.5px;color:var(--muted);margin-top:22px;}
	#ropa-page .ropa-hero .hero-note svg{width:16px;height:16px;color:var(--ropa-green);flex-shrink:0;}

	/* Métricas rápidas bajo el hero */
	#ropa-page .ropa-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-top:34px;max-width:540px;}
	#ropa-page .ropa-stat{background:#fff;border:1px solid var(--line);border-radius:12px;padding:16px 18px;box-shadow:var(--shadow-sm);}
	#ropa-page .ropa-stat b{display:block;font-family:'Manrope';font-weight:800;font-size:21px;color:var(--red);line-height:1;}
	#ropa-page .ropa-stat span{display:block;color:var(--muted);font-size:12.5px;margin-top:7px;}

	/* MARCO (estilo navegador) para capturas y videos */
	#ropa-page .ropa-frame{background:#fff;border:1px solid #d9d9de;border-radius:14px;overflow:hidden;box-shadow:var(--shadow-md);}
	#ropa-page .ropa-frame .bar{display:flex;align-items:center;gap:6px;padding:9px 12px;background:#f3f3f5;border-bottom:1px solid #e6e6ea;}
	#ropa-page .ropa-frame .bar i{width:10px;height:10px;border-radius:50%;background:#d6d6dc;display:block;}
	#ropa-page .ropa-frame video,#ropa-page .ropa-frame img{width:100%;height:auto;display:block;background:#000;}
	#ropa-page .ropa-hero .ropa-frame{box-shadow:var(--shadow-lg);}
	#ropa-page .ropa-shot{margin:0;}
	#ropa-page .ropa-shot figcaption{margin-top:12px;text-align:center;color:var(--muted);font-size:13.5px;}

	/* Marcador (placeholder) */
	#ropa-page .ropa-ph{aspect-ratio:16/10;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;text-align:center;background:var(--bg-alt);color:var(--muted);padding:24px;font-size:14px;}
	#ropa-page .ropa-ph svg{width:46px;height:46px;color:#c9c9d0;}
	#ropa-page .ropa-ph b{font-family:'Manrope';font-weight:700;color:var(--ink-strong);font-size:15px;}
	#ropa-page .ropa-ph code{font-size:13px;color:var(--red-dark);background:var(--red-soft);padding:4px 10px;border-radius:6px;}
	#ropa-page .ropa-ph-img{aspect-ratio:auto;padding:52px 20px;}

	/* HUB: tarjetas de lo que resuelve */
	#ropa-page .ropa-hub{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;}
	#ropa-page .ropa-tool{position:relative;background:#fff;border:1px solid var(--line);border-radius:var(--radius);padding:24px 22px;transition:transform .18s ease,box-shadow .18s ease,border-color .18s ease;overflow:hidden;}
	#ropa-page .ropa-tool::after{content:"";position:absolute;right:-40px;top:-40px;width:120px;height:120px;border-radius:50%;background:var(--red-soft);opacity:0;transition:opacity .2s ease;}
	#ropa-page .ropa-tool:hover{transform:translateY(-4px);box-shadow:var(--shadow-md);border-color:#e0d0d0;}
	#ropa-page .ropa-tool:hover::after{opacity:.6;}
	#ropa-page .ropa-tool>*{position:relative;z-index:1;}
	#ropa-page .ropa-tool .ropa-ic{width:50px;height:50px;border-radius:13px;background:var(--red-soft);display:grid;place-items:center;margin-bottom:16px;}
	#ropa-page .ropa-tool .ropa-ic svg{width:25px;height:25px;color:var(--red);}
	#ropa-page .ropa-tool h3{font-size:17px;font-weight:700;margin-bottom:7px;}
	#ropa-page .ropa-tool p{color:var(--muted);font-size:14px;}

	/* FILAS ALTERNADAS (texto + imagen juntos) */
	#ropa-page .ropa-rows{display:flex;flex-direction:column;gap:60px;}
	#ropa-page .ropa-row{display:grid;grid-template-columns:1fr 1.15fr;gap:46px;align-items:center;}
	#ropa-page .ropa-row.reverse .ropa-row-text{order:2;}
	#ropa-page .ropa-row.reverse .ropa-row-media{order:1;}
	#ropa-page .ropa-row-text .ropa-ic{width:52px;height:52px;border-radius:13px;background:var(--red-soft);display:grid;place-items:center;margin-bottom:18px;}
	#ropa-page .ropa-row-text .ropa-ic svg{width:26px;height:26px;color:var(--red);}
	#ropa-page .ropa-row-text h3{font-size:clamp(20px,2.4vw,26px);font-weight:800;}
	#ropa-page .ropa-row-text p{color:var(--muted);font-size:16.5px;margin-top:14px;max-width:430px;}
	#ropa-page .ropa-list{list-style:none;margin:18px 0 0;padding:0;display:flex;flex-direction:column;gap:10px;max-width:430px;}
	#ropa-page .ropa-list li{display:flex;align-items:flex-start;gap:10px;color:var(--ink-strong);font-size:15px;}
	#ropa-page .ropa-list li svg{width:19px;height:19px;color:var(--ropa-green);flex-shrink:0;margin-top:1px;}

	/* SECCIÓN DE VIDEO */
	#ropa-page .ropa-video-wrap{max-width:900px;margin:0 auto;}
	#ropa-page .ropa-video-wrap .cap{margin-top:16px;text-align:center;}
	#ropa-page .ropa-video-wrap .cap b{font-family:'Manrope';font-weight:700;font-size:16px;color:var(--ink-strong);display:block;}
	#ropa-page .ropa-video-wrap .cap span{color:var(--muted);font-size:14px;}

	@media (max-width:980px){
		#ropa-page .ropa-hub{grid-template-columns:repeat(2,1fr);}
	}
	@media (max-width:900px){
		#ropa-page .ropa-hero .hero-grid{grid-template-columns:1fr;gap:34px;padding:52px 0 56px;}
		#ropa-page .ropa-stats{max-width:none;}
		#ropa-page .ropa-row{grid-template-columns:1fr;gap:22px;}
		#ropa-page .ropa-row.reverse .ropa-row-text{order:0;}
		#ropa-page .ropa-row.reverse .ropa-row-media{order:0;}
	}
	@media (max-width:560px){
		#ropa-page .ropa-stats{grid-template-columns:1fr;}
		#ropa-page .ropa-hub{grid-template-columns:1fr;}
	}
</style>

<div id="ropa-page">

	<!-- HERO -->
	<section class="ropa-hero">
		<div class="wrap">
			<div class="hero-grid">
				<div class="hero-copy">
					<span class="eyebrow"><span class="dot"></span> <?php echo esc_html( vlac_opt( 'ropa_eyebrow', 'Tienda de Ropa' ) ); ?></span>
					<h1><?php echo wp_kses_post( vlac_opt( 'ropa_title', 'El sistema hecho para tu <span class="accent">tienda de ropa</span>' ) ); ?></h1>
					<p class="lead"><?php echo esc_html( vlac_opt( 'ropa_sub', 'Controla cada prenda por talla y color, imprime etiquetas con código de barras, vende rápido en caja y sabe qué se vende por temporada, todo en un mismo sistema.' ) ); ?></p>
					<div class="hero-cta">
						<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'hero_cta1_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
						<a class="btn btn-ghost" href="<?php echo esc_url( vlac_opt( 'hero_cta2_url', '#' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta2_txt', 'Ver una demo' ) ); ?></a>
					</div>
					<div class="hero-note">
						<svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
						Variantes por talla y color · Etiquetas con código de barras · Ventas por temporada
					</div>

					<div class="ropa-stats">
						<div class="ropa-stat"><b>Talla y color</b><span>Cada prenda, por variante</span></div>
						<div class="ropa-stat"><b>Etiquetas</b><span>Código de barras listo para imprimir</span></div>
						<div class="ropa-stat"><b>Temporada</b><span>Qué se vende y qué se queda</span></div>
					</div>
				</div>

				<div class="ropa-visual">
					<?php
					$ropa_hero_key  = vlac_opt( 'ropa_img_hero' ) ? 'ropa_img_hero' : 'ropa_img_producto';
					$ropa_hero_file = file_exists( $img_dir . 'ropa-hero.png' ) ? 'ropa-hero.png' : 'ropa-producto.png';
					$ropa_shot( $ropa_hero_file, '', $ropa_hero_key );
					?>
				</div>
			</div>
		</div>
	</section>

	<!-- LO QUE RESUELVE -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Pensado para ropa</div>
				<h2>Lo que una tienda de ropa necesita, resuelto</h2>
				<p>Desde la prenda con sus variantes hasta la venta en caja y el informe de la temporada.</p>
			</div>

			<div class="ropa-hub">
				<div class="ropa-tool">
					<div class="ropa-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M8 4l-4 3 2 3 2-1v10h8V9l2 1 2-3-4-3-2 2H10L8 4z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg></div>
					<h3>Variantes por talla y color</h3>
					<p>Cada prenda con sus tallas, colores y marca, cada combinación con su propio SKU.</p>
				</div>
				<div class="ropa-tool">
					<div class="ropa-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3zm0 0v18M4 7.5l8 4.5 8-4.5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg></div>
					<h3>Existencias por variante</h3>
					<p>Sabe cuántas quedan de cada talla y color, en cada sucursal.</p>
				</div>
				<div class="ropa-tool">
					<div class="ropa-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 6v12M7 6v12M10 6v12M13 6v12M16 6v12M20 6v12" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg></div>
					<h3>Etiquetas con código de barras</h3>
					<p>Imprime etiquetas en varios tamaños con código de barras y precio.</p>
				</div>
				<div class="ropa-tool">
					<div class="ropa-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M3 5h2l2.4 10.2a2 2 0 002 1.6h7.6a2 2 0 002-1.6L21 8H6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><circle cx="10" cy="20" r="1.4" stroke="currentColor" stroke-width="1.5"/><circle cx="17" cy="20" r="1.4" stroke="currentColor" stroke-width="1.5"/></svg></div>
					<h3>Punto de venta</h3>
					<p>Escanea la prenda, elige la talla y cobra con cualquier forma de pago.</p>
				</div>
				<div class="ropa-tool">
					<div class="ropa-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="4" y="4" width="16" height="16" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M8 4v16M4 9h4M4 14h4" stroke="currentColor" stroke-width="1.6"/></svg></div>
					<h3>Catálogo con fotos</h3>
					<p>Listado con foto, categoría, marca y filtros por color, talla o proveedor.</p>
				</div>
				<div class="ropa-tool">
					<div class="ropa-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 19V5M4 19h16M8 16l3-4 3 2 4-6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Informes por temporada</h3>
					<p>Qué se vende, qué se queda y cuánto ganas, por período y sucursal.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- VARIANTES: MATRIZ TALLA × COLOR -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Variantes</div>
				<h2>Una prenda, todas sus tallas y colores</h2>
				<p>Registra la prenda una vez y el sistema arma cada combinación de talla y color con su propio SKU y existencia.</p>
			</div>

			<div class="ropa-rows">
				<div class="ropa-row">
					<div class="ropa-row-text">
						<div class="ropa-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M8 4l-4 3 2 3 2-1v10h8V9l2 1 2-3-4-3-2 2H10L8 4z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg></div>
						<h3>Talla, color y marca</h3>
						<p>Define las tallas y los colores de cada prenda, junto con su marca, categoría y subcategoría. Cada combinación queda como una variante con su código.</p>
						<ul class="ropa-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Color, talla/medida, marca y categorías</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Un SKU y código de barras por variante</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Costo, precio y foto por prenda</li>
						</ul>
					</div>
					<div class="ropa-row-media"><?php $ropa_video( 'variantes-ropa', 'Video: variantes de la prenda', 'Talla, color y marca con su SKU', 'ropa_video_variantes' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- INVENTARIO Y ETIQUETAS -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Inventario y etiquetas</div>
				<h2>Controla lo que hay y etiqueta cada prenda</h2>
				<p>Existencias por variante y sucursal, más etiquetas con código de barras listas para imprimir.</p>
			</div>

			<div class="ropa-rows">
				<div class="ropa-row">
					<div class="ropa-row-text">
						<div class="ropa-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3zm0 0v18M4 7.5l8 4.5 8-4.5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg></div>
						<h3>Existencias por variante</h3>
						<p>Consulta cuántas prendas quedan de cada talla y color, su costo y su precio de venta, con alerta de stock mínimo para reponer a tiempo.</p>
						<ul class="ropa-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Stock por talla, color y sucursal</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Traslados entre tiendas y stock mínimo</li>
						</ul>
					</div>
					<div class="ropa-row-media"><?php $ropa_shot( 'ropa-existencias.png', '', 'ropa_img_existencias' ); ?></div>
				</div>

				<div class="ropa-row reverse">
					<div class="ropa-row-text">
						<div class="ropa-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 6v12M7 6v12M10 6v12M13 6v12M16 6v12M20 6v12" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg></div>
						<h3>Etiquetas con código de barras</h3>
						<p>Imprime etiquetas en distintos tamaños con el código de barras, el nombre y el precio de la prenda, para pegar y escanear en caja.</p>
						<ul class="ropa-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Tamaños 50×25, 45×25 y 40×30 mm</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Código de barras o QR con precio</li>
						</ul>
					</div>
					<div class="ropa-row-media"><?php $ropa_shot( 'ropa-etiquetas.png', '', 'ropa_img_etiquetas' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- CATÁLOGO -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Catálogo</div>
				<h2>Todas tus prendas, con foto y a la mano</h2>
				<p>Un catálogo con fotos, categorías y filtros para encontrar cualquier prenda en segundos.</p>
			</div>

			<div class="ropa-rows">
				<div class="ropa-row">
					<div class="ropa-row-text">
						<div class="ropa-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="4" y="4" width="16" height="16" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M8 4v16M4 9h4M4 14h4" stroke="currentColor" stroke-width="1.6"/></svg></div>
						<h3>Catálogo con fotos</h3>
						<p>Busca por nombre, SKU o código de barras y filtra por categoría, color, talla, marca o proveedor, cada prenda con su foto.</p>
						<ul class="ropa-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Foto, categoría y subcategoría por prenda</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Filtros por color, talla, marca y proveedor</li>
						</ul>
					</div>
					<div class="ropa-row-media"><?php $ropa_shot( 'ropa-catalogo.png', '', 'ropa_img_catalogo' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- VIDEO: UNA VENTA -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">En acción</div>
				<h2>Una venta de ropa, de principio a fin</h2>
				<p>Mira cómo se realiza una venta y se cobra.</p>
			</div>

			<div class="ropa-video-wrap">
				<?php $ropa_video( 'venta-ropa', 'Video: una venta de ropa', 'Escanea, elige la talla y cobra', 'ropa_video_venta' ); ?>
				<div class="cap">
					<b>Venta de ropa en vivo</b>
					<span>Escanea la prenda, confirma talla y color y emite el comprobante</span>
				</div>
			</div>
		</div>
	</section>

	<!-- INFORMES -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Informes</div>
				<h2>Sabe qué se vende y qué se queda</h2>
				<p>Reportes de ventas por temporada, categoría y sucursal para comprar mejor.</p>
			</div>

			<div class="ropa-rows">
				<div class="ropa-row">
					<div class="ropa-row-text">
						<div class="ropa-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 19V5M4 19h16M8 16l3-4 3 2 4-6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
						<h3>Ventas por temporada</h3>
						<p>Consulta las prendas más vendidas, las que no rotan, la ganancia por categoría y el comparativo entre sucursales, por el período que elijas.</p>
						<ul class="ropa-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Más vendidas, sin rotación y ganancia</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Por temporada, categoría y sucursal</li>
						</ul>
					</div>
					<div class="ropa-row-media"><?php $ropa_shot( 'ropa-informes.png', '', 'ropa_img_informes' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- CAPACIDADES -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Todo lo que incluye</div>
				<h2>Pensado para el día a día de tu tienda</h2>
			</div>
			<div class="feat-grid">
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M8 4l-4 3 2 3 2-1v10h8V9l2 1 2-3-4-3-2 2H10L8 4z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg></div>
					<h3>Variantes de prenda</h3>
					<p>Talla, color y marca, cada combinación con su SKU.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3zm0 0v18M4 7.5l8 4.5 8-4.5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg></div>
					<h3>Stock por variante</h3>
					<p>Existencias por talla y color en cada sucursal.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 6v12M7 6v12M10 6v12M13 6v12M16 6v12M20 6v12" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg></div>
					<h3>Etiquetas y códigos</h3>
					<p>Código de barras y QR en varios tamaños.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M3 5h2l2.4 10.2a2 2 0 002 1.6h7.6a2 2 0 002-1.6L21 8H6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><circle cx="10" cy="20" r="1.4" stroke="currentColor" stroke-width="1.5"/><circle cx="17" cy="20" r="1.4" stroke="currentColor" stroke-width="1.5"/></svg></div>
					<h3>Punto de venta</h3>
					<p>Escanea, cobra y descuenta del inventario.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="4" y="4" width="16" height="16" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M8 4v16M4 9h4M4 14h4" stroke="currentColor" stroke-width="1.6"/></svg></div>
					<h3>Catálogo con fotos</h3>
					<p>Filtros por color, talla, marca y proveedor.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 19V5M4 19h16M8 16l3-4 3 2 4-6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Informes por temporada</h3>
					<p>Lo más vendido, lo que no rota y tu ganancia.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- CTA -->
	<section class="section">
		<div class="wrap">
			<div class="cta-strip">
				<h2><?php echo esc_html( vlac_opt( 'ropa_cta_title', 'Lleva tu tienda de ropa al siguiente nivel' ) ); ?></h2>
				<p><?php echo esc_html( vlac_opt( 'ropa_cta_sub', 'Controla cada prenda por talla y color, etiqueta, vende y analiza tu temporada desde un solo sistema conectado.' ) ); ?></p>
				<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'cta_btn_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
			</div>
		</div>
	</section>

</div>

<?php
get_footer();
