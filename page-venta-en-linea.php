<?php
/**
 * Template Name: Venta en Línea (Tienda)
 *
 * Página de producto del módulo de Venta en Línea (tienda SoftShop).
 * Cubre el ciclo completo: publicar categorías y productos desde el ERP,
 * armar la vitrina con banners y secciones, configurar la identidad de la
 * tienda, definir entrega a domicilio y retiro en tienda, y atender los
 * pedidos desde el panel de ventas.
 *
 * IMÁGENES (guárdalas en /assets/img/ con estos nombres exactos):
 *   vlo-tienda.png     → Portada de la tienda publicada, con banner (captura 1)
 *   vlo-config.png     → Configuraciones: logo, favicon, colores, banners (captura 2)
 *   vlo-categorias.png → Publicación de categorías y sección de categorías (captura 3)
 *   vlo-productos.png  → Publicación de productos y secciones de productos (captura 4)
 *   vlo-destacados.png → Vitrina: productos más buscados (captura 5)
 *   vlo-catalogo.png   → Catálogo de una categoría con filtros de precio y marca (captura 6)
 *   vlo-carrito.png    → Carrito y proceso de compra (captura 7)
 *   vlo-tablet.png     → (hero) la tienda vista en tablet
 *   vlo-phone.png      → (hero) la tienda vista en teléfono
 *   vlo-hero.png       → (opcional) imagen destacada del hero
 * Mientras no existan, se muestra un marcador en su lugar.
 *
 * Para usarla: crea una página (Páginas → Añadir nueva) con el título
 * «Venta en línea» y el slug «venta-en-linea», y en «Atributos de página →
 * Plantilla» elige «Venta en Línea (Tienda)». No necesita contenido.
 * Los textos se editan en Apariencia → Personalizar → Contenido del sitio →
 * «Página Venta en Línea».
 *
 * @package Vlac_Systems
 */

get_header();

$img     = get_template_directory_uri() . '/assets/img';
$img_dir = get_template_directory() . '/assets/img/';

// Renderiza una captura enmarcada. Prioridad de la imagen:
//   1) La elegida en el Personalizador (Biblioteca de medios de WordPress).
//   2) El archivo en /assets/img/.
//   3) Un marcador con las instrucciones.
$vlo_shot = function ( $file, $caption, $opt_key = '' ) use ( $img, $img_dir ) {
	$url    = $opt_key ? vlac_opt( $opt_key ) : '';
	$exists = file_exists( $img_dir . $file );
	echo '<figure class="vlo-shot"><div class="vlo-frame"><div class="bar"><i></i><i></i><i></i></div>';
	if ( $url ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $url ), esc_attr( $caption ) );
	} elseif ( $exists ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $img . '/' . $file ), esc_attr( $caption ) );
	} else {
		printf( '<div class="vlo-shot-ph">Elige la imagen en <b>Personalizar → Página Venta en Línea</b><br>o sube <code>assets/img/%s</code></div>', esc_html( $file ) );
	}
	echo '</div>';
	if ( $caption ) {
		printf( '<figcaption>%s</figcaption>', esc_html( $caption ) );
	}
	echo '</figure>';
};

// Imagen de un dispositivo del hero. Igual prioridad: Personalizador → archivo → marcador.
$vlo_dev = function ( $file, $ratio, $opt_key = '' ) use ( $img, $img_dir ) {
	$url = $opt_key ? vlac_opt( $opt_key ) : '';
	if ( $url ) {
		printf( '<img class="shot" src="%s" alt="" loading="lazy" />', esc_url( $url ) );
	} elseif ( file_exists( $img_dir . $file ) ) {
		printf( '<img class="shot" src="%s" alt="" loading="lazy" />', esc_url( $img . '/' . $file ) );
	} else {
		printf( '<div class="vlo-dev-ph" style="aspect-ratio:%s;"><span>Imagen</span><code>%s</code></div>', esc_attr( $ratio ), esc_html( $file ) );
	}
};
?>

