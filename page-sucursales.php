<?php
/**
 * Template Name: Múltiples Sucursales
 *
 * Página de producto del módulo de Gestión de Múltiples Sucursales.
 * Diseño propio (hero centrado, selector de sucursal con pestañas CSS y
 * retícula tipo bento) para diferenciarla del resto de páginas de producto,
 * respetando la paleta del tema.
 *
 * Muestra: más de una sucursal con su propia información y configuración,
 * existencias por sucursal, ventas por sucursal, usuarios separados por
 * sucursal y traslados entre sucursales.
 *
 * IMÁGENES (elígelas en el Personalizador o guárdalas en /assets/img/ con
 * estos nombres exactos):
 *   ms-negocio.png           → Información del negocio, sucursal 1 (captura 1)
 *   ms-negocio-2.png         → Información del negocio, sucursal 2 (captura 2)
 *   ms-existencias.png       → Existencias por sucursal (captura 3)
 *   ms-ventas.png            → Información de ventas por sucursal (captura 4)
 *   ms-usuarios.png          → Usuarios separados por sucursal (captura 5)
 *   ms-traslados.png         → Traslados entre sucursales — ingresos (captura 6)
 *   ms-traslado-detalle.png  → Detalle del traslado (captura 7)
 *   ms-traslados-salidas.png → Traslados — salidas y confirmación (captura 8)
 *   ms-hero.png              → (opcional) imagen destacada del hero
 *
 * Para usarla: crea una página (Páginas → Añadir nueva) con el título
 * «Múltiples Sucursales» y el slug «sucursales», y en «Atributos de página →
 * Plantilla» elige «Múltiples Sucursales». No necesita contenido. Los textos
 * y las imágenes se editan en Apariencia → Personalizar → Contenido del sitio →
 * «Página Múltiples Sucursales».
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
$ms_shot = function ( $file, $caption, $opt_key = '' ) use ( $img, $img_dir ) {
	$url    = $opt_key ? vlac_opt( $opt_key ) : '';
	$exists = file_exists( $img_dir . $file );
	echo '<figure class="ms-shot"><div class="ms-frame"><div class="bar"><i></i><i></i><i></i></div>';
	if ( $url ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $url ), esc_attr( $caption ) );
	} elseif ( $exists ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $img . '/' . $file ), esc_attr( $caption ) );
	} else {
		printf( '<div class="ms-ph">Elige la imagen en <b>Personalizar → Página Múltiples Sucursales</b><br>o sube <code>assets/img/%s</code></div>', esc_html( $file ) );
	}
	echo '</div>';
	if ( $caption ) {
		printf( '<figcaption>%s</figcaption>', esc_html( $caption ) );
	}
	echo '</figure>';
};
?>

<style>
	/* Estilos de la página de Múltiples Sucursales (ámbito local). */
	#ms-page{--ms-green:#2e9e5b;}

	/* ---------- HERO CENTRADO ---------- */
	#ms-page .ms-hero{position:relative;overflow:hidden;text-align:center;}
	#ms-page .ms-hero::before{content:"";position:absolute;inset:0;z-index:0;background:radial-gradient(900px 460px at 50% -8%,rgba(193,39,45,.09),transparent 62%),linear-gradient(180deg,#fff,var(--bg-alt));}
	/* Solo padding vertical: el lateral lo pone .wrap del tema (24px / 18px en móvil). */
	#ms-page .ms-hero .wrap{position:relative;z-index:1;padding-top:72px;}
	#ms-page .ms-hero h1{font-size:clamp(32px,5vw,54px);font-weight:800;max-width:900px;margin:0 auto;}
	#ms-page .ms-hero .lead{color:var(--muted);font-size:18.5px;margin:22px auto 0;max-width:620px;}
	#ms-page .ms-hero .hero-cta{display:flex;gap:14px;flex-wrap:wrap;justify-content:center;margin-top:30px;}

	/* Cadena de sucursales (chips) */
	#ms-page .ms-chain{display:flex;align-items:center;justify-content:center;gap:10px;flex-wrap:wrap;margin-top:34px;}
	#ms-page .ms-chip{display:inline-flex;align-items:center;gap:7px;background:#fff;border:1px solid var(--line);border-radius:999px;padding:8px 15px;font-family:'Manrope';font-weight:600;font-size:13px;color:var(--ink-strong);box-shadow:var(--shadow-sm);}
	#ms-page .ms-chip i{width:7px;height:7px;border-radius:50%;background:var(--ms-green);display:block;}
	#ms-page .ms-chip.is-more{background:var(--red-soft);border-color:transparent;color:var(--red-dark);}

	/* Captura ancha del hero, ligeramente elevada */
	#ms-page .ms-hero-shot{max-width:1000px;margin:44px auto 0;transform:translateY(28px);}
	#ms-page .ms-hero-shot .ms-frame{box-shadow:var(--shadow-lg);}

	/* ---------- MARCO (estilo navegador) ---------- */
	#ms-page .ms-frame{background:#fff;border:1px solid #d9d9de;border-radius:14px;overflow:hidden;box-shadow:var(--shadow-md);}
	#ms-page .ms-frame .bar{display:flex;align-items:center;gap:6px;padding:9px 12px;background:#f3f3f5;border-bottom:1px solid #e6e6ea;}
	#ms-page .ms-frame .bar i{width:10px;height:10px;border-radius:50%;background:#d6d6dc;display:block;}
	#ms-page .ms-frame img{width:100%;height:auto;display:block;background:#fff;}
	#ms-page .ms-shot{margin:0;}
	#ms-page .ms-shot figcaption{margin-top:12px;font-family:'Manrope';font-weight:600;font-size:14px;color:var(--muted);text-align:center;}
	#ms-page .ms-ph{padding:52px 20px;text-align:center;color:var(--muted);font-size:14px;background:var(--bg-alt);line-height:1.7;}
	#ms-page .ms-ph code{display:inline-block;margin-top:6px;font-size:13px;color:var(--red-dark);background:var(--red-soft);padding:4px 10px;border-radius:6px;}
	#ms-page .ms-ph b{color:var(--ink-strong);}

	/* ---------- SELECTOR DE SUCURSAL (pestañas solo con CSS) ---------- */
	#ms-page .ms-switch{max-width:940px;margin:0 auto;}
	#ms-page .ms-switch>input{position:absolute;opacity:0;pointer-events:none;}
	#ms-page .ms-switch-tabs{display:flex;justify-content:center;gap:8px;flex-wrap:wrap;margin-bottom:26px;}
	#ms-page .ms-switch-tabs label{cursor:pointer;background:#fff;border:1px solid var(--line);border-radius:999px;padding:10px 20px;font-family:'Manrope';font-weight:700;font-size:13.5px;color:var(--muted);transition:all .18s ease;user-select:none;}
	#ms-page .ms-switch-tabs label:hover{border-color:#e0d0d0;color:var(--ink-strong);}
	#ms-page .ms-switch-pane{display:none;}
	#ms-page #ms-b1:checked~.ms-switch-tabs label[for="ms-b1"],
	#ms-page #ms-b2:checked~.ms-switch-tabs label[for="ms-b2"]{background:var(--red);border-color:var(--red);color:#fff;box-shadow:0 6px 16px rgba(193,39,45,.28);}
	#ms-page #ms-b1:checked~.ms-switch-panes .ms-switch-pane[data-b="1"],
	#ms-page #ms-b2:checked~.ms-switch-panes .ms-switch-pane[data-b="2"]{display:block;}
	#ms-page .ms-switch-note{text-align:center;color:var(--muted);font-size:14.5px;margin-top:18px;}

	/* ---------- RETÍCULA BENTO ---------- */
	#ms-page .ms-bento{display:grid;grid-template-columns:repeat(2,1fr);gap:24px;}
	#ms-page .ms-cell{background:#fff;border:1px solid var(--line);border-radius:var(--radius);padding:28px;box-shadow:var(--shadow-sm);transition:transform .18s ease,box-shadow .18s ease,border-color .18s ease;}
	#ms-page .ms-cell:hover{transform:translateY(-4px);box-shadow:var(--shadow-md);border-color:#e0d0d0;}
	#ms-page .ms-cell.is-feature{grid-column:1 / -1;display:grid;grid-template-columns:.82fr 1.18fr;gap:34px;align-items:center;}
	#ms-page .ms-cell .ms-ic{width:48px;height:48px;border-radius:12px;background:var(--red-soft);display:grid;place-items:center;margin-bottom:15px;}
	#ms-page .ms-cell .ms-ic svg{width:24px;height:24px;color:var(--red);}
	#ms-page .ms-cell h3{font-size:19px;font-weight:800;margin-bottom:9px;}
	#ms-page .ms-cell.is-feature h3{font-size:clamp(20px,2.2vw,25px);}
	#ms-page .ms-cell p{color:var(--muted);font-size:15px;}
	#ms-page .ms-cell .ms-media{margin-top:20px;}
	#ms-page .ms-cell.is-feature .ms-media{margin-top:0;}
	#ms-page .ms-cell .ms-list{list-style:none;margin:16px 0 0;padding:0;display:flex;flex-direction:column;gap:9px;}
	#ms-page .ms-cell .ms-list li{display:flex;align-items:flex-start;gap:9px;color:var(--ink-strong);font-size:14.5px;}
	#ms-page .ms-cell .ms-list svg{width:18px;height:18px;color:var(--ms-green);flex-shrink:0;margin-top:1px;}

	/* ---------- TRASLADOS: TRÍPTICO ---------- */
	#ms-page .ms-trio{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;}
	#ms-page .ms-step{position:relative;}
	#ms-page .ms-step .num{width:32px;height:32px;border-radius:10px;background:var(--red);color:#fff;font-family:'Manrope';font-weight:800;font-size:14px;display:grid;place-items:center;margin-bottom:14px;box-shadow:0 6px 14px rgba(193,39,45,.3);}
	#ms-page .ms-step h4{font-size:16.5px;font-weight:700;margin-bottom:7px;}
	#ms-page .ms-step p{color:var(--muted);font-size:14px;margin-bottom:16px;}

	@media (max-width:900px){
		#ms-page .ms-hero .wrap{padding-top:56px;}
		#ms-page .ms-hero-shot{transform:translateY(20px);margin-top:34px;}
		#ms-page .ms-bento{grid-template-columns:1fr;}
		#ms-page .ms-cell.is-feature{grid-template-columns:1fr;gap:22px;}
		#ms-page .ms-cell.is-feature .ms-media{margin-top:4px;}
		#ms-page .ms-trio{grid-template-columns:1fr;gap:30px;}
	}
