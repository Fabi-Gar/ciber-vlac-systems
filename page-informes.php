<?php
/**
 * Template Name: Informes
 *
 * Página de producto del módulo de Informes generales.
 * Muestra un video con el panel de informes, el catálogo completo de los 17
 * informes agrupados en sus 7 categorías, el selector de período y columnas,
 * y una galería con muestras reales de los PDF generados.
 *
 * IMÁGENES (elígelas en el Personalizador o guárdalas en /assets/img/ con
 * estos nombres exactos):
 *   inf-panel.png         → Panel de informes generales
 *   inf-columnas.png      → Modal de período y columnas seleccionables
 *   inf-pdf-ordenes.png   → PDF: informe de órdenes
 *   inf-pdf-inventario.png→ PDF: situación de inventario
 *   inf-pdf-caja.png      → PDF: utilidad de caja general
 *   inf-pdf-historial.png → PDF: historial de inventario
 *   inf-hero.png          → (opcional) imagen destacada del hero
 *
 * VIDEO (opcional): se elige en el Personalizador, o se guarda como
 *   /assets/video/informes.mp4 → recorrido por todos los informes
 *
 * Para usarla: crea una página (Páginas → Añadir nueva) con el título
 * «Informes» y el slug «informes», y en «Atributos de página → Plantilla»
 * elige «Informes». No necesita contenido. Los textos y los medios se editan
 * en Apariencia → Personalizar → Contenido del sitio → «Página Informes».
 *
 * @package Vlac_Systems
 */

get_header();

$img     = get_template_directory_uri() . '/assets/img';
$img_dir = get_template_directory() . '/assets/img/';
$vid_url = get_template_directory_uri() . '/assets/video';
$vid_dir = get_template_directory() . '/assets/video/';

// Resuelve la URL de una imagen: Personalizador → archivo → vacío.
$inf_src = function ( $file, $opt_key = '' ) use ( $img, $img_dir ) {
	$url = $opt_key ? vlac_opt( $opt_key ) : '';
	if ( $url ) {
		return $url;
	}
	return file_exists( $img_dir . $file ) ? $img . '/' . $file : '';
};

// Captura con marco de navegador (para pantallas del sistema).
$inf_shot = function ( $file, $caption, $opt_key = '' ) use ( $inf_src ) {
	$src = $inf_src( $file, $opt_key );
	echo '<figure class="inf-shot"><div class="inf-frame"><div class="bar"><i></i><i></i><i></i></div>';
	if ( $src ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $src ), esc_attr( $caption ) );
	} else {
		printf( '<div class="inf-ph">Elige la imagen en <b>Personalizar → Página Informes</b><br>o sube <code>assets/img/%s</code></div>', esc_html( $file ) );
	}
	echo '</div>';
	if ( $caption ) {
		printf( '<figcaption>%s</figcaption>', esc_html( $caption ) );
	}
	echo '</figure>';
};

// Muestra de PDF con marco tipo hoja de papel.
$inf_paper = function ( $file, $title, $sub, $opt_key = '' ) use ( $inf_src ) {
	$src = $inf_src( $file, $opt_key );
	echo '<figure class="inf-paper-item"><div class="inf-paper">';
	if ( $src ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $src ), esc_attr( $title ) );
	} else {
		printf( '<div class="inf-ph inf-ph-paper">Elige la imagen en <b>Personalizar → Página Informes</b><br>o sube <code>assets/img/%s</code></div>', esc_html( $file ) );
	}
	echo '</div><figcaption>';
	printf( '<b>%s</b><span>%s</span>', esc_html( $title ), esc_html( $sub ) );
	echo '</figcaption></figure>';
};

// Video autoplay: Personalizador → archivo → marcador.
$inf_video = function ( $base, $title, $sub, $opt_key = '' ) use ( $vid_dir, $vid_url ) {
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
	echo '<div class="inf-frame"><div class="bar"><i></i><i></i><i></i></div>';
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
		echo '<div class="inf-ph inf-ph-video">';
		echo '<svg viewBox="0 0 24 24" fill="none"><path d="M4 5h16v14H4zM10 9l6 3-6 3V9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>';
		printf( '<b>%s</b><span>%s</span>', esc_html( $title ), esc_html( $sub ) );
		printf( '<code>assets/video/%s.mp4</code>', esc_html( $base ) );
		echo '</div>';
	}
	echo '</div>';
};

