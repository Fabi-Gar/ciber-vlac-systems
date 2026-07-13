<?php
/**
 * Template Name: Facturador FEL
 *
 * Página de producto del módulo de Facturación Electrónica (FEL).
 * Muestra el flujo de emisión desde el sistema y desde el cajero (POS),
 * usando capturas reales del sistema.
 *
 * IMÁGENES (guárdalas en /assets/img/ con estos nombres exactos):
 *   fac-form.png     → modal de Facturación con productos (captura 1)
 *   fac-preview.png  → vista previa del DTE / «Emitir factura» (captura 2)
 *   fac-exito.png    → pantalla «procesada exitosamente» (captura 3)
 *   fac-factura.png  → factura PDF impresa (captura 4)
 *   fac-termica.png  → ticket térmico (captura 5)
 *   fac-cajero.png   → pantalla del cajero / POS (captura 6)
 *
 * Mientras no existan, el hero usa las imágenes genéricas del tema como
 * respaldo y el resto muestra un marcador con el nombre esperado.
 *
 * Para usarla: crea una página (Páginas → Añadir nueva) con el título
 * «Facturación» y el slug «facturacion», y en «Atributos de página →
 * Plantilla» elige «Facturador FEL». No necesita contenido.
 *
 * @package Vlac_Systems
 */

get_header();

$img     = get_template_directory_uri() . '/assets/img';
$img_dir = get_template_directory() . '/assets/img/';

// Video opcional del flujo (si existe, reemplaza a las 3 capturas del showcase).
$vid_url       = get_template_directory_uri() . '/assets/video';
$vid_dir       = get_template_directory() . '/assets/video/';
$fac_has_mp4   = file_exists( $vid_dir . 'facturacion.mp4' );
$fac_has_webm  = file_exists( $vid_dir . 'facturacion.webm' );
$fac_has_video = $fac_has_mp4 || $fac_has_webm;

// Segundo video: entrega de la factura (PDF y térmica).
$out_has_mp4   = file_exists( $vid_dir . 'entrega.mp4' );
$out_has_webm  = file_exists( $vid_dir . 'entrega.webm' );
$out_has_video = $out_has_mp4 || $out_has_webm;

// Devuelve la URL de $preferred si existe; si no, la de $fallback.
$fac_pick = function ( $preferred, $fallback ) use ( $img, $img_dir ) {
	return file_exists( $img_dir . $preferred ) ? $img . '/' . $preferred : $img . '/' . $fallback;
};

// Renderiza una captura enmarcada (o un marcador si el archivo no existe).
$fac_shot = function ( $file, $caption ) use ( $img, $img_dir ) {
	$exists = file_exists( $img_dir . $file );
	echo '<figure class="fac-shot"><div class="fac-frame"><div class="bar"><i></i><i></i><i></i></div>';
	if ( $exists ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $img . '/' . $file ), esc_attr( $caption ) );
	} else {
		printf( '<div class="fac-ph">Coloca la imagen<br><code>assets/img/%s</code></div>', esc_html( $file ) );
	}
	echo '</div>';
	if ( $caption ) {
		printf( '<figcaption>%s</figcaption>', esc_html( $caption ) );
	}
	echo '</figure>';
};
?>

