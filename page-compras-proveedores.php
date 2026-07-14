<?php
/**
 * Template Name: Compras y Proveedores
 *
 * Página de producto del módulo de Gestión de Compras y Proveedores.
 * Muestra el listado de proveedores, la ficha del proveedor, los pedidos
 * a proveedor y un video del flujo de crear un pedido a proveedor.
 *
 * IMÁGENES (guárdalas en /assets/img/ con estos nombres exactos):
 *   cp-proveedores.png → listado de proveedores (captura 1)
 *   cp-proveedor.png   → ficha / información del proveedor (captura 2)
 *   cp-pedidos.png     → listado de pedidos a proveedor (captura 3)
 *   cp-pedido.png      → crear un pedido a proveedor (captura 4)
 *   cp-hero.png        → (opcional) imagen destacada del hero
 *
 * VIDEO (opcional, guárdalo en /assets/video/):
 *   pedido-proveedor.mp4 → flujo: crear un pedido a proveedor
 * Mientras no exista, se muestra un marcador en su lugar.
 *
 * Para usarla: crea una página (Páginas → Añadir nueva) con el título
 * «Compras y Proveedores» y el slug «compras-proveedores», y en «Atributos
 * de página → Plantilla» elige «Compras y Proveedores». No necesita contenido.
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
$cp_shot = function ( $file, $caption, $opt_key = '' ) use ( $img, $img_dir ) {
	$url    = $opt_key ? vlac_opt( $opt_key ) : '';
	$exists = file_exists( $img_dir . $file );
	echo '<figure class="cp-shot"><div class="cp-frame"><div class="bar"><i></i><i></i><i></i></div>';
	if ( $url ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $url ), esc_attr( $caption ) );
	} elseif ( $exists ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $img . '/' . $file ), esc_attr( $caption ) );
	} else {
		printf( '<div class="cp-ph cp-ph-img">Elige la imagen en <b>Personalizar → Página Compras y Proveedores</b><br>o sube <code>assets/img/%s</code></div>', esc_html( $file ) );
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
$cp_video = function ( $base, $title, $sub, $opt_key = '' ) use ( $vid_dir, $vid_url ) {
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
	echo '<div class="cp-frame"><div class="bar"><i></i><i></i><i></i></div>';
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
		echo '<div class="cp-ph">';
		echo '<svg viewBox="0 0 24 24" fill="none"><path d="M4 5h16v14H4zM10 9l6 3-6 3V9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>';
		printf( '<b>%s</b><span>%s</span>', esc_html( $title ), esc_html( $sub ) );
		printf( '<code>assets/video/%s.mp4</code>', esc_html( $base ) );
		echo '</div>';
	}
	echo '</div>';
};
?>

<style>
	/* Estilos de la página de Compras y Proveedores (ámbito local). */
	#cp-page{--cp-green:#2e9e5b;}

	/* HERO */
	#cp-page .cp-hero{position:relative;overflow:hidden;}
	#cp-page .cp-hero::before{content:"";position:absolute;inset:0;z-index:0;background:radial-gradient(700px 380px at 82% 8%,rgba(193,39,45,.07),transparent 60%),linear-gradient(180deg,#fff,var(--bg-alt));}
	#cp-page .cp-hero .hero-grid{position:relative;z-index:1;display:grid;grid-template-columns:1fr 1.12fr;gap:48px;align-items:center;padding:66px 0 84px;}
	#cp-page .cp-hero h1{font-size:clamp(32px,4.4vw,50px);font-weight:800;}
	#cp-page .cp-hero .lead{color:var(--muted);font-size:18px;margin:20px 0 8px;max-width:520px;}
	#cp-page .cp-hero .hero-cta{display:flex;gap:14px;flex-wrap:wrap;margin-top:28px;}
	#cp-page .cp-hero .hero-note{display:flex;align-items:center;gap:8px;font-size:13.5px;color:var(--muted);margin-top:22px;}
	#cp-page .cp-hero .hero-note svg{width:16px;height:16px;color:var(--cp-green);}

	/* Métricas rápidas bajo el hero */
	#cp-page .cp-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-top:34px;max-width:520px;}
	#cp-page .cp-stat{background:#fff;border:1px solid var(--line);border-radius:12px;padding:16px 18px;box-shadow:var(--shadow-sm);}
	#cp-page .cp-stat b{display:block;font-family:'Manrope';font-weight:800;font-size:22px;color:var(--red);line-height:1;}
	#cp-page .cp-stat span{display:block;color:var(--muted);font-size:12.5px;margin-top:7px;}

	/* MARCO (estilo navegador) para capturas y videos */
	#cp-page .cp-frame{background:#fff;border:1px solid #d9d9de;border-radius:14px;overflow:hidden;box-shadow:var(--shadow-md);}
	#cp-page .cp-frame .bar{display:flex;align-items:center;gap:6px;padding:9px 12px;background:#f3f3f5;border-bottom:1px solid #e6e6ea;}
	#cp-page .cp-frame .bar i{width:10px;height:10px;border-radius:50%;background:#d6d6dc;display:block;}
	#cp-page .cp-frame video,#cp-page .cp-frame img{width:100%;height:auto;display:block;background:#000;}
	#cp-page .cp-hero .cp-frame{box-shadow:var(--shadow-lg);}

	/* Marcador (placeholder) */
	#cp-page .cp-ph{aspect-ratio:16/10;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;text-align:center;background:var(--bg-alt);color:var(--muted);padding:24px;font-size:14px;}
	#cp-page .cp-ph svg{width:46px;height:46px;color:#c9c9d0;}
	#cp-page .cp-ph b{font-family:'Manrope';font-weight:700;color:var(--ink-strong);font-size:15px;}
	#cp-page .cp-ph code{font-size:13px;color:var(--red-dark);background:var(--red-soft);padding:4px 10px;border-radius:6px;}
	#cp-page .cp-ph-img{aspect-ratio:auto;padding:52px 20px;}

	/* FILAS ALTERNADAS (texto + imagen juntos) */
	#cp-page .cp-rows{display:flex;flex-direction:column;gap:60px;}
	#cp-page .cp-row{display:grid;grid-template-columns:1fr 1.15fr;gap:46px;align-items:center;}
	#cp-page .cp-row.reverse .cp-row-text{order:2;}
	#cp-page .cp-row.reverse .cp-row-media{order:1;}
	#cp-page .cp-row-text .cp-ic{width:52px;height:52px;border-radius:13px;background:var(--red-soft);display:grid;place-items:center;margin-bottom:18px;}
	#cp-page .cp-row-text .cp-ic svg{width:26px;height:26px;color:var(--red);}
	#cp-page .cp-row-text h3{font-size:clamp(20px,2.4vw,26px);font-weight:800;}
	#cp-page .cp-row-text p{color:var(--muted);font-size:16.5px;margin-top:14px;max-width:430px;}
	#cp-page .cp-row-text .cp-list{list-style:none;margin:18px 0 0;padding:0;display:flex;flex-direction:column;gap:10px;max-width:430px;}
	#cp-page .cp-row-text .cp-list li{display:flex;align-items:flex-start;gap:10px;color:var(--ink-strong);font-size:15px;}
	#cp-page .cp-row-text .cp-list svg{width:19px;height:19px;color:var(--cp-green);flex-shrink:0;margin-top:1px;}

	/* SECCIÓN DE VIDEO */
	#cp-page .cp-video-wrap{max-width:900px;margin:0 auto;}
	#cp-page .cp-video-wrap .cap{margin-top:16px;text-align:center;}
	#cp-page .cp-video-wrap .cap b{font-family:'Manrope';font-weight:700;font-size:16px;color:var(--ink-strong);display:block;}
	#cp-page .cp-video-wrap .cap span{color:var(--muted);font-size:14px;}

	@media (max-width:900px){
		#cp-page .cp-hero .hero-grid{grid-template-columns:1fr;gap:34px;padding:52px 0 56px;}
		#cp-page .cp-stats{max-width:none;}
		#cp-page .cp-row{grid-template-columns:1fr;gap:22px;}
		#cp-page .cp-row.reverse .cp-row-text{order:0;}
		#cp-page .cp-row.reverse .cp-row-media{order:0;}
	}
	@media (max-width:520px){
		#cp-page .cp-stats{grid-template-columns:1fr;}
	}