/*
 * Catálogo de informes: las 7 categorías del panel con sus informes.
 * Estructura: etiqueta, subtítulo, icono SVG y lista de informes.
 */
$inf_doc  = '<path d="M6 3h9l3 3v15H6z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 8h6M9 12h6M9 16h3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>';
$inf_cats = array(
	array(
		'Ventas',
		'Órdenes y facturación',
		'<path d="M6 3h9l3 3v15l-2-1.4L14 21l-2-1.4L10 21l-2-1.4L6 21V3z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 8h6M9 12h6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>',
		array(
			array( 'Órdenes', 'Listado de órdenes por período y columnas seleccionables.' ),
			array( 'Facturas', 'Reporte de facturas emitidas (DTE) por período.' ),
			array( 'Recibos', 'Recibos emitidos por período.' ),
			array( 'Productos vendidos', 'Detalle de productos vendidos por período.' ),
		),
	),
	array(
		'Inventario',
		'Movimientos y existencias',
		'<path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3zm0 0v18M4 7.5l8 4.5 8-4.5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>',
		array(
			array( 'Existencias de inventario', 'Existencias actuales con costo y valor de venta.' ),
			array( 'Movimientos detallado', 'Entradas y salidas de inventario por período, categoría y marca.' ),
			array( 'Movimientos resumen', 'Resumen de entradas y salidas de inventario por período.' ),
			array( 'Movimientos utilidad', 'Utilidad de los movimientos de inventario por período.' ),
		),
	),
	array(
		'Finanzas',
		'Transacciones bancarias',
		'<path d="M12 1v22M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>',
		array(
			array( 'Transacciones', 'Movimientos bancarios y de caja por período.' ),
			array( 'Resumen financiero', 'Utilidad e ingresos/egresos por período.' ),
			array( 'Ganancias', 'Utilidad de caja general por mes.' ),
		),
	),
	array(
		'Productos',
		'Listados y ranking de ventas',
		'<circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="1.7"/><path d="M20 20l-3.5-3.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>',
		array(
			array( 'General', 'Catálogo de productos con campos y filtros seleccionables.' ),
			array( 'Inventario por fecha', 'Posición de inventario a una fecha de corte.' ),
			array( 'Más vendido', 'Productos más vendidos por período.' ),
		),
	),
	array(
		'Clientes',
		'Estados de cuenta y operaciones',
		'<path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M17 11l2 2 4-4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>',
		array(
			array( 'Estado de cuenta', 'Operaciones y saldo de clientes por período.' ),
		),
	),
	array(
		'Caja',
		'Cierres e historial de cajas',
		'<circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.7"/><path d="M12 7v5l3 2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>',
		array(
			array( 'Historial de cajas', 'Cierres de caja por período y sucursal.' ),
		),
	),
	array(
		'Nómina',
		'Operaciones de personal',
		'<rect x="3" y="7" width="18" height="13" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>',
		array(
			array( 'Operaciones de nómina', 'Bonos, débitos, deducciones e IGSS por período.' ),
		),
	),
);

// Total de informes, para mostrarlo en el hero sin descuadrar si cambia la lista.
$inf_total = 0;
foreach ( $inf_cats as $inf_cat ) {
	$inf_total += count( $inf_cat[3] );
}
?>