<style>
	/* Estilos de la página de Venta en Línea (ámbito local). */
	#vlo-page{--vlo-green:#2e9e5b;--vlo-blue:#2f6fed;--vlo-amber:#d98a17;}

	/* HERO */
	#vlo-page .vlo-hero{position:relative;overflow:hidden;}
	#vlo-page .vlo-hero::before{content:"";position:absolute;inset:0;z-index:0;background:radial-gradient(700px 380px at 82% 8%,rgba(193,39,45,.07),transparent 60%),linear-gradient(180deg,#fff,var(--bg-alt));}
	#vlo-page .vlo-hero .hero-grid{position:relative;z-index:1;display:grid;grid-template-columns:1.02fr 1.15fr;gap:50px;align-items:center;padding:66px 0 88px;}
	#vlo-page .vlo-hero h1{font-size:clamp(32px,4.4vw,50px);font-weight:800;}
	#vlo-page .vlo-hero .lead{color:var(--muted);font-size:18px;margin:20px 0 8px;max-width:520px;}
	#vlo-page .vlo-hero .hero-cta{display:flex;gap:14px;flex-wrap:wrap;margin-top:28px;}
	#vlo-page .vlo-hero .hero-note{display:flex;align-items:center;gap:8px;font-size:13.5px;color:var(--muted);margin-top:22px;}
	#vlo-page .vlo-hero .hero-note svg{width:16px;height:16px;color:var(--vlo-green);}

	/* Montaje de dispositivos del hero */
	#vlo-page .vlo-montage .vlo-dev-ph{display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px;background:#eef0f3;color:var(--muted);text-align:center;padding:12px;font-size:11px;}
	#vlo-page .vlo-montage .vlo-dev-ph code{font-size:9.5px;color:var(--red-dark);background:var(--red-soft);padding:2px 6px;border-radius:5px;word-break:break-all;}
	#vlo-page .vlo-montage .screen .vlo-dev-ph{aspect-ratio:16/10;font-size:13px;}
	#vlo-page .vlo-montage .screen .vlo-dev-ph code{font-size:12px;}

	/* MARCO DE PANTALLA (estilo navegador) */
	#vlo-page .vlo-frame{background:#fff;border:1px solid #d9d9de;border-radius:14px;overflow:hidden;box-shadow:var(--shadow-lg);}
	#vlo-page .vlo-frame .bar{display:flex;align-items:center;gap:6px;padding:9px 12px;background:#f3f3f5;border-bottom:1px solid #e6e6ea;}
	#vlo-page .vlo-frame .bar i{width:10px;height:10px;border-radius:50%;background:#d6d6dc;display:block;}
	#vlo-page .vlo-frame img{width:100%;height:auto;display:block;}

	/* PASOS */
	#vlo-page .vlo-steps{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;}
	#vlo-page .vlo-step{position:relative;background:#fff;border:1px solid var(--line);border-radius:var(--radius);padding:28px 22px;transition:transform .18s ease,box-shadow .18s ease,border-color .18s ease;}
	#vlo-page .vlo-step:hover{transform:translateY(-4px);box-shadow:var(--shadow-md);border-color:#e0d0d0;}
	#vlo-page .vlo-step .vlo-num{position:absolute;top:20px;right:22px;font-family:'Manrope';font-weight:800;font-size:34px;color:var(--line-soft);line-height:1;}
	#vlo-page .vlo-step .vlo-ic{width:52px;height:52px;border-radius:13px;background:var(--red-soft);display:grid;place-items:center;margin-bottom:18px;}
	#vlo-page .vlo-step .vlo-ic svg{width:26px;height:26px;color:var(--red);}
	#vlo-page .vlo-step h3{font-size:17px;font-weight:700;margin-bottom:8px;}
	#vlo-page .vlo-step p{color:var(--muted);font-size:14.5px;}

	/* FILAS ALTERNADAS */
	#vlo-page .vlo-rows{display:flex;flex-direction:column;gap:60px;}
	#vlo-page .vlo-row{display:grid;grid-template-columns:1fr 1.15fr;gap:46px;align-items:center;}
	#vlo-page .vlo-row.reverse .vlo-row-text{order:2;}
	#vlo-page .vlo-row.reverse .vlo-row-media{order:1;}
	#vlo-page .vlo-row-text .vlo-ic{width:52px;height:52px;border-radius:13px;background:var(--red-soft);display:grid;place-items:center;margin-bottom:18px;}
	#vlo-page .vlo-row-text .vlo-ic svg{width:26px;height:26px;color:var(--red);}
	#vlo-page .vlo-row-text h3{font-size:clamp(20px,2.4vw,26px);font-weight:800;}
	#vlo-page .vlo-row-text p{color:var(--muted);font-size:16.5px;margin-top:14px;max-width:440px;}
	#vlo-page .vlo-row-text ul{list-style:none;margin-top:18px;display:flex;flex-direction:column;gap:9px;}
	#vlo-page .vlo-row-text li{display:flex;align-items:flex-start;gap:9px;color:var(--ink);font-size:14.5px;}
	#vlo-page .vlo-row-text li svg{width:16px;height:16px;color:var(--red);flex:none;margin-top:3px;}

	/* SHOWCASE DE CAPTURAS */
	#vlo-page .vlo-shots{display:grid;grid-template-columns:repeat(2,1fr);gap:26px;}
	#vlo-page .vlo-shot{margin:0;}
	#vlo-page .vlo-shot .vlo-frame{box-shadow:var(--shadow-md);}
	#vlo-page .vlo-shot figcaption{margin-top:14px;font-family:'Manrope';font-weight:600;font-size:15px;color:var(--ink-strong);text-align:center;}
	#vlo-page .vlo-shot-ph{padding:52px 20px;text-align:center;color:var(--muted);font-size:14px;background:var(--bg-alt);}
	#vlo-page .vlo-shot-ph code{display:inline-block;margin-top:8px;font-size:13px;color:var(--red-dark);background:var(--red-soft);padding:4px 10px;border-radius:6px;}

	/* TARJETAS DE ENTREGA */
	#vlo-page .vlo-cards{display:grid;grid-template-columns:repeat(2,1fr);gap:24px;}
	#vlo-page .vlo-card{background:#fff;border:1px solid var(--line);border-radius:var(--radius);padding:30px 26px;}
	#vlo-page .vlo-card .vlo-ic{width:48px;height:48px;border-radius:12px;background:var(--red-soft);display:grid;place-items:center;margin-bottom:16px;}
	#vlo-page .vlo-card .vlo-ic svg{width:24px;height:24px;color:var(--red);}
	#vlo-page .vlo-card h3{font-size:19px;font-weight:800;margin-bottom:6px;}
	#vlo-page .vlo-card > p{color:var(--muted);font-size:15px;}
	#vlo-page .vlo-fields{margin-top:20px;display:flex;flex-direction:column;gap:10px;}
	#vlo-page .vlo-field{display:flex;justify-content:space-between;align-items:center;gap:14px;padding:11px 14px;background:var(--bg-alt);border:1px solid var(--line-soft);border-radius:9px;font-size:14px;}
	#vlo-page .vlo-field span{color:var(--muted);}
	#vlo-page .vlo-field b{font-family:'Manrope';font-weight:700;color:var(--ink-strong);white-space:nowrap;}

	/* PANEL DE VENTAS — réplica del panel real del sistema */
	#vlo-page .vlo-panel{background:#f7f8fa;border:1px solid var(--line);border-radius:12px;padding:20px 18px 22px;}
	#vlo-page .vlo-panel-head{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:16px;}
	#vlo-page .vlo-panel-head h6{font-family:'Manrope';font-weight:700;font-size:14px;color:var(--ink-strong);margin:0 0 3px;}
	#vlo-page .vlo-panel-head .u{display:inline-flex;align-items:center;gap:5px;font-size:13px;color:var(--vlo-blue);}
	#vlo-page .vlo-panel-head .u svg{width:12px;height:12px;}
	#vlo-page .vlo-panel-head .mute{color:var(--vlo-green);}
	#vlo-page .vlo-panel-head .mute svg{width:20px;height:20px;}

	#vlo-page .vlo-kanban{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;}
	#vlo-page .vlo-col{background:#fff;border:1px solid #e6e6ea;border-radius:8px;overflow:hidden;}
	#vlo-page .vlo-col-head{display:flex;justify-content:space-between;align-items:center;gap:10px;padding:12px 14px;border-bottom:1px solid #eee;font-size:13.5px;color:var(--ink-strong);}
	#vlo-page .vlo-col-head .n{font-size:12px;font-weight:700;line-height:1;color:#fff;background:var(--red);border-radius:4px;padding:4px 8px;}
	#vlo-page .vlo-col.is-new .n{background:#ffc107;color:#1f2124;}
	/* El cuerpo replica la lista con scroll del panel (min-height 600 en el sistema). */
	#vlo-page .vlo-col-body{position:relative;background:#fff;min-height:330px;padding:6px 16px 6px 8px;display:flex;flex-direction:column;gap:6px;}
	#vlo-page .vlo-scroll{position:absolute;top:0;right:0;width:13px;height:100%;background:#fafafa;border-left:1px solid #f0f0f3;display:flex;flex-direction:column;justify-content:space-between;align-items:center;padding:4px 0;}
	#vlo-page .vlo-scroll i{width:0;height:0;border-left:4px solid transparent;border-right:4px solid transparent;}
	#vlo-page .vlo-scroll i.up{border-bottom:5px solid #b7b7c0;}
	#vlo-page .vlo-scroll i.down{border-top:5px solid #b7b7c0;}

	/* Tarjeta de pedido: igual que la del sistema (bg-light, radio 5px) */
	#vlo-page .vlo-tk{background:#f8f9fa;border:1px solid #ececf0;border-radius:5px;padding:13px 14px;}
	#vlo-page .vlo-tk .tk-top{display:flex;justify-content:space-between;align-items:flex-start;gap:8px;}
	#vlo-page .vlo-tk .addr{font-size:12px;font-weight:600;text-transform:uppercase;color:var(--ink-strong);line-height:1.35;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;}
	#vlo-page .vlo-tk .tk-code{flex:none;font-size:11.5px;font-weight:600;color:#fff;background:#6c757d;border-radius:4px;padding:3px 7px;line-height:1.2;}
	#vlo-page .vlo-tk .tk-sep{border:0;border-top:1px solid #e3e3e8;margin:9px 0 11px;}
	#vlo-page .vlo-tk .tk-mid{display:flex;justify-content:space-between;align-items:baseline;gap:8px;}
	#vlo-page .vlo-tk .cli{font-size:13.5px;color:var(--ink);}
	#vlo-page .vlo-tk .tot{font-size:15px;color:var(--ink-strong);white-space:nowrap;}
	#vlo-page .vlo-tk .tk-date{font-size:12px;color:var(--muted);margin-top:3px;}

	/* EXTRAS (redes, términos, calificaciones) */
	#vlo-page .vlo-mini{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;}
	#vlo-page .vlo-minic{background:#fff;border:1px solid var(--line);border-radius:var(--radius);padding:26px 22px;}
	#vlo-page .vlo-minic .vlo-ic{width:44px;height:44px;border-radius:11px;background:var(--red-soft);display:grid;place-items:center;margin-bottom:14px;}
	#vlo-page .vlo-minic .vlo-ic svg{width:22px;height:22px;color:var(--red);}
	#vlo-page .vlo-minic h3{font-size:16px;font-weight:700;margin-bottom:7px;}
	#vlo-page .vlo-minic p{color:var(--muted);font-size:14px;}
	#vlo-page .vlo-tags{display:flex;flex-wrap:wrap;gap:7px;margin-top:14px;}
	#vlo-page .vlo-tags span{font-size:12px;color:var(--ink);background:var(--bg-alt);border:1px solid var(--line);border-radius:20px;padding:4px 11px;}

	@media (max-width:900px){
		#vlo-page .vlo-hero .hero-grid{grid-template-columns:1fr;gap:34px;padding:52px 0 56px;}
		#vlo-page .vlo-steps{grid-template-columns:1fr;}
		#vlo-page .vlo-shots{grid-template-columns:1fr;}
		#vlo-page .vlo-cards{grid-template-columns:1fr;}
		#vlo-page .vlo-mini{grid-template-columns:1fr;}
		#vlo-page .vlo-kanban{grid-template-columns:repeat(2,1fr);}
		#vlo-page .vlo-col-body{min-height:240px;}
		#vlo-page .vlo-row{grid-template-columns:1fr;gap:22px;}
		#vlo-page .vlo-row.reverse .vlo-row-text{order:0;}
		#vlo-page .vlo-row.reverse .vlo-row-media{order:0;}
	}
	@media (max-width:560px){
		#vlo-page .vlo-panel{padding:16px 12px 18px;}
		#vlo-page .vlo-kanban{grid-template-columns:1fr;}
		#vlo-page .vlo-col-body{min-height:0;}
	}
