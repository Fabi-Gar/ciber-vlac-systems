<?php
/**
 * Template Name: Gestión de Contratos
 *
 * Página de producto del módulo de Contratos (planes de pago / cuotas).
 * Muestra el listado, la vista y creación de contratos, los cuadres, y
 * dos videos: pago de contratos y consulta de cuotas.
 *
 * IMÁGENES (guárdalas en /assets/img/ con estos nombres exactos):
 *   con-listado.png → listado de contratos (captura 1)
 *   con-vista.png    → vista de un contrato (captura 2)
 *   con-crear.png    → crear un contrato (captura 3)
 *   con-cuadre.png   → cuadre mensual de contratos (captura 4)
 *
 * VIDEOS (opcionales, guárdalos en /assets/video/):
 *   contratos-pago.mp4    → flujo de pago de un contrato
 *   contratos-cuotas.mp4  → consulta de cuotas
 *
 * Para usarla: crea una página (Páginas → Añadir nueva) con el título
 * «Contratos» y el slug «contratos», y en «Atributos de página →
 * Plantilla» elige «Gestión de Contratos». No necesita contenido.
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
$con_shot = function ( $file, $caption, $opt_key = '' ) use ( $img, $img_dir ) {
	$url    = $opt_key ? vlac_opt( $opt_key ) : '';
	$exists = file_exists( $img_dir . $file );
	echo '<figure class="con-shot"><div class="con-frame"><div class="bar"><i></i><i></i><i></i></div>';
	if ( $url ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $url ), esc_attr( $caption ) );
	} elseif ( $exists ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $img . '/' . $file ), esc_attr( $caption ) );
	} else {
		printf( '<div class="con-ph con-ph-img">Elige la imagen en <b>Personalizar → Página Gestión de Contratos</b><br>o sube <code>assets/img/%s</code></div>', esc_html( $file ) );
	}
	echo '</div>';
	if ( $caption ) {
		printf( '<figcaption>%s</figcaption>', esc_html( $caption ) );
	}
	echo '</figure>';
};

// Renderiza un video autoplay (o un marcador con el nombre esperado).
$con_video = function ( $base, $title, $sub ) use ( $vid_dir, $vid_url ) {
	$has_mp4  = file_exists( $vid_dir . $base . '.mp4' );
	$has_webm = file_exists( $vid_dir . $base . '.webm' );
	echo '<div class="con-frame"><div class="bar"><i></i><i></i><i></i></div>';
	if ( $has_mp4 || $has_webm ) {
		echo '<video autoplay muted loop playsinline preload="metadata">';
		if ( $has_webm ) {
			printf( '<source src="%s" type="video/webm" />', esc_url( $vid_url . '/' . $base . '.webm' ) );
		}
		if ( $has_mp4 ) {
			printf( '<source src="%s" type="video/mp4" />', esc_url( $vid_url . '/' . $base . '.mp4' ) );
		}
		echo '</video>';
	} else {
		echo '<div class="con-ph">';
		echo '<svg viewBox="0 0 24 24" fill="none"><path d="M4 5h16v14H4zM10 9l6 3-6 3V9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>';
		printf( '<b>%s</b><span>%s</span>', esc_html( $title ), esc_html( $sub ) );
		printf( '<code>assets/video/%s.mp4</code>', esc_html( $base ) );
		echo '</div>';
	}
	echo '</div>';
};
?>

<style>
	/* Estilos de la página de Contratos (ámbito local). */
	#con-page{--con-green:#2e9e5b;}

	/* HERO */
	#con-page .con-hero{position:relative;overflow:hidden;}
	#con-page .con-hero::before{content:"";position:absolute;inset:0;z-index:0;background:radial-gradient(700px 380px at 82% 8%,rgba(193,39,45,.07),transparent 60%),linear-gradient(180deg,#fff,var(--bg-alt));}
	#con-page .con-hero .hero-grid{position:relative;z-index:1;display:grid;grid-template-columns:1fr 1.12fr;gap:48px;align-items:center;padding:66px 0 84px;}
	#con-page .con-hero h1{font-size:clamp(32px,4.4vw,50px);font-weight:800;}
	#con-page .con-hero .lead{color:var(--muted);font-size:18px;margin:20px 0 8px;max-width:520px;}
	#con-page .con-hero .hero-cta{display:flex;gap:14px;flex-wrap:wrap;margin-top:28px;}
	#con-page .con-hero .hero-note{display:flex;align-items:center;gap:8px;font-size:13.5px;color:var(--muted);margin-top:22px;}
	#con-page .con-hero .hero-note svg{width:16px;height:16px;color:var(--con-green);}

	/* MARCO (estilo navegador) para capturas y videos */
	#con-page .con-frame{background:#fff;border:1px solid #d9d9de;border-radius:14px;overflow:hidden;box-shadow:var(--shadow-md);}
	#con-page .con-frame .bar{display:flex;align-items:center;gap:6px;padding:9px 12px;background:#f3f3f5;border-bottom:1px solid #e6e6ea;}
	#con-page .con-frame .bar i{width:10px;height:10px;border-radius:50%;background:#d6d6dc;display:block;}
	#con-page .con-frame video,#con-page .con-frame img{width:100%;height:auto;display:block;background:#000;}
	#con-page .con-hero .con-frame{box-shadow:var(--shadow-lg);}

	/* Marcador (placeholder) */
	#con-page .con-ph{aspect-ratio:16/10;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;text-align:center;background:var(--bg-alt);color:var(--muted);padding:24px;font-size:14px;}
	#con-page .con-ph svg{width:46px;height:46px;color:#c9c9d0;}
	#con-page .con-ph b{font-family:'Manrope';font-weight:700;color:var(--ink-strong);font-size:15px;}
	#con-page .con-ph code{font-size:13px;color:var(--red-dark);background:var(--red-soft);padding:4px 10px;border-radius:6px;}
	#con-page .con-ph-img{aspect-ratio:auto;padding:52px 20px;}

	/* SHOWCASE DE CAPTURAS */
	#con-page .con-shots{display:grid;grid-template-columns:repeat(2,1fr);gap:26px;}
	#con-page .con-shot{margin:0;}
	#con-page .con-shot figcaption{margin-top:14px;font-family:'Manrope';font-weight:600;font-size:15px;color:var(--ink-strong);text-align:center;}

	/* FILAS ALTERNADAS (texto + imagen juntos) */
	#con-page .con-rows{display:flex;flex-direction:column;gap:60px;}
	#con-page .con-row{display:grid;grid-template-columns:1fr 1.15fr;gap:46px;align-items:center;}
	#con-page .con-row.reverse .con-row-text{order:2;}
	#con-page .con-row.reverse .con-row-media{order:1;}
	#con-page .con-row-text .con-ic{width:52px;height:52px;border-radius:13px;background:var(--red-soft);display:grid;place-items:center;margin-bottom:18px;}
	#con-page .con-row-text .con-ic svg{width:26px;height:26px;color:var(--red);}
	#con-page .con-row-text h3{font-size:clamp(20px,2.4vw,26px);font-weight:800;}
	#con-page .con-row-text p{color:var(--muted);font-size:16.5px;margin-top:14px;max-width:420px;}

	/* SECCIÓN DE VIDEOS */
	#con-page .con-videos{display:grid;grid-template-columns:1fr 1fr;gap:30px;}
	#con-page .con-video-item .cap{margin-top:16px;text-align:center;}
	#con-page .con-video-item .cap b{font-family:'Manrope';font-weight:700;font-size:16px;color:var(--ink-strong);display:block;}
	#con-page .con-video-item .cap span{color:var(--muted);font-size:14px;}

	@media (max-width:900px){
		#con-page .con-hero .hero-grid{grid-template-columns:1fr;gap:34px;padding:52px 0 56px;}
		#con-page .con-shots{grid-template-columns:1fr;}
		#con-page .con-videos{grid-template-columns:1fr;}
		#con-page .con-row{grid-template-columns:1fr;gap:22px;}
		#con-page .con-row.reverse .con-row-text{order:0;}
		#con-page .con-row.reverse .con-row-media{order:0;}
	}