<style>
	/* Estilos de la página de Informes (ámbito local). */
	#inf-page{--inf-green:#2e9e5b;}

	/* ---------- HERO ---------- */
	#inf-page .inf-hero{position:relative;overflow:hidden;}
	#inf-page .inf-hero::before{content:"";position:absolute;inset:0;z-index:0;background:radial-gradient(760px 400px at 78% 6%,rgba(193,39,45,.08),transparent 60%),linear-gradient(180deg,#fff,var(--bg-alt));}
	#inf-page .inf-hero .hero-grid{position:relative;z-index:1;display:grid;grid-template-columns:1fr 1.2fr;gap:48px;align-items:center;padding:66px 0 84px;}
	#inf-page .inf-hero h1{font-size:clamp(32px,4.4vw,50px);font-weight:800;}
	#inf-page .inf-hero .lead{color:var(--muted);font-size:18px;margin:20px 0 8px;max-width:520px;}
	#inf-page .inf-hero .hero-cta{display:flex;gap:14px;flex-wrap:wrap;margin-top:28px;}
	#inf-page .inf-hero .hero-note{display:flex;align-items:center;gap:8px;font-size:13.5px;color:var(--muted);margin-top:22px;}
	#inf-page .inf-hero .hero-note svg{width:16px;height:16px;color:var(--inf-green);}
	#inf-page .inf-hero .inf-frame{box-shadow:var(--shadow-lg);}

	/* Contador grande de informes */
	#inf-page .inf-count{display:flex;align-items:center;gap:14px;margin-top:32px;padding:16px 20px;background:#fff;border:1px solid var(--line);border-radius:14px;box-shadow:var(--shadow-sm);max-width:400px;}
	#inf-page .inf-count b{font-family:'Manrope';font-weight:800;font-size:38px;color:var(--red);line-height:1;}
	#inf-page .inf-count span{color:var(--muted);font-size:13.5px;line-height:1.5;}
	#inf-page .inf-count span em{font-style:normal;font-weight:600;color:var(--ink-strong);display:block;}

	/* ---------- MARCOS ---------- */
	#inf-page .inf-frame{background:#fff;border:1px solid #d9d9de;border-radius:14px;overflow:hidden;box-shadow:var(--shadow-md);}
	#inf-page .inf-frame .bar{display:flex;align-items:center;gap:6px;padding:9px 12px;background:#f3f3f5;border-bottom:1px solid #e6e6ea;}
	#inf-page .inf-frame .bar i{width:10px;height:10px;border-radius:50%;background:#d6d6dc;display:block;}
	#inf-page .inf-frame img,#inf-page .inf-frame video{width:100%;height:auto;display:block;background:#fff;}
	#inf-page .inf-shot{margin:0;}
	#inf-page .inf-shot figcaption{margin-top:12px;font-family:'Manrope';font-weight:600;font-size:14px;color:var(--muted);text-align:center;}
	#inf-page .inf-ph{padding:52px 20px;text-align:center;color:var(--muted);font-size:14px;background:var(--bg-alt);line-height:1.7;}
	#inf-page .inf-ph code{display:inline-block;margin-top:6px;font-size:13px;color:var(--red-dark);background:var(--red-soft);padding:4px 10px;border-radius:6px;}
	#inf-page .inf-ph b{color:var(--ink-strong);}
	#inf-page .inf-ph-video{aspect-ratio:16/10;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;}
	#inf-page .inf-ph-video svg{width:46px;height:46px;color:#c9c9d0;}
	#inf-page .inf-ph-video b{font-family:'Manrope';font-weight:700;font-size:15px;}

	/* ---------- CATÁLOGO DE INFORMES ---------- */
	#inf-page .inf-cat{margin-bottom:44px;}
	#inf-page .inf-cat:last-child{margin-bottom:0;}
	#inf-page .inf-cat-head{display:flex;align-items:center;gap:11px;padding-bottom:14px;border-bottom:1px solid var(--line);margin-bottom:20px;}
	#inf-page .inf-cat-head .ic{width:30px;height:30px;border-radius:8px;background:var(--red-soft);display:grid;place-items:center;flex-shrink:0;}
	#inf-page .inf-cat-head .ic svg{width:17px;height:17px;color:var(--red);}
	#inf-page .inf-cat-head h3{font-size:19px;font-weight:800;}
	#inf-page .inf-cat-head span{color:var(--muted);font-size:14.5px;}
	#inf-page .inf-items{display:grid;grid-template-columns:repeat(2,1fr);gap:16px;}
	#inf-page .inf-item{display:flex;align-items:flex-start;gap:14px;background:#fff;border:1px solid var(--line);border-radius:12px;padding:18px 20px;transition:transform .16s ease,box-shadow .16s ease,border-color .16s ease;}
	#inf-page .inf-item:hover{transform:translateY(-3px);box-shadow:var(--shadow-md);border-color:#e0d0d0;}
	#inf-page .inf-item .doc{width:36px;height:36px;border-radius:9px;background:#eef0ff;display:grid;place-items:center;flex-shrink:0;}
	#inf-page .inf-item .doc svg{width:19px;height:19px;color:#4c4ddc;}
	#inf-page .inf-item h4{font-size:15.5px;font-weight:700;margin-bottom:4px;}
	#inf-page .inf-item p{color:var(--muted);font-size:13.5px;}

	/* ---------- MUESTRAS DE PDF (hojas de papel) ---------- */
	#inf-page .inf-papers{display:grid;grid-template-columns:repeat(2,1fr);gap:30px;}
	#inf-page .inf-paper-item{margin:0;}
	#inf-page .inf-paper{background:#fff;border:1px solid #e6e6ea;border-radius:4px;overflow:hidden;box-shadow:0 10px 30px rgba(15,15,20,.10),0 2px 6px rgba(15,15,20,.06);transition:transform .2s ease,box-shadow .2s ease;}
	#inf-page .inf-paper-item:hover .inf-paper{transform:translateY(-5px);box-shadow:0 18px 44px rgba(15,15,20,.15),0 3px 8px rgba(15,15,20,.07);}
	#inf-page .inf-paper img{width:100%;height:auto;display:block;background:#fff;}
	#inf-page .inf-paper-item figcaption{margin-top:16px;text-align:center;}
	#inf-page .inf-paper-item figcaption b{font-family:'Manrope';font-weight:700;font-size:15.5px;color:var(--ink-strong);display:block;}
	#inf-page .inf-paper-item figcaption span{color:var(--muted);font-size:13.5px;}
	#inf-page .inf-ph-paper{padding:70px 20px;}

	/* ---------- CÓMO SE GENERA ---------- */
	#inf-page .inf-gen{display:grid;grid-template-columns:1fr 1.1fr;gap:46px;align-items:center;}
	#inf-page .inf-gen h2{font-size:clamp(24px,2.8vw,34px);font-weight:800;}
	#inf-page .inf-gen>.copy>p{color:var(--muted);font-size:16.5px;margin-top:16px;max-width:440px;}
	#inf-page .inf-gen .inf-steps{margin-top:26px;display:flex;flex-direction:column;gap:18px;}
	#inf-page .inf-gen .inf-step{display:flex;gap:14px;align-items:flex-start;}
	#inf-page .inf-gen .inf-step .num{width:30px;height:30px;border-radius:9px;background:var(--red);color:#fff;font-family:'Manrope';font-weight:800;font-size:13.5px;display:grid;place-items:center;flex-shrink:0;box-shadow:0 5px 12px rgba(193,39,45,.3);}
	#inf-page .inf-gen .inf-step b{font-family:'Manrope';font-weight:700;font-size:15.5px;color:var(--ink-strong);display:block;margin-bottom:3px;}
	#inf-page .inf-gen .inf-step p{color:var(--muted);font-size:14.5px;}
	#inf-page .inf-out{display:flex;gap:10px;flex-wrap:wrap;margin-top:26px;}
	#inf-page .inf-out span{display:inline-flex;align-items:center;gap:7px;background:#fff;border:1px solid var(--line);border-radius:999px;padding:8px 14px;font-family:'Manrope';font-weight:600;font-size:13px;color:var(--ink-strong);}
	#inf-page .inf-out svg{width:15px;height:15px;color:var(--inf-green);}

	@media (max-width:900px){
		#inf-page .inf-hero .hero-grid{grid-template-columns:1fr;gap:34px;padding:52px 0 56px;}
		#inf-page .inf-count{max-width:none;}
		#inf-page .inf-items{grid-template-columns:1fr;}
		#inf-page .inf-papers{grid-template-columns:1fr;gap:34px;}
		#inf-page .inf-gen{grid-template-columns:1fr;gap:28px;}
	}