</style>

<div id="vlo-page">

	<!-- HERO -->
	<section class="vlo-hero">
		<div class="wrap">
			<div class="hero-grid">
				<div class="hero-copy">
					<span class="eyebrow"><span class="dot"></span> <?php echo esc_html( vlac_opt( 'vlo_eyebrow', 'Venta en Línea' ) ); ?></span>
					<h1><?php echo wp_kses_post( vlac_opt( 'vlo_title', 'Tu <span class="accent">tienda en línea</span>, conectada a tu inventario' ) ); ?></h1>
					<p class="lead"><?php echo esc_html( vlac_opt( 'vlo_sub', 'Publica tus productos con un clic desde el mismo sistema donde llevas el inventario. Tus clientes compran en línea y los pedidos entran directo a tu panel de ventas.' ) ); ?></p>
					<div class="hero-cta">
						<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'hero_cta1_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
						<a class="btn btn-ghost" href="<?php echo esc_url( vlac_opt( 'hero_cta2_url', '#' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta2_txt', 'Ver una demo' ) ); ?></a>
					</div>
					<div class="hero-note">
						<svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
						Dominio propio · Sin comisión por venta · Stock siempre al día
					</div>
				</div>

				<!-- Montaje de dispositivos: la tienda en monitor, tablet y teléfono -->
				<div class="montage vlo-montage" aria-label="Tienda en línea de Vlac Systems">
					<div class="monitor">
						<div class="screen">
							<div class="browserbar"><i></i><i></i><i></i><span class="url">tunegocio.softshop.app</span></div>
							<?php
							$vlo_hero_key = vlac_opt( 'vlo_img_hero' ) ? 'vlo_img_hero' : 'vlo_img_tienda';
							$vlo_dev( 'vlo-tienda.png', '16/10', $vlo_hero_key );
							?>
						</div>
						<div class="stand-neck"></div>
						<div class="stand"></div>
					</div>

					<div class="tablet">
						<span class="badge">Catálogo</span>
						<div class="tscreen"><?php $vlo_dev( 'vlo-tablet.png', '4/3', 'vlo_img_tablet' ); ?></div>
					</div>

					<div class="phone">
						<div class="pscreen"><?php $vlo_dev( 'vlo-phone.png', '9/16', 'vlo_img_phone' ); ?></div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- CÓMO FUNCIONA -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Cómo funciona</div>
				<h2>Del inventario a la vitrina, en tres pasos</h2>
				<p>No hay catálogo aparte ni doble captura: la tienda se alimenta de los productos que ya tienes cargados.</p>
			</div>

			<div class="vlo-steps">
				<div class="vlo-step">
					<span class="vlo-num">01</span>
					<div class="vlo-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Publicas lo que quieras vender</h3>
					<p>Marcas las categorías y los productos que salen a la tienda. Lo que no publicas sigue en el sistema, pero no se ve en línea.</p>
				</div>
				<div class="vlo-step">
					<span class="vlo-num">02</span>
					<div class="vlo-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="7" rx="2" stroke="currentColor" stroke-width="1.7"/><rect x="3" y="14" width="8" height="6" rx="2" stroke="currentColor" stroke-width="1.7"/><rect x="13" y="14" width="8" height="6" rx="2" stroke="currentColor" stroke-width="1.7"/></svg></div>
					<h3>Ordenas la vitrina</h3>
					<p>Armas los banners y las secciones —«Seguridad para tu hogar», «Productos más buscados»— y decides cuáles van en carrusel.</p>
				</div>
				<div class="vlo-step">
					<span class="vlo-num">03</span>
					<div class="vlo-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 7h16l-1 12H5L4 7zM8 7V5a4 4 0 018 0v2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Recibes los pedidos</h3>
					<p>Cada compra entra al panel de ventas con aviso sonoro, y avanza por las etapas hasta quedar entregada.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- LA VITRINA -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">La tienda</div>
				<h2>Una vitrina que armas tú, sin programar</h2>
			</div>

			<div class="vlo-rows">
				<div class="vlo-row">
					<div class="vlo-row-text">
						<div class="vlo-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="5" width="18" height="12" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M3 14l4-4 4 4 3-3 7 6" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg></div>
						<h3>Banners con destino propio</h3>
						<p>Cada banner lleva su imagen para escritorio y otra para teléfono, con título, subtítulo y botón. Al tocarlo, el cliente cae en la categoría que tú elegiste.</p>
						<ul>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Imagen distinta para escritorio y móvil</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Banner principal fijo y rotación del resto</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Altura configurable en pantalla grande y pequeña</li>
						</ul>
					</div>
					<div class="vlo-row-media"><?php $vlo_shot( 'vlo-tienda.png', '', 'vlo_img_tienda' ); ?></div>
				</div>

				<div class="vlo-row reverse">
					<div class="vlo-row-text">
						<div class="vlo-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 6h16M4 12h16M4 18h10" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></div>
						<h3>Categorías publicadas a tu criterio</h3>
						<p>Publicas y despublicas categorías en lote. Después las agrupas en secciones con su propio título y subtítulo, en cuadrícula o en carrusel.</p>
					</div>
					<div class="vlo-row-media"><?php $vlo_shot( 'vlo-categorias.png', '', 'vlo_img_categorias' ); ?></div>
				</div>

				<div class="vlo-row">
					<div class="vlo-row-text">
						<div class="vlo-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3zm0 0v18M4 7.5l8 4.5 8-4.5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg></div>
						<h3>Productos con su SKU y su foto</h3>
						<p>Busca por código o nombre, filtra por categoría y publica los que quieras. Los agrupas en secciones como «Seguridad para tu hogar» o «Redes» y esas secciones son las que ve el cliente en la portada.</p>
					</div>
					<div class="vlo-row-media"><?php $vlo_shot( 'vlo-productos.png', '', 'vlo_img_productos' ); ?></div>
				</div>

				<div class="vlo-row reverse">
					<div class="vlo-row-text">
						<div class="vlo-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 5h16M7 12h10M10 19h4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></div>
						<h3>Catálogo con filtros de verdad</h3>
						<p>Dentro de cada categoría el cliente filtra por precio máximo, marca y talla, y ordena de menor a mayor precio. Los filtros salen de los atributos que ya tienen tus productos.</p>
					</div>
					<div class="vlo-row-media"><?php $vlo_shot( 'vlo-catalogo.png', '', 'vlo_img_catalogo' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- CONFIGURACIÓN -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Identidad</div>
				<h2>La tienda se ve como tu marca</h2>
				<p>Logo, favicon y colores se cambian desde el mismo panel, sin tocar una línea de código.</p>
			</div>

			<div class="vlo-rows">
				<div class="vlo-row">
					<div class="vlo-row-text">
						<div class="vlo-ic"><svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.7"/><path d="M12 3a9 9 0 000 18" stroke="currentColor" stroke-width="1.7"/><circle cx="15.5" cy="9" r="1.3" fill="currentColor"/><circle cx="16.5" cy="13.5" r="1.3" fill="currentColor"/></svg></div>
						<h3>Tu logo y tus colores</h3>
						<p>Subes el logo y el favicon, eliges el color primario y el de los botones, y decides si se muestra la barra de categorías.</p>
						<ul>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Valor mínimo de orden para aceptar la compra</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Mostrar u ocultar los productos sin existencia</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Código QR de la tienda, listo para imprimir</li>
						</ul>
					</div>
					<div class="vlo-row-media"><?php $vlo_shot( 'vlo-config.png', '', 'vlo_img_config' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- ENTREGA Y RETIRO -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Entrega</div>
				<h2>Tú pones las reglas del envío</h2>
			</div>

			<div class="vlo-cards">
				<div class="vlo-card">
					<div class="vlo-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M3 7h11v8H3zM14 10h4l3 3v2h-7z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="7" cy="18" r="1.6" stroke="currentColor" stroke-width="1.6"/><circle cx="17.5" cy="18" r="1.6" stroke="currentColor" stroke-width="1.6"/></svg></div>
					<h3>Entrega a domicilio</h3>
					<p>El flete se calcula solo, según la distancia hasta la dirección del cliente.</p>
					<div class="vlo-fields">
						<div class="vlo-field"><span>Kilómetro inicial</span><b>Desde dónde se cobra</b></div>
						<div class="vlo-field"><span>Distancia máxima</span><b>Hasta dónde llegas</b></div>
						<div class="vlo-field"><span>Valor base del flete</span><b>Q · fijo</b></div>
						<div class="vlo-field"><span>Adicional por kilómetro</span><b>Q · por km</b></div>
						<div class="vlo-field"><span>Tiempo de entrega</span><b>Minutos o días</b></div>
					</div>
				</div>

				<div class="vlo-card">
					<div class="vlo-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M3 21V9l9-6 9 6v12M3 21h18M9 21v-6h6v6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Retiro en tienda</h3>
					<p>Si el cliente prefiere pasar recogiendo, defines cuánto tardas en tener el pedido listo.</p>
					<div class="vlo-fields">
						<div class="vlo-field"><span>Tiempo de preparación</span><b>Minutos o días</b></div>
						<div class="vlo-field"><span>Sin costo de envío</span><b>Q 0.00</b></div>
						<div class="vlo-field"><span>Aviso al cliente</span><b>Cuando esté listo</b></div>
					</div>
					<p style="margin-top:18px;font-size:14px;">Puedes tener las dos modalidades activas y que el cliente elija en el momento de pagar.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- PANEL DE VENTAS -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Panel de ventas</div>
				<h2>Los pedidos avanzan arrastrando</h2>
				<p>Cada venta en línea entra como una tarjeta y se mueve entre etapas. El cliente ve el avance y tu equipo sabe qué toca hacer.</p>
			</div>

			<div class="vlo-panel">
				<div class="vlo-panel-head">
					<div>
						<h6>Panel de ventas</h6>
						<span class="u">tunegocio.softshop.app
							<svg viewBox="0 0 24 24" fill="none"><path d="M14 4h6v6M20 4l-8 8M18 14v5a1 1 0 01-1 1H5a1 1 0 01-1-1V7a1 1 0 011-1h5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
						</span>
					</div>
					<span class="mute" title="Aviso sonoro de pedidos nuevos">
						<svg viewBox="0 0 24 24" fill="none"><path d="M11 5L6 9H3v6h3l5 4V5z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M15.5 8.5a5 5 0 010 7M18.5 5.5a9 9 0 010 13" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
					</span>
				</div>

				<div class="vlo-kanban">
					<div class="vlo-col is-new">
						<div class="vlo-col-head">NUEVA VENTA <span class="n">2</span></div>
						<div class="vlo-col-body">
							<div class="vlo-scroll"><i class="up"></i><i class="down"></i></div>
							<div class="vlo-tk">
								<div class="tk-top"><span class="addr">12 av 5-60 zona 10, Guatemala</span><span class="tk-code">1042</span></div>
								<hr class="tk-sep">
								<div class="tk-mid"><span class="cli">Andrea Ruiz</span><span class="tot">Q 1,990.00</span></div>
								<div class="tk-date">04 sep 26 10:12 a. m.</div>
							</div>
							<div class="vlo-tk">
								<div class="tk-top"><span class="addr">Retirada</span><span class="tk-code">1043</span></div>
								<hr class="tk-sep">
								<div class="tk-mid"><span class="cli">Luis Ovalle</span><span class="tot">Q 360.00</span></div>
								<div class="tk-date">04 sep 26 09:58 a. m.</div>
							</div>
						</div>
					</div>

					<div class="vlo-col is-prep">
						<div class="vlo-col-head">PREPARACIÓN <span class="n">1</span></div>
						<div class="vlo-col-body">
							<div class="vlo-scroll"><i class="up"></i><i class="down"></i></div>
							<div class="vlo-tk">
								<div class="tk-top"><span class="addr">4a calle 3-45 zona 1, Mixco</span><span class="tk-code">1041</span></div>
								<hr class="tk-sep">
								<div class="tk-mid"><span class="cli">Ferretería El Sol</span><span class="tot">Q 1,200.00</span></div>
								<div class="tk-date">04 sep 26 09:21 a. m.</div>
							</div>
						</div>
					</div>

					<div class="vlo-col is-road">
						<div class="vlo-col-head">EN CAMINO <span class="n">1</span></div>
						<div class="vlo-col-body">
							<div class="vlo-scroll"><i class="up"></i><i class="down"></i></div>
							<div class="vlo-tk">
								<div class="tk-top"><span class="addr">Calzada Roosevelt 22-15, Villa Nueva</span><span class="tk-code">1039</span></div>
								<hr class="tk-sep">
								<div class="tk-mid"><span class="cli">Marta Cifuentes</span><span class="tot">Q 800.00</span></div>
								<div class="tk-date">03 sep 26 04:47 p. m.</div>
							</div>
						</div>
					</div>

					<div class="vlo-col is-done">
						<div class="vlo-col-head">ENTREGADO <span class="n">1</span></div>
						<div class="vlo-col-body">
							<div class="vlo-scroll"><i class="up"></i><i class="down"></i></div>
							<div class="vlo-tk">
								<div class="tk-top"><span class="addr">Retirada</span><span class="tk-code">1038</span></div>
								<hr class="tk-sep">
								<div class="tk-mid"><span class="cli">Byron Santos</span><span class="tot">Q 140.00</span></div>
								<div class="tk-date">03 sep 26 11:30 a. m.</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- LA COMPRA -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">La compra</div>
				<h2>Un carrito claro, con cupones y factura</h2>
			</div>

			<div class="vlo-shots">
				<?php
				$vlo_shot( 'vlo-destacados.png', 'Secciones de productos en la portada', 'vlo_img_destacados' );
				$vlo_shot( 'vlo-carrito.png', 'Carrito, cupón de descuento y resumen del pedido', 'vlo_img_carrito' );
				?>
			</div>
		</div>
	</section>

	<!-- EXTRAS -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Además</div>
				<h2>Los detalles que dan confianza</h2>
			</div>

			<div class="vlo-mini">
				<div class="vlo-minic">
					<div class="vlo-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M18 8a3 3 0 10-2.8-4H15L8.9 9.6A3 3 0 106 14.9l6.2 3.6v.5a3 3 0 103-3 3 3 0 00-2 .8L7.9 13a3 3 0 000-2l6.3-3.7A3 3 0 0018 8z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg></div>
					<h3>Tus redes en el pie</h3>
					<p>Los enlaces se configuran una vez y aparecen en toda la tienda.</p>
					<div class="vlo-tags">
						<span>Facebook</span><span>Instagram</span><span>TikTok</span><span>YouTube</span><span>X</span><span>App Store</span><span>Google Play</span>
					</div>
				</div>
				<div class="vlo-minic">
					<div class="vlo-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M6 3h9l3 3v15H6z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M9 9h6M9 13h6M9 17h3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Términos y privacidad</h3>
					<p>Redactas las condiciones de uso y el aviso de privacidad desde el panel, y quedan publicados en el pie de la tienda.</p>
				</div>
				<div class="vlo-minic">
					<div class="vlo-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3l2.6 5.6 6.1.8-4.5 4.2 1.2 6L12 16.8 6.6 19.6l1.2-6L3.3 9.4l6.1-.8L12 3z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg></div>
					<h3>Calificación del pedido</h3>
					<p>Al cerrar la entrega el cliente puede calificar su compra, y tú ves las opiniones reunidas en el sistema.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- CTA -->
	<section class="section">
		<div class="wrap">
			<div class="cta-strip">
				<h2><?php echo esc_html( vlac_opt( 'vlo_cta_title', 'Abre tu tienda en línea esta semana' ) ); ?></h2>
				<p><?php echo esc_html( vlac_opt( 'vlo_cta_sub', 'Si ya tienes tus productos en el sistema, publicarlos en línea es cuestión de marcarlos.' ) ); ?></p>
				<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'cta_btn_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
			</div>
		</div>
	</section>

</div>

<?php
get_footer();
