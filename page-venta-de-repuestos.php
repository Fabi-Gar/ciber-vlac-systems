<?php
/**
 * Template Name: Venta de Repuestos
 *
 * Página de rubro para venta de repuestos y accesorios de vehículo. Recorre lo
 * que este negocio necesita del sistema: un catálogo enorme donde cada pieza
 * lleva su código de fábrica, su código alterno y su código de barras, su
 * marca y su ubicación en bodega; varios proveedores por repuesto; listas de
 * precios distintas para mostrador, mayoreo y taller; existencias por sucursal
 * con traslados; repuestos dejados a consignación; y la venta con cotización,
 * comisión al vendedor y factura.
 *
 * Se aplica automáticamente a la página con slug «venta-de-repuestos»
 * (el menú del tema ya apunta a /industrias/venta-de-repuestos/), o puede
 * asignarse a mano desde Atributos de página → Plantilla.
 *
 * IMÁGENES (guárdalas en /assets/img/ con estos nombres exactos, o mejor
 * elígelas desde el Personalizador):
 *   rep-hero.png          → ficha del repuesto o catálogo (va en el hero)
 *   rep-existencias.png   → existencias por sucursal
 *   rep-precios.png       → listas de precios
 *   rep-proveedores.png   → compra o requisición a proveedores
 *
 * VIDEOS (guárdalos en /assets/video/):
 *   busqueda-repuesto.mp4 → encontrar la pieza por código o por marca
 *   venta-repuesto.mp4    → vender en mostrador, cobrar y facturar
 * Mientras no existan, se muestra un marcador en su lugar.
 *
 * Los textos se editan en Apariencia → Personalizar → Contenido del sitio →
 * «Página Venta de Repuestos».
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
$rep_shot = function ( $file, $opt_key = '', $alt = '' ) use ( $img, $img_dir ) {
	$url    = $opt_key ? vlac_opt( $opt_key ) : '';
	$exists = file_exists( $img_dir . $file );
	echo '<div class="rep-frame"><div class="bar"><i></i><i></i><i></i></div>';
	if ( $url ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $url ), esc_attr( $alt ) );
	} elseif ( $exists ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $img . '/' . $file ), esc_attr( $alt ) );
	} else {
		printf( '<div class="rep-ph rep-ph-img">Elige la imagen en <b>Personalizar → Página Venta de Repuestos</b><br>o sube el archivo <code>assets/img/%s</code></div>', esc_html( $file ) );
	}
	echo '</div>';
};

// Renderiza un video autoplay. Prioridad:
//   1) El elegido en el Personalizador (Biblioteca de medios de WordPress).
//   2) El archivo en /assets/video/.
//   3) Un marcador con el nombre esperado.
$rep_video = function ( $base, $title, $sub, $opt_key = '' ) use ( $vid_dir, $vid_url ) {
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
	echo '<div class="rep-frame"><div class="bar"><i></i><i></i><i></i></div>';
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
		echo '<div class="rep-ph">';
		echo '<svg viewBox="0 0 24 24" fill="none"><path d="M4 5h16v14H4zM10 9l6 3-6 3V9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>';
		printf( '<b>%s</b><span>%s</span>', esc_html( $title ), esc_html( $sub ) );
		printf( '<code>assets/video/%s.mp4</code>', esc_html( $base ) );
		echo '</div>';
	}
	echo '</div>';
};
?>

<style>
	/* Estilos de la página de Venta de Repuestos (ámbito local). */
	#rep-page{--rep-green:#2e9e5b;--rep-slate:#5A6070;}

	/* HERO */
	#rep-page .rep-hero{position:relative;overflow:hidden;}
	#rep-page .rep-hero::before{content:"";position:absolute;inset:0;z-index:0;background:radial-gradient(720px 400px at 84% 2%,rgba(193,39,45,.08),transparent 62%),linear-gradient(180deg,#fff,var(--bg-alt));}
	#rep-page .rep-hero .hero-grid{position:relative;z-index:1;display:grid;grid-template-columns:1fr 1.18fr;gap:50px;align-items:center;padding:64px 0 82px;}
	#rep-page .rep-hero h1{font-size:clamp(32px,4.4vw,50px);font-weight:800;}
	#rep-page .rep-hero .lead{color:var(--muted);font-size:18px;margin:20px 0 0;max-width:510px;}
	#rep-page .rep-hero .hero-cta{display:flex;gap:14px;flex-wrap:wrap;margin-top:28px;}
	#rep-page .rep-hero .hero-note{display:flex;align-items:center;gap:8px;font-size:13.5px;color:var(--muted);margin-top:22px;}
	#rep-page .rep-hero .hero-note svg{width:16px;height:16px;color:var(--rep-green);flex-shrink:0;}

	/* Franja de datos separados por línea */
	#rep-page .rep-facts{display:flex;flex-wrap:wrap;gap:14px 0;margin-top:30px;}
	#rep-page .rep-fact{padding-right:24px;margin-right:24px;border-right:1px solid var(--line);}
	#rep-page .rep-fact:last-child{border-right:none;margin-right:0;padding-right:0;}
	#rep-page .rep-fact b{display:block;font-family:'Manrope';font-weight:800;font-size:16.5px;color:var(--ink-strong);}
	#rep-page .rep-fact span{display:block;color:var(--muted);font-size:13px;margin-top:3px;}

	/* MARCO (estilo navegador) para capturas y videos */
	#rep-page .rep-frame{background:#fff;border:1px solid #d9d9de;border-radius:14px;overflow:hidden;box-shadow:var(--shadow-md);}
	#rep-page .rep-hero .rep-frame{box-shadow:var(--shadow-lg);}
	#rep-page .rep-frame .bar{display:flex;align-items:center;gap:6px;padding:9px 12px;background:#f3f3f5;border-bottom:1px solid #e6e6ea;}
	#rep-page .rep-frame .bar i{width:10px;height:10px;border-radius:50%;background:#d6d6dc;display:block;}
	#rep-page .rep-frame video,#rep-page .rep-frame img{width:100%;height:auto;display:block;background:#000;}

	/* Marcador (placeholder) */
	#rep-page .rep-ph{aspect-ratio:16/10;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;text-align:center;background:var(--bg-alt);color:var(--muted);padding:24px;font-size:14px;}
	#rep-page .rep-ph svg{width:46px;height:46px;color:#c9c9d0;}
	#rep-page .rep-ph b{font-family:'Manrope';font-weight:700;color:var(--ink-strong);font-size:15px;}
	#rep-page .rep-ph code{font-size:13px;color:var(--red-dark);background:var(--red-soft);padding:4px 10px;border-radius:6px;}
	#rep-page .rep-ph-img{aspect-ratio:auto;padding:52px 20px;}

	/* TABLA de los códigos de la pieza */
	#rep-page .rep-table-wrap{overflow-x:auto;border:1px solid var(--line);border-radius:var(--radius);background:#fff;box-shadow:var(--shadow-sm);}
	#rep-page .rep-table{width:100%;min-width:620px;border-collapse:collapse;}
	#rep-page .rep-table th{text-align:left;font-family:'Manrope';font-weight:700;font-size:11.5px;letter-spacing:.09em;text-transform:uppercase;color:var(--muted);padding:15px 20px;background:var(--bg-alt);border-bottom:1px solid var(--line);}
	#rep-page .rep-table td{padding:17px 20px;border-bottom:1px solid var(--line-soft);font-size:14.5px;color:var(--muted);vertical-align:top;}
	#rep-page .rep-table tr:last-child td{border-bottom:none;}
	#rep-page .rep-table td b{display:block;font-family:'Manrope';font-weight:700;font-size:15.5px;color:var(--ink-strong);margin-bottom:4px;}
	#rep-page .rep-table td.ej{font-family:ui-monospace,SFMono-Regular,Menlo,monospace;font-size:13px;color:var(--red-dark);white-space:nowrap;}

	/* TARJETAS con captura adentro */
	#rep-page .rep-cards{display:grid;grid-template-columns:1fr 1fr;gap:24px;}
	#rep-page .rep-card{background:#fff;border:1px solid var(--line);border-radius:var(--radius);overflow:hidden;display:flex;flex-direction:column;transition:transform .18s ease,box-shadow .18s ease,border-color .18s ease;}
	#rep-page .rep-card:hover{transform:translateY(-4px);box-shadow:var(--shadow-md);border-color:#e0d0d0;}
	#rep-page .rep-card .head{padding:24px 24px 0;}
	#rep-page .rep-card .ic{width:48px;height:48px;border-radius:13px;background:var(--red-soft);display:grid;place-items:center;margin-bottom:15px;}
	#rep-page .rep-card .ic svg{width:24px;height:24px;color:var(--red);}
	#rep-page .rep-card h3{font-size:18.5px;font-weight:800;margin-bottom:8px;}
	#rep-page .rep-card p{color:var(--muted);font-size:14.5px;}
	#rep-page .rep-card .media{padding:22px 24px 24px;margin-top:auto;}

	/* SPLIT (el medio siempre en la columna ancha) */
	#rep-page .rep-split{display:grid;grid-template-columns:1fr 1.3fr;gap:46px;align-items:center;}
	#rep-page .rep-split.rev{grid-template-columns:1.3fr 1fr;}
	#rep-page .rep-split.rev .rep-split-media{order:-1;}
	#rep-page .rep-split .ic{width:52px;height:52px;border-radius:13px;background:var(--red-soft);display:grid;place-items:center;margin-bottom:18px;}
	#rep-page .rep-split .ic svg{width:26px;height:26px;color:var(--red);}
	#rep-page .rep-split h3{font-size:clamp(20px,2.4vw,26px);font-weight:800;}
	#rep-page .rep-split p.txt{color:var(--muted);font-size:16.5px;margin-top:14px;max-width:440px;}
	#rep-page .rep-list{list-style:none;margin:18px 0 0;padding:0;display:flex;flex-direction:column;gap:10px;max-width:440px;}
	#rep-page .rep-list li{display:flex;align-items:flex-start;gap:10px;color:var(--ink-strong);font-size:15px;}
	#rep-page .rep-list li svg{width:19px;height:19px;color:var(--rep-green);flex-shrink:0;margin-top:1px;}

	/* CAPACIDADES — dos columnas con visto bueno */
	#rep-page .rep-caps{display:grid;grid-template-columns:repeat(2,1fr);gap:2px 46px;}
	#rep-page .rep-cap{display:flex;align-items:flex-start;gap:13px;padding:17px 0;border-bottom:1px solid var(--line);}
	#rep-page .rep-cap svg{width:20px;height:20px;color:var(--rep-green);flex-shrink:0;margin-top:2px;}
	#rep-page .rep-cap b{display:block;font-family:'Manrope';font-weight:700;font-size:15.5px;color:var(--ink-strong);}
	#rep-page .rep-cap p{color:var(--muted);font-size:14px;margin-top:3px;}

	@media (max-width:900px){
		#rep-page .rep-hero .hero-grid{grid-template-columns:1fr;gap:32px;padding:50px 0 58px;}
		#rep-page .rep-cards{grid-template-columns:1fr;}
		#rep-page .rep-split,
		#rep-page .rep-split.rev{grid-template-columns:1fr;gap:24px;}
		#rep-page .rep-split.rev .rep-split-media{order:0;}
		#rep-page .rep-caps{grid-template-columns:1fr;}
	}
	@media (max-width:560px){
		#rep-page .rep-fact{padding-right:18px;margin-right:18px;}
	}