</style>

<div id="inf-page">

	<!-- HERO + VIDEO -->
	<section class="inf-hero">
		<div class="wrap">
			<div class="hero-grid">
				<div class="hero-copy">
					<span class="eyebrow"><span class="dot"></span> <?php echo esc_html( vlac_opt( 'inf_eyebrow', 'Informes' ) ); ?></span>
					<h1><?php echo wp_kses_post( vlac_opt( 'inf_title', 'Un <span class="accent">informe</span> para cada pregunta de tu negocio' ) ); ?></h1>
					<p class="lead"><?php echo esc_html( vlac_opt( 'inf_sub', 'Ventas, inventario, finanzas, productos, clientes, caja y nómina. Elige el período, las columnas que quieres ver e imprime en PDF.' ) ); ?></p>
					<div class="hero-cta">
						<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'hero_cta1_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
						<a class="btn btn-ghost" href="<?php echo esc_url( vlac_opt( 'hero_cta2_url', '#' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta2_txt', 'Ver una demo' ) ); ?></a>
					</div>

					<div class="inf-count">
						<b><?php echo esc_html( $inf_total ); ?></b>
						<span><em>informes listos para usar</em>agrupados en <?php echo esc_html( count( $inf_cats ) ); ?> categorías, sin configurar nada.</span>
					</div>

					<div class="hero-note">
						<svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
						Por período · Columnas a tu gusto · Impresión en PDF
					</div>
				</div>

				<div class="inf-visual">
					<?php $inf_video( 'informes', 'Video: panel de informes', 'Recorrido por todos los informes', 'inf_video_panel' ); ?>
				</div>
			</div>
		</div>
	</section>

	<!-- CATÁLOGO COMPLETO -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Catálogo</div>
				<h2>Todos los informes, agrupados por área</h2>
				<p>Entra al panel de informes generales y genera el que necesites en segundos. Estos son todos los que trae el sistema.</p>
			</div>

			<?php foreach ( $inf_cats as $cat ) : ?>
				<div class="inf-cat">
					<div class="inf-cat-head">
						<span class="ic"><svg viewBox="0 0 24 24" fill="none"><?php echo wp_kses( $cat[2], array( 'path' => array( 'd' => array(), 'stroke' => array(), 'stroke-width' => array(), 'stroke-linecap' => array(), 'stroke-linejoin' => array() ), 'circle' => array( 'cx' => array(), 'cy' => array(), 'r' => array(), 'stroke' => array(), 'stroke-width' => array() ), 'rect' => array( 'x' => array(), 'y' => array(), 'width' => array(), 'height' => array(), 'rx' => array(), 'stroke' => array(), 'stroke-width' => array() ) ) ); ?></svg></span>
						<h3><?php echo esc_html( $cat[0] ); ?></h3>
						<span><?php echo esc_html( $cat[1] ); ?></span>
					</div>
					<div class="inf-items">
						<?php foreach ( $cat[3] as $item ) : ?>
							<div class="inf-item">
								<span class="doc"><svg viewBox="0 0 24 24" fill="none"><?php echo wp_kses( $inf_doc, array( 'path' => array( 'd' => array(), 'stroke' => array(), 'stroke-width' => array(), 'stroke-linecap' => array(), 'stroke-linejoin' => array() ) ) ); ?></svg></span>
								<div>
									<h4><?php echo esc_html( $item[0] ); ?></h4>
									<p><?php echo esc_html( $item[1] ); ?></p>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</section>

	<!-- CÓMO SE GENERA -->
	<section class="section">
		<div class="wrap">
			<div class="inf-gen">
				<div class="copy">
					<div class="sec-kicker" style="text-align:left;">Tú decides qué ver</div>
					<h2>Elige el período y las columnas que te importan</h2>
					<p>Ningún informe te obliga a cargar con datos que no necesitas. Enciende y apaga cada columna antes de imprimir.</p>

					<div class="inf-steps">
						<div class="inf-step">
							<span class="num">1</span>
							<div>
								<b>Define el período</b>
								<p>Desde y hasta la fecha que quieras analizar.</p>
							</div>
						</div>
						<div class="inf-step">
							<span class="num">2</span>
							<div>
								<b>Enciende las columnas</b>
								<p>Fecha, orden, status, vendedor, costo, propina, descuento, utilidad… solo lo que necesitas ver.</p>
							</div>
						</div>
						<div class="inf-step">
							<span class="num">3</span>
							<div>
								<b>Imprime o descarga</b>
								<p>Genera el PDF con el logo y los datos de tu negocio, listo para enviar o archivar.</p>
							</div>
						</div>
					</div>

					<div class="inf-out">
						<span><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Impresión PDF</span>
						<span><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Descarga Excel</span>
						<span><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Con tu logo y marca</span>
					</div>
				</div>

				<div class="media">
					<?php $inf_shot( 'inf-columnas.png', 'Período y columnas seleccionables antes de imprimir', 'inf_img_columnas' ); ?>
				</div>
			</div>
		</div>
	</section>

	<!-- MUESTRAS DE PDF -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Resultados reales</div>
				<h2>Así se ven tus informes impresos</h2>
				<p>Cada PDF sale encabezado con el logo y los datos de tu negocio, con los totales del período arriba y el detalle abajo.</p>
			</div>

			<div class="inf-papers">
				<?php
				$inf_paper( 'inf-pdf-ordenes.png', 'Órdenes', 'Totales por status y el detalle de cada orden', 'inf_img_pdf_ordenes' );
				$inf_paper( 'inf-pdf-inventario.png', 'Situación de inventario', 'Inversión, potencial de ventas y costo por producto', 'inf_img_pdf_inventario' );
				$inf_paper( 'inf-pdf-caja.png', 'Utilidad de caja general', 'Ingresos y gastos por categoría y forma de pago', 'inf_img_pdf_caja' );
				$inf_paper( 'inf-pdf-historial.png', 'Historial de inventario', 'Compras, salidas y totales con su referencia', 'inf_img_pdf_historial' );
				?>
			</div>
		</div>
	</section>

	<!-- CAPACIDADES -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Todo lo que incluye</div>
				<h2>Pensado para decidir con datos</h2>
			</div>
			<div class="feat-grid">
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M6 3h9l3 3v15H6z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 8h6M9 12h6M9 16h3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg></div>
					<h3><?php echo esc_html( $inf_total ); ?> informes</h3>
					<p>De ventas a nómina, sin plantillas que configurar.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="17" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M3 9h18M8 2v4M16 2v4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Por período</h3>
					<p>Elige desde y hasta la fecha que necesites.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="2" y="6" width="20" height="5" rx="2.5" stroke="currentColor" stroke-width="1.6"/><circle cx="17" cy="8.5" r="1.6" fill="currentColor"/><rect x="2" y="14" width="20" height="5" rx="2.5" stroke="currentColor" stroke-width="1.6"/><circle cx="7" cy="16.5" r="1.6" fill="currentColor"/></svg></div>
					<h3>Columnas a tu gusto</h3>
					<p>Enciende solo los datos que te interesan.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M6 9V3h12v6M6 18H4a2 2 0 01-2-2v-3a2 2 0 012-2h16a2 2 0 012 2v3a2 2 0 01-2 2h-2M6 14h12v7H6z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>PDF y Excel</h3>
					<p>Imprime, envía o sigue trabajando los datos.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 20V10M10 20V4M16 20v-7M22 20H2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Totales del período</h3>
					<p>Cada informe encabeza con sus cifras clave.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M3 21V9l9-6 9 6v12M3 21h18M9 21v-6h6v6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Por sucursal</h3>
					<p>Genera los informes de la sucursal que elijas.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- CTA -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="cta-strip">
				<h2><?php echo esc_html( vlac_opt( 'inf_cta_title', 'Deja de adivinar: mira los números' ) ); ?></h2>
				<p><?php echo esc_html( vlac_opt( 'inf_cta_sub', 'Genera el informe que necesites, con el período y las columnas que quieras, en segundos.' ) ); ?></p>
				<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'cta_btn_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
			</div>
		</div>
	</section>

</div>

<?php
get_footer();