</style>

<div id="ms-page">

	<!-- HERO CENTRADO -->
	<section class="ms-hero">
		<div class="wrap">
			<span class="eyebrow"><span class="dot"></span> <?php echo esc_html( vlac_opt( 'ms_eyebrow', 'Múltiples Sucursales' ) ); ?></span>
			<h1><?php echo wp_kses_post( vlac_opt( 'ms_title', 'Un sistema, <span class="accent">todas</span> tus sucursales' ) ); ?></h1>
			<p class="lead"><?php echo esc_html( vlac_opt( 'ms_sub', 'Cada sucursal con su propia información, existencias, ventas y equipo —y todas conectadas entre sí desde un mismo lugar.' ) ); ?></p>
			<div class="hero-cta">
				<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'hero_cta1_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
				<a class="btn btn-ghost" href="<?php echo esc_url( vlac_opt( 'hero_cta2_url', '#' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta2_txt', 'Ver una demo' ) ); ?></a>
			</div>

			<div class="ms-chain" aria-label="Ejemplo de sucursales">
				<span class="ms-chip"><i></i> Casa matriz</span>
				<span class="ms-chip"><i></i> 2da sucursal</span>
				<span class="ms-chip"><i></i> Tercera</span>
				<span class="ms-chip"><i></i> Bodega central</span>
				<span class="ms-chip is-more">+ las que necesites</span>
			</div>

			<div class="ms-hero-shot">
				<?php
				$ms_hero_key  = vlac_opt( 'ms_img_hero' ) ? 'ms_img_hero' : 'ms_img_negocio';
				$ms_hero_file = file_exists( $img_dir . 'ms-hero.png' ) ? 'ms-hero.png' : 'ms-negocio.png';
				$ms_shot( $ms_hero_file, '', $ms_hero_key );
				?>
			</div>
		</div>
	</section>

	<!-- MÁS DE UNA SUCURSAL: SELECTOR -->
	<section class="section section-alt" style="padding-top:76px;">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Más de una sucursal</div>
				<h2>Cambia de sucursal y todo cambia con ella</h2>
				<p>Cada sucursal tiene su propio nombre, NIT, logo, dirección, contacto y configuración. Elige una arriba y trabaja solo con sus datos.</p>
			</div>

			<div class="ms-switch">
				<input type="radio" name="ms-branch" id="ms-b1" checked />
				<input type="radio" name="ms-branch" id="ms-b2" />

				<div class="ms-switch-tabs" role="tablist">
					<label for="ms-b1">Casa matriz</label>
					<label for="ms-b2">2da sucursal</label>
				</div>

				<div class="ms-switch-panes">
					<div class="ms-switch-pane" data-b="1">
						<?php $ms_shot( 'ms-negocio.png', 'Información y configuración de la casa matriz', 'ms_img_negocio' ); ?>
					</div>
					<div class="ms-switch-pane" data-b="2">
						<?php $ms_shot( 'ms-negocio-2.png', 'La misma pantalla, con los datos de otra sucursal', 'ms_img_negocio_2' ); ?>
					</div>
				</div>

				<p class="ms-switch-note">Impresoras, tipos de pago, horarios, propina, mapa de mesas y formatos: todo se configura por sucursal.</p>
			</div>
		</div>
	</section>

	<!-- BENTO: EXISTENCIAS / VENTAS / USUARIOS -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Por sucursal</div>
				<h2>Lo que tienes, lo que vendes y quién lo hace</h2>
				<p>Existencias, ventas y equipo, siempre separados por sucursal pero visibles desde un solo panel.</p>
			</div>

			<div class="ms-bento">
				<div class="ms-cell is-feature">
					<div class="ms-cell-copy">
						<div class="ms-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3zm0 0v18M4 7.5l8 4.5 8-4.5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg></div>
						<h3>Existencias por sucursal</h3>
						<p>Un mismo producto, con su existencia real en cada sucursal en la misma fila. Ve de un vistazo dónde sobra y dónde falta antes de comprar o trasladar.</p>
						<ul class="ms-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Existencia por sucursal en la misma vista</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Filtros por categoría, marca, medida y proveedor</li>
						</ul>
					</div>
					<div class="ms-media"><?php $ms_shot( 'ms-existencias.png', '', 'ms_img_existencias' ); ?></div>
				</div>

				<div class="ms-cell">
					<div class="ms-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 20V10M10 20V4M16 20v-7M22 20H2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Ventas por sucursal</h3>
					<p>Nuevos clientes, ventas del período, total facturado, últimas órdenes, ventas por mes y top de productos —los números de cada sucursal, por separado.</p>
					<div class="ms-media"><?php $ms_shot( 'ms-ventas.png', '', 'ms_img_ventas' ); ?></div>
				</div>

				<div class="ms-cell">
					<div class="ms-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Usuarios por sucursal</h3>
					<p>La misma persona puede ser administradora en una sucursal y cajera en otra. Cada usuario lleva su rol por sucursal, visible en el listado.</p>
					<div class="ms-media"><?php $ms_shot( 'ms-usuarios.png', '', 'ms_img_usuarios' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- TRASLADOS ENTRE SUCURSALES -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Traslados entre sucursales</div>
				<h2>Mueve mercancía de una sucursal a otra</h2>
				<p>Del envío a la recepción, con estados claros y el inventario de ambas sucursales siempre cuadrado.</p>
			</div>

			<div class="ms-trio">
				<div class="ms-step">
					<div class="num">1</div>
					<h4>Crea el traslado</h4>
					<p>Elige sucursal que envía y que recibe, busca productos y define cantidades. Queda como cotización hasta que lo solicites.</p>
					<?php $ms_shot( 'ms-traslado-detalle.png', '', 'ms_img_traslado_detalle' ); ?>
				</div>
				<div class="ms-step">
					<div class="num">2</div>
					<h4>Envía y confirma</h4>
					<p>Confirma la salida de la mercancía hacia la sucursal destino. El stock sale de origen y queda en tránsito.</p>
					<?php $ms_shot( 'ms-traslados-salidas.png', '', 'ms_img_traslados_salidas' ); ?>
				</div>
				<div class="ms-step">
					<div class="num">3</div>
					<h4>Recibe en destino</h4>
					<p>La sucursal que recibe lo recepciona y el stock entra. Todo con sus totales por estado: solicitado, enviado y recepcionado.</p>
					<?php $ms_shot( 'ms-traslados.png', '', 'ms_img_traslados' ); ?>
				</div>
			</div>
		</div>
	</section>

	<!-- CAPACIDADES -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Todo lo que incluye</div>
				<h2>Pensado para crecer sucursal a sucursal</h2>
			</div>
			<div class="feat-grid">
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M3 21V9l9-6 9 6v12M3 21h18M9 21v-6h6v6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Sucursales ilimitadas</h3>
					<p>Suma las que necesites, cada una con su identidad.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 15a3 3 0 100-6 3 3 0 000 6z" stroke="currentColor" stroke-width="1.7"/><path d="M19.4 13a1.6 1.6 0 00.3 1.8l.1.1a2 2 0 11-2.8 2.8l-.1-.1a1.6 1.6 0 00-2.7 1.1V19a2 2 0 11-4 0v-.1A1.6 1.6 0 006.8 17l-.1.1a2 2 0 11-2.8-2.8l.1-.1A1.6 1.6 0 004 12.6a2 2 0 010-4A1.6 1.6 0 005.3 6l-.1-.1a2 2 0 112.8-2.8l.1.1A1.6 1.6 0 0011 4V4a2 2 0 014 0A1.6 1.6 0 0017.2 6l.1-.1a2 2 0 112.8 2.8l-.1.1a1.6 1.6 0 001.4 2.2h.2a2 2 0 010 4h-.2z" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Configuración propia</h3>
					<p>Impresoras, pagos, horarios y propina por sucursal.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3zm0 0v18M4 7.5l8 4.5 8-4.5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg></div>
					<h3>Stock independiente</h3>
					<p>Existencias reales por sucursal, sin mezclarse.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M3 7h11v8H3zM14 10h4l3 3v2h-7z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="7" cy="18" r="1.6" stroke="currentColor" stroke-width="1.6"/><circle cx="17.5" cy="18" r="1.6" stroke="currentColor" stroke-width="1.6"/></svg></div>
					<h3>Traslados con estados</h3>
					<p>Solicitado, enviado, recepcionado o anulado.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><circle cx="9" cy="8" r="4" stroke="currentColor" stroke-width="1.6"/><path d="M2 21a7 7 0 0114 0M16 11l2 2 4-4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Roles por sucursal</h3>
					<p>Cada persona con los permisos que le tocan en cada una.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 20V10M10 20V4M16 20v-7M22 20H2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Comparativo de ventas</h3>
					<p>Mide el rendimiento de cada sucursal por período.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- CTA -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="cta-strip">
				<h2><?php echo esc_html( vlac_opt( 'ms_cta_title', 'Haz crecer tu negocio, sucursal por sucursal' ) ); ?></h2>
				<p><?php echo esc_html( vlac_opt( 'ms_cta_sub', 'Abre una nueva sucursal sin duplicar sistemas: mismo software, misma marca, datos separados.' ) ); ?></p>
				<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'cta_btn_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
			</div>
		</div>
	</section>

</div>

<?php
get_footer();