<style>
	/* Estilos de la página de Facturación (ámbito local). */
	#fac-page{--fac-green:#2e9e5b;}

	/* HERO con dispositivos */
	#fac-page .fac-hero{position:relative;overflow:hidden;}
	#fac-page .fac-hero::before{content:"";position:absolute;inset:0;z-index:0;background:radial-gradient(700px 380px at 82% 8%,rgba(193,39,45,.07),transparent 60%),linear-gradient(180deg,#fff,var(--bg-alt));}
	#fac-page .fac-hero .hero-grid{position:relative;z-index:1;display:grid;grid-template-columns:1.02fr 1.15fr;gap:50px;align-items:center;padding:66px 0 88px;}
	#fac-page .fac-hero h1{font-size:clamp(32px,4.4vw,50px);font-weight:800;}
	#fac-page .fac-hero .lead{color:var(--muted);font-size:18px;margin:20px 0 8px;max-width:520px;}
	#fac-page .fac-hero .hero-cta{display:flex;gap:14px;flex-wrap:wrap;margin-top:28px;}
	#fac-page .fac-hero .hero-note{display:flex;align-items:center;gap:8px;font-size:13.5px;color:var(--muted);margin-top:22px;}
	#fac-page .fac-hero .hero-note svg{width:16px;height:16px;color:var(--fac-green);}

	/* PASOS */
	#fac-page .fac-steps{display:grid;grid-template-columns:repeat(4,1fr);gap:22px;}
	#fac-page .fac-step{position:relative;background:#fff;border:1px solid var(--line);border-radius:var(--radius);padding:28px 22px;transition:transform .18s ease,box-shadow .18s ease,border-color .18s ease;}
	#fac-page .fac-step:hover{transform:translateY(-4px);box-shadow:var(--shadow-md);border-color:#e0d0d0;}
	#fac-page .fac-step .num{position:absolute;top:-14px;left:22px;width:34px;height:34px;border-radius:10px;background:var(--red);color:#fff;font-family:'Manrope';font-weight:800;font-size:15px;display:grid;place-items:center;box-shadow:0 6px 14px rgba(193,39,45,.32);}
	#fac-page .fac-step .fac-ic{width:52px;height:52px;border-radius:13px;background:var(--red-soft);display:grid;place-items:center;margin:14px 0 18px;}
	#fac-page .fac-step .fac-ic svg{width:26px;height:26px;color:var(--red);}
	#fac-page .fac-step h3{font-size:17px;font-weight:700;margin-bottom:8px;}
	#fac-page .fac-step p{color:var(--muted);font-size:14.5px;}

	/* MARCO DE CAPTURA (estilo navegador) */
	#fac-page .fac-frame{background:#fff;border:1px solid #d9d9de;border-radius:14px;overflow:hidden;box-shadow:var(--shadow-md);}
	#fac-page .fac-frame .bar{display:flex;align-items:center;gap:6px;padding:9px 12px;background:#f3f3f5;border-bottom:1px solid #e6e6ea;}
	#fac-page .fac-frame .bar i{width:10px;height:10px;border-radius:50%;background:#d6d6dc;display:block;}
	#fac-page .fac-frame img{width:100%;height:auto;display:block;}
	#fac-page .fac-ph{padding:56px 20px;text-align:center;color:var(--muted);font-size:14px;background:var(--bg-alt);}
	#fac-page .fac-ph code{display:inline-block;margin-top:8px;font-size:13px;color:var(--red-dark);background:var(--red-soft);padding:4px 10px;border-radius:6px;}

	/* SHOWCASE DE CAPTURAS */
	#fac-page .fac-shots{display:grid;grid-template-columns:repeat(2,1fr);gap:26px;}
	#fac-page .fac-shot{margin:0;}
	#fac-page .fac-shot figcaption{margin-top:14px;font-family:'Manrope';font-weight:600;font-size:15px;color:var(--ink-strong);text-align:center;}
	#fac-page .fac-exito-wrap{max-width:720px;margin:34px auto 0;}
	#fac-page .fac-exito-wrap figcaption{color:var(--muted);font-weight:500;}
	/* Video del flujo */
	#fac-page .fac-frame video{width:100%;height:auto;display:block;background:#000;}
	#fac-page .fac-video-wrap{max-width:900px;margin:0 auto;}
	#fac-page .fac-video-cap{margin-top:16px;text-align:center;color:var(--muted);font-size:15px;}

	/* Bloque de entrega (segundo video + canales) */
	#fac-page .deliver-grid{display:grid;grid-template-columns:1.7fr 1fr;gap:36px;align-items:center;margin-top:60px;}
	#fac-page .deliver-copy h2{font-size:clamp(24px,2.8vw,34px);font-weight:800;}
	#fac-page .deliver-copy p{color:var(--muted);font-size:16.5px;margin-top:16px;max-width:440px;}
	#fac-page .fac-outputs{display:flex;flex-wrap:wrap;gap:18px;margin-top:28px;}
	#fac-page .fac-output{display:flex;flex-direction:column;align-items:center;gap:9px;font-family:'Manrope';font-weight:600;font-size:13px;color:var(--ink-strong);}
	#fac-page .fac-output .chip{width:56px;height:56px;border-radius:14px;background:#eef0ff;display:grid;place-items:center;transition:transform .16s ease,background .16s ease;}
	#fac-page .fac-output:hover .chip{transform:translateY(-3px);background:#e3e6ff;}
	#fac-page .fac-output .chip svg{width:26px;height:26px;color:#4c4ddc;}
	@media (max-width:900px){
		#fac-page .deliver-grid{grid-template-columns:1fr;gap:30px;margin-top:44px;}
	}

	/* CAJERO (POS) */
	#fac-page .pos-grid{display:grid;grid-template-columns:1fr 1.1fr;gap:44px;align-items:center;}
	#fac-page .pos-left h2{font-size:clamp(26px,3vw,36px);font-weight:800;}
	#fac-page .pos-left p{color:var(--muted);font-size:16.5px;margin-top:16px;max-width:460px;}
	#fac-page .pos-flow{margin-top:26px;display:flex;flex-direction:column;gap:12px;}
	#fac-page .pos-flow .row{display:flex;align-items:center;gap:12px;font-size:15px;color:var(--ink);}
	#fac-page .pos-flow .row svg{width:20px;height:20px;color:var(--fac-green);flex-shrink:0;}

	@media (max-width:900px){
		#fac-page .fac-hero .hero-grid{grid-template-columns:1fr;gap:36px;padding:52px 0 60px;}
		#fac-page .fac-steps{grid-template-columns:repeat(2,1fr);gap:26px 22px;}
		#fac-page .fac-shots{grid-template-columns:1fr;}
		#fac-page .pos-grid{grid-template-columns:1fr;gap:30px;}
	}
	@media (max-width:520px){
		#fac-page .fac-steps{grid-template-columns:1fr;}
	}