</style>

<div id="cp-page">

	<!-- HERO -->
	<section class="cp-hero">
		<div class="wrap">
			<div class="hero-grid">
				<div class="hero-copy">
					<span class="eyebrow"><span class="dot"></span> <?php echo esc_html( vlac_opt( 'cp_eyebrow', 'Compras y Proveedores' ) ); ?></span>
					<h1><?php echo wp_kses_post( vlac_opt( 'cp_title', 'Controla tus <span class="accent">compras</span> y tus <span class="accent">proveedores</span> de punta a punta' ) ); ?></h1>
					<p class="lead"><?php echo esc_html( vlac_opt( 'cp_sub', 'Un directorio completo de proveedores conectado a tus pedidos de compra: cotiza, confirma, registra facturas y controla lo pagado y lo pendiente.' ) ); ?></p>
					<div class="hero-cta">
						<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'hero_cta1_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
						<a class="btn btn-ghost" href="<?php echo esc_url( vlac_opt( 'hero_cta2_url', '#' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta2_txt', 'Ver una demo' ) ); ?></a>
					</div>
					<div class="hero-note">
						<svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
						Cotización a factura · Pagado y pendiente · Ligado a inventario
					</div>

					<div class="cp-stats">
						<div class="cp-stat"><b>Q 1,360</b><span>Total pagado</span></div>
						<div class="cp-stat"><b>Q 1,376</b><span>Total pendiente</span></div>
						<div class="cp-stat"><b>1 clic</b><span>Del pedido a la factura</span></div>
					</div>
				</div>

				<div class="cp-visual">
					<?php
					$cp_hero_key  = vlac_opt( 'cp_img_hero' ) ? 'cp_img_hero' : 'cp_img_pedido';
					$cp_hero_file = file_exists( $img_dir . 'cp-hero.png' ) ? 'cp-hero.png' : 'cp-pedido.png';
					$cp_shot( $cp_hero_file, '', $cp_hero_key );
					?>
				</div>
			</div>
		</div>
	</section>

	<!-- PROVEEDORES: LISTADO Y FICHA -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Proveedores</div>
				<h2>Toda la información de tus proveedores, ordenada</h2>
				<p>Desde el listado completo hasta la ficha detallada con direcciones y contactos.</p>
			</div>

			<div class="cp-rows">
				<div class="cp-row">
					<div class="cp-row-text">
						<div class="cp-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></div>
						<h3>Listado de proveedores</h3>
						<p>Todos tus proveedores con su código, nombre, nombre comercial, correo, teléfono, NIT y estado. Busca, edita, consulta o recupera los eliminados.</p>
						<ul class="cp-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Búsqueda instantánea por cualquier dato</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Estado activo / inactivo y papelera de eliminados</li>
						</ul>
					</div>
					<div class="cp-row-media"><?php $cp_shot( 'cp-proveedores.png', '', 'cp_img_proveedores' ); ?></div>
				</div>

				<div class="cp-row reverse">
					<div class="cp-row-text">
						<div class="cp-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="4" y="3" width="16" height="18" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M8 8h8M8 12h8M8 16h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
						<h3>Ficha del proveedor</h3>
						<p>NIT, DPI, nombre de emisor, nombre comercial, teléfonos, correo, descuento y periodo de pago, con búsqueda automática por NIT o DPI.</p>
						<ul class="cp-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Múltiples direcciones y contactos por proveedor</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Descuento y periodo de pago predefinidos</li>
						</ul>
					</div>
					<div class="cp-row-media"><?php $cp_shot( 'cp-proveedor.png', '', 'cp_img_proveedor' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- PEDIDOS A PROVEEDOR -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Pedidos a proveedor</div>
				<h2>Del pedido de compra al control de pagos</h2>
				<p>Gestiona cada pedido de principio a fin, con totales de pagado, pendiente y cotizaciones siempre al día.</p>
			</div>

			<div class="cp-rows">
				<div class="cp-row">
					<div class="cp-row-text">
						<div class="cp-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 7h16l-1 12H5L4 7zM8 7V5a4 4 0 018 0v2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
						<h3>Panel de pedidos</h3>
						<p>Total pagado por tipo (efectivo, depósito…), total pendiente y vencido, y cotizaciones, con el detalle de cada pedido: fecha, código, proveedor y número de factura.</p>
						<ul class="cp-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Filtra por período, código, factura, status o proveedor</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Totales al instante: pagado, pendiente y vencido</li>
						</ul>
					</div>
					<div class="cp-row-media"><?php $cp_shot( 'cp-pedidos.png', '', 'cp_img_pedidos' ); ?></div>
				</div>

				<div class="cp-row reverse">
					<div class="cp-row-text">
						<div class="cp-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></div>
						<h3>Crear un pedido</h3>
						<p>Elige el proveedor, busca productos por nombre o código de barras, define cantidades y precio de compra, y guarda como cotización o confirma la compra.</p>
						<ul class="cp-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Fecha y vencimiento de factura, serie y número</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Al confirmar, actualiza el inventario y el costo</li>
						</ul>
					</div>
					<div class="cp-row-media"><?php $cp_shot( 'cp-pedido.png', '', 'cp_img_pedido' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- VIDEO: CREAR UN PEDIDO -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">En acción</div>
				<h2>Crea un pedido a proveedor, paso a paso</h2>
				<p>Mira cómo se arma un pedido: proveedor, productos, cantidades y confirmación.</p>
			</div>

			<div class="cp-video-wrap">
				<?php $cp_video( 'pedido-proveedor', 'Video: crear un pedido a proveedor', 'Del proveedor a la confirmación de compra', 'cp_video_pedido' ); ?>
				<div class="cap">
					<b>Pedido a proveedor en vivo</b>
					<span>Selecciona el proveedor, agrega productos y confirma la compra</span>
				</div>
			</div>
		</div>
	</section>

	<!-- CAPACIDADES -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Todo lo que incluye</div>
				<h2>Pensado para tus compras</h2>
			</div>
			<div class="feat-grid">
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8z" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Directorio de proveedores</h3>
					<p>Fichas completas con NIT, DPI, contactos y direcciones.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 7h16l-1 12H5L4 7zM8 7V5a4 4 0 018 0v2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Cotización y confirmación</h3>
					<p>Guarda como cotización y confírmala cuando estés listo.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M3 9h18M8 13h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Facturas y vencimientos</h3>
					<p>Serie, número, fecha y vencimiento de cada factura de compra.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Pagado y pendiente</h3>
					<p>Controla lo pagado por tipo y lo pendiente o vencido.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M20 7L9 18l-5-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M20 12v6a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h9" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Ligado al inventario</h3>
					<p>Al confirmar, suma stock y actualiza el costo del producto.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 20V10M10 20V4M16 20v-7M22 20H2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Filtros y totales</h3>
					<p>Por período, proveedor, status o factura, con totales al día.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- CTA -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="cta-strip">
				<h2><?php echo esc_html( vlac_opt( 'cp_cta_title', 'Ordena tus compras y proveedores hoy' ) ); ?></h2>
				<p><?php echo esc_html( vlac_opt( 'cp_cta_sub', 'Centraliza tus proveedores, controla cada pedido y no vuelvas a perder de vista un pago.' ) ); ?></p>
				<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'cta_btn_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
			</div>
		</div>
	</section>

</div>

<?php
get_footer();