</style>

<div id="con-page">

	<!-- HERO -->
	<section class="con-hero">
		<div class="wrap">
			<div class="hero-grid">
				<div class="hero-copy">
					<span class="eyebrow"><span class="dot"></span> <?php echo esc_html( vlac_opt( 'con_eyebrow', 'Gestión de Contratos' ) ); ?></span>
					<h1><?php echo wp_kses_post( vlac_opt( 'con_title', 'Controla tus <span class="accent">contratos</span> y cuotas sin perder el hilo' ) ); ?></h1>
					<p class="lead"><?php echo esc_html( vlac_opt( 'con_sub', 'Crea planes de pago, registra cuotas y pagos, y consulta el estado de cada contrato: al día, vencido o pagado.' ) ); ?></p>
					<div class="hero-cta">
						<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'hero_cta1_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
						<a class="btn btn-ghost" href="<?php echo esc_url( vlac_opt( 'hero_cta2_url', '#' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta2_txt', 'Ver una demo' ) ); ?></a>
					</div>
					<div class="hero-note">
						<svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
						Cuotas y recargos · Estados automáticos · Cuadre mensual
					</div>
				</div>

				<div class="con-visual">
					<?php
					$con_hero_key  = vlac_opt( 'con_img_hero' ) ? 'con_img_hero' : 'con_img_listado';
					$con_hero_file = file_exists( $img_dir . 'con-hero.png' ) ? 'con-hero.png' : 'con-listado.png';
					$con_shot( $con_hero_file, '', $con_hero_key );
					?>
				</div>
			</div>
		</div>
	</section>

	<!-- CONTRATOS: LISTADO / VISTA / CREAR / CUADRE -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Contratos</div>
				<h2>Del plan de pago al cuadre mensual</h2>
				<p>Gestiona cada contrato de principio a fin, con estados y totales siempre al día.</p>
			</div>

			<div class="con-rows">
				<div class="con-row">
					<div class="con-row-text">
						<div class="con-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></div>
						<h3>Listado de contratos</h3>
						<p>Todos tus contratos con su estado (al día, vencido, cotización), cuota, pagado, pendiente y total. Filtra por nombre, cliente, status y rango de facturación.</p>
					</div>
					<div class="con-row-media"><?php $con_shot( 'con-listado.png', '', 'con_img_listado' ); ?></div>
				</div>

				<div class="con-row reverse">
					<div class="con-row-text">
						<div class="con-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="4" y="3" width="16" height="18" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M8 8h8M8 12h8M8 16h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
						<h3>Vista del contrato</h3>
						<p>Cliente, valor de cuota, recargo, impuesto, comisión, notas y totales; más sus cuotas en abierto, finalizadas, pagos y ventas asociadas.</p>
					</div>
					<div class="con-row-media"><?php $con_shot( 'con-vista.png', '', 'con_img_vista' ); ?></div>
				</div>

				<div class="con-row">
					<div class="con-row-text">
						<div class="con-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></div>
						<h3>Crear un contrato</h3>
						<p>Define nombre, primer vencimiento, cantidad de cuotas y valor, aplica recargos, impuestos y comisión, e indica quién la recibe.</p>
					</div>
					<div class="con-row-media"><?php $con_shot( 'con-crear.png', '', 'con_img_crear' ); ?></div>
				</div>

				<div class="con-row reverse">
					<div class="con-row-text">
						<div class="con-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 20V10M10 20V4M16 20v-7M22 20H2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
						<h3>Cuadre mensual</h3>
						<p>Resumen del mes en un vistazo: total, pagado, al día y vencido, con el detalle contrato por contrato.</p>
					</div>
					<div class="con-row-media"><?php $con_shot( 'con-cuadre.png', '', 'con_img_cuadre' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- VIDEOS: PAGOS Y CUOTAS -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">En acción</div>
				<h2>Pagos y cuotas, paso a paso</h2>
				<p>Mira cómo se registra un pago y cómo se consultan las cuotas de un contrato.</p>
			</div>

			<div class="con-rows">
				<div class="con-row">
					<div class="con-row-text">
						<div class="con-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
						<h3>Pagar contratos</h3>
						<p>Registra abonos y liquida cuotas al instante: elige el tipo de pago, el monto y la referencia, y el estado del contrato se actualiza solo.</p>
					</div>
					<div class="con-row-media"><?php $con_video( 'contratos-pago', 'Video: pagar un contrato', 'Registro de pago de cuotas' ); ?></div>
				</div>

				<div class="con-row reverse">
					<div class="con-row-text">
						<div class="con-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="17" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M3 9h18M7 13h10M7 17h6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
						<h3>Ver cuotas</h3>
						<p>Consulta las cuotas en abierto, finalizadas, los pagos y las ventas asociadas, con sus totales pagado, pendiente y vencido.</p>
					</div>
					<div class="con-row-media"><?php $con_video( 'contratos-cuotas', 'Video: ver cuotas', 'Cuotas en abierto y finalizadas' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- CAPACIDADES -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Todo lo que incluye</div>
				<h2>Pensado para el cobro por cuotas</h2>
			</div>
			<div class="feat-grid">
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="17" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M3 9h18M8 2v4M16 2v4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Planes de cuotas</h3>
					<p>Define cantidad de cuotas, valor y primer vencimiento.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Recargos, impuestos y comisión</h3>
					<p>Aplica porcentajes y define quién recibe la comisión.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.7"/><path d="M8 12l2.5 2.5L16 9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Estados automáticos</h3>
					<p>Al día, vencido, cotización o pagado, calculado por ti.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 20V10M10 20V4M16 20v-7M22 20H2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Cuadre mensual</h3>
					<p>Totales por mes: pagado, al día y vencido de un vistazo.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M6 3h9l3 3v15H6z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Historial de pagos</h3>
					<p>Cuotas en abierto, finalizadas, pagos y ventas asociadas.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8z" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Ligado al cliente</h3>
					<p>Cada contrato queda vinculado a la ficha del cliente.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- CTA -->
	<section class="section" style="padding-top:0;">
		<div class="wrap">
			<div class="cta-strip">
				<h2><?php echo esc_html( vlac_opt( 'con_cta_title', 'Ordena tus cobros por cuotas hoy' ) ); ?></h2>
				<p><?php echo esc_html( vlac_opt( 'con_cta_sub', 'Crea contratos, controla sus cuotas y no vuelvas a perder de vista un pago.' ) ); ?></p>
				<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'cta_btn_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
			</div>
		</div>
	</section>

</div>

<?php
get_footer();