</style>

<div id="fac-page">

	<!-- HERO -->
	<section class="fac-hero">
		<div class="wrap">
			<div class="hero-grid">
				<div class="hero-copy">
					<span class="eyebrow"><span class="dot"></span> <?php echo esc_html( vlac_opt( 'fac_eyebrow', 'Facturador FEL · Guatemala' ) ); ?></span>
					<h1><?php echo wp_kses_post( vlac_opt( 'fac_title', 'Crea tu factura electrónica <span class="accent">FEL</span> en segundos' ) ); ?></h1>
					<p class="lead"><?php echo esc_html( vlac_opt( 'fac_sub', 'Emite facturas certificadas ante la SAT directamente desde el sistema o desde tu cajero (punto de venta). El mismo flujo, simple y rápido.' ) ); ?></p>
					<div class="hero-cta">
						<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'hero_cta1_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
						<a class="btn btn-ghost" href="<?php echo esc_url( vlac_opt( 'hero_cta2_url', '#' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta2_txt', 'Ver una demo' ) ); ?></a>
					</div>
					<div class="hero-note">
						<svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
						Certificado ante la SAT · Consumidor Final en un clic · Multi-sucursal
					</div>
				</div>

				<!-- Montaje de dispositivos con capturas reales -->
				<div class="montage" aria-label="Facturación electrónica en Vlac Systems">
					<div class="monitor">
						<div class="screen">
							<div class="browserbar"><i></i><i></i><i></i><span class="url">app.tunegocio.com.gt</span></div>
							<img class="shot" src="<?php echo esc_url( $fac_pick( 'fac-form.png', 'hero-monitor.jpg' ) ); ?>" alt="Modal de facturación de Vlac Systems" />
						</div>
						<div class="stand-neck"></div>
						<div class="stand"></div>
					</div>

					<div class="tablet">
						<span class="badge">Factura FEL</span>
						<div class="tscreen"><img class="shot" src="<?php echo esc_url( $fac_pick( 'fac-factura.png', 'hero-tablet.png' ) ); ?>" alt="Factura FEL certificada ante la SAT" /></div>
					</div>

					<div class="phone">
						<div class="pscreen"><img class="shot" src="<?php echo esc_url( $fac_pick( 'fac-termica.png', 'hero-phone.png' ) ); ?>" alt="Ticket térmico de la factura" /></div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- FLUJO POR PASOS -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Crea tu factura desde el sistema</div>
				<h2>Facturar nunca fue tan fácil</h2>
				<p>Cuatro pasos para emitir un DTE válido, sin complicaciones y sin salir del sistema.</p>
			</div>

			<div class="fac-steps">
				<div class="fac-step">
					<span class="num">1</span>
					<div class="fac-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM22 21v-2a4 4 0 00-3-3.87" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Elige el DTE y el cliente</h3>
					<p>Factura, Pequeño Contribuyente y más. Busca al cliente por NIT o usa Consumidor Final (CF).</p>
				</div>
				<div class="fac-step">
					<span class="num">2</span>
					<div class="fac-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3zm0 0v18M4 7.5l8 4.5 8-4.5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg></div>
					<h3>Agrega productos o servicios</h3>
					<p>El sistema calcula automáticamente el IVA, el monto gravable y el total de la factura.</p>
				</div>
				<div class="fac-step">
					<span class="num">3</span>
					<div class="fac-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M6 3h9l3 3v15l-2-1.4L14 21l-2-1.4L10 21l-2-1.4L6 21V3z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Revisa y emite</h3>
					<p>Confirma la vista previa del DTE y emite. Se certifica ante la SAT en tiempo real.</p>
				</div>
				<div class="fac-step">
					<span class="num">4</span>
					<div class="fac-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 4h16v12H4zM4 20h16M8 8h8M8 12h5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Entrégala como quieras</h3>
					<p>PDF, impresión térmica, WhatsApp o correo. O inicia de una vez una nueva factura.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- SHOWCASE DE CAPTURAS REALES -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Míralo en acción</div>
				<h2>Del formulario al DTE certificado</h2>
			</div>

			<?php if ( $fac_has_video ) : ?>
				<div class="fac-video-wrap">
					<div class="fac-frame">
						<div class="bar"><i></i><i></i><i></i></div>
						<video autoplay muted loop playsinline preload="metadata" poster="<?php echo esc_url( $img . '/fac-form.png' ); ?>">
							<?php if ( $fac_has_webm ) : ?>
								<source src="<?php echo esc_url( $vid_url . '/facturacion.webm' ); ?>" type="video/webm" />
							<?php endif; ?>
							<?php if ( $fac_has_mp4 ) : ?>
								<source src="<?php echo esc_url( $vid_url . '/facturacion.mp4' ); ?>" type="video/mp4" />
							<?php endif; ?>
						</video>
					</div>
					<p class="fac-video-cap">Del formulario al DTE certificado, en segundos.</p>
				</div>
			<?php else : ?>
				<div class="fac-shots">
					<?php $fac_shot( 'fac-form.png', 'Llena los datos y los productos' ); ?>
					<?php $fac_shot( 'fac-preview.png', 'Revisa la vista previa del DTE' ); ?>
				</div>

				<div class="fac-exito-wrap">
					<?php $fac_shot( 'fac-exito.png', 'Factura procesada: entrégala por PDF, térmica, WhatsApp o correo' ); ?>
				</div>
			<?php endif; ?>

			<!-- Entrega de la factura (segundo video / imágenes) -->
			<div class="deliver-grid">
				<div class="deliver-media">
					<?php if ( $out_has_video ) : ?>
						<div class="fac-frame">
							<div class="bar"><i></i><i></i><i></i></div>
							<video autoplay muted loop playsinline preload="metadata" poster="<?php echo esc_url( $img . '/fac-factura.png' ); ?>">
								<?php if ( $out_has_webm ) : ?>
									<source src="<?php echo esc_url( $vid_url . '/entrega.webm' ); ?>" type="video/webm" />
								<?php endif; ?>
								<?php if ( $out_has_mp4 ) : ?>
									<source src="<?php echo esc_url( $vid_url . '/entrega.mp4' ); ?>" type="video/mp4" />
								<?php endif; ?>
							</video>
						</div>
					<?php else : ?>
						<?php $fac_shot( 'fac-factura.png', '' ); ?>
					<?php endif; ?>
				</div>

				<div class="deliver-copy">
					<div class="sec-kicker">Entrega</div>
					<h2>Comparte la factura al instante</h2>
					<p>Apenas se emite, entrégala como tu cliente prefiera — impresa o digital, en segundos.</p>
					<div class="fac-outputs">
						<div class="fac-output">
							<span class="chip"><svg viewBox="0 0 24 24" fill="none"><path d="M7 3h7l5 5v13H7z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M14 3v5h5" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9.5 14.5h.8a1.3 1.3 0 010 2.6h-.8v-2.6zm4 0h1.6m-1.6 0v3.4m0-1.7h1.2" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
							PDF
						</div>
						<div class="fac-output">
							<span class="chip"><svg viewBox="0 0 24 24" fill="none"><path d="M6 9V3h12v6M6 18H4v-6a2 2 0 012-2h12a2 2 0 012 2v6h-2M8 14h8v6H8z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
							Térmica
						</div>
						<div class="fac-output">
							<span class="chip"><svg viewBox="0 0 24 24" fill="none"><path d="M4 21l1.6-4A8 8 0 1112 20a8 8 0 01-4-1L4 21z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
							WhatsApp
						</div>
						<div class="fac-output">
							<span class="chip"><svg viewBox="0 0 24 24" fill="none"><path d="M3 6h18v12H3V6zm0 1l9 6 9-6" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg></span>
							Correo
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- FACTURAR DESDE EL CAJERO -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="pos-grid">
				<div class="pos-left">
					<div class="sec-kicker">Punto de venta</div>
					<h2>Factura también desde el cajero</h2>
					<p>Cierra la venta en tu POS y factura con el mismo flujo: el cliente y los productos ya están cargados. Un clic en «Facturar» y listo.</p>
					<div class="pos-flow">
						<div class="row"><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg> La venta pasa a facturación con todo precargado</div>
						<div class="row"><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg> Mismo formulario de DTE, NIT y productos</div>
						<div class="row"><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg> Entrega por PDF, térmica, WhatsApp o correo</div>
					</div>
				</div>

				<?php $fac_shot( 'fac-cajero.png', '' ); ?>
			</div>
		</div>
	</section>

	<!-- CAPACIDADES -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Todo lo que incluye</div>
				<h2>Pensado para facturar sin fricción</h2>
			</div>
			<div class="feat-grid">
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M6 3h9l3 3v15H6z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M9 8h6M9 12h6M9 16h3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Múltiples tipos de DTE</h3>
					<p>Factura, Pequeño Contribuyente y más, según tu régimen.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="1.7"/><path d="M21 21l-4-4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Búsqueda por NIT</h3>
					<p>Encuentra al cliente al instante o factura a Consumidor Final.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Cálculo automático de IVA</h3>
					<p>Monto gravable, IVA y total calculados por ti, sin errores.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.7"/><path d="M8 12l2.5 2.5L16 9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Certificación SAT en tiempo real</h3>
					<p>Cada DTE se valida y certifica al momento de emitirlo.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 4h16v12H4zM4 20h16M8 8h8M8 12h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Entrega multicanal</h3>
					<p>PDF, impresión térmica, WhatsApp o correo electrónico.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 7h16l-1 12H5L4 7zM8 7V5a4 4 0 018 0v2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Facturación desde caja (POS)</h3>
					<p>El mismo flujo directo desde el punto de venta.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M3 21V9l9-6 9 6v12M3 21h18M9 21v-6h6v6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Multi-sucursal y multi-caja</h3>
					<p>Factura desde cualquier sucursal o caja de tu negocio.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M3 9h18M8 4v16" stroke="currentColor" stroke-width="1.6"/></svg></div>
					<h3>Historial y reimpresión</h3>
					<p>Consulta y vuelve a enviar cualquier documento emitido.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- CTA -->
	<section class="section" style="padding-top:0;">
		<div class="wrap">
			<div class="cta-strip">
				<h2><?php echo esc_html( vlac_opt( 'fac_cta_title', 'Empieza a facturar FEL hoy mismo' ) ); ?></h2>
				<p><?php echo esc_html( vlac_opt( 'fac_cta_sub', 'Activa tu Facturador FEL, personalízalo con tu marca y emite tu primera factura en minutos.' ) ); ?></p>
				<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'cta_btn_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
			</div>
		</div>
	</section>

</div>

<?php
get_footer();