</style>

<div id="rep-page">

	<!-- HERO -->
	<section class="rep-hero">
		<div class="wrap">
			<div class="hero-grid">
				<div class="hero-copy">
					<span class="eyebrow"><span class="dot"></span> <?php echo esc_html( vlac_opt( 'rep_eyebrow', 'Venta de Repuestos' ) ); ?></span>
					<h1><?php echo wp_kses_post( vlac_opt( 'rep_title', 'El sistema para tu <span class="accent">venta de repuestos</span>' ) ); ?></h1>
					<p class="lead"><?php echo esc_html( vlac_opt( 'rep_sub', 'Encuentra la pieza por cualquiera de sus códigos, sabe en qué anaquel está y en qué sucursal queda, cotiza al taller y vende en mostrador con su factura.' ) ); ?></p>
					<div class="hero-cta">
						<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'hero_cta1_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
						<a class="btn btn-ghost" href="<?php echo esc_url( vlac_opt( 'hero_cta2_url', '#' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta2_txt', 'Ver una demo' ) ); ?></a>
					</div>
					<div class="hero-note">
						<svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
						Miles de piezas · Varios códigos · Multisucursal · Facturación
					</div>

					<div class="rep-facts">
						<div class="rep-fact">
							<b>3 códigos</b>
							<span>Fábrica, alterno y de barras</span>
						</div>
						<div class="rep-fact">
							<b>Varios proveedores</b>
							<span>Por cada repuesto</span>
						</div>
						<div class="rep-fact">
							<b>Listas de precios</b>
							<span>Mostrador, mayoreo y taller</span>
						</div>
					</div>
				</div>

				<div class="hero-media"><?php $rep_shot( 'rep-hero.png', 'rep_img_hero', 'Ficha del repuesto' ); ?></div>
			</div>
		</div>
	</section>

	<!-- ENCONTRAR LA PIEZA -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Encontrar la pieza</div>
				<h2>El cliente llega con un número, tú lo tienes</h2>
				<p>Cada repuesto guarda todos los códigos con los que lo pueden pedir, así lo encuentras venga como venga la consulta.</p>
			</div>

			<div class="rep-table-wrap">
				<table class="rep-table">
					<thead>
						<tr>
							<th>Código</th>
							<th>Para qué sirve</th>
							<th>Ejemplo</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><b>Código de fábrica</b></td>
							<td>El número original de la pieza, el que trae impreso o el que aparece en el catálogo del fabricante.</td>
							<td class="ej">90915-YZZD2</td>
						</tr>
						<tr>
							<td><b>Código alterno</b></td>
							<td>El equivalente de otra marca o el código con el que tu negocio lo maneja internamente.</td>
							<td class="ej">FIL-0428</td>
						</tr>
						<tr>
							<td><b>Código de barras</b></td>
							<td>Para leerlo con la pistola en mostrador o al hacer el conteo de inventario.</td>
							<td class="ej">7501234567890</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="rep-split" style="margin-top:60px">
				<div class="rep-split-text">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="1.7"/><path d="M20 20l-3.5-3.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></div>
					<h3>Búsqueda que aguanta miles de piezas</h3>
					<p class="txt">Escribe el código, parte del nombre o la marca y la pieza aparece, aunque manejes decenas de miles de referencias. Y cuando la encuentras, el sistema te dice en qué anaquel está guardada.</p>
					<ul class="rep-list">
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Busca por nombre, código, alterno o marca</li>
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Filtros por categoría, subcategoría y marca</li>
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Ubicación en bodega: pasillo y anaquel</li>
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Fotos de la pieza para confirmar que es la correcta</li>
					</ul>
				</div>
				<div class="rep-split-media"><?php $rep_video( 'busqueda-repuesto', 'Video: encontrar la pieza', 'Por código, nombre o marca', 'rep_video_busqueda' ); ?></div>
			</div>
		</div>
	</section>

	<!-- EXISTENCIAS Y PRECIOS -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Qué hay y a cuánto sale</div>
				<h2>Existencias y precios, siempre claros</h2>
				<p>Antes de prometerle algo al cliente ya sabes si lo tienes, dónde lo tienes y a qué precio le toca.</p>
			</div>

			<div class="rep-cards">
				<div class="rep-card">
					<div class="head">
						<div class="ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3zm0 0v18M4 7.5l8 4.5 8-4.5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg></div>
						<h3>Existencias por sucursal</h3>
						<p>Ves cuánto hay en cada tienda o bodega. Si en la tuya se acabó pero en la otra queda, haces el traslado sin perder la venta. Con stock mínimo y aviso cuando una pieza se está agotando.</p>
					</div>
					<div class="media"><?php $rep_shot( 'rep-existencias.png', 'rep_img_existencias', 'Existencias por sucursal' ); ?></div>
				</div>

				<div class="rep-card">
					<div class="head">
						<div class="ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 7h11l5 5-8 8-8-8V7z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="8.5" cy="10.5" r="1.3" stroke="currentColor" stroke-width="1.5"/></svg></div>
						<h3>Listas de precios</h3>
						<p>El mostrador no paga lo mismo que el taller que te compra todas las semanas. Armas tus listas y cada cliente se cobra con la que le corresponde, sin que el vendedor tenga que acordarse.</p>
					</div>
					<div class="media"><?php $rep_shot( 'rep-precios.png', 'rep_img_precios', 'Listas de precios' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- PROVEEDORES Y COMPRAS -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="rep-split rev">
				<div class="rep-split-text">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><path d="M3 7h13v10H3zM16 10h3l2 3v4h-5" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="7" cy="18" r="1.6" stroke="currentColor" stroke-width="1.5"/><circle cx="17.5" cy="18" r="1.6" stroke="currentColor" stroke-width="1.5"/></svg></div>
					<h3>Varios proveedores por repuesto</h3>
					<p class="txt">La misma pieza la consigues con dos o tres proveedores, cada uno a su precio. El sistema guarda quién te vende qué, para que al momento de reponer sepas a quién pedirle y en cuánto te sale.</p>
					<ul class="rep-list">
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Cada repuesto con sus proveedores asignados</li>
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Requisiciones para pedir lo que está bajo</li>
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>La compra entra al inventario y actualiza el costo</li>
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Cuentas por pagar de cada proveedor</li>
					</ul>
				</div>
				<div class="rep-split-media"><?php $rep_shot( 'rep-proveedores.png', 'rep_img_proveedores', 'Compra a proveedores' ); ?></div>
			</div>
		</div>
	</section>

	<!-- COTIZAR Y VENDER -->
	<section class="section">
		<div class="wrap">
			<div class="rep-split rev">
				<div class="rep-split-text">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><path d="M3 5h2l2.4 10.2a2 2 0 002 1.6h7.6a2 2 0 002-1.6L21 8H6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><circle cx="10" cy="20" r="1.4" stroke="currentColor" stroke-width="1.5"/><circle cx="17" cy="20" r="1.4" stroke="currentColor" stroke-width="1.5"/></svg></div>
					<h3>De la cotización al mostrador</h3>
					<p class="txt">Le pasas la cotización al taller con los repuestos y sus precios, y cuando la aprueban se convierte en venta sin volver a escribir nada. En caja cobras con cualquier forma de pago y facturas al instante.</p>
					<ul class="rep-list">
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Cotización en PDF que se vuelve venta al aprobarse</li>
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Lectura con pistola de código de barras</li>
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Comisión al vendedor por lo que vende</li>
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Crédito al taller con su saldo pendiente</li>
					</ul>
				</div>
				<div class="rep-split-media"><?php $rep_video( 'venta-repuesto', 'Video: una venta de mostrador', 'Busca la pieza, cobra y factura', 'rep_video_venta' ); ?></div>
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

			<div class="rep-caps">
				<div class="rep-cap">
					<svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
					<div><b>Catálogo enorme</b><p>Decenas de miles de piezas con marca, categoría y fotos.</p></div>
				</div>
				<div class="rep-cap">
					<svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
					<div><b>Tres códigos por pieza</b><p>De fábrica, alterno y de barras, todos buscables.</p></div>
				</div>
				<div class="rep-cap">
					<svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
					<div><b>Ubicación en bodega</b><p>En qué anaquel está guardada cada pieza.</p></div>
				</div>
				<div class="rep-cap">
					<svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
					<div><b>Existencias multisucursal</b><p>Con traslados entre tiendas y bodegas.</p></div>
				</div>
				<div class="rep-cap">
					<svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
					<div><b>Listas de precios</b><p>Mostrador, mayoreo y taller, cada quien con la suya.</p></div>
				</div>
				<div class="rep-cap">
					<svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
					<div><b>Compras y proveedores</b><p>Varios por repuesto, con requisiciones y cuentas por pagar.</p></div>
				</div>
				<div class="rep-cap">
					<svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
					<div><b>Consignación</b><p>Lo que dejas en talleres o con vendedores, controlado.</p></div>
				</div>
				<div class="rep-cap">
					<svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
					<div><b>Cotizaciones</b><p>Que se vuelven venta cuando el taller las aprueba.</p></div>
				</div>
				<div class="rep-cap">
					<svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
					<div><b>Comisiones</b><p>Calculadas por vendedor sobre lo que vendió.</p></div>
				</div>
				<div class="rep-cap">
					<svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
					<div><b>Crédito a clientes</b><p>Saldos y abonos de los talleres que te compran al crédito.</p></div>
				</div>
				<div class="rep-cap">
					<svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
					<div><b>Facturación electrónica</b><p>La venta facturada al instante desde la caja.</p></div>
				</div>
				<div class="rep-cap">
					<svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
					<div><b>Informes</b><p>Qué se vende, qué no rota y cuánto ganas por período.</p></div>
				</div>
			</div>
		</div>
	</section>

	<!-- CTA -->
	<section class="section">
		<div class="wrap">
			<div class="cta-strip">
				<h2><?php echo esc_html( vlac_opt( 'rep_cta_title', 'Ordena tu venta de repuestos hoy' ) ); ?></h2>
				<p><?php echo esc_html( vlac_opt( 'rep_cta_sub', 'Catálogo, códigos, existencias, proveedores y facturación en un solo sistema conectado.' ) ); ?></p>
				<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'cta_btn_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
			</div>
		</div>
	</section>

</div>

<?php
get_footer();
